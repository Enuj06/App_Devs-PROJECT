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

    <script>
        document.getElementById('chatbotForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Get user input
            const userMessage = document.getElementById('userMessage').value;

            // Make a POST request to your PHP backend
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/chatbotinteraction', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Handle the response from the backend
                        const response = JSON.parse(xhr.responseText);
                        document.getElementById('chatbotResponse').innerText = response.text; // Access 'text' property
                    } else {
                        console.error('Error:', xhr.status);
                    }
                }
            };

            // Send the user input as form data
            xhr.send('userMessage=' + encodeURIComponent(userMessage));
        });
    </script>
</body>
</html>
