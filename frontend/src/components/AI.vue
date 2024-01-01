<template>
  <div class="chatbot">
    <header>
      <h2>AI_Generated Chatbot</h2>
    </header>
    <ul class="chatbox" ref="chatbox">
      <li class="chat incoming">
        <span class="material-symbols-outlined">smart_toy</span>
        <p>Hi there 👋<br>How may I help you?</p>
      </li>
      <!-- <li class="chat outgoing">
        <p>I want someone to talk to. Please.</p>
      </li> -->
    </ul>
    <div class="chat-input">
      <textarea ref="chatInput" v-model="userMessage" @input="adjustTextareaHeight" placeholder="Enter a message..." required></textarea>
      <span class="material-symbols-outlined" @click="handleChat">send</span>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      userMessage: "",
      API_KEY: "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",
      inputInitHeight: 0,
    };
  },
  mounted() {
    this.$nextTick(() => {
      this.inputInitHeight = this.$refs.chatInput.scrollHeight;
    });
  },
  methods: {
    createChatLi(message, className) {
      const chatLi = document.createElement("li");
      chatLi.classList.add("chat", className);
      let chatContent = className === "outgoing" ? `<p></p>` : `<span class="material-symbols-outlined">smart_toy</span><p></p>`;
      chatLi.innerHTML = chatContent;
      chatLi.querySelector("p").textContent = message;
      return chatLi;
    },
    generateResponse(incomingChatLi) {
      const API_URL = "https://api.openai.com/v1/chat/completions";
      const messageElement = incomingChatLi.querySelector("p");

      const requestOptions = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${this.API_KEY}`,
        },
        body: JSON.stringify({
          model: "gpt-3.5-turbo",
          messages: [{ role: "user", content: this.userMessage }],
        }),
      };

      fetch(API_URL, requestOptions)
        .then((res) => res.json())
        .then((data) => {
          messageElement.textContent = data.choices[0].message.content;
        })
        .catch((error) => {
          messageElement.classList.add("error");
          messageElement.textContent = "Oops! Something went wrong. Please try again.";
        })
        .finally(() =>
          this.$refs.chatbox.scrollTo(0, this.$refs.chatbox.scrollHeight)
        );
    },
    handleChat() {
      const userMessage = this.userMessage.trim();
      if (!userMessage) return;
      this.userMessage = "";
      this.$refs.chatInput.style.height = `${this.inputInitHeight}px`;

      this.$refs.chatbox.appendChild(
        this.createChatLi(userMessage, "outgoing")
      );
      this.$refs.chatbox.scrollTo(0, this.$refs.chatbox.scrollHeight);

      setTimeout(() => {
        const incomingChatLi = this.createChatLi("Thinking...", "incoming");
        this.$refs.chatbox.appendChild(incomingChatLi);
        this.$refs.chatbox.scrollTo(0, this.$refs.chatbox.scrollHeight);
        this.generateResponse(incomingChatLi);
      }, 600);
    },
    adjustTextareaHeight() {
      this.$refs.chatInput.style.height = `${this.inputInitHeight}px`;
      this.$refs.chatInput.style.height = `${this.$refs.chatInput.scrollHeight}px`;
    },
    handleEnterKey(e) {
      if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        this.handleChat();
      }
    },
  },
};
</script>
  
  <style scoped>
@import url('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0');
  
  
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
  }
  
  body {
    background: #e3f2fd;
  }
  
 .chatbot {
  background: #fff;
  width: 420px;
  position: relative;
  margin: 0 auto;
  overflow-y: auto; /* Enable vertical scrolling */
  max-height: 80vh; /* Adjust this value based on your design */
  border-radius: 15px;
  box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1), 0 32px 64px -48px rgba(0, 0, 0, 0.5);
}
  .chatbot header {
    background: #9ce67f;
    padding: 16px 0;
    text-align: center;
  }
  
  .chatbot header h2 {
    color: #fff;
    font-size: 1.4rem;
  }
  
  .chatbot .chatbox {
    height: 510px;
    overflow-y: auto;
    padding: 30px 20px 100px;
  }
  
  .chatbox .chat {
    display: flex;
  }
  
  .chatbox .chat p {
    color: #fff;
    font-size: 0.95rem;
    background: #724ae8;
    border-radius: 10px 10px 0 10px;
    padding: 12px 16px;
    max-width: 75%;
    white-space: pre-wrap;
  }
  
  .chatbox .chat p.error {
    color: #721c24;
    background: #f8d7da;
  }
  
  .chatbox .incoming p {
    color: #000;
    background: #f2f2f2;
    border-radius: 10px 10px 10px 0;
  }
  
  .chatbox .incoming span {
    height: 32px;
    width: 32px;
    background: #34ec18;
    color: #fff;
    text-align: center;
    line-height: 32px;
    border-radius: 4px;
    margin: 0 10px 7px 0;
    align-self: flex-end;
  }
  .chatbox .outgoing {
    justify-content: flex-end;
    margin: 20px 0;
  }
  
  .chatbot .chat-input {
    position: absolute;
    bottom: 0;
    border-top: 1px solid #ccc;
    width: 100%;
    background: #fff;
    padding: 5px 20px;
    display: flex;
    gap: 5px;
  }
  
  .chat-input textarea {
    border: none;
    outline: none;
    font-size: 0.95rem;
    resize: none;
    max-height: 180px;
    height: 55px;
    width: 100%;
    padding: 16px 15px 16px 0;
  }
  
  .chat-input span {
    align-self: flex-end;
    height: 55px;
    line-height: 55px;
    color: #724ea8;
    font-size: 1.35rem;
    cursor: pointer;
    visibility: hidden;
  }
  
  .chat-input textarea:valid ~ span {
    visibility: visible;
  }
  
  @media (max-width: 490px) {
    .chatbot {
      right: 0;
      bottom: 0;
      width: 100%;
      height: 100%;
      border-radius: 0;
    }
    .chatbot .chatbox {
      height: 90%;
    }
  }

  .emoji-icon {
  font-size: 1.35rem; /* Adjust the size as needed */
  cursor: pointer;
  /* Add any other styles you want for the emoji */
}

.emoji-robot {
  font-size: 1.35rem; /* Adjust the size as needed */
  cursor: pointer;
  /* Add any other styles you want for the emoji */
}
  </style>
  