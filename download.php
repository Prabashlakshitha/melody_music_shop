<?php

require_once 'config.php';

if (isset($_GET['product_id']) && isset($_GET['order_id'])) {
    $db = db_connect();
    $p_id = (int)$_GET['product_id'];
    $o_id = (int)$_GET['order_id'];

    // 1. Join order_items and digital_products to check limits
    // Using table structures from image_6de545.png and image_6c819f.png
    $query = "SELECT dp.file_path, dp.max_downloads, oi.download_count 
              FROM digital_products dp
              JOIN order_items oi ON dp.product_id = oi.product_id
              WHERE oi.order_id = ? AND oi.product_id = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $o_id, $p_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        // 2. Check if current downloads are less than max_downloads limit
        if ($result['download_count'] < $result['max_downloads']) {
            
            // 3. Update the download count in order_items
            $update = $db->prepare("UPDATE order_items SET download_count = download_count + 1 
                                   WHERE order_id = ? AND product_id = ?");
            $update->bind_param("ii", $o_id, $p_id);
            $update->execute();

            // 4. Start the file download
            $file = $result['file_path'];
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file).'"');
                readfile($file);
                exit;
            }
        } else {
            echo "Download limit reached! (Max: " . $result['max_downloads'] . ")";
        }
    }
}
?>