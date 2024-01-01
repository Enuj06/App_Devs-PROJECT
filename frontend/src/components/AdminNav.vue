<template>
    <v-tabs bg-color="secondary" class="sticky-tabs">
      <v-tab href="/users" class="custom-tab">Users</v-tab>
      <v-tab href="/announcements" class="custom-tab">Announcements</v-tab>
      <v-tab href="/faqsadmin" class="custom-tab">FAQs</v-tab>
      <v-tab href="/schedules" class="custom-tab">Schedules</v-tab>
      <v-tab href="" class="logout-tab" @click="confirmation">Log Out</v-tab>
    </v-tabs>
  </template>
  
  <script>
  export default {
    methods: {
    confirmation() {
      var answer = confirm("Confirm Log Out?")
      if(answer){
        this.$router.push("/")
      }
      else{
        return false;
    }
    }
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
  