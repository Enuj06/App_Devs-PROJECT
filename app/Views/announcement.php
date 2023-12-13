<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Announcement Page</title>
    <style>
        /* Basic styling for demonstration purposes */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .announcement {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        h2 {
            margin-bottom: 5px;
        }
        p {
            margin-top: 5px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
<body>
    <h1>Announcements</h1>

    <table id="announcementsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Image</th>
                <th>Date Created</th>

            </tr>
        </thead>
        <tbody id="announcementsTableBody"> <!-- Add this tbody with the appropriate id -->
            <!-- Announcements will be dynamically added here -->
        </tbody>
    </table>

    <!-- You can add a form to allow users to submit new announcements -->
    <h2>Create New Announcement</h2>
    <form id="announcementForm">
        <label for="announcementTitle">Title:</label>
        <input type="text" id="announcementTitle" name="title" required><br><br>
        <label for="announcementContent">Content:</label><br>
        <textarea id="announcementContent" name="content" rows="4" cols="50" required></textarea><br><br>
        <label for="announcementImage">Upload Image:</label><br>
        <input type="file" id="announcementImage" name="userfile" accept="image/*" required><br><br>
        <button type="submit">Submit Announcement</button>
    </form>

    <script>
        function updateAnnouncementsTable(announcements) {
            const tableBody = document.getElementById('announcementsTableBody');

            // Clear existing content in the tbody
            tableBody.innerHTML = '';

            // Loop through the fetched announcements and populate the table
            announcements.forEach(announcement => {
                const row = tableBody.insertRow();

                // Populate cells with announcement data
                const idCell = row.insertCell(0);
                const titleCell = row.insertCell(1);
                const contentCell = row.insertCell(2);
                const imageUrlCell = row.insertCell(3);
                const createdAtCell = row.insertCell(4);

                idCell.textContent = announcement.id;
                titleCell.textContent = announcement.title;
                contentCell.textContent = announcement.content;

                // Create an image element and set its source to the image URL
                const img = document.createElement('img');
                img.src = announcement.image_url;
                img.style.maxWidth = '100px'; // Optional: Set a maximum width for the image
                imageUrlCell.appendChild(img); // Append the image element to the cell

                createdAtCell.textContent = announcement.created_at;
            });
        }

        // Function to handle form submission for adding new announcements
        function addNewAnnouncement() {
            const formData = new FormData(document.getElementById('announcementForm'));
            const xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Fetch the updated list of announcements after successful addition
                        const updatedAnnouncements = JSON.parse(xhr.responseText);
                        updateAnnouncementsTable(updatedAnnouncements);
                    } else {
                        console.error('Failed to add announcement');
                    }
                }
            };

            xhr.open('POST', '/create-announcement', true);
            xhr.send(formData);
        }

        // Fetch announcements from the server when the page loads
        window.addEventListener('load', function() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/fetch-announcements', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const announcements = JSON.parse(xhr.responseText);
                        updateAnnouncementsTable(announcements); // Update the table with fetched announcements
                    } else {
                        console.error('Failed to fetch announcements');
                    }
                }
            };
            xhr.send();
        });

        // Event listener for form submission
        document.getElementById('announcementForm').addEventListener('submit', function(e) {
            e.preventDefault();
            addNewAnnouncement();
        });
</script>

</body>
</html>
