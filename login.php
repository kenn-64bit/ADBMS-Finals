<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "clubpenguinProject");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$errMsg = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM User WHERE userEmail = ? AND isAdmin = 1 LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['userPassword'])) {
            $_SESSION['admin_id'] = $user['userID'];
            $_SESSION['admin_name'] = $user['userfName'] . ' ' . $user['userlName'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $errMsg = "❌ Incorrect password.";
        }
    } else {
        $errMsg = "❌ Admin not found.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="samplestyle.css">
</head>
<body>
    <h2>Admin Login</h2>

    <?php if ($errMsg): ?>
        <div style="color: red;"><?php echo $errMsg; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
