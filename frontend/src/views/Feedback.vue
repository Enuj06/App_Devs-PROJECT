<template>
    <div class="navbar-container">
      <Logo /><br>
        <NavBar  />
        <h3>This page gives you to share your thoughts and experience using this website.</h3>
        <h4>Plase fill out the form below.</h4>
    </div>
</template>

<script>
import Logo from '@/components/Logo.vue';
import NavBar from '@/components/NavBar.vue';

export default{
    name: 'Feedback',
    components:{
        Logo,
        NavBar,
    }
}
</script>

<style scoped>
.navbar-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px; /* Adjust padding as needed */
  }

  h1, h3, h4{
    text-align: center;
}
</style>
