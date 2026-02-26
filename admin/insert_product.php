<?php
session_start();
require_once 'config.php';
require_once 'function.php';

// Ensure only admins can process this request
require_admin();
require_staff();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = db_connect();

    // Sanitize and collect basic product data from the form
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $category_id = (int)$_POST['category_id']; // ID from categories dropdown
    $price = (float)$_POST['price'];
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $is_digital = isset($_POST['is_digital']) ? true : false;

    // Start a database transaction to ensure data consistency across two tables
    $db->begin_transaction();

    try {
        // 1. Insert basic product details into the 'products' table
        $product_query = "INSERT INTO products (name, category_id, price, description) VALUES (?, ?, ?, ?)";
        $stmt = $db->prepare($product_query);
        $stmt->bind_param("sids", $name, $category_id, $price, $description);
        $stmt->execute();
        
        // Retrieve the newly created product ID
        $new_product_id = $db->insert_id;

        // 2. If the product is marked as digital, insert additional data into 'digital_products' table
        if ($is_digital) {
            $file_path = mysqli_real_escape_string($db, $_POST['file_path']); // e.g., digital/song.pdf
            $max_downloads = (int)$_POST['max_downloads']; // Using max_downloads from image_6c819f.png structure

            $digital_query = "INSERT INTO digital_products (product_id, file_path, max_downloads) VALUES (?, ?, ?)";
            $d_stmt = $db->prepare($digital_query);
            $d_stmt->bind_param("isi", $new_product_id, $file_path, $max_downloads);
            $d_stmt->execute();
        }

        // Commit the transaction if everything is successful
        $db->commit();
        
        echo "<script>
                alert('Product successfully added!');
                window.location.href = 'admin_dashboard.php';
              </script>";

    } catch (Exception $e) {
        // Rollback the transaction if any query fails
        $db->rollback();
        echo "Error adding product: " . $e->getMessage();
    }
} else {
    // Redirect if accessed without POST method
    header('Location: add_product.php');
    exit();
}
?>