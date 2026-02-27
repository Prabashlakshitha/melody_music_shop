<?php
require_once 'config.php';
require_once 'function.php';

$p_id = (int)$_GET['pid'];
$o_id = (int)$_GET['oid'];

$db = db_connect();

// find user id related to the order id 
$user_query = $db->query("SELECT user_id FROM orders WHERE id = $o_id");
$user_data  = $user_query->fetch_assoc();

if ($user_data) {
    $user_id = $user_data['user_id'];

    
    // function hasPurchased($user_id, $product_id)
    if (hasPurchased($user_id, $p_id)) {
        ?>
        <!DOCTYPE html>
        <html lang="eng">
            <head>
                <meta charset="UTF-8">
                <title>Checkout - Melody Masters</title>
                <link rel="stylesheet" href="style/review.css">
            </head>
            <body>
        <form action="save_review.php" method="POST" class="review-box">
            <h3>Write a Review</h3>
            
            <input type="hidden" name="user_id" value="<?= $user_id ?>">
            <input type="hidden" name="product_id" value="<?= $p_id ?>">

            <div class="field">
                <label>Rating:</label>
                <select name="rating" required>
                    <option value="5"> (Excellent)</option>
                    <option value="4"> (Good)</option>
                    <option value="3"> (Average)</option>
                    <option value="2"> (Poor)</option>
                    <option value="1"> (Very Bad)</option>
                </select>
            </div>

            <div class="field">
                <label>Your Comment:</label>
                <textarea name="comment" rows="5" placeholder="Tell us what you think..." required></textarea>
            </div>

            <button type="submit" class="btn-submit">Submit Review</button>
        </form>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Error: You are not authorized to review this product as no purchase was found.</p>";
    }
} else {
    echo "<p>Order not found.</p>";
}
?>