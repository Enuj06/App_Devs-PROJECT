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
  import Logo from '@/components/Logo.vue'
  export default {
    name: 'Create',
    components:{
      Logo
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
    },
  };
  </script>
  
  <style scoped>
  /* Add your custom styles here */
  </style>
  