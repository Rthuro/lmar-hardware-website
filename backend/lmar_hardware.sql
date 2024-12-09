-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 09, 2024 at 01:37 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lmar_hardware`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `size_id` int DEFAULT NULL,
  `quantity` int NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Hand Tools'),
(2, 'Measuring Tools'),
(3, 'Cutting Tools'),
(4, 'Fastening Tools'),
(5, 'Grinding Tools'),
(6, 'Clamping Tools'),
(7, 'Finishing Tools'),
(8, 'Wood Materials'),
(9, 'Building Materials');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

DROP TABLE IF EXISTS `deliveries`;
CREATE TABLE IF NOT EXISTS `deliveries` (
  `delivery_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `address` text NOT NULL,
  `status` enum('Pending','Shipped','Delivered') DEFAULT 'Pending',
  `date` text,
  PRIMARY KEY (`delivery_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

DROP TABLE IF EXISTS `feedback`;
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text,
  `feedback_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `deliveryFee` decimal(11,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`id`, `name`, `deliveryFee`) VALUES
(1, 'Luyahan', 60.00),
(2, 'Pasonanca', 100.00),
(3, 'Santa Maria', 140.00),
(4, 'Tumaga', 140.00),
(5, 'Cabatangan', 180.00),
(6, 'Lunzuran ', 180.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int DEFAULT NULL,
  `payment` decimal(11,2) NOT NULL,
  `location` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` text,
  `contact_num` bigint NOT NULL,
  `delivery_option` enum('delivery','pickup') DEFAULT NULL,
  `status` enum('pending','completed','cancelled','to_deliver','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pickup_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `payment`, `location`, `address`, `contact_num`, `delivery_option`, `status`, `order_date`, `pickup_date`, `delivery_date`) VALUES
(32, 17, 3540.00, NULL, NULL, 9455393908, 'pickup', 'completed', '2024-12-08 13:11:06', '2024-12-08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `size_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(11,2) NOT NULL,
  PRIMARY KEY (`order_item_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `size_id`, `quantity`, `price`) VALUES
(10, 32, 6, 14, 2, 885.00);

-- --------------------------------------------------------

--
-- Table structure for table `pickups`
--

DROP TABLE IF EXISTS `pickups`;
CREATE TABLE IF NOT EXISTS `pickups` (
  `pickup_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `product` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `pickup_date` date NOT NULL,
  `status` enum('Pending','Picked') DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`pickup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `product_img` text NOT NULL,
  `category` int NOT NULL,
  `description` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_img`, `category`, `description`, `created_at`, `updated_at`) VALUES
(6, 'Plywood', 'productImages/67553c06c3ced13.png', 9, '', '2024-12-08 06:26:14', '2024-12-08 06:26:14'),
(7, 'Deformed Bar G40', 'productImages/6755c1738418612.png', 9, '', '2024-12-08 15:55:31', '2024-12-08 15:55:31'),
(8, 'Concrete Hollow Block', 'productImages/6755c2a9831d7concrete_blocks.png', 9, '', '2024-12-08 16:00:41', '2024-12-08 16:00:41'),
(9, 'White Sand', 'productImages/6755c35d40b2d15.png', 9, '', '2024-12-08 16:03:41', '2024-12-08 16:03:41');

-- --------------------------------------------------------

--
-- Table structure for table `product_size`
--

DROP TABLE IF EXISTS `product_size`;
CREATE TABLE IF NOT EXISTS `product_size` (
  `size_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `size` varchar(255) NOT NULL,
  `stock` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`size_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`size_id`, `product_id`, `size`, `stock`, `price`) VALUES
(12, 6, '1/4&quot;', 20, 494.00),
(14, 6, '1/2&quot;', 18, 885.00),
(15, 7, '10mm', 20, 190.00),
(16, 7, '10.5mm', 10, 600.00),
(17, 7, '12mm', 20, 274.00),
(18, 7, '16mm', 10, 482.00),
(19, 7, '20mm', 10, 753.00),
(20, 8, '4&quot;', 200, 19.00),
(21, 8, '5&quot;', 200, 20.00),
(22, 8, '6&quot;', 200, 25.00),
(23, 9, 'Sack', 200, 190.00);

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

DROP TABLE IF EXISTS `stock_transactions`;
CREATE TABLE IF NOT EXISTS `stock_transactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `change_type` enum('addition','subtraction') NOT NULL,
  `quantity` int NOT NULL,
  `transaction_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'admin',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(17, 'ruth', 'asasa@gmail.com', '$2y$10$eG2LwaoihZWCtwzKF6YLiu6AOKwCZsGyZ5Kc6byQNv20NrTUm/0aG', 'customer'),
(18, 'lmarAdmin', 'lmarAdmin@gmail.com', '$2y$10$rXQL80scgKPmfl3nx2MhE.sM23n4p4BtptKbi0rb1LH21dqO.jJJe', 'admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
