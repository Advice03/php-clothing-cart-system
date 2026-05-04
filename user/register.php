<?php
include "../config/DBConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if username already exists
    $check = $conn->query("SELECT * FROM tblUser WHERE username='$username'");
    
    if ($check->num_rows > 0) {
        echo "Username already exists!";
    } else {

        $sql = "INSERT INTO tblUser (name, email, username, password, role, status)
                VALUES ('$name', '$email', '$username', '$password', 'user', 'active')";

        if ($conn->query($sql)) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<h2>Register</h2>

<form method="POST">
    Name: <input type="text" name="name" required><br><br>
    Email: <input type="email" name="email" required><br><br>
    Username: <input type="text" name="username" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Register</button>
</form>

