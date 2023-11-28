<template>
  <Hamburger />
  <v-card class="d-flex flex-column justify-center align-center">
  <NavBar />
    <v-card-text>
      <v-container class="align-center">
        <form @submit.prevent="submitForm" class="mx-auto">
          <v-sheet width="300">
            <textarea
              v-model="chatbotResponse"
              cols="30"
              rows="10"
              placeholder="Chatbot response..."
              style="
                background-color: rgb(175, 189, 201);
                width: 100%;
                padding: 12px;
                border: 1px solid #f58be7;
                box-sizing: border-box;
                margin-bottom: 16px;
                resize: vertical;
                min-height: 150px; /* Adjust the height */
              "
              readonly
            ></textarea>

            <!-- User input textarea -->
            <textarea
              v-model="userMessage"
              cols="30"
              rows="5" 
              placeholder="Input your thoughts here..."
              style="
                background-color: rgb(175, 189, 201);
                width: 100%;
                padding: 12px;
                border: 1px solid #f58be7;
                box-sizing: border-box;
                margin-bottom: 16px;
                resize: vertical;
              "
            ></textarea>

            <!-- Submit button -->
            <v-btn type="submit" block class="mt-2">Submit</v-btn>
          </v-sheet>
        </form>
      </v-container>
    </v-card-text>
  </v-card>
</template>
<script>
import axios from 'axios';
import Hamburger from '@/components/Hamburger.vue';
import NavBar from '@/components/NavBar.vue'
export default {
  name: 'Communicate',
  components:{
    Hamburger,
    NavBar
  },
  data() {
    return {
      tab: null,
      userMessage: '',
      chatbotResponse: ''
    };
  },
    async submitForm() {
      try {
        const response = await axios.post('/chatbotinteraction', {
          message: this.userMessage
        });

        if (response.data && response.data.response) {
          this.chatbotResponse = response.data.response;
        } else {
          console.error('Invalid response format from server');
        }

        this.userMessage = '';
      } catch (error) {
        console.error('Error submitting form:', error);
      }
    }
  }
</script>















<style>
textarea {
  min-width: 100%; 
}

.flex-column {
  flex-direction: column;
}
.align-center {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  height: 100%;
}
</style>
