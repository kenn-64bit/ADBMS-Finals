<?php
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_GET['carID'])) {
    die("Invalid request: car ID missing.");
}

$carID = intval($_GET['carID']);

$result = mysqli_query($conn, "SELECT * FROM Car WHERE carID = $carID");

if (mysqli_num_rows($result) == 0) {
    die("Car not found.");
}

$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    <link rel="stylesheet" href="samplestyle.css">
</head>
<body>
    <h2>Edit Car</h2>
    <form method="POST" action="editCar_action.php">
        <input type="hidden" name="carID" value="<?php echo $row['carID']; ?>">

        <label>Brand:</label><br>
        <input type="text" name="carBrand" value="<?php echo $row['carBrand']; ?>" required><br><br>

        <label>Model:</label><br>
        <input type="text" name="carModel" value="<?php echo $row['carModel']; ?>" required><br><br>

        <label>Size:</label><br>
        <select name="carSize" required>
            <option value="Small" <?php if ($row['carSize'] == 'Small') echo 'selected'; ?>>Small</option>
            <option value="Medium" <?php if ($row['carSize'] == 'Medium') echo 'selected'; ?>>Medium</option>
            <option value="Large" <?php if ($row['carSize'] == 'Large') echo 'selected'; ?>>Large</option>
            <option value="SUV" <?php if ($row['carSize'] == 'SUV') echo 'selected'; ?>>SUV</option>
            <option value="Van" <?php if ($row['carSize'] == 'Van') echo 'selected'; ?>>Van</option>
        </select><br><br>

        <label>Plate Number:</label><br>
        <input type="text" name="carPlateNum" value="<?php echo $row['carPlateNum']; ?>" maxlength="9" required><br><br>

        <label>Description:</label><br>
        <textarea name="carDescription" rows="3" cols="40"><?php echo $row['carDescription']; ?></textarea><br><br>

        <label>Daily Rate (₱):</label><br>
        <input type="number" name="dailyRate" value="<?php echo $row['dailyRate']; ?>" step="0.01" required><br><br>

        <label>Available:</label><br>
        <select name="isAvailable">
            <option value="1" <?php if ($row['isAvailable'] == 1) echo 'selected'; ?>>Yes</option>
            <option value="0" <?php if ($row['isAvailable'] == 0) echo 'selected'; ?>>No</option>
        </select><br><br>

        <input type="submit" value="Update Car">
        <a href="admin_dashboard.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
