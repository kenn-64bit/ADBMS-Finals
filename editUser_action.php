<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize inputs
$userID = intval($_POST['userID']);
$userfName = trim($_POST['userfName']);
$userlName = trim($_POST['userlName']);
$userEmail = trim($_POST['userEmail']);
$userPhoneNum = trim($_POST['userPhoneNum']);
$userPassword = trim($_POST['userPassword']); // Might be empty

// Update query (conditionally include password)
if (!empty($userPassword)) {
    $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE User SET 
                userfName = ?, 
                userlName = ?, 
                userEmail = ?, 
                userPhoneNum = ?, 
                userPassword = ?
            WHERE userID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $userfName, $userlName, $userEmail, $userPhoneNum, $hashedPassword, $userID);
} else {
    $sql = "UPDATE User SET 
                userfName = ?, 
                userlName = ?, 
                userEmail = ?, 
                userPhoneNum = ?
            WHERE userID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $userfName, $userlName, $userEmail, $userPhoneNum, $userID);
}

if ($stmt->execute()) {
    header("Location: admin_dashboard.php?msg=user_updated");
    exit();
} else {
    echo "Error updating user: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
