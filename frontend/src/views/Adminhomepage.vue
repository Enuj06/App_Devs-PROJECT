<template>  
        <AdminLogo />
        <AdminNav />

        <br><h2>Hello, Admin!</h2>

<div class="header-text">
        <h1>I hope you are doing well!</h1>
        <h1>Thank you for your patronage in using this system.</h1>
        <h1>We, as a team, are so glad that you are giving support to our beloved MinSUans.</h1>
        <h1>Let's make everything positive and let us ensure that everyone gets the good vibes they deserve.</h1>
        <h1>Here we go!😉</h1>
</div>
</template>


<style scoped>

h1, h2, p {
text-align: center;
}

.header-text {
margin: 4%;
font-size: 10px;
margin-left: 4%;
}

.header-text h1 {
font-size: 19px;
margin-top: 20px;
border-right: 0px solid;
width: 100%;
white-space: nowrap;
overflow: hidden;
animation:
typing 2s steps(120),
cursor .4s step-end infinite alternate;
}

@keyframes typing {
from {
width: 0;
}
}

</style>


<script>
import AdminNav from '@/components/AdminNav.vue';
import AdminLogo from '@/components/AdminLogo.vue';

export default{
name: 'Adminhomepage',
components:{
        AdminNav,
        AdminLogo
}
}
</script>