<template>
    <div>
        <Logo />
        <NavBar />
        <h1>Frequently Asked Questions</h1>
    </div>
</template>

<script>
import Logo from '@/components/Logo.vue'
import NavBar from '@/components/NavBar.vue';

export default{
    name: 'FAQs',
        components:{
        Logo,
        NavBar
    }
}
</script>