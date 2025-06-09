<?php
// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get POST data and sanitize
$userfName = trim($_POST['userfName']);
$userlName = trim($_POST['userlName']);
$userEmail = trim($_POST['userEmail']);
$userPassword = password_hash(trim($_POST['userPassword']), PASSWORD_DEFAULT); // Secure password hash
$userPhoneNum = trim($_POST['userPhoneNum']);

// Insert into the database
$sql = "INSERT INTO User (userfName, userlName, userEmail, userPassword, userPhoneNum) 
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssss", $userfName, $userlName, $userEmail, $userPassword, $userPhoneNum);

    if ($stmt->execute()) {
        // Redirect back to admin dashboard
        header("Location: admin_dashboard.php?msg=user_added");
        exit();
    } else {
        echo "Error executing query: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>