<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['userID'])) {
    die("Invalid request: user ID missing.");
}

$userID = intval($_GET['userID']);

$result = mysqli_query($conn, "SELECT * FROM User WHERE userID = $userID");

if (mysqli_num_rows($result) == 0) {
    die("User not found.");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="samplestyle.css">
</head>
<body>
    <h2>Edit User</h2>
    <form method="POST" action="editUser_action.php">
        <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">

        <label>First Name:</label><br>
        <input type="text" name="userfName" value="<?php echo $row['userfName']; ?>" required><br><br>

        <label>Last Name:</label><br>
        <input type="text" name="userlName" value="<?php echo $row['userlName']; ?>" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="userEmail" value="<?php echo $row['userEmail']; ?>" required><br><br>

        <label>Phone Number:</label><br>
        <input type="text" name="userPhoneNum" value="<?php echo $row['userPhoneNum']; ?>" required><br><br>

        <label>New Password (leave blank to keep current):</label><br>
        <input type="password" name="userPassword"><br><br>

        <input type="submit" value="Update User">
        <a href="admin_dashboard.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
