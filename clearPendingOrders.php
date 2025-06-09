<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Delete all pending orders
$sql = "DELETE FROM Orders WHERE isConfirmed = 0";
if (mysqli_query($conn, $sql)) {
    header("Location: pendingOrders.php?msg=cleared_all");
    exit();
} else {
    echo "Error clearing orders: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
