<template>
    <div>
        <img :src="logo" alt="MinSU Logo" class="logo-img">
    </div>

</template>

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