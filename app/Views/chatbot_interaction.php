<!DOCTYPE html>
<html>
<head>
    <title>Chatbot interaction</title>
</head>
<body>

    <form id="chatbotForm">
        <label for="userMessage">Enter your message:</label>
        <input type="text" id="userMessage" name="userMessage">
        <button type="submit">Send</button>
    </form>

    <div id="chatbotResponse"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.4/axios.min.js"></script>
    <script>
        document.getElementById('chatbotForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const userMessage = document.getElementById('userMessage').value;

            // Make an AJAX request using Axios
            axios.post('/chatbotinteraction', {
                message: userMessage
            })
            .then(function(response) {
                const chatbotResponse = response.data.response;
                document.getElementById('chatbotResponse').innerHTML = chatbotResponse;
            })
            .catch(function(error) {
                console.error('Erroraa submitting form:', error);
            });
        });
    </script>
</body>
</html>
