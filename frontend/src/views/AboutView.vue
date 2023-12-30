<template>
    <div>
        <Logo />
        <NavBar />
        <h1>This is an About page</h1>
    </div>
</template>

<script>
import Logo from '@/components/Logo.vue'
import NavBar from '@/components/NavBar.vue';
    
export default{
    name: 'AboutView',
        components:{
        Logo,
        NavBar
      }
    }
</script>