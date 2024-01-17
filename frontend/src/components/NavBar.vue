<template>
  <v-tabs bg-color="secondary" class="sticky-tabs">
    <router-link to="/communicate" class="custom-tab">
      <v-tab>Home</v-tab>
    </router-link>
    <router-link to="/events" class="custom-tab">
      <v-tab>Events</v-tab>
    </router-link>
    <router-link to="/FAQs" class="custom-tab">
      <v-tab>FAQs</v-tab>
    </router-link>
    <router-link to="/about" class="custom-tab">
      <v-tab>About</v-tab>
    </router-link>
    <router-link to="/appointments" class="custom-tab">
      <v-tab>Appointments</v-tab>
    </router-link>
    <router-link to="/feedback" class="custom-tab">
      <v-tab>Feedback</v-tab>
    </router-link>
    <v-tab class="logout-tab" @click="confirmation"><b>Log Out</b></v-tab>
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

.custom-tab {
    color: rgb(255, 255, 255);
  }
</style>