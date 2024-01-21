<template>
    <div class="ccontainer">
      <Logo /><br>
      <NavBar />
          <div class="optional">
            <b><router-link to="/communicate">AI-Generated</router-link> |
            <router-link to="/counselor">Counselor</router-link></b>
          </div>
          <div class="openai">
            <br><p>You can try this chatbot to costumize your chatbot experience.</p>
            <button><a href="https://platform.openai.com/playground?mode=chat" target="blank">CHATBOT</a></button><br><br>
            <button @click="handleInstructionsClick">INSTRUCTIONS</button><br><br>

            <InstructionsModal :showModal="showInstructionsModal" @close="showInstructionsModal = false" />

          </div>
      
  </div>
</template>

<script>
import axios from 'axios';
import NavBar from '@/components/NavBar.vue';
import Logo from '@/components/Logo.vue';
import AI from '@/components/AI.vue';
import InstructionsModal from '@/components/InstructionsModal.vue';

 export default {
   name: 'Communicate',
   data(){
    return{
      showInstructionsModal: false,
    };
   },
   components: {
     NavBar,
     Logo,
     AI,
     InstructionsModal,
   },

   methods:{
      handleInstructionsClick(){
        console.log("Button clicked");
        this.showInstructionsModal = true;
      }
   }
  };

</script>

<style scoped>
.navbar-container {
  max-width: 800px;
  margin: 0 auto;
}

.ccontainer {
  max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.faq-content {
  height: 100%; /* Set the height to 100% */
  background-color: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #f58be7;
  box-sizing: border-box;
  margin-bottom: 16px;
  resize: vertical;
}
.optional{
  text-align: center;
}

@keyframes shine {
      0% {
        background-position: -100% 0;
      }
      100% {
        background-position: 200% 0;
      }
    }



    .openai {
      position: relative;
      overflow: hidden;
      background: linear-gradient(90deg, #fff, #eee, #fff); /* Adjust colors as needed */
      background-size: 200% 100%;
      animation: shine 3s linear infinite, subtlePulse 5s ease-in-out infinite;
      padding: 20px;
      
      border-radius: 10px;
    }

    .openai p {
      margin: 0;
    }

    .openai button {
      margin-top: 10px;
      padding: 10px 20px;
      background-color: #3498db; /* Adjust button color as needed */
      color: #fff; /* Adjust text color as needed */
      text-decoration: none;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .openai button:hover {
      background-color: #2980b9; /* Adjust button hover color as needed */
    }
    a{
      color: white;
    }
</style>
