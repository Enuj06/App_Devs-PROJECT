<template>
  <div class="faq-container">
    <Logo /><br>
    <NavBar />
    <div class="event-container">
      <h1 style="text-align: center;"><b>MinSU Events</b></h1><br>   
      <div v-for="(announcement, index) in announcements" :key="index" class="announcement-container">
        <div class="announcement-details">
          <h3>{{ announcement.title }}</h3>
          <p>{{ announcement.content }}</p>
        </div>
        <hr> <!-- Move the <hr> here -->
        <div class="announcement-image">
          <img class="img-fluid menu" style="max-width: 250px; height: auto; margin-top: 10px;"
            :src="require('@/assets/img/' + announcement.image_url)" alt="" /><hr>
        </div>
      </div><hr>
    </div>
  </div>
</template>


  
  <script>
  import axios from 'axios';
  import Logo from '@/components/Logo.vue';
  import NavBar from '@/components/NavBar.vue';
  
  export default {
    name: 'Events',
    components: {
      Logo,
      NavBar,
    },
    data() {
      return {
        announcements: [],
      };
    },
    mounted() {
      this.fetchAnnouncements();
    },
    methods: {
      async fetchAnnouncements() {
        try {
          const response = await axios.get('/fetch-announcements');
          this.announcements = response.data;
        } catch (error) {
          console.error('Error fetching announcements:', error);
        }
      },
    },
  };
  </script>
  
  <style scoped>
    .faq-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    }

    .faq-content {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  .event-container {
    background-color: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .announcement-container {
    display: flex;
    margin-bottom: 20px;
  }
  
  .announcement-details {
    flex: 1;
  }
  
  .announcement-image {
    flex-shrink: 0;
    margin-left: 20px;
  }
  
  img {
    max-width: 100%;
    height: auto;
  }
  </style>
  