<template>
  <div>
    <AdminLogo /><br>
    <AdminNav />

    <h1>Frequently Asked Questions</h1>

    <!-- Form for creating new FAQ -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content p-4 rounded m-4">
          <h5 class="card-title text-center mb-5 fw-light fs-5">{{ faqToEdit ? 'Edit FAQ' : 'Create FAQ' }}</h5>
          <form @submit.prevent="createOrUpdateFAQ">
            <label>Question:</label>
            <input v-model="newQuestion" required>

            <label>Answer:</label>
            <textarea v-model="newAnswer" required></textarea>

            <button class="btn btn-success" type="submit">{{ faqToEdit ? 'Update FAQ' : 'Create FAQ' }}</button>
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
          <th>Question</th>
          <th>Answer</th>
          <th>Actions <a class="btn btn-primary me-2" @click="openModal()" data-bs-toggle="modal"
              data-bs-target="#editModal" data-bs-placement="top" title="Edit">
              <i class="fas fa-add"></i>
            </a></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(faq, index) in info" :key="index">
          <td>{{ index + 1 }}</td>
          <td>{{ faq.question }}</td>
          <td>{{ faq.answer }}</td>
          <td>
            <a class="btn btn-primary me-2" @click="openModal(faq.id)" data-bs-toggle="modal" data-bs-target="#editModal"
              data-bs-placement="top" title="Edit">
              <i class="fas fa-edit"></i>
            </a>
            <a class="btn btn-danger ms-2" @click="staffDelete(faq.id)" data-bs-toggle="tooltip" data-bs-placement="top"
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
          Are you sure you want to delete this FAQ?
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
import AdminNav from '@/components/AdminNav.vue';
import AdminLogo from '@/components/AdminLogo.vue';

export default {
  name: 'FaqsAdmin',
  components: {
    AdminNav,
    AdminLogo,
  },
  data() {
    return {
      info: [],
      newQuestion: '',
      newAnswer: '',
    };
  },
  created() {
    this.getInfo();
  },
  methods: {
    async getInfo() {
      try {
        const inf = await axios.get('/getFAQ');
        this.info = inf.data;
      } catch (error) {
        console.log(error);
      }
    },
    async openModal(id = null) {
      if (id) {
        try {
          const response = await axios.get(`fetchFaq/${id}`);
          const faq = response.data;

          this.newQuestion = faq.question;
          this.newAnswer = faq.answer;
          this.faqToEdit = faq;

          this.$router.push({ name: 'FAQ', params: { id: id } });
        } catch (error) {
          console.error('Error fetching FAQ data:', error);
        }
      } else {
        this.newQuestion = '';
        this.newAnswer = '';
        this.faqToEdit = null;

        this.$router.push({ name: 'FAQ' });
      }
    },
    async createOrUpdateFAQ() {
      try {
        if (this.faqToEdit) {
          await axios.put(`updateFaq/${this.faqToEdit.id}`, {
            question: this.newQuestion,
            answer: this.newAnswer,
          });
        } else {
          const response = await axios.post('create-faq', {
            question: this.newQuestion,
            answer: this.newAnswer,
          });

          const newFaq = response.data;
          this.info.push(newFaq);
        }

        this.newQuestion = '';
        this.newAnswer = '';
        this.faqToEdit = null;

        this.$router.push({ name: 'SomeOtherRoute' });
      } catch (error) {
        console.error('Error creating/updating FAQ:', error);
      }
      this.getInfo();
      this.closeModal();
    },
    editFAQ(faq) {
      this.newQuestion = faq.question;
      this.newAnswer = faq.answer;

      this.$router.push({ name: 'EditFAQView', params: { id: faq.id } });
    },

    async deleteFAQ(id) {
      try {
        const response = await axios.get('/delete-faq/' + id);

        if (response.data.msg === 'okay') {
          this.getInfo();
        } else {
          console.error('Failed to delete FAQ');
        }
      } catch (error) {
        console.error('Error deleting FAQ:', error);
      }
    },
    staffDelete(userId) {
      this.DeleteId = userId;

      $('#deleteModal').modal('show');
    },
    deleteConfirmed() {
      this.deleteStaff(this.DeleteId);

      $('#deleteModal').modal('hide');
    },
    async deleteStaff(userId) {
      try {
        await axios.delete(`deleteFAQ/${userId}`);
        this.$refs.notification.open("Deleted successfully.", 'success');
        this.getStaff();
      } catch (error) {
        console.log(error);
      }
      this.$router.push({ name: 'FAQ' });
      this.getInfo();
      this.closeModal();
    },
    closeModal() {
      this.$router.push({ name: 'FAQ' });
      $('#editModal').modal('hide');
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
  