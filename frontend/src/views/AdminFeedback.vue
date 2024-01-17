<template>
    <div>
    <AdminLogo /><br>
    <AdminNav />

    <h1>Feedback</h1>

    <!-- Form for creating new FAQ -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content p-4 rounded m-4">
          <h5 class="card-title text-center mb-5 fw-light fs-5">{{ feedbackToEdit ? 'Edit Feedback' : 'Create Feedback' }}</h5>
          <form @submit.prevent="createOrUpdateFeedback">
            <label>First Name:</label>
            <input v-model="newFName" required>

            <label>Last Name:</label>
            <input v-model="newLName" required>

            <label>Feedback:</label>
            <textarea v-model="newFeed" required></textarea>

            <button class="btn btn-success" type="submit">{{ feedbackToEdit ? 'Update Feedback' : 'Create Feedback' }}</button>
          </form>
        </div>
      </div>
    </div>

    <h3>Table</h3>

    <!-- Display FAQs in a wider table -->
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Feedback</th>
          <th>Actions <a class="btn btn-primary me-2" @click="openModal()" data-bs-toggle="modal"
              data-bs-target="#editModal" data-bs-placement="top" title="Edit">
              <i class="fas fa-add"></i>
            </a></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(feedback, index) in info" :key="index">
          <td>{{ index + 1 }}</td>
          <td>{{ feedback.first_name }}</td>
          <td>{{ feedback.last_name }}</td>
          <td>{{ feedback.feed_content }}</td>
          <td>
            <a class="btn btn-primary me-2" @click="openModal(feedback.id)" data-bs-toggle="modal" data-bs-target="#editModal"
              data-bs-placement="top" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger ms-2" @click="staffDelete(feedback.id)" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Delete">
              <i class="fas fa-trash-alt"></i>
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <!-- Modal for Confirmation -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this Feedback?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" @click="deleteConfirmed">Delete</button>
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
  name: 'AdminFeedback',
  components: {
    AdminNav,
    AdminLogo,
  },
  data() {
    return {
      info: [],
      newFName: '',
      newLName: '',
      newFeed: '',
    };
  },
  created() {
    this.getInfo();
  },
  methods: {
    async getInfo() {
      try {
        const inf = await axios.get('/getfeed');
        this.info = inf.data;
      } catch (error) {
        console.log(error);
      }
    },
    async openModal(id = null) {
      if (id) {
        try {
          const response = await axios.get(`fetchFeed/${id}`);
          const feedback = response.data;

          this.newFName = feedback.first_name;
          this.newLName = feedback.last_name;
          this.newFeed = feedback.feed_content;
          this.feedbackToEdit = feedback;

          this.$router.push({ name: 'FEED', params: { id: id } });   
        } catch (error) {
          console.error('Error fetching Feedback data:', error);
        }
      } else {
        this.newFName = '';
        this.newLName = '';
        this.newFeed = '';
        this.feedbackToEdit = null;

        this.$router.push({ name: 'FEED' }); 
      }
    },
    async createOrUpdateFeedback() {
      try {
        if (this.feedbackToEdit) {
          await axios.put(`updateFeed/${this.feedbackToEdit.id}`, {
            first_name: this.newFName,
            last_name: this.newLName,
            feed_content: this.newFeed,
          });
        } else {
          const response = await axios.post('cfeedback', {
            first_name: this.newFName,
            last_name: this.newLName,
            feed_content: this.newFeed,
          });

          const newFeedback = response.data;
          this.info.push(newFeedback);
        }

        this.newFName = '';
        this.newLName = '';
        this.newFeed = '';
        this.feedbackToEdit = null;

        this.$router.push({ name: 'SomeOtherRoute' });
      } catch (error) {
        console.error('Error creating/updating Feedback:', error);
      }
      this.getInfo();
      this.closeModal();
    },
    editFAQ(feedback) {
      this.newFName = feedback.first_name;
      this.newLName = feedback.last_name;
      this.newFeed = feedback.feed_content;

      this.$router.push({ name: 'EditFAQView', params: { id: feedback.id } });
    },

    async deleteFAQ(id) {
      try {
        const response = await axios.get('/deleteFeedback/' + id);

        if (response.data.msg === 'okay') {
          this.getInfo();
        } else {
          console.error('Failed to delete FEEDBACK');
        }
      } catch (error) {
        console.error('Error deleting FEEDBACK:', error);
      }
    },
    staffDelete(userId) {
      this.DeleteId = userId;

      $('#deleteModal').modal('show');
      $('.modal-backdrop').remove();

    },
    deleteConfirmed() {
      this.deleteStaff(this.DeleteId);

      $('#deleteModal').modal('hide');
      $('.modal-backdrop').remove();

    },
    async deleteStaff(userId) {
      try {
        await axios.delete(`deleteFeedback/${userId}`);
        this.$refs.notification.open("Deleted successfully.", 'success');
        this.getStaff();
      } catch (error) {
        console.log(error);
      }
      this.$router.push({ name: 'FEED' });
      this.getInfo();
      this.closeModal();
    },
    closeModal() {
      this.$router.push({ name: 'FEED' });
      $('#editModal').modal('hide');
      $('.modal-backdrop').remove();
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
  /* Adjust the width as needed */
  text-align: center;
  font-size: 20px;
}

form {
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
</style>