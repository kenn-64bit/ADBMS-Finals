<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize & validate inputs
$carBrand = trim($_POST['carBrand']);
$carModel = trim($_POST['carModel']);
$carSize = trim($_POST['carSize']);
$carPlateNum = trim($_POST['carPlateNum']);
$carDescription = trim($_POST['carDescription']);
$dailyRate = floatval($_POST['dailyRate']);
$isAvailable = intval($_POST['isAvailable']);

// Insert query
$sql = "INSERT INTO Car (carBrand, carModel, carSize, carPlateNum, carDescription, dailyRate, isAvailable)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("sssssdi", $carBrand, $carModel, $carSize, $carPlateNum, $carDescription, $dailyRate, $isAvailable);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=car_added");
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
