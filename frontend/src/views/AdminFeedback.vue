<template>
    <div class="navbar-container">
      <AdminLogoVue/><br>
        <AdminNav  />
        <h1>Feedback</h1>
        <h3>Feedback Table</h3>
    </div>
</template>


<script>
import AdminLogoVue from '@/components/AdminLogo.vue';
import AdminNav from '@/components/AdminNav.vue';

export default{
    name: 'AdminFeedback',
    components:{
        AdminNav,
        AdminLogoVue,
    },

}
</script>

<style scoped>
h1, h3, h4{
    text-align: center;
}
</style>