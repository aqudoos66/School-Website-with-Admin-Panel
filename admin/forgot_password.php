<?php
include 'db.php';

if (isset($_POST['reset'])) {
    $email = $_POST['email'];
    $newpass = md5("123456"); // Default new password

    $sql = "UPDATE users SET password='$newpass' WHERE email='$email'";

    if ($conn->query($sql) === TRUE) {
        $success = "Password reset successful! New password: 123456";
    } else {
        $error = "Email not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="form-container">
    <h2>Forgot Password</h2>
    <?php 
        if (isset($success)) echo "<p class='success'>$success</p>";
        if (isset($error)) echo "<p class='error'>$error</p>";
    ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter Your Email" required><br>
        <button type="submit" name="reset">Reset Password</button>
    </form>
    <p><a href="login.php">Back to Login</a></p>
</div>
</body>
</html>
