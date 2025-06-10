<?php
require 'db_connect.php';

$errors = [];
$success = false;

$firstname = '';
$lastname = '';
$email = '';
$birthdate = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($firstname)) {
        $errors['firstname'] = "Please provide a first name";
    }

    if (empty($lastname)) {
        $errors['lastname'] = "Please provide a last name";
    }

    if (empty($email)) {
        $errors['email'] = "Please provide an email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($birthdate)) {
        $errors['birthdate'] = "Please provide a birthdate";
    }

    if (empty($password)) {
        $errors['password'] = "Please provide a password";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "Password must be at least 8 characters";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    if (empty($errors)) {
        $check_sql = "SELECT id FROM users WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            $errors['email'] = "Email is already registered";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (firstname, lastname, email, password, birthdate) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $firstname, $lastname, $email, $hashed_password, $birthdate);

            if ($stmt->execute()) {
                $success = true;
                $firstname = $lastname = $email = $birthdate = '';
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
    <link rel="stylesheet" href="css/register_page.css">
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <img src="/Car-rental/images/logo.png" alt="Penguin">
        </div>
        <div class="right-panel">
            <h1>Register</h1>
            <form method="post" novalidate>
                <!-- First/Last name -->
                <div class="input-row">
                    <div class="input-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" value="<?= htmlspecialchars($firstname) ?>">
                        <?php if (!empty($errors['firstname'])): ?>
                            <div class="error-message"><?= $errors['firstname'] ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="input-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" value="<?= htmlspecialchars($lastname) ?>">
                        <?php if (!empty($errors['lastname'])): ?>
                            <div class="error-message"><?= $errors['lastname'] ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- @ -->
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                    <?php if (!empty($errors['email'])): ?>
                        <div class="error-message"><?= $errors['email'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- bday -->
                <div class="input-group">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" max="<?= date('Y-m-d', strtotime('-18 years')) ?>" value="<?= htmlspecialchars($birthdate) ?>">
                    <?php if (!empty($errors['birthdate'])): ?>
                        <div class="error-message"><?= $errors['birthdate'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- password -->
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password">
                    <?php if (!empty($errors['password'])): ?>
                        <div class="error-message"><?= $errors['password'] ?></div>
                    <?php endif; ?>
                </div>
                
                <!-- Confirm pass -->
                <div class="input-group">
                    <label for="confirm_password">Re-enter Password</label>
                    <input type="password" id="confirm_password" name="confirm_password">
                    <?php if (!empty($errors['confirm_password'])): ?>
                        <div class="error-message"><?= $errors['confirm_password'] ?></div>
                    <?php endif; ?>
                </div>
                
                <button type="submit">create account</button>
                <p class="login-link">Already have an account? <a href="login_page.php">Login here</a></p>
            </form>
        </div>
    </div>

    <?php if ($success): ?>
        <div class="success-popup">
            <div class="popup-content">
                ✅ Registration successful! You can now <a href="login_page.php">log in</a>.
            </div>
        </div>
        <script>
            setTimeout(() => {
                document.querySelector('.success-popup').style.display = 'none';
            }, 5000);
        </script>
    <?php endif; ?>
</body>
</html>
