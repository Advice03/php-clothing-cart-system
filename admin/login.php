<?php
session_start();

if ($_POST) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if admin login details are correct
    if ($username == "admin" && $password == "admin123") {

        $_SESSION['admin'] = true;

        // Go to dashboard
        header("Location: dashboard.php");

    } else {
        echo "Wrong admin login!";
    }
}
?>

<h2>Admin Login</h2>

<form method="POST">
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>
