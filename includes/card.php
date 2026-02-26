<?php
?>

<DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    </head>
    <body>

    <div class="card-name">
        <div class="card-image">
            <?php
            switch ($product['category_id']) {
                case 1:
                    echo '<i class="fa-solid fa-guitar"></i>';
                    break;
                case 2:
                    echo '<i class="fa-solid fa-piano-keyboard"></i>';
                    break;
                case 3:
                    echo '<i class="fa-solid fa-drum"></i>';
                    break;
                case 4:
                    echo '<i class="fa-solid fa-flute"></i>';
                    break;
                case 5:
                    echo '<i class="fa-solid fa-violin"></i>';
                    break;
                case 6:
                    echo '<i class="fa-solid fa-speaker"></i>';
                    break;
                case 7:
                    echo '<i class="fa-solid fa-sheet-music"></i>';
                    break;
                case 8:
                    echo '<i class="fa-solid fa-guitar"></i>';
                    break;
                case 9:
                    echo '<i class="fa-solid fa-guitar"></i>';
                    break;
                case 10:
                    echo '<i class="fa-solid fa-guitar"></i>';
                    break;
                case 11:
                    echo '<i class="fa-solid fa-piano-keyboard"></i>';
                    break;
                case 12:
                    echo '<i class="fa-solid fa-midi"></i>';
                    break;

                default:
                    echo '<i class="fa-solid fa-music"></i>';
            }
        ?>
        </div>
        <div class="card-name">
            <div class="name"><?= htmlspecialchars($product['name']) ?></div>
            <div class="price">$<?= number_format($product['price'], 2) ?></div>
        </div>
    </div>
        </body>
        </html>