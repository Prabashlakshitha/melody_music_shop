<?php

require_once 'config.php';
require_once 'function.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = db_connect();

    $user_id    = (int)$_POST['user_id'];
    $product_id = (int)$_POST['product_id'];
    $rating     = (int)$_POST['rating'];
    $comment    = trim($_POST['comment']);

    // 1. Business Rule Validation
    if (hasPurchased($user_id, $product_id)) {
        
        $stmt = $db->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $product_id, $user_id, $rating, $comment);

        if ($stmt->execute()) {
            // 2. Success message and Redirect to Logout or Home
            echo "<script>
                    alert('Thank you! Your review has been submitted successfully.');
                    window.location.href = 'logout.php'; 
                  </script>";
            exit();
        } else {
            echo "Error: Could not save review. " . $db->error;
        }
        
    } else {
        die("Unauthorized access.");
    }
}
?>