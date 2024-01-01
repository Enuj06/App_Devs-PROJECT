<template>
      <v-tabs bg-color="secondary" class="sticky-tabs">
      <v-tab href="/communicate">Home</v-tab>
      <v-tab href="/events">Events</v-tab>
      <v-tab href="/FAQs">FAQs</v-tab>
      <v-tab href="/about">About</v-tab>
      <v-tab href="/appointments">Appointments</v-tab>
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