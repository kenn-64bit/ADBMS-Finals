<?php
$host = "localhost";
$user = "root"; 
$password = "";
$dbname = "clubpenguinProject";

// Establish connection
try {
    $conn = new mysqli($host, $user, $password);
    
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    //Create database if not exists
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!$conn->query($sql)) {
        throw new Exception("Error creating database: " . $conn->error);
    }
    echo "Database created or already exists.<br>";

    //Select the database
    if (!$conn->select_db($dbname)) {
        throw new Exception("Error selecting database: " . $conn->error);
    }

    //Create User table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS `User` (
        userID INT AUTO_INCREMENT PRIMARY KEY,
        userfName VARCHAR(50) NOT NULL,
        userlName VARCHAR(50) NOT NULL,
        userEmail VARCHAR(100) NOT NULL UNIQUE,
        userPassword VARCHAR(255) NOT NULL,
        userPhoneNum VARCHAR(50) NOT NULL,
        isAdmin TINYINT(1) DEFAULT 0,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating User table: " . $conn->error);
    }
    echo "Table 'User' created or already exists.<br>";

        // Insert default super admin if not exists
        $sql = "INSERT IGNORE INTO User (userfName, userlName, userEmail, userPassword, userPhoneNum, isAdmin) 
                VALUES ('Super', 'Admin', 'admin@example.com', '" . password_hash('admin123', PASSWORD_DEFAULT) . "', '09999999999', 1)";
        $conn->query($sql);


    //Create Car table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS `Car` (
        carID INT AUTO_INCREMENT PRIMARY KEY,
        carBrand VARCHAR(50) NOT NULL,
        carModel VARCHAR(50) NOT NULL,
        carSize ENUM('Small', 'Medium', 'Large', 'SUV', 'Van') NOT NULL,
        carPlateNum VARCHAR(9) NOT NULL UNIQUE,
        carDescription VARCHAR(100),
        isAvailable TINYINT(1) DEFAULT 1,
        dailyRate DECIMAL(10,2) NOT NULL,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating Car table: " . $conn->error);
    }
    echo "Table 'Car' created or already exists.<br>";

    //Create Orders table if not exists
    $sql = "CREATE TABLE IF NOT EXISTS `Orders` (
        orderID INT AUTO_INCREMENT PRIMARY KEY,
        userID INT NOT NULL,
        carID INT NOT NULL,
        orderDescription VARCHAR(100),
        dispatchDate DATE NOT NULL,
        returnDate DATE NOT NULL,
        isConfirmed TINYINT(1) DEFAULT 0,
        createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (userID) REFERENCES User(userID),
        FOREIGN KEY (carID) REFERENCES Car(carID),
        CHECK (returnDate > dispatchDate)
    ) ENGINE=InnoDB";
    
    if (!$conn->query($sql)) {
        throw new Exception("Error creating Orders table: " . $conn->error);
    }
    echo "Table 'Orders' created or already exists.<br>";

        // Insert a sample car
        $conn->query("INSERT IGNORE INTO Car (carBrand, carModel, carSize, carPlateNum, carDescription, dailyRate, isAvailable) VALUES ('Toyota', 'Vios', 'Small', 'ABC1234', 'Economy car', 1000.00, 1)");

        // Get inserted car/user IDs
        $carID = $conn->insert_id;
        $userID = $conn->insert_id;

        // Insert sample pending and confirmed orders
        $conn->query("INSERT INTO Orders (userID, carID, orderDescription, dispatchDate, returnDate, isConfirmed) VALUES (1, 1, 'Test pending order', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 3 DAY), 0)");
        $conn->query("INSERT INTO Orders (userID, carID, orderDescription, dispatchDate, returnDate, isConfirmed) VALUES (1, 1, 'Test confirmed order', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 3 DAY), 1)");


    $conn->close();
    header("Location: admin_dashboard.php?setup=success");
    exit();

} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>