<?php
require __DIR__ . '/function.php';
require_once __DIR__ . '/config.php';

require_login(); // Ensure user is logged in to access checkout

$db = db_connect();

//check if cart is empty, if empty redirect to shop
if (empty($_SESSION['cart'])) {
    header("Location: shop.php");
    exit();
}
$grandTotal = 0;
$shippingCost = 0;
$hasPhysicalProduct = false;
$cartItems = [];

// 2. Database get and check Business Rules 
$ids = implode(',', array_keys($_SESSION['cart']));
$result = $db->query("SELECT id, name, price, type, stock FROM products WHERE id IN ($ids)");

while ($row = $result->fetch_assoc()) {
    $qty = $_SESSION['cart'][$row['id']];
    
    // Rule: Limited Stock Check
    if ($row['stock'] < $qty) {
        die("Sorry, " . $row['name'] . " is out of stock or not enough quantity.");
    }

    // Rule: Physical Product check
    if ($row['type'] == 'physical') {
        $hasPhysicalProduct = true;
    }

    $subtotal = $row['price'] * $qty;
    $grandTotal += $subtotal;
    
    $row['qty'] = $qty;
    $row['subtotal'] = $subtotal;
    $cartItems[] = $row;
}

// Rule: Shipping Cost Calculation 
if ($hasPhysicalProduct && $grandTotal < 100) {
    $shippingCost = 10.00;
}

$finalTotal = $grandTotal + $shippingCost;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - Melody Masters</title>
    <link rel="stylesheet" href="style/checkout.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= ucfirst($item['type']) ?></td>
                    <td>£<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td>£<?= number_format($item['subtotal'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="checkout-summary">
            <p>Subtotal: <strong>£<?= number_format($grandTotal, 2) ?></strong></p>
            <p>Shipping: <strong><?= ($shippingCost > 0) ? '£' . number_format($shippingCost, 2) : 'FREE' ?></strong></p>
            <hr>
            <h2>Total to Pay: £<?= number_format($finalTotal, 2) ?></h2>
        </div>

        <form action="oder_place.php" method="POST" class="checkout-form">
    <h3>Billing Details</h3>
    
    <input type="text" name="shipping_name" placeholder="Full Name" required>
    
    <textarea name="shipping_address" placeholder="Shipping Address" required></textarea>
    
    <input type="text" name="shipping_city" placeholder="City" required>
    <input type="text" name="shipping_postcode" placeholder="Postal Code" required>
    
    <input type="text" name="phone" placeholder="Phone Number" required>
    
    <input type="hidden" name="total_amount" value="<?= $finalTotal ?>">
    
    <button type="submit" class="btn">Place Order & Pay</button>
</form>
    </div>
</body>
</html>


