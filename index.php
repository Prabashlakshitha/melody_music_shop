<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
include __DIR__ . '/includes/header.php';

$db=db_connect();
//featured products
$featured_products = $db->query("SELECT * FROM products WHERE featured=1 LIMIT 3");
//latest products
$product_results= $db->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 7");
//categories
$categories = $db->query("SELECT * FROM categories where parent_id IS NULL");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    </head>
    <body>
        <!-- Hero Section -->

        <section class="hero">
            <div class="hero-section">
                <h1>WELCOME MELODY MASTER</h1>
                <p>Discover your next favorite music experience with our curated collection of instruments and accessories.</p>
                <a href="shop.php" class="btn-primary">Shop Now</a>
            </div>

        </section>
        <!--categories-->
        <section class="categories">
            <div class="categorie-section">
            <h2>Shop by Category</h2>
            <?php 
            $icons=[
               '<i class="fa-solid fa-guitar"></i>',
                '<i class="fa-solid fa-piano-keyboard"></i>',
                '<i class="fa-solid fa-drum"></i>',
                '<i class="fa-solid fa-flute"></i>',
                '<i class="fa-solid fa-violin"></i>',
                '<i class="fa-solid fa-speaker"></i>',
                '<i class="fa-solid fa-music"></i>'
                
            ];
            $i=0;
            while ($cat = $categories->fetch_assoc()) {
                $caticon = $icons[$i % count($icons)];
            
                ?>

                <div class="category-item">
                    <a href="shop.php?cat=<?= $cat['id'] ?>">
                        <div class="cat-icon"><?=$caticon?></div>
                        <div clas="cat-name"><?= htmlspecialchars($cat['name']) ?></div>
                        </a>
                        <?php
                        $i++;
                       
            }


                        ?>

                </div>

                </div>
            
                
        </section>

        <!-- Featured Products -->

        <section class="feature-product">
            <div class="feature-name">Featured Products</div>
            <?php if($featured_products-> num_rows >0){
                while ($product = $featured_products->fetch_assoc()) {
                    include __DIR__ . '/includes/card.php';
                   

                }
                
                


            }?>

            
        </section>
        <!-- Latest Products -->
        <section class="latest-products">
            <div class="latest-name">Latest Products</div>
            <?php if($product_results-> num_rows >0){
                while ($product = $product_results->fetch_assoc()) {
                    include __DIR__ . '/includes/card.php';
                  

                }
                
                 

            }?>
    </body>
</html>




