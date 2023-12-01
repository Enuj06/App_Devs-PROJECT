<template>
    <div :class="{ 'dark-mode': isDarkMode }">
      <h1>Dark Mode Toggle Example</h1>
  
      <!-- Dark Mode Toggle Component -->
      <button @click="toggleDarkMode" class="toggle-button">
        {{ isDarkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode' }}
      </button>
  
      <!-- Your page content goes here -->
      <p>This is your page content.</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        isDarkMode: false,
      };
    },
    methods: {
      toggleDarkMode() {
        this.isDarkMode = !this.isDarkMode;
        // Save the user's preference to localStorage or a backend
        localStorage.setItem("darkMode", this.isDarkMode.toString());
      },
      checkSavedMode() {
        // Check if the user has a saved preference for dark mode
        const savedMode = localStorage.getItem("darkMode");
  
        if (savedMode !== null) {
          this.isDarkMode = savedMode === "true";
        }
      },
    },
    created() {
      // Check and apply the saved mode when the component is created
      this.checkSavedMode();
    },
  };
  </script>
  
  <style scoped>
  /* Dark mode styles */
  .dark-mode {
    color: white;
    background-color: #333;
  }
  
  /* Additional styling for the toggle button */
  .toggle-button {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    cursor: pointer;
    margin-bottom: 20px;
  }
  </style>
  