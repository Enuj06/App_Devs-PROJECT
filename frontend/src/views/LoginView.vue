<template>
  <div>
    <Logo /><br><br>
  </div>
  <v-sheet width="300" class="mx-auto">
    <v-form @submit.prevent="login">
      <v-text-field 
      v-model="username" 
      label="Username"
      ></v-text-field>
      <v-text-field
      v-model="password"
      label="Password"
      :type="showPassword ? 'text' : 'password'" 
      append-icon="mdi-eye" 
      @click:append="showPassword = !showPassword" 
      ></v-text-field>

      <v-btn type="submit" block class="mt-2" color="primary">Submit</v-btn><br>
      <p v-if="errorMsg" class="red--text">{{ errorMsg }}</p>
    </v-form>
    <v-col cols="12" class="text-center">
      <v-col cols="12">
            <v-divider></v-divider>
          </v-col>
    <span>Don't have an account?</span>
    <v-btn text block color="secondary" router-link="/create" class="mt-2">Create Account</v-btn>
  </v-col>
  </v-sheet>
</template>

<script>
import axios from 'axios';
import Logo from '@/components/Logo.vue';

export default {
  name: 'LoginView',
  components: {
    Logo,
  },
  data() {
    return {
      username: '',
      password: '',
      showPassword: false,
      errorMsg: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('/login', {
          username: this.username,
          password: this.password,
        });

        if (response.data.msg === 'okay' && response.data.token) {
            console.log('Login successful. Token:', response.data.token);
            // Set authentication token in local storage
            localStorage.setItem('authenticated', 'true');

            // Checking of role and redirect
            if (response.data.role === 'admin') {
                this.$router.push('/adminhome');
            } else if (response.data.role === 'user') {
                this.$router.push('/communicate');
            }
        } else {
            this.errorMsg = 'Invalid credentials';
        }
    } catch (error) {
        console.error('Error logging in:', error);
        this.errorMsg = 'An error occurred while logging in';
    }
    },
  },
};
</script>