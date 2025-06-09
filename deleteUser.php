<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['userID'])) {
    $userID = intval($_GET['userID']);

    $stmt = $conn->prepare("DELETE FROM User WHERE userID = ?");
    $stmt->bind_param("i", $userID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=user_deleted");
        exit();
    } else {
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No user ID provided.";
}

$conn->close();
?>
