<!DOCTYPE html>
<html>
<head>
    <title>Add New Car</title>
    <link rel="stylesheet" href="samplestyle.css">
</head>
<body>
    <h2>Add New Car</h2>
    <form method="POST" action="addCar_action.php">
        <label>Brand:</label><br>
        <input type="text" name="carBrand" required><br><br>

        <label>Model:</label><br>
        <input type="text" name="carModel" required><br><br>

        <label>Size:</label><br>
        <select name="carSize" required>
            <option value="">-- Select Size --</option>
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
            <option value="SUV">SUV</option>
            <option value="Van">Van</option>
        </select><br><br>

        <label>Plate Number:</label><br>
        <input type="text" name="carPlateNum" maxlength="9" required><br><br>

        <label>Description:</label><br>
        <textarea name="carDescription" rows="3" cols="40"></textarea><br><br>

        <label>Daily Rate (₱):</label><br>
        <input type="number" name="dailyRate" step="0.01" required><br><br>

        <label>Available:</label><br>
        <select name="isAvailable">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select><br><br>

        <input type="submit" value="Add Car">
        <a href="admin_dashboard.php"><button type="button">Cancel</button></a>
    </form>
</body>
</html>
