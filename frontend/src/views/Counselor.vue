<template>
        <div class="navbar-container">
      <Logo /><br>
        <NavBar  />
    <div class="optional">
            <b><router-link to="/communicate">AI-Generated</router-link> |
            <router-link to="/counselor">Counselor</router-link></b>
    </div>
    <h3>
        <div class="container">
          <div v-if="hideandshow" class="typed-out">
            <p>Hello MinSUAN!</p>
            <p>This chatbot cannot typically reply instantly due to its processing nature and the need to generate thoughtful and accurate responses.</p>
            <p>Similarly, the busy schedule of a guidance counselor may also contribute to delays in providing immediate assistance.</p>
            <p>Guidance counselors often have various responsibilities, including advising students, conducting counseling sessions, and managing administrative tasks.</p>
            <p>As a result, they may not always be available to respond instantly, but they strive to offer valuable support and guidance when they can.</p><br>
            <p>We are here for you.💗</p>
          </div>
        </div>
      </h3>
      <div v-if="!hideandshow">
        <AdminAI />
      </div>
      </div>
</template>

<script>
import Logo from '@/components/Logo.vue';
import NavBar from '@/components/NavBar.vue';
import AdminAI from '@/components/AdminAI.vue';

export default{
    name: 'Couselor',
    components:{
        Logo,
        NavBar,
        AdminAI,
    },
    data() {
      return {
        hideandshow: true,
      };
    },
    mounted() {
      // Auto-hide the text after 10 seconds
      setTimeout(() => {
        this.hideText();
      }, 10000);
    },
    methods: {
      hideText() {
        // false to hide the other text
        this.hideandshow = false;
      }
    }
}
</script>

<style scoped>
    .navbar-container {
      max-width: 800px;
    margin: 0 auto;
    padding: 20px; /* Adjust padding as needed */
}

.optional{
    text-align: center;
}

.typed-out {
    opacity: 1;
    animation: fadeInOut 30s forwards;
  }
  
  @keyframes fadeInOut {
    0%, 100% {
      opacity: 1;
    }
    50%, 99% {
      opacity: 1;
    }
    100% {
      opacity: 0;
    }
  }

  p{
    margin-left: 60px;
    max-width: 800px;
    margin: 0 auto;
  }
</style>