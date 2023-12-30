<template>
    <Logo />
    <NavBar />
    <h1>MinSU Events</h1>
    
</template>

<script>
import Logo from '@/components/Logo.vue'
import NavBar from '@/components/NavBar.vue'

export default{
    name: 'Events',
    components:{
        Logo,
        NavBar
    }
}
</script>