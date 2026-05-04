<?php
session_start();
include "../config/DBConn.php";

if (!isset($_SESSION['user_id'])) {
    die("Please login first!");
}

if (!isset($_GET['id'])) {
    die("Invalid request!");
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_GET['id']); // sanitize

// Check if item already exists
$stmt = $conn->prepare("SELECT quantity FROM tblCart WHERE user_id=? AND item_id=?");
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity
    $stmt = $conn->prepare("UPDATE tblCart SET quantity = quantity + 1 WHERE user_id=? AND item_id=?");
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
} else {
    // Insert new item
    $stmt = $conn->prepare("INSERT INTO tblCart (user_id, item_id, quantity) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
}

// Redirect back to shop
header("Location: shop.php");
exit();
?>