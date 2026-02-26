<?php
require __DIR__ . '/function.php';
include __DIR__ . '/includes/header.php';
require_once __DIR__ . '/config.php';

$db = db_connect();

//header category id  and index page category id

$cat_id = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$categoryIds = [$cat_id]; // Start with the selected category itself


if ($cat_id > 0) {
    $selectedCat = $cat_id;



    // Find subcategories under this category
    $subResult = $db->query("SELECT id FROM categories WHERE parent_id = $selectedCat");
    while ($sub = $subResult->fetch_assoc()) {
        $categoryIds[] = (int)$sub['id'];
    }

    // Build IN clause  →  1,8,9
    $inClause = implode(',', $categoryIds);

    $products = $db->query("
        SELECT p.*, c.name AS cat_name
        FROM products p
        JOIN categories c ON p.category_id = c.id
        WHERE p.category_id IN ($inClause)
        ORDER BY p.name ASC
    ");

    // Get category name for page heading
    $headingName = $db->query("SELECT name FROM categories WHERE id = $selectedCat")->fetch_assoc()['name'];

} else {
    // No category selected — show all
    $products = $db->query("
        SELECT p.*, c.name AS cat_name
        FROM products p
        JOIN categories c ON p.category_id = c.id
        ORDER BY p.name ASC
    ");
}
    $headingName = 'All Products';




?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | Melody Masters</title>
    <link rel="stylesheet" href="style/shop.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style/home.css">
    <link rel="stylesheet" href="style/shop.css">
</head>
<body>
    <div class="shop_container ">
        <div class="shop_header">
            <h1><?= htmlspecialchars($headingName) ?></h1>
            </div>
            <div class="product grid">
                <?php if ($products->num_rows > 0) {
                    while ($product = $products->fetch_assoc()) {
                        include __DIR__ . '/includes/shop_card.php';
                    }
                } else {
                    echo "<p>No products found in this category.</p>";
                } ?>
            </div>
    </div>
</body>
</html>

