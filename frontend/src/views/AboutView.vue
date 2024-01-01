<template>
    <div>
      <Logo /><br>
      <div class="navbar-container">
        <NavBar class="small-navbar" />
      </div>
  
      <section class="about-section">
        <h1>About Us</h1><br>

        <div class="mission-section">
          <h4>Our Mission</h4>
          <p>
            Our mission is to foster a positive and inclusive learning environment where students can thrive. We aim to assist students in setting and achieving their academic and personal goals, as well as developing the skills and resilience needed for success.
          </p>
        </div>

        <div class="goal-section">
          <h4>Our Goal</h4>
          <p>
            The goal of our guidance counseling service is to empower students in their personal and academic development. We strive to provide support, guidance, and resources to help students navigate their educational journey and make informed decisions about their future.
          </p>
        </div>
  
        <div class="contact-section">
          <h2>Contact Information</h2>
          <p>
            If you have any questions or need assistance, feel free to reach out to us. We are here to support you.
          </p>
          <address><br>
            <strong>Email:</strong> minsuguidance@minsu.edu.ph<br>
            <strong>Phone:</strong> 0927 689 5543
          </address>
        </div>
      </section>
    </div>
  </template>
  
  <script>
  import Logo from '@/components/Logo.vue'
  import NavBar from '@/components/NavBar.vue';
  
  export default {
    name: 'AboutView',
    components: {
      Logo,
      NavBar
    }
  }
  </script>
  
  <style scoped>
  /* Add your custom styles for the About page here */
  
  .navbar-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px; /* Adjust padding as needed */
  }
  
  .small-navbar {
    max-width: 800px; /* Adjust the max-width as needed */
    margin: 0 auto;
    padding: 10px; /* Adjust padding as needed */
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  .about-section {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
  }
  
  .goal-section,
  .mission-section,
  .contact-section {
    margin-bottom: 30px;
  }
  
  h1,
  h2 {
    text-align: center;
  }
  
  p {
    line-height: 1.6;
  }
  </style>
  