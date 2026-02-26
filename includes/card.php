<?php
?>

<div class="card-item">

    <div class="card-image">
        <?php
        
        switch ($product['category_id']) {
            case 1:
            case 8:
            case 9:
            case 10:
                echo '<i class="fa-solid fa-guitar"></i>';
                break;
            case 2:
            case 11:
                echo '<i class="fa-solid fa-music"></i>';
                break;
            case 3:
                echo '<i class="fa-solid fa-drum"></i>';
                break;
            case 4:
                echo '<i class="fa-solid fa-compact-disc"></i>';
                break;
            case 5:
                echo '<i class="fa-solid fa-headphones"></i>';
                break;
            case 6:
                echo '<i class="fa-solid fa-microphone"></i>';
                break;
            case 7:
            case 12:
                echo '<i class="fa-solid fa-music"></i>';
                break;
            default:
                echo '<i class="fa-solid fa-music"></i>';
        }
        ?>
    </div>

    <div class="card-info">
        <div class="name"><?= htmlspecialchars($product['name']) ?></div>
        <div class="price">£<?= number_format($product['price'], 2) ?></div>
        <a href="shop.php?cat=<?= $product['category_id'] ?>" class="btn-view">View</a>
    </div>

</div>