<template>
  <v-tabs bg-color="secondary" class="sticky-tabs">
    <router-link to="/users" class="custom-tab">
      <v-tab>Users</v-tab>
    </router-link>
    <router-link to="/announcements" class="custom-tab">
      <v-tab>Announcements</v-tab>
    </router-link>
    <router-link to="/faqsadmin" class="custom-tab">
      <v-tab>FAQs</v-tab>
    </router-link>
    <router-link to="/schedules" class="custom-tab">
      <v-tab>Schedules</v-tab>
    </router-link>
    <router-link to="/adminfeedback" class="custom-tab">
      <v-tab>Feedback</v-tab>
    </router-link>
    <v-tab class="logout-tab" @click="confirmation">Log Out</v-tab>
  </v-tabs>
</template>
  
  <script>
  export default {
    methods: {
    confirmation() {
      var answer = confirm("Confirm Log Out?")
      if(answer){
        this.$router.push("/");
      }
      else{
        return false;
    }
    },
  },
  };
  </script>
  
  <style scoped>
  .custom-tab {
    min-width: 120px; /* Adjust the width as needed */
  }
  
  .logout-tab {
    margin-left: auto;
  }
  
  .sticky-tabs {
    position: sticky;
    top: 0;
    z-index: 1000; /* Adjust the z-index as needed to ensure it appears above other elements */
  }
  </style>
  