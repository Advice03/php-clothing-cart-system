<?php
include "../config/DBConn.php";

$result = $conn->query("SELECT * FROM tblUser WHERE status='pending'");

echo "<h2>Pending Users</h2>";

while ($row = $result->fetch_assoc()) {
    echo $row['username'] . "
    <a href='approve.php?id=".$row['user_id']."'>Approve</a><br>";
}
?>
