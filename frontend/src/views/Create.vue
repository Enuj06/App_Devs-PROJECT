<template>
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
            <v-btn type="submit" color="primary">Create Account</v-btn>
          </v-col>
          <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
          <v-col cols="12" class="text-center">
            <span>Already have an account? </span>
            <router-link to="/">
            <v-btn color="primary">Login</v-btn>
          </router-link>
          </v-col>
        </v-row>
      </v-form>
    </v-container>
  </template>
  
  <script>
  import { RouterLink } from 'vue-router';
  export default {
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
        // Perform account creation logic here
        // For example, you can make an API call to a server to create the account
        console.log('Account created with the following details:');
        console.log('Username:', this.username);
        console.log('Email:', this.email);
        console.log('Password:', this.password);
        console.log('Confirm Password:', this.confirmPassword);
  
        // Reset form fields after submission
        this.username = '';
        this.email = '';
        this.password = '';
        this.confirmPassword = '';
      },
      goToLoginPage() {
        // You can implement the logic to navigate to the login page here
        console.log('Redirecting to the login page');
        // Example using Vue Router:
        // this.$router.push('/login');
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  </style>
  