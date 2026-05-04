<?php
include "../config/DBConn.php";

// delete table if exists
$conn->query("DROP TABLE IF EXISTS tblUser");

// create table
$conn->query("CREATE TABLE tblUser (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    role VARCHAR(20),
    status VARCHAR(20)
)");

// open text file
$file = fopen("userData.txt", "r");

// read file line by line
while (($line = fgets($file)) !== false) {

    $data = explode(",", trim($line));

    $name = $data[0];
    $email = $data[1];
    $username = $data[2];

    // encrypt password
    $password = password_hash($data[3], PASSWORD_DEFAULT);

    $conn->query("INSERT INTO tblUser 
    (name,email,username,password,role,status)
    VALUES ('$name','$email','$username','$password','user','approved')");
}

fclose($file);

echo "Table created successfully!";
?>
