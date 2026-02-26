<?php 
//require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../function.php';

$page_title = "Melody - Master";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> | Melody Masters</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="nav-logo">
        <span class="logo-icon">&#9834;</span>
        <span>Melody <em>Masters</em></span>
    </a>

    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li class="dropdown">
            <a href="#">Categories &#9662;</a>
            <ul class="dropdown-menu">
                <li><a href="shop.php?cat=1">Guitars</a></li>
                <li><a href="shop.php?cat=2">Keyboards</a></li>
                <li><a href="shop.php?cat=3">Drums &amp; Percussion</a></li>
                <li><a href="shop.php?cat=4">Wind Instruments</a></li>
                <li><a href="shop.php?cat=5">String Instruments</a></li>
                <li><a href="shop.php?cat=6">Accessories</a></li>
                <li><a href="shop.php?cat=7">Sheet Music</a></li>
            </ul>
        </li>
    </ul>

    <div class="nav-actions">
        <?php
        $cartCount = 0;
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $cartCount += $item['qty'];
            }
        }
        ?>
        <a href="cart.php" class="cart-btn">
            &#128722; <span class="cart-count"><?= $cartCount ?></span>
        </a>

        <?php if (isLoggedIn()): ?>
            <div class="dropdown">
                <a href="#" class="btn-outline"><?= htmlspecialchars($_SESSION['user_name']) ?> &#9662;</a>
                <ul class="dropdown-menu">
                    <li><a href="customer/dashboard.php">My Dashboard</a></li>
                    <li><a href="customer/orders.php">My Orders</a></li>
                    <li><a href="customer/downloads.php">My Downloads</a></li>
                    <?php if (isStaff()): ?>
                        <li><hr style="border-color:#333;margin:4px 0;"></li>
                        <li><a href="admin/dashboard.php">Admin Panel</a></li>
                    <?php endif; ?>
                    <li><hr style="border-color:#333;margin:4px 0;"></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
        <?php else: ?>
            <a href="login.php"    class="btn-outline">Login</a>
            <a href="register.php" class="btn-primary">Register</a>
        <?php endif; ?>
    </div>

    <button class="mobile-menu-btn" onclick="toggleMobileMenu()">&#9776;</button>
</nav>