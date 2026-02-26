-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Feb 26, 2026 at 09:21 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `melody`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `description`) VALUES
(1, 'Guitars', NULL, 'All types of guitars'),
(2, 'Keyboards', NULL, 'Pianos, synthesizers and keyboards'),
(3, 'Drums & Percussion', NULL, 'Drum kits and percussion instruments'),
(4, 'Wind Instruments', NULL, 'Brass and woodwind instruments'),
(5, 'String Instruments', NULL, 'Violins, cellos and more'),
(6, 'Accessories', NULL, 'Straps, picks, cables and more'),
(7, 'Digital Sheet Music', NULL, 'Downloadable sheet music'),
(8, 'Electric Guitars', 1, 'Electric guitars'),
(9, 'Acoustic Guitars', 1, 'Acoustic guitars'),
(10, 'Bass Guitars', 1, 'Bass guitars'),
(11, 'Digital Pianos', 2, 'Digital pianos'),
(12, 'Synthesizers', 2, 'Synthesizers and workstations');

-- --------------------------------------------------------

--
-- Table structure for table `digital_products`
--

CREATE TABLE `digital_products` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `max_downloads` int(11) DEFAULT 3
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `digital_products`
--

INSERT INTO `digital_products` (`id`, `product_id`, `file_path`, `max_downloads`) VALUES
(1, 16, 'digital/Happy Birthday To You.pdf', 3),
(2, 17, 'digital/Happy Birthday To You.pdf', 3),
(3, 18, 'digital/Happy Birthday To You.pdf', 3);

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `download_count` int(11) DEFAULT 0,
  `last_downloaded` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_cost` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `tracking_number` varchar(100) DEFAULT NULL,
  `shipping_name` varchar(100) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_postcode` varchar(20) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `subtotal`, `shipping_cost`, `total`, `status`, `tracking_number`, `shipping_name`, `shipping_address`, `shipping_city`, `shipping_postcode`, `notes`, `created_at`) VALUES
