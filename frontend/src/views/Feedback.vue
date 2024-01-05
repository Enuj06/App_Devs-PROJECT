<template>
    <div class="navbar-container">
      <Logo /><br>
        <NavBar  />
        <h3>This page gives you to share your thoughts and experience using this website.</h3>
        <h4>Plase fill out the form below.</h4>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content p-4 rounded m-4">
          <h5 class="card-title text-center mb-5 fw-light fs-5">{{ faqToEdit ? 'Edit FAQ' : 'Create FAQ' }}</h5>
          <form @submit.prevent="createOrUpdateFAQ">
            <label>First Name:</label>
            <input v-model="newFname" required>

            <label>Last Name:</label>
            <input v-model="newLname" required>

            <label>Feedback:</label>
            <textarea v-model="newFeedback" required></textarea>

            <button class="btn btn-success" type="submit">{{ faqToEdit ? 'Update FAQ' : 'Create FAQ' }}</button>
          </form>
        </div>
      </div>
    </div>

    <h3>Table</h3>

    <!-- Display Feedback in a wider table -->
    <table class="responsive-table">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Feedback</th>
          <th>Add here! <a class="btn btn-primary me-2" @click="openModal()" data-bs-toggle="modal"
              data-bs-target="#editModal" data-bs-placement="top" title="Edit">
              <i class="fas fa-add"></i>
            </a></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(feedback, index) in info" :key="index">
          <td>{{ feedback.first_name }}</td>
          <td>{{ feedback.last_name }}</td>
          <td>{{ feedback.feed_content }}</td>
        </tr>
      </tbody>
    </table>
    </div>
</template>




<script>
import axios from 'axios';
import Logo from '@/components/Logo.vue';
import NavBar from '@/components/NavBar.vue';

export default{
    name: 'Feedback',
    components:{
        Logo,
        NavBar,
    },
    data() {
    return {
      info: [],
      newFname: '',
      newLname: '',
      newFeedback: '',
    };
  },
  created() {
    this.getInfo();
  },
  methods: {
    async getInfo() {
      try {
        const inf = await axios.get('/getfeed');   //display
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

          this.newFname = feedback.first_name;   //faq.question is the table name and head
          this.newLname = feedback.last_name;
          this.newFeedback = feedback.feed_content;
          this.faqToEdit = faq;

          this.$router.push({ name: 'FAQ', params: { id: id } });
        } catch (error) {
          console.error('Error fetching Feedback data:', error);
        }
      } else {
        this.newFname = '';
        this.newLname = '';
        this.newFeedback = '';
        this.faqToEdit = null;

        this.$router.push({ name: 'FAQ' });
      }
    },
    async createOrUpdateFAQ() {
      try {
        if (this.faqToEdit) {
          await axios.put(`updateFaq/${this.faqToEdit.id}`, {
            first_name: this.newFname,
            last_name: this.newLname,
            feed_content: this.newFeedback,
          });
        } else {
          const response = await axios.post('cfeedback', {    //function sa controller for adding
            first_name: this.newFname,
            last_name: this.newLname,
            feed_content: this.newFeedback,
          });

          const newFeedback = response.data;
          this.info.push(newFeedback);
        }

        this.newFname = '';
        this.newLname = '';
        this.newFeedback = '';
        this.faqToEdit = null;

        this.$router.push({ name: 'SomeOtherRoute' });
      } catch (error) {
        console.error('Error creating/updating FAQ:', error);
      }
      this.getInfo();
      this.closeModal();
    },

    closeModal() {
      this.$router.push({ name: 'FAQ' });
      $('#editModal').modal('hide');
    },
  },
}
</script>













<style scoped>

/* --------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------- */

.responsive-table{
  width: 100%;
  border-collapse: collapse;
  /* Add more styles */
}

/* Responsive styles */
@media (max-width: 600px){
  /* Adjust styles for smaller screens */
  /**= For example, make cells block elements to stack them */

  td, th{
    display: block;
    width: 100%;
    box-sizing: border-box;
    /* Add any other necessary styles for smaller screeens */
  }
}

/* --------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------- */
/* --------------------------------------------------------------------------------------- */


.navbar-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px; /* Adjust padding as needed */
  }

  h1, h3, h4{
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
