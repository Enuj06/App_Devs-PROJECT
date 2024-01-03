<template>
  <v-tabs bg-color="secondary" class="sticky-tabs">
    <router-link to="/communicate">
      <v-tab>Home</v-tab>
    </router-link>
    <router-link to="/events">
      <v-tab>Events</v-tab>
    </router-link>
    <router-link to="/FAQs">
      <v-tab>FAQs</v-tab>
    </router-link>
    <router-link to="/about">
      <v-tab>About</v-tab>
    </router-link>
    <router-link to="/appointments">
      <v-tab>Appointments</v-tab>
    </router-link>
    <router-link to="/cfeedback">
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
        this.$router.push("/")
      }
      else{
        return false;
    }
    }
  }
}
</script>


<style scoped>
.logout-tab{
  margin-left: auto;
}

.sticky-tabs {
  position: sticky;
  top: 0;
  z-index: 1000; /* Adjust the z-index as needed to ensure it appears above other elements */
}
</style>