(1, 3, 899.99, 0.00, 899.99, 'delivered', NULL, 'John Smith', '123 Music Lane', 'London', 'EC1A 1BB', NULL, '2026-02-25 08:55:06'),
(2, 4, 0.00, 0.00, 3899.97, 'pending', NULL, 'Prabash Lakshitha', '156/A Rajasinghe Mawatta, Ihala Imbullgoda', 'Gampaha', '11040', NULL, '2026-02-26 19:56:46'),
(3, 4, 0.00, 0.00, 899.99, 'pending', NULL, 'Prabash Lakshitha', '156/A Rajasinghe Mawatta, Ihala Imbullgoda', 'Gampaha', '11040', NULL, '2026-02-26 19:58:21'),
(4, 4, 0.00, 0.00, 699.99, 'pending', NULL, 'Prabash Lakshitha', '156/A Rajasinghe Mawatta, Ihala Imbullgoda', 'Gampaha', '11040', NULL, '2026-02-26 20:03:40'),
(5, 4, 0.00, 0.00, 7.98, 'pending', NULL, 'kamal weersinghe', '156/A Rajasinghe Mawatta, ragama', 'ragama', '11040', NULL, '2026-02-26 20:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `download_count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `download_count`) VALUES
(1, 1, 1, 1, 899.99, 1),
(2, 2, 11, 1, 2499.99, 0),
(3, 2, 4, 1, 649.99, 0),
(4, 2, 3, 1, 749.99, 0),
(5, 3, 1, 1, 899.99, 0),
(6, 4, 10, 1, 699.99, 0),
(7, 5, 18, 2, 3.99, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(200) NOT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(255) DEFAULT 'default.jpg',
  `type` enum('physical','digital') DEFAULT 'physical',
  `specs` text DEFAULT NULL,
  `featured` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `brand`, `description`, `price`, `stock`, `image`, `type`, `specs`, `featured`, `created_at`) VALUES
(1, 8, 'Stratocaster Pro', 'Fender', 'Classic electric guitar with maple neck and alder body. Perfect for rock, blues and more.', 899.99, 15, 'default.jpg', 'physical', 'Body: Alder, Neck: Maple, Frets: 22, Pickups: 3x Single Coil', 1, '2026-02-25 08:55:06'),
(2, 8, 'Les Paul Standard', 'Gibson', 'Iconic humbucker-equipped electric guitar with mahogany body.', 1299.99, 8, 'default.jpg', 'physical', 'Body: Mahogany, Neck: Mahogany, Frets: 22, Pickups: 2x Humbucker', 1, '2026-02-25 08:55:06'),
(3, 9, 'Dreadnought D-28', 'Martin', 'Premium acoustic guitar with Sitka spruce top and rosewood back.', 749.99, 12, 'default.jpg', 'physical', 'Top: Sitka Spruce, Back/Sides: Rosewood, Neck: Select Hardwood', 1, '2026-02-25 08:55:06'),
(4, 9, 'Grand Auditorium', 'Taylor', 'Versatile acoustic guitar ideal for fingerpicking and strumming.', 649.99, 10, 'default.jpg', 'physical', 'Top: Sitka Spruce, Back/Sides: Layered Walnut', 0, '2026-02-25 08:55:06'),
(5, 10, 'Jazz Bass', 'Fender', 'Classic 4-string bass with brilliant tone for all genres.', 549.99, 20, 'default.jpg', 'physical', 'Body: Alder, Strings: 4, Pickups: 2x Single Coil', 0, '2026-02-25 08:55:06'),
(6, 11, 'Roland FP-90X', 'Roland', 'Professional digital piano with 88-key weighted hammer action.', 1499.99, 5, 'default.jpg', 'physical', 'Keys: 88 Weighted, Polyphony: 256, Sounds: 90+', 1, '2026-02-25 08:55:06'),
(7, 11, 'Yamaha P-125', 'Yamaha', 'Slim digital piano perfect for beginners and intermediate players.', 599.99, 18, 'default.jpg', 'physical', 'Keys: 88 Graded, Polyphony: 192, Sounds: 24', 0, '2026-02-25 08:55:06'),
(8, 12, 'Moog Subsequent 37', 'Moog', 'Powerful analog synthesizer with 37 keys and dual oscillators.', 1599.99, 4, 'default.jpg', 'physical', 'Keys: 37, Oscillators: 2, Filter: Moog Ladder', 0, '2026-02-25 08:55:06'),
(9, 3, 'DW Performance Kit', 'DW', 'Professional 5-piece drum kit with hardware and cymbals included.', 1899.99, 3, 'default.jpg', 'physical', 'Pieces: 5, Shell: Maple, Finish: Chrome Shadow', 1, '2026-02-25 08:55:06'),
(10, 3, 'Pearl Export EXX', 'Pearl', 'Great starter drum kit for beginner and intermediate drummers.', 699.99, 7, 'default.jpg', 'physical', 'Pieces: 5, Shell: Poplar/Asian Mahogany', 0, '2026-02-25 08:55:06'),
(11, 4, 'Bach Stradivarius Trumpet', 'Bach', 'Professional Bb trumpet favoured by orchestral players worldwide.', 2499.99, 5, 'default.jpg', 'physical', 'Key: Bb, Bell: 4-7/8\", Material: Yellow Brass', 0, '2026-02-25 08:55:06'),
(12, 5, 'Stentor Student Violin', 'Stentor', 'Full-size student violin, ideal for beginners with solid spruce top.', 129.99, 25, 'default.jpg', 'physical', 'Size: 4/4, Top: Solid Spruce, Body: Maple', 0, '2026-02-25 08:55:06'),
(13, 6, 'Guitar Picks Set (50)', 'Dunlop', 'Mixed variety pack of 50 picks in assorted gauges and colours.', 12.99, 100, 'default.jpg', 'physical', 'Count: 50, Gauges: Thin/Medium/Heavy', 0, '2026-02-25 08:55:06'),
(14, 6, 'Guitar Strap - Leather', 'Levy', 'Genuine leather guitar strap, adjustable 40-58 inches.', 29.99, 45, 'default.jpg', 'physical', 'Material: Genuine Leather, Width: 2.5 inches', 0, '2026-02-25 08:55:06'),
(15, 6, 'Instrument Cable 3m', 'Mogami', 'Professional-grade cable for guitars and keyboards, noise-free.', 24.99, 60, 'default.jpg', 'physical', 'Length: 3m, Connectors: 6.35mm TS', 0, '2026-02-25 08:55:06'),
(16, 7, 'Bohemian Rhapsody Score', 'Queen', 'Official sheet music for the legendary Queen masterpiece. Instant download.', 4.99, 999, 'default.jpg', 'digital', 'Pages: 8, Format: PDF, Difficulty: Intermediate', 0, '2026-02-25 08:55:06'),
(17, 7, 'Fur Elise - Beethoven', 'Beethoven', 'Classic piano piece by Beethoven. Perfect for intermediate pianists.', 2.99, 999, 'default.jpg', 'digital', 'Pages: 4, Format: PDF, Difficulty: Intermediate', 0, '2026-02-25 08:55:06'),
(18, 7, 'Hotel California Guitar Tab', 'Eagles', 'Complete guitar tablature for Hotel California by The Eagles.', 3.99, 999, 'default.jpg', 'digital', 'Pages: 6, Format: PDF, Difficulty: Advanced', 0, '2026-02-25 08:55:06');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 3, 1, 5, 'Absolutely love this guitar! The tone is incredible and setup was perfect out of the box.', '2026-02-25 08:55:07'),
(2, 4, 18, 5, 'well done', '2026-02-26 20:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','staff','admin') DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postcode` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `city`, `postcode`, `created_at`) VALUES
(1, 'Admin User', 'admin@melodymasters.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NULL, NULL, NULL, NULL, '2026-02-25 08:55:06'),
(2, 'Staff Member', 'staff@melodymasters.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'staff', NULL, NULL, NULL, NULL, '2026-02-25 08:55:06'),
(3, 'John Smith', 'customer@melodymasters.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer', NULL, NULL, NULL, NULL, '2026-02-25 08:55:06'),
(4, 'Prabash Lakshitha', 'prabashweerasinghe2002@gmail.com', '$2y$10$YpOuMsbo/.97MgAE1r/bs.rFugxaeFo6zlq1TWKusY3HxPw/5ghF.', 'customer', '0703734962', '156/A Rajasinghe Mawatta, Ihala Imbullgoda', 'Gampaha', '11040', '2026-02-26 16:02:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `digital_products`
--
ALTER TABLE `digital_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_review` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `digital_products`
--
ALTER TABLE `digital_products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `digital_products`
--
ALTER TABLE `digital_products`
  ADD CONSTRAINT `digital_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `downloads_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
