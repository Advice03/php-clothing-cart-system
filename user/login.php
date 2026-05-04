<?php
session_start();
include "../config/DBConn.php";

$username = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];

    $sql = "SELECT * FROM tblUser WHERE username='$username'";
    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {

        if (password_verify($_POST['password'], $row['password'])) {

            $_SESSION['user'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = $row['role'];

            header("Location: ../clothes/shop.php");
            exit();

        } else {
            echo "Wrong password!";
        }

    } else {
        echo "User not found!";
    }
}
?>

<h2>Login</h2>

<form method="POST">
    Username: <input type="text" name="username" value="<?php echo $username; ?>" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <button type="submit">Login</button>
</form>
