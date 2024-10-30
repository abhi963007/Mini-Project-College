<?php
session_start();
include('config.php'); // Database connection

if (isset($_POST['login'])) {
    $admin_user = $_POST['username'];
    $admin_pass = $_POST['password'];

    $query = "SELECT * FROM admins WHERE username = '$admin_user' AND password = '$admin_pass'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin_dashboard.php');
    } else {
        echo "Invalid Admin Credentials!";
    }
}
?>

<!-- HTML Form for Admin Login -->
<form method="post" action="">
    <input type="text" name="username" placeholder="Admin Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <input type="submit" name="login" value="Login">
</form>
