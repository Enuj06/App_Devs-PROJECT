<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scheduled Appointments</title>
</head>
<body>
    <h1>Scheduled Appointments</h1>

    <form action="/schedule/create" method="POST">
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" required><br><br>
        
        <label for="start_time">Start Time:</label>
        <input type="time" id="start_time" name="start_time" required><br><br>
        
        <label for="end_time">End Time:</label>
        <input type="time" id="end_time" name="end_time" required><br><br>
        
        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="available">Available</option>
            <option value="booked">Booked</option>
        </select><br><br>
        
        <button type="submit">Schedule Appointment</button><br><br><br>
    </form>

    <form action="/schedule/bookAppointment" method="POST">
        <label for="appointment">Choose an available appointment:</label>
        <select id="appointment" name="appointment">
            <?php foreach ($appointments as $appointment): ?>
                <?php if ($appointment['status'] === 'Available'): ?>
                    <option value="<?php echo $appointment['id']; ?>">
                        <?php echo $appointment['appointment_date'] . ' ' . $appointment['start_time'] . ' - ' . $appointment['end_time']; ?>
                    </option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select><br><br>
        
        <button type="submit">Book Appointment</button>
    </form>

    <table border="1">
        <thead>
            <tr>
                <th>Appointment Date</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($appointments as $appointment): ?>
                <tr>
                    <td><?php echo $appointment['appointment_date']; ?></td>
                    <td><?php echo $appointment['start_time']; ?></td>
                    <td><?php echo $appointment['end_time']; ?></td>
                    <td><?php echo $appointment['status']; ?></td>
                    <td>
                        <a href="/edit/<?php echo $appointment['id']; ?>">Edit</a>
                    </td>
                    <td>
                        <a href="/delete/<?php echo $appointment['id']; ?>" onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
