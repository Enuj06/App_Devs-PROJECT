<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback Form</title>
</head>
<body>
    <h1>Feedback Form</h1>
    <form action="/cfeedback" method="post">
        <label for="firstname">First Name:</label><br>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="lastname">Last Name:</label><br>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="feedback">Feedback:</label><br>
        <input type="text" id="feed_content" name="feed_content" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
