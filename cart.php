<?php
require __DIR__ . '/function.php';
require_once __DIR__ . '/config.php';

cart(); // Initialize the cart session
$db = db_connect();
//get product id from url
$p_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($p_id > 0) {
    //check exist the product on cart
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id]++; // increase quantity if already in cart
    } else {
        $_SESSION['cart'][$p_id] = 1; // add new product to cart
    }
}
//display cart items
$cartItems = [];
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart'])); // get product ids in cart
    $result = $db->query("SELECT * FROM products WHERE id IN ($ids)");
    while ($row = $result->fetch_assoc()) {
        $row['qty'] = $_SESSION['cart'][$row['id']]; // add quantity to product data
        $cartItems[] = $row;
    }

}
//remove item from cart
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    if (isset($_SESSION['cart'][$remove_id])) {
        unset($_SESSION['cart'][$remove_id]);
    }
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/cart.css">
</head>

<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <?php if (empty($cartItems)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td>
    <input type="number" value="<?= $item['qty'] ?>" min="1" class="qty-input">
</td>
                            <td>$<?= number_format($item['price'] * $item['qty'], 2) ?></td>
                            <td><a href="?remove=<?= $item['id'] ?>" class="btn-danger">Remove</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php
            $total = array_sum(array_map(function($item) {
                return $item['price'] * $item['qty'];
            }, $cartItems));
            ?>
            <div class="cart-total">
                Total: $<?= number_format($total, 2) ?>
            </div>

        <?php endif; ?>
        <a href="checkout.php" class="btn">Proceed to Checkout</a>
    </div>
</body>
</html>