<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>FAQ Form</title>
</head>
<body>
    <h1>FAQ Form</h1>
    <form action="/create-faq" method="post">
        <label for="question">Question:</label><br>
        <input type="text" id="question" name="question" required><br><br>

        <label for="answer">Answer:</label><br>
        <textarea id="answer" name="answer" rows="4" cols="50" required></textarea><br><br>

        <label for="category">Category:</label><br>
        <input type="text" id="category" name="category" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
