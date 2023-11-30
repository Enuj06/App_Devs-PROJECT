<template>
      <v-tabs bg-color="secondary">
      <v-tab value="one" href="/communicate">Home</v-tab>
      <v-tab value="two" href="/events">Events</v-tab>
      <v-tab value="three" href="/FAQs">FAQs</v-tab>
      <v-tab value="three" href="/about">About</v-tab>
      <v-tab value="three" href="" class="logout-tab" @click="confirmation">Log Out</v-tab>
    </v-tabs>
</template>

<script>
export default {
  methods: {
    confirmation() {
      var answer = confirm("Confirm submit?")
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
</style>