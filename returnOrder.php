<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['orderID'])) {
    $orderID = intval($_GET['orderID']);

    $stmt = $conn->prepare("UPDATE Orders SET isConfirmed = 0 WHERE orderID = ?");
    $stmt->bind_param("i", $orderID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=order_returned");
        exit();
    } else {
        echo "Error returning order to pending: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Order ID not provided.";
}

$conn->close();
?>
