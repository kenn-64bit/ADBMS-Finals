<?php
require 'db_connect.php'; // Database connection
session_start();

$errors = []; // Store validation errors
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email
    if (empty($email)) {
        $errors['email'] = "Please provide an email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // Validate password
    if (empty($password)) {
        $errors['password'] = "Please provide a password";
    }

    // If no validation errors, check database
    if (empty($errors)) {
        $sql = "SELECT id, firstname, lastname, password FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 0) {
            // Email not found
            $errors['email'] = "Email not found";
        } else {
            $stmt->bind_result($id, $firstname, $lastname, $hashed_password);
            $stmt->fetch();
            
            if (!password_verify($password, $hashed_password)) {
                // incorrect pass
                $errors['password'] = "Incorrect password";
            } else {
                // login successful
                $_SESSION["user_id"] = $id;
                $_SESSION["firstname"] = $firstname;
                $_SESSION["lastname"] = $lastname;

                header("Location: dashboard.php");
                exit();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login_page.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Login</h1>
            
            <div class="car-icon">
                <img src="/Car-rental/images/car.png" alt="Car">
            </div>
            
            <form method="post" novalidate>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                    <?php if (!empty($errors['email'])): ?>
                        <div class="error-message"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <?php if (!empty($errors['password'])): ?>
                        <div class="error-message"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
                
                <button type="submit">Login</button>
                
                <p class="register-link">Don't have an account? <a href="register_page.php">Register here</a></p>
            </form>
        </div>
    </div>
</body>
</html>
