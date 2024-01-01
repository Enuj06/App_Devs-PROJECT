<template>
    <div class="header-container">
      <h1 class="admin-title">Admin Panel &#128512;</h1>
      <div class="logo-container">
        <img :src="logo" alt="MinSU Logo" class="logo-img">
        <h1>Mindoro State University <h2>Guidance Office</h2></h1>
      </div>
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
  <style scoped>
  .header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px;
    background-color: #f0f0f0; /* Add a background color if needed */
  }
  
  .admin-title {
    margin: 0; /* Remove default margin */
  }
  
  .logo-container {
    display: flex;
    align-items: center;
  }
  
  .logo-img {
    margin-right: 10px;
  }
  </style>
  