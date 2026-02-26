<?php

require_once 'config.php';
require_once 'function.php';
//admin loged and staff 
require_admin();
require_staff();


$db = db_connect();

// 1. Fetch all categories from the category table
$cat_query = "SELECT * FROM categories";
$cat_result = $db->query($cat_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Add Product</title>
    <link rel="stylesheet" href="style/admin.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Add New Product</h2>
        <form action="insert_product.php" method="POST" enctype="multipart/form-data">
            
            <label>Product Name:</label>
            <input type="text" name="name" required>

            <label>Category:</label>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                <?php while ($cat = $cat_result->fetch_assoc()): ?>
                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Price:</label>
            <input type="number" step="0.01" name="price" required>

            <label>Description:</label>
            <textarea name="description"></textarea>

            <label>Product Image:</label>
            <input type="file" name="image" required>

            <button type="submit" name="submit">Add Product</button>
        </form>
    </div>
</body>
</html>