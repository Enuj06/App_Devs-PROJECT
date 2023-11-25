<template>
    <div>
      <nav>
        <router-link to="/">HOME</router-link> |
        <router-link to="/about">ABOUT</router-link> |
        <router-link to="/communicate">CHAT</router-link>
      </nav>
    </div>
</template>

<script>
  export default{
    name: "NavBar",
    components:{
      
    }
  }
</script>