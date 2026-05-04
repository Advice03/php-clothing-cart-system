<?php
session_start();
include "../config/DBConn.php";

if (!isset($_SESSION['user_id'])) {
    die("Please login first!");
}

$user_id = $_SESSION['user_id'];

// HANDLE UPDATE
if (isset($_POST['update'])) {
    $item_id = intval($_POST['item_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity > 0) {
        $stmt = $conn->prepare("UPDATE tblCart SET quantity=? WHERE user_id=? AND item_id=?");
        $stmt->bind_param("iii", $quantity, $user_id, $item_id);
        $stmt->execute();
    }
}

// HANDLE DELETE
if (isset($_GET['delete'])) {
    $item_id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM tblCart WHERE user_id=? AND item_id=?");
    $stmt->bind_param("ii", $user_id, $item_id);
    $stmt->execute();
}

// GET CART ITEMS
$sql = "SELECT tblCart.*, tblClothes.name, tblClothes.price 
        FROM tblCart 
        JOIN tblClothes ON tblCart.item_id = tblClothes.item_id
        WHERE tblCart.user_id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

echo "<h2>Your Cart</h2>";
echo "<a href='shop.php'>← Continue Shopping</a><br><br>";

$total = 0;

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;

        echo "<div>
            <b>".$row['name']."</b><br>
            Price: R".$row['price']."<br>
            Subtotal: R".$subtotal."<br>

            <form method='POST'>
                <input type='hidden' name='item_id' value='".$row['item_id']."'>
                Quantity: 
                <input type='number' name='quantity' value='".$row['quantity']."' min='1'>
                <button name='update'>Update</button>
            </form>

            <a href='cart.php?delete=".$row['item_id']."'>Remove</a>
        </div><hr>";
    }

    echo "<h3>Total: R".$total."</h3>";

} else {
    echo "Cart is empty!";
}
?>
