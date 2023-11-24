<template>
  <v-sheet width="300" class="mx-auto">
    <v-form @submit.prevent="login">
      <v-text-field v-model="username" label="username"></v-text-field>
      <v-text-field v-model="password" label="password" type="password"></v-text-field>
      <v-btn type="submit" block class="mt-2">Submit</v-btn>
      <p v-if="errorMsg" class="red--text">{{ errorMsg }}</p>
    </v-form>
  </v-sheet>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      errorMsg: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          username: this.username,
          password: this.password
        });

        if (response.data.msg === 'okay' && response.data.token) {
          console.log('Login successful. Token:', response.data.token);
        } else {
          this.errorMsg = 'Invalid credentials';
        }
      } catch (error) {
        console.error('Error logging in:', error);
        this.errorMsg = 'An error occurred while logging in';
      }
    }
  }
};
</script>
