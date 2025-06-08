<?php
require 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "⚠️ Passwords do not match.";
    } else {
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $message = "⚠️ Email is already registered.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (firstname, lastname, email, password, birthdate) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $birthdate);

            if ($stmt->execute()) {
                $message = "✅ Registration successful! You can now <a href='login_page.php'>log in</a>.";
            } else {
                $message = "❌ Error: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>

    <h1>Register Page</h1>

    <?php if (!empty($message)) : ?>
        <p style="color: <?= strpos($message, 'successful') !== false ? 'green' : 'red' ?>;">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>

    <form method="post">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" required>

        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="birthdate">Birthdate:</label>
        <input type="date" name="birthdate" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" required>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Register</button>
        <p>Already have an account? <a href="login_page.php">Login here</a></p>
    </form>

</body>
</html>
