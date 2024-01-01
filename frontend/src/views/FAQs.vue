<template>
  <div class="faq-container">
    <Logo />
    <NavBar />
    <div class="faq-content">
      <h1>Frequently Asked Questions</h1>
      <div v-for="(faq, index) in faqList" :key="index" class="faq-item">
        <h3>{{ faq.question }}</h3>
        <p>{{ faq.answer }}</p>
        <hr />
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Logo from '@/components/Logo.vue';
import NavBar from '@/components/NavBar.vue';

export default {
  name: 'FAQs',
  components: {
    Logo,
    NavBar,
  },
  data() {
    return {
      faqList: [],
    };
  },
  mounted() {
    this.fetchFAQ();
  },
  methods: {
    async fetchFAQ() {
      try {
        const response = await axios.get('/getFAQ');
        this.faqList = response.data;
      } catch (error) {
        console.error('Error fetching FAQ data:', error);
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

.faq-item {
  margin-bottom: 20px;
}

h1 {
  color: #333;
}

h3 {
  color: #007bff;
}

p {
  color: #666;
}

hr {
  border: 1px solid #ddd;
}

/* Add more styling as needed */
</style>
