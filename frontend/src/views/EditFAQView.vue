<template>
    <div>
      <h1>Edit FAQ</h1>
  
      <!-- Form for editing FAQ -->
      <form @submit.prevent="updateFAQ">
        <label>Question:</label>
        <input v-model="editedQuestion" required>
  
        <label>Answer:</label>
        <textarea v-model="editedAnswer" required></textarea>
  
        <button type="submit">Update FAQ</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import { router } from '@/router';  // Import the router from your router file
  
  export default {
    name: 'EditFAQView',
    data() {
      return {
        editedQuestion: '',
        editedAnswer: '',
        error: null, // Add an error property to store error messages
      };
    },
    created() {
      // Fetch the existing FAQ data to populate the form
      this.fetchFAQData();
    },
    methods: {
      async fetchFAQData() {
        try {
          // Assuming you have an API endpoint to fetch FAQ details based on ID
          const response = await axios.get(`/get-faq/${this.$route.params.id}`);
  
          // Populate the form fields with existing FAQ data
          this.editedQuestion = response.data.question;
          this.editedAnswer = response.data.answer;
        } catch (error) {
          // Handle the 404 error
          if (error.response && error.response.status === 404) {
            this.error = 'FAQ not found';
          } else {
            console.error('Error fetching FAQ data:', error);
          }
        }
      },
      async updateFAQ() {
        try {
          // Assuming you have an API endpoint to update FAQ based on ID
          const response = await axios.post(`/update-faq/${this.$route.params.id}`, {
            question: this.editedQuestion,
            answer: this.editedAnswer,
          });
  
          if (response.data.msg === 'okay') {
            // Redirect to FaqsAdmin view after successful update
            this.$router.push({ name: 'FaqsAdmin' });
            console.log('FAQ updated successfully');
          } else {
            console.error('Failed to update FAQ');
          }
        } catch (error) {
          console.error('Error updating FAQ:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
  h1 {
    text-align: center;
  }
  
  form {
    max-width: 800px; /* Adjust the width as needed */
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
  
  button {
    background-color: #4caf50;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  button:hover {
    background-color: #45a049;
  }
  </style>
    