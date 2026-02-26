<?php

require_once __DIR__.'/config.php';
require_once __DIR__.'/function.php';

// Check if user is logged in and cart is not empty
if (isloggedin() && !empty($_SESSION['cart'])) {
    $db = db_connect();
    
    // Get user ID from session
    $user_id = $_SESSION['user_id']; 
    
    // Get billing/shipping details from POST request
    $shipping_name = $_POST['shipping_name'];
    $shipping_address = $_POST['shipping_address'];
    $shipping_city = $_POST['shipping_city'];
    $shipping_postcode = $_POST['shipping_postcode'];
    $phone = $_POST['phone'];
    $total_amount = $_POST['total_amount'];

    // 1. Insert order details into 'orders' table
    $query = "INSERT INTO orders (user_id, shipping_name, shipping_address, shipping_city, shipping_postcode, total, status) 
              VALUES (?, ?, ?, ?, ?, ?, 'pending')";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("issssd", $user_id, $shipping_name, $shipping_address, $shipping_city, $shipping_postcode, $total_amount);
    
    if ($stmt->execute()) {
        // Get the last inserted Order ID
        $order_id = $db->insert_id;

        // 2. Loop through the cart session to insert items into 'order_items' table
        foreach ($_SESSION['cart'] as $product_id => $qty) {
            
            // Retrieve the latest price for the product from 'products' table
            $p_stmt = $db->prepare("SELECT price FROM products WHERE id = ?");
            $p_stmt->bind_param("i", $product_id);
            $p_stmt->execute();
            $p_result = $p_stmt->get_result();
            $product_data = $p_result->fetch_assoc();
            $unit_price = $product_data['price'];

            // 3. Insert each item into 'order_items' table
            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $item_stmt = $db->prepare($item_query);
            $item_stmt->bind_param("iiid", $order_id, $product_id, $qty, $unit_price);
            $item_stmt->execute();
        }

        //unset cart session
        unset($_SESSION['cart']);

        

        // Redirect to a success page
        header('Location: order_sucess.php?id=' . $order_id);
        exit();

      



    } else {
        // Handle database errors
        die("Order processing failed: " . $db->error);
    }

} else {
    // Redirect to login if session is invalid or cart is empty
    header('Location: login.php');
    exit();
}

?>