<template>
  <Logo />
    <v-container>
      <v-form @submit.prevent="createAccount">
        <v-row>
          <v-col cols="12">
            <v-text-field v-model="username" label="Username" required></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field v-model="email" label="Email" type="email" required></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field v-model="password" label="Password" type="password" required></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-text-field v-model="confirmPassword" label="Confirm Password" type="password" required></v-text-field>
          </v-col>
          <v-col cols="12">
            <v-btn type="submit" color="primary" block class="mt-2">Create Account</v-btn>
          </v-col>
          <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
          <v-col cols="12" class="text-center">
            <span>Already have an account? </span>
            <router-link to="/">
            <v-btn color="secondary" href="/">Login</v-btn>
          </router-link>
          </v-col>
        </v-row>
      </v-form>
    </v-container>
  </template>
  
<script>
  import { RouterLink } from 'vue-router';
  import Logo from '@/components/Logo.vue';
  import axios from 'axios'; 
  
  export default {
    name: 'Create',
    components: {
      Logo,
    },
    data() {
      return {
        username: '',
        email: '',
        password: '',
        confirmPassword: '',
      };
    },
    methods: {
      createAccount() {
        const registrationData = {
          username: this.username,
          password: this.password,
        };
  
        axios.post('/register', registrationData)
        .then(response => {
          if (response.data.msg === 'okay') {
            console.log('Registration successful!');

            // Inform the user about successful registration
            this.$router.push({ path: '/' });
            // You can also use 'replace' instead of 'push' if you don't want the back button to go back to the registration page
            // this.$router.replace({ path: '/login' });
          } else {
            console.log('Registration failed!');
          }
        })
        .catch(error => {
          console.error('Error during registration:', error);
        });
  
        this.username = '';
        this.email = '';
        this.password = '';
        this.confirmPassword = '';
      },
    },
  };
  </script>
  
  <style scoped>
  </style>
  