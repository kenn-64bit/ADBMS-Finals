<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['carID'])) {
    $carID = intval($_GET['carID']);

    $stmt = $conn->prepare("DELETE FROM Car WHERE carID = ?");
    $stmt->bind_param("i", $carID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=car_deleted");
        exit();
    } else {
        echo "Error deleting car: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "No car ID provided.";
}

$conn->close();
?>
