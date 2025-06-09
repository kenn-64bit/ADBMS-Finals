<?php
// Optional: Start session or include any needed auth checks
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>
    <link rel="stylesheet" href="samplestyle.css">
</head>
<body>
    <h2>Add New User</h2>
    <form method="POST" action="addUser_action.php">
        <label for="userfName">First Name:</label><br>
        <input type="text" name="userfName" required><br><br>

        <label for="userlName">Last Name:</label><br>
        <input type="text" name="userlName" required><br><br>

        <label for="userEmail">Email:</label><br>
        <input type="email" name="userEmail" required><br><br>

        <label for="userPassword">Password:</label><br>
        <input type="password" name="userPassword" required><br><br>

        <label for="userPhoneNum">Phone Number:</label><br>
        <input type="text" name="userPhoneNum" required><br><br>

        <input type="submit" value="Add User">
        <a href="admin_dashboard.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>
