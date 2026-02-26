<?php

require_once 'config.php';
require_once 'function.php';

// Get Order ID from URL
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($order_id <= 0) {
    die("Invalid Order ID.");
}

$db = db_connect();

// Query to find if there are any digital products in this order
// We join order_items, products and digital_products tables
$query = "SELECT p.name, oi.product_id 
          FROM order_items oi
          JOIN products p ON oi.product_id = p.id
          JOIN digital_products dp ON p.id = dp.product_id
          WHERE oi.order_id = ?";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$digital_items = $stmt->get_result();

$order_items_query = "SELECT p.id, p.name FROM order_items oi 
                      JOIN products p ON oi.product_id = p.id 
                      WHERE oi.order_id = ?";
$stmt2 = $db->prepare($order_items_query);
$stmt2->bind_param("i", $order_id);
$stmt2->execute();
$order_items_result = $stmt2->get_result();

while ($item = $order_items_result->fetch_assoc()) {
    echo "<div>";
    echo "<h4>" . htmlspecialchars($item['name']) . "</h4>";
    // Review form send id's
    echo "<a href='review_write.php?pid=" . $item['id'] . "&oid=" . $order_id . "'>Review this product</a>";
    echo "</div>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Success | Melody Masters</title>
    <link rel="stylesheet" href="style/success.css">
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="icon">✔</div>
            <h1>Order Successful!</h1>
            <p>Thank you for your purchase. Your payment has been processed successfully.</p>
            
            <div class="order-info">
                <span>Order ID: <strong>#<?= $order_id ?></strong></span>
            </div>

            <hr>

            <?php if ($digital_items->num_rows > 0): ?>
                <div class="digital-section">
                    <h3>Your Digital Downloads</h3>
                    <p>You can download your purchased files below (Subject to download limits):</p>
                    <div class="download-grid">
                        <?php while ($item = $digital_items->fetch_assoc()): ?>
                            <div class="download-item">
                                <span><?= htmlspecialchars($item['name']) ?></span>
                                <a href="download.php?order_id=<?= $order_id ?>&product_id=<?= $item['product_id'] ?>" class="btn-download">
                                    Download Now
                                </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="actions">
                <a href="index.php" class="btn-secondary">Return to Shop</a>
            </div>
        </div>
    </div>
</body>
</html>