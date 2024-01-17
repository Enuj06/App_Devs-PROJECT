<template>
    <div v-if="feedbacks.length > 0">
      <vueper-slides
        ref="myVueperSlides"
        autoplay
        :autoplay-options="{ pauseOnHover: pauseOnHover, duration: 5000 }"
        @autoplay-pause="internalAutoPlaying = false"
        @autoplay-resume="internalAutoPlaying = true"
        :loop="true"
      >
<vueper-slide
  v-for="(feedback, i) in feedbacks"
  :key="i"
  :title="`<b>` +feedback.first_name + ' ' + feedback.last_name + `</b>`"
  :content="`<h4>` + `<i>` + feedback.feed_content + `</i>`"
  :style="'background-color: ' + colors[i % colors.length] + '; color: #333; font-weight: bold;'"
>
  <template #title>
    <b>{{ feedback.first_name + ' ' + feedback.last_name }}</b>
  </template>
</vueper-slide>
<template #pause>
  <i class="icon pause_circle_outline" style="color: #007bff;"></i>
</template>
</vueper-slides>

    </div>
    <div v-else>
      <!-- Add loading state or message here if needed -->
    </div>  
  </template>
  
  <script>
  import { VueperSlides, VueperSlide } from 'vueperslides';
  import 'vueperslides/dist/vueperslides.css';
  import axios from 'axios';
  
  export default {
    name: 'FeedCarousel',
    components: {
      VueperSlides,
      VueperSlide,
    },
    data() {
      return {
        pauseOnHover: true,
        autoPlaying: true,
        internalAutoPlaying: true,
        feedbacks: [],
        colors: ['#f8f8f8', '#faf3e0', '#e0f7fa', '#ffe0b2'], // Light and subtle background colors
      };
    },
    methods: {
      async fetchData() {
        console.log('Fetching data...');
        try {
          const response = await axios.get('/getfeed');
          console.log('Fetched data:', response.data);
          this.feedbacks = response.data;
        } catch (error) {
          console.error('Error fetching Feedbacks:', error);
        }
      },
      toggleAutoplay() {
        if (this.$refs.myVueperSlides) {
          this.$refs.myVueperSlides[`${this.autoPlaying ? 'pause' : 'resume'}Autoplay`]();
          this.autoPlaying = !this.autoPlaying;
        }
      },
    },
    mounted() {
      this.fetchData();
    },
  };
  </script>
  