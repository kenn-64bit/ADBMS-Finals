<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['orderID'])) {
    $orderID = intval($_GET['orderID']);

    $stmt = $conn->prepare("DELETE FROM Orders WHERE orderID = ?");
    $stmt->bind_param("i", $orderID);

    if ($stmt->execute()) {
        header("Location: admin_dashboard.php?msg=order_cancelled");
        exit();
    } else {
        echo "Error canceling order: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Order ID not provided.";
}

$conn->close();
?>
