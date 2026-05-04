<?php
session_start();
include "../config/DBConn.php";

if (!isset($_SESSION['user_id'])) {
    die("Please login first!");
}

echo "Welcome " . htmlspecialchars($_SESSION['user']) . "<br><br>";

echo "<a href='cart.php'>🛒 View Cart</a> | ";
echo "<a href='../user/logout.php'>Logout</a><br><br>";

// Fetch products
$result = $conn->query("SELECT * FROM tblClothes");

while ($row = $result->fetch_assoc()) {

    echo "<div style='border:1px solid #ccc; padding:10px; width:200px; margin-bottom:10px;'>

        <img src='../images/".htmlspecialchars($row['image'])."' width='100'><br>

        <b>".htmlspecialchars($row['name'])."</b><br>
        Price: R".htmlspecialchars($row['price'])."<br><br>

        <a href='addToCart.php?id=".$row['item_id']."'>
            Add to Cart
        </a>

    </div>";
}