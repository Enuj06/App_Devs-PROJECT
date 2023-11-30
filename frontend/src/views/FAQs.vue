<template>
    <div>
        <Logo />
        <NavBar />
        <h1>Frequently Asked Questions</h1><br><br>
        <div v-for="(faq, index) in faqList" :key="index">
            <h3>{{ faq.question }}</h3>
            <p>{{ faq.answer }}</p>
            <hr />
          </div>
        </div>
      </template>
      
      <script>
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
            faqList: [
              {
                question: 'What courses should I take to prepare for my career?',
                answer: 'Consider courses that align with your career field. Look for subjects that offer practical skills and knowledge relevant to the industry. Consult professionals or mentors in your intended career for specific recommendations.',
              },
              {
                question: 'How can I improve my study habits or time management skills?',
                answer: 'Enhance your study habits by creating a schedule, setting goals, eliminating distractions, and using effective study techniques like active recall and spaced repetition. Time management can be improved by prioritizing tasks and using tools like planners or apps.',
              },
              {
                question: 'What are the requirements for graduation or college admission?',
                answer: 'Graduation requirements vary by institution but typically include completing credit hours and specific courses. College admission requirements often involve standardized tests (SAT, ACT), GPA, essays, and extracurricular activiti',
              },
              {
                question: 'What career paths match my interests and strengths?',
                answer: 'Explore career assessment tools or talk to career counselors to identify careers that align with your interests, strengths, and values. Consider internships or shadowing experiences to gain insights into various professions.',
              },
              {
                question: 'Im feeling stressed or overwhelmed. How can I manage these feelings?',
                answer: 'Practice stress management techniques such as deep breathing, mindfulness, exercise, and seeking social support. Establish healthy boundaries and time for relaxation.',
              },
              {
                question: 'How can I handle conflicts with my friends or peers?',
                answer: 'Approach conflicts calmly, communicate openly, and listen actively to understand perspectives. Focus on finding solutions and seek help from a mediator or counselor if necessary.',
              },
              {
                question: 'Im experiencing difficulties at home. Can you provide guidance?',
                answer: 'Seek support from trusted adults, family counseling, or therapists to address challenges. Establish open communication and consider family therapy if needed.',
              },
            ],
          };
        },
      };
      </script>