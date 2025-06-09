<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get POST data
$carID = intval($_POST['carID']);
$carBrand = trim($_POST['carBrand']);
$carModel = trim($_POST['carModel']);
$carSize = trim($_POST['carSize']);
$carPlateNum = trim($_POST['carPlateNum']);
$carDescription = trim($_POST['carDescription']);
$dailyRate = floatval($_POST['dailyRate']);
$isAvailable = intval($_POST['isAvailable']);

// Update query
$sql = "UPDATE Car SET 
            carBrand = ?, 
            carModel = ?, 
            carSize = ?, 
            carPlateNum = ?, 
            carDescription = ?, 
            dailyRate = ?, 
            isAvailable = ?
        WHERE carID = ?";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssssdii", $carBrand, $carModel, $carSize, $carPlateNum, $carDescription, $dailyRate, $isAvailable, $carID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=car_updated");
        exit();
    } else {
        echo "Error updating car: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
