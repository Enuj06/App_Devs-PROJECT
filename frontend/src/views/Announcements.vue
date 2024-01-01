<template>
  <div>
    <AdminLogo /><br>
    <AdminNav />

    <h1>Announcements</h1>

    <!-- Form for creating new Announcement -->


    <div>
      <!-- Announcements Table -->
      <div class="pa-4 col-12">
        <v-row justify="space-between" align="center">
          <v-col>
            <h3 class="mb-2">Announcements Table</h3>
          </v-col>
        </v-row>
        <div class="col-12">
          <div class="row float-end col-2 mb-2">
            <button @click="openDialog" class="btn btn-primary btn-small">Add Announcement</button>
          </div>
          <table class="table table-bordered table-hover">
            <thead class="thead-light">
              <tr>
                <th class="text-center">Title</th>
                <th class="text-center">Content</th>
                <th class="text-center">Image</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="announcement in announcements" :key="announcement.id">
                <td class="align-middle">{{ announcement.title }}</td>
                <td class="align-middle">{{ announcement.content }}</td>
                <td class="align-middle">
                  <img class="img-fluid" style="max-width: 200px; max-height: 100px;"
                  :src="require('@/assets/img/' + announcement.image_url)" alt="" />
                </td>
                <td class="text-center align-middle">
                  <button @click="openRoomEditModal(announcement)"
                    class="btn btn-outline-primary btn-sm me-2">Edit</button>
                  <button @click="deleteAnnouncement(announcement.id)"
                    class="btn btn-outline-danger btn-sm">Delete</button>
                </td>
              </tr>
            </tbody>
          </table>

        </div>

        <!-- Announcements Table -->

      </div>
    </div>

  </div>
  <v-dialog v-model="dialog" max-width="600">
    <v-card>
      <v-card-title>{{ editing ? 'Edit Announcement' : 'Create Announcement' }}</v-card-title>
      <v-card-text>
        <form @submit.prevent="handleSubmit" class="announcement-form">
          <label>Title:</label>
          <input v-model="title" required>

          <label>Content:</label>
          <textarea v-model="content" required></textarea>

          <label>Upload Image:</label>
          <input type="file" ref="roomImageInput" @change="handleRoomImageUpload" class="form-control-file">

          <button class="btn btn-success" type="submit">
            {{ editing ? 'Update Announcement' : 'Create Announcement' }}
          </button>
          <button class="btn btn-danger" @click="closeDialog">Cancel</button>
        </form>
      </v-card-text>
    </v-card>
  </v-dialog>
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
      image: null,
      editRoomModalVisible: false,
      editedRoom: null,
      dialog: false,
      editing: false,
      announcementToEdit: null,
    };
  },
  mounted() {
    this.fetchAnnouncements();
  },
  methods: {

    // onFileChange(event) {
    //   this.image = event.target.files[0];
    // },
    openRoomEditModal(id=null) {
      this.editing = true;
      this.announcementToEdit = announcement;

      // Populate form fields with existing announcement data
      this.title = announcement.title;
      this.content = announcement.content;

      // Additional fields for editing, e.g., this.editDate = announcement.editDate;

      this.dialog = true;
    },
    closeRoomEditModal() {
      this.editedRoom = null;
      this.editRoomModalVisible = false;
    },
    async saveRoomEdit() {
      try {
        const data = {
          title: this.editedRoom.title,
          content: this.editedRoom.content,

        };

        const apiUrl = `/updateRoom/${this.editedRoom.id}`;
        const response = await axios.put(apiUrl, data);

        console.log('Room updated successfully:', response.data);
        this.closeRoomEditModal();

      } catch (error) {
        console.error('Error updating room:', error);
      }
    },

    async fetchAnnouncements() {
      try {
        const response = await axios.get('/fetch-announcements');
        this.announcements = response.data;
      } catch (error) {
        console.error('Error fetching announcements:', error);
      }
    },
    // async createAnnouncement() {
    //   try {
    //     const formData = new FormData();
    //     formData.append('title', this.title);
    //     formData.append('content', this.content);
    //     formData.append('image', this.image);

    //     const response = await axios.post('/create-announcement', formData);

    //     if (response.status === 200) {
    //       this.fetchAnnouncements();
    //       this.title = '';
    //       this.content = '';
    //       this.image = null;
    //     } else {
    //       console.error('Failed to add announcement');
    //     }
    //   } catch (error) {
    //     console.error('Error creating announcement:', error);
    //   }
    // },
    handleRoomImageUpload() {   ////    fdfdfdsfsfsdfr
      const fileInput = this.$refs.roomImageInput;
      const file = fileInput.files[0];

      const formData = new FormData();
      formData.append('image_url', file);

      this.image_url = formData;
    },
    async updateAnnouncement(id) {
  try {
    console.log('Updating announcement with ID:', id);
    console.log('Title:', this.title);
    console.log('Content:', this.content);

    const formData = new FormData();
    console.log('Empty FormData:', formData);

    formData.append('title', this.title);
    formData.append('content', this.content);
    formData.append('id', id);

    if (this.$refs.roomImageInput.files.length > 0) {
      formData.append('image', this.$refs.roomImageInput.files[0]);
    }

    console.log('Updated FormData:', formData);

    const response = await axios.put(`updateannounce/${id}`, formData);

    if (response.data && response.data.message) {
      console.log(response.data.message);
    }

    this.image_url = '';
    this.title = '';
    this.content = '';
    this.fetchAnnouncements();
    this.closeDialog();
  } catch (error) {
    console.error(error);
  }
}
,
    handleSubmit() {
      if (this.editing) {
        this.saveRoomEdit();
      } else {
        this.createAnnouncement();
      }
      this.closeDialog();
    },
    async createAnnouncement() {
      try {
        const data = this.image_url;
        data.append('title', this.title);
        data.append('content', this.content);

        const ins = await axios.post('createannounce', data);

        this.image_url = '';
        this.title = '';
        this.content = '';
        this.fetchAnnouncements();



      } catch (error) {
        console.error(error);
      }
    },
    openDialog() {
      this.dialog = true;
    },
    closeDialog() {
      this.dialog = false;
      this.editing = false;
      this.announcementToEdit = null;

      this.title = '';
      this.content = '';
      this.image_url = '';

      this.$refs.roomImageInput.value = null;
    },
  },
};
</script>
<style scoped>
h1,
h3 {
  text-align: center;
}



.announcement-form {
  max-width: 800px;
  /* Adjust the width as needed */
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


.action-button {
  background-color: #4caf50;
  color: white;
  padding: 6px 10px;
  /* Adjust the padding as needed */
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 12px;
  /* Adjust the font size as needed */
  margin-right: 5px;
  /* Add margin between buttons if necessary */
}

.action-button:hover {
  background-color: #45a049;
}
</style>    