<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all pending orders
$sql = "SELECT o.orderID, u.userfName, u.userlName, c.carBrand, c.carModel, o.orderDescription, o.dispatchDate, o.returnDate
        FROM Orders o
        JOIN User u ON o.userID = u.userID
        JOIN Car c ON o.carID = c.carID
        WHERE o.isConfirmed = 0
        ORDER BY o.dispatchDate ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pending Orders</title>
    <link rel="stylesheet" href="samplestyle.css">
</head>
<body>
    <h2>Pending Rental Orders</h2>
    <br>
    <a href="clearPendingOrders.php" onclick="return confirm('Are you sure you want to delete ALL pending orders?');">
    <button style="background-color: red; color: white;">🗑️ Clear All Pending Orders</button></a>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'cleared_all'): ?>
    <div style="color: green; font-weight: bold; margin: 10px 0;">✅ All pending orders cleared.</div>
    <?php endif; ?>
    <table border="1" width="100%" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Car</th>
                <th>Description</th>
                <th>Dispatch Date</th>
                <th>Return Date</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['orderID']; ?></td>
                        <td><?php echo $row['userfName'] . ' ' . $row['userlName']; ?></td>
                        <td><?php echo $row['carBrand'] . ' ' . $row['carModel']; ?></td>
                        <td><?php echo $row['orderDescription']; ?></td>
                        <td><?php echo $row['dispatchDate']; ?></td>
                        <td><?php echo $row['returnDate']; ?></td>
                        <td align="center">
                            <a href="confirmOrder.php?orderID=<?php echo $row['orderID']; ?>">✅ Confirm</a>
                        </td>
                        <td align="center">
                            <a href="cancelOrder.php?orderID=<?php echo $row['orderID']; ?>" onclick="return confirm('Cancel this order?');">❌ Cancel</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="8" align="center">No pending orders.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <br>
    <a href="admin_dashboard.php"><button>Back to Dashboard</button></a>
</body>
</html>

<?php mysqli_close($conn); ?>
