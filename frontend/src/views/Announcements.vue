<template>
  <div>
    <AdminLogo /><br>
    <AdminNav />

    <h1>Announcements</h1>

    <!-- Form for creating new Announcement -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content p-4 rounded m-4">
          <h5 class="card-title text-center mb-5 fw-light fs-5">{{ editing ? 'Edit Announcement' : 'Create Announcement' }}
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </h5>
          <form @submit.prevent="handleSubmit">
            <label>Title:</label>
            <input v-model="title" required>

            <label>Content:</label>
            <textarea v-model="content" required></textarea>

            <label>Upload Image:</label>
            <input type="file" ref="announcementImageInput" name="image_url" @change="handleAnnouncementImageUpload" class="form-control-file">

            <button class="btn btn-success" type="submit">
              {{ editing ? 'Update Announcement' : 'Create Announcement' }}
            </button>
          </form>
        </div>
      </div>
    </div>

    <h3>Table</h3>

    <!-- Display Announcements in a wider table -->
    <table>
      <thead>
        <tr>
          <th>Title</th>
          <th>Content</th>
          <th>Image</th>
          <th>Actions <a class="btn btn-primary me-2" @click="openDialog()" data-bs-toggle="modal"
              data-bs-target="#editModal" data-bs-placement="top" title="Add">
              <i class="fas fa-add"></i>
            </a></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(announcement, index) in announcements" :key="index">
          <td>{{ announcement.title }}</td>
          <td>{{ announcement.content }}</td>
          <td>
            <img class="img-fluid" style="max-width: auto; max-height: auto;"
              :src="require('@/assets/img/' + announcement.image_url)" alt="" />
          </td>
          <td>
            <a class="btn btn-primary me-2" @click="openDialog(announcement.id)" data-bs-toggle="modal"
              data-bs-target="#editModal" data-bs-placement="top" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger ms-2" @click="showConfirmationModal(announcement.id)" 
              data-bs-toggle="modal" data-bs-target="#deleteAnnouncementModal" data-bs-placement="top" title="Delete">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Confirmation Modal -->
<div class="modal fade" id="deleteAnnouncementModal" tabindex="-1" aria-labelledby="deleteAnnouncementModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteAnnouncementModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this Announcement?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" @click="deleteAnnouncementConfirmed">Delete</button>
      </div>
    </div>
  </div>
</div>

  </div>
</template>

<script>
import axios from 'axios';
import AdminLogo from '@/components/AdminLogo.vue';
import AdminNav from '@/components/AdminNav.vue';

export default {
  name: 'Announcements',
  components: {
    AdminLogo,
    AdminNav,
  },
  data() {
    return {
      announcements: [],
      title: '',
      content: '',
      image_url: null,
      dialog: false,
      editing: false,
      announcementToEdit: null,
      confirmationDialog: false,
      announcementToDelete: null,
    };
  },
  mounted() {
    this.fetchAnnouncements();
  },
  methods: {
    showConfirmationModal(id) {
    this.announcementToDelete = id;
    this.confirmationDialog = true;
  }, //1
  async deleteAnnouncementConfirmed() {
    try {
        const response = await axios.delete(`/delete-announcement/${this.announcementToDelete}`);

        if (response.data.msg === 'Announcement deleted successfully') {
            console.log('Announcement deleted successfully');
            this.fetchAnnouncements(); // Fetch the announcements again to update the list
        } else {
            console.error('Failed to delete announcement');
        }
    } catch (error) {
        console.error('Error deleting announcement:', error);
    } finally {
        this.closeConfirmationModal();
    }
},

  closeConfirmationModal() {
    this.confirmationDialog = false;
    this.announcementToDelete = null;

    $('#deleteAnnouncementModal').modal('hide');
    $('.modal-backdrop').remove();
  }, //3
    openDialog(id = null) {
      if (id) {
        console.log('Open Dialog Called');  // Add this line
        const announcement = this.announcements.find((a) => a.id === id);
        this.editing = true;
        this.announcementToEdit = announcement;

        // Populate form fields with existing announcement data
        this.title = announcement.title;
        this.content = announcement.content;
        this.dialog = true;
      } else {
        this.editing = false;
        this.announcementToEdit = null;
        this.title = '';
        this.content = '';
        this.dialog = true;
      }
    },
    closeDialog() {
      this.dialog = false;
      this.editing = false;
      this.announcementToEdit = null;
      this.title = '';
      this.content = '';
      this.image_url = null;
      this.$refs.announcementImageInput.value = null;
    },
    async fetchAnnouncements() {
      try {
        const response = await axios.get('/fetch-announcements');
        console.log(response.data); //
        this.announcements = response.data;
      } catch (error) {
        console.error('Error fetching announcements:', error);
      }
    },
    handleAnnouncementImageUpload() {
      const fileInput = this.$refs.announcementImageInput;
      this.image_url = fileInput.files[0];
    },


    async handleSubmit() {
      if (this.editing) {
        this.saveRoomEdit();
      } else {
        this.createAnnouncement();
      }
      this.closeDialog();


      const formData = new FormData();
      formData.append('title', this.title);
      formData.append('content', this.content);

      // Check if an image is selected
      if (this.image_url) {
        formData.append('image_url', this.image_url);
      }

      const apiUrl = this.editing
        ? `/updateannounce/${this.announcementToEdit.id}`
        : '/create-announcement';

      const response = await axios[this.editing ? 'put' : 'post'](apiUrl, formData);
    },



    async createAnnouncement() {
      try {
        const formData = new FormData();
        formData.append('title', this.title);
        formData.append('content', this.content);
        formData.append('image_url', this.image_url);

        const response = await axios.post('/create-announcement', formData);

        if (response.status === 200) {
          console.log('Announcement added successfully');
          this.fetchAnnouncements();
          this.title = '';
          this.content = '';
          this.image_url = null;
          this.closeDialog();
          $('#editModal').modal('hide');
          $('.modal-backdrop').remove();
        } else {
          console.error('Failed to add announcement');
        }
      } catch (error) {
        console.error('Error creating announcement:', error);
      }
    },
    async saveRoomEdit() {
      try {
        console.log('Saving room edit...');
        const formData = new FormData();
        formData.append('title', this.title);
        formData.append('content', this.content);

        console.log("Form data Before request:", formData);

        const apiUrl = `/updateannounce/${this.announcementToEdit.id}`;
        const response = await axios.put(apiUrl, formData);

        console.log('Announcement updated successfully:', response.data);
        this.closeDialog();
        this.fetchAnnouncements();

      } catch (error) {
        console.error('Error updating announcement:', error);
      }
    },
    async deleteAnnouncementConfirmed() {
  try {
    const response = await axios.delete(`/delete-announcement/${this.announcementToDelete}`);

    if (response.data.msg === 'Announcement deleted successfully') {
      console.log('Announcement deleted successfully');
      this.fetchAnnouncements(); // Fetch the announcements again to update the list
      this.closeConfirmationModal(); // Close the confirmation modal
    } else {
      console.error('Failed to delete announcement');
    }
  } catch (error) {
    console.error('Error deleting announcement:', error);
  }
},


  },
};
</script>

<style scoped>
h1,
h3 {
  text-align: center;
}

table,
th,
td {
  border: 1px solid black;
  margin-left: auto;
  margin-right: auto;
  border-collapse: collapse;
  width: 800px;
  text-align: center;
  font-size: 20px;
}

form {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
  display: block;
  margin-bottom: 8px;
}

input,
textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #f58be7;
  box-sizing: border-box;
  margin-bottom: 16px;
  resize: vertical;
}
</style>