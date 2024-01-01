<template>
    <div class="logo-container">
        <img :src="logo" alt="MinSU Logo" class="logo-img">
        <h1>Mindoro State University <h2>Guidance Office</h2></h1>
    </div>
</template>

<style>
.logo-container {
    display: flex;
    align-items: center; /* Vertical alignment */
    margin: 0;
    justify-content: center;
}

.logo-img {
    margin-right: 10px; /* Adjust the margin as needed */
}
</style>


<script>
import Logo from '@/assets/pictures/minsulogo.png'

export default{
    data() {
        return {
            logo: Logo,
        };
    }
}
</script>