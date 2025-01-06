-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 06, 2025 at 07:00 PM
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
CREATE DATABASE IF NOT EXISTS `lmar_hardware` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `lmar_hardware`;

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
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Hand Tools'),
(2, 'Measuring Tools'),
(3, 'Cutting / Disc Tools'),
(4, 'Fastening Tools'),
(5, 'Grinding Tools'),
(6, 'Clamping Tools'),
(7, 'Finishing Tools'),
(9, 'Building Materials'),
(13, 'Bits Tools'),
(14, 'Others');

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

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
  `status` enum('pending','completed','cancelled','to deliver','') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pickup_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `payment`, `location`, `address`, `contact_num`, `delivery_option`, `status`, `order_date`, `pickup_date`, `delivery_date`) VALUES
(35, 17, 120.00, NULL, NULL, 9455393908, 'pickup', 'cancelled', '2024-12-11 17:04:59', '2024-12-12', NULL),
(36, 17, 90.00, NULL, NULL, 9455393908, 'pickup', 'cancelled', '2024-12-17 20:09:27', '2024-12-18', NULL),
(37, 17, 494.00, NULL, NULL, 9455393908, 'pickup', 'cancelled', '2024-12-17 20:29:29', '2024-12-18', NULL),
(38, 17, 350.00, NULL, NULL, 9455393908, 'pickup', 'completed', '2024-12-17 20:33:58', '2024-12-18', NULL),
(39, 17, 494.00, NULL, NULL, 9455393908, 'pickup', 'cancelled', '2024-12-17 20:44:09', '2024-12-18', NULL),
(40, 17, 79.00, 'Luyahan ', 'Luyahan  , near booster dtation', 9455393908, 'delivery', 'cancelled', '2024-12-21 11:19:50', NULL, '2024-12-23'),
(41, 17, 57.00, NULL, NULL, 9455393908, 'pickup', 'cancelled', '2025-01-04 14:14:02', '2025-01-11', NULL),
(42, 17, 250.00, 'Luyahan ', 'Luyahan  , sasa', 9455393908, 'delivery', 'cancelled', '2025-01-04 14:22:17', NULL, '2025-01-05'),
(43, 17, 1710.00, NULL, NULL, 9455393908, 'pickup', 'completed', '2025-01-05 11:01:39', '2025-01-05', NULL),
(46, 17, 634.00, 'Santa Maria ', 'Santa Maria  , sasa', 9455393908, 'delivery', 'to deliver', '2025-01-05 11:54:00', NULL, '2025-01-05'),
(47, 17, 200.00, NULL, NULL, 9455393908, 'pickup', 'cancelled', '2025-01-06 13:02:14', '2025-01-06', NULL),
(48, 17, 845.00, NULL, NULL, 9455393908, 'pickup', 'pending', '2025-01-06 13:06:50', '2025-01-06', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `size_id`, `quantity`, `price`) VALUES
(16, 37, 10, 28, 1, 494.00),
(15, 36, 23, 56, 2, 45.00),
(14, 35, 15, 37, 1, 60.00),
(17, 38, 13, 32, 1, 190.00),
(18, 38, 17, 39, 1, 160.00),
(19, 39, 10, 28, 1, 494.00),
(20, 40, 11, 24, 1, 19.00),
(21, 41, 11, 24, 3, 19.00),
(22, 42, 13, 32, 1, 190.00),
(23, 43, 21, 48, 1, 1710.00),
(24, 44, 10, 30, 1, 885.00),
(25, 45, 13, 32, 1, 190.00),
(26, 46, 10, 28, 1, 494.00),
(27, 47, 40, 88, 1, 200.00),
(28, 48, 40, 86, 1, 305.00),
(29, 48, 40, 87, 1, 340.00),
(30, 48, 40, 88, 1, 200.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_img`, `category`, `description`, `created_at`, `updated_at`) VALUES
(10, 'Plywood', 'productImages/67583746240e313.png', 9, '', '2024-12-10 12:42:46', '2024-12-10 12:42:46'),
(11, 'Concrete Hollow Block', 'productImages/6758379173c6cconcrete_blocks.png', 9, 'sa', '2024-12-10 12:44:01', '2025-01-03 12:19:09'),
(12, 'White Sand', 'productImages/6758379d30fdc15.png', 9, '', '2024-12-10 12:44:13', '2024-12-10 12:44:13'),
(13, 'Deformed Bar G40', 'productImages/675837a5e13cc12.png', 9, 'sasa', '2024-12-10 12:44:21', '2024-12-10 12:47:41'),
(15, 'Stanley Flat Screwdriver', 'productImages/6759642e50604stanley-flat-screwdriver-1.jpg', 1, '', '2024-12-11 10:06:38', '2024-12-11 10:06:38'),
(17, 'KYK Fiber Glass Claw Hammer', 'productImages/6759650a2873ffiber-glass-claw-hammer.jpg', 1, '', '2024-12-11 10:10:18', '2024-12-11 10:10:18'),
(18, 'KYK C-Clamp', 'productImages/675965bc3ff5dc-clamp-1.jpg', 6, '', '2024-12-11 10:13:16', '2024-12-11 10:13:16'),
(19, 'Stanley Level Bar', 'productImages/6759669786c91stanley-level-bar.jpg', 2, '', '2024-12-11 10:16:55', '2024-12-11 10:16:55'),
(20, 'Ohayo Measuring Tape', 'productImages/675966e29fe5eMeasuring-Tape-ohayo.jpg', 2, '', '2024-12-11 10:18:10', '2024-12-11 10:18:10'),
(21, 'Finishing Nail Box', 'productImages/67596774df526finishing-nail-1-1.jpg', 4, '', '2024-12-11 10:20:36', '2024-12-11 10:20:36'),
(22, 'Finishing Nail ( by kilo )', 'productImages/6759678d4b904finishing-nail-1-1.jpg', 4, '', '2024-12-11 10:21:01', '2024-12-11 10:21:01'),
(23, 'Wokin Wall Scraper', 'productImages/6761a3d08538fRed-with-X-Band-Logo-8.png', 1, '• Size: 4″/100mm • High quality tool steel • Heat treated • Fine polished • Wooden handle', '2024-12-17 16:16:16', '2025-01-05 15:13:27'),
(27, 'Panclub Paint Brush', '../product/productImages/677a9cc2c46c7panclub.jpg', 7, '', '2025-01-05 14:52:50', '2025-01-05 14:52:50'),
(29, 'Paint Tray', '../product/productImages/677a9ecd78be5paint-tray.jpg', 7, '', '2025-01-05 15:01:33', '2025-01-05 15:01:33'),
(30, 'Acrylon Paint Roller', '../product/productImages/677a9f5ddc451Acrylon-Paint-Roller-7.png', 7, '', '2025-01-05 15:03:57', '2025-01-05 15:03:57'),
(31, '3M Sandpaper', '../product/productImages/677aa06b385fd3M-Sandpaper-1.jpg', 7, '', '2025-01-05 15:08:27', '2025-01-05 15:08:27'),
(32, 'Putty Knife', '../product/productImages/677aa1135e1c5putty-knife-4.jpg', 1, '', '2025-01-05 15:11:15', '2025-01-05 15:11:15'),
(33, 'Shovel', '../product/productImages/677bcce9e3b7dshovel-poited.png', 1, 'All Steel Pointed', '2025-01-06 12:30:33', '2025-01-06 12:30:46'),
(34, 'Finishing Trowel', '../product/productImages/677bcde9e2c7dfinishing-trowel.png', 1, '', '2025-01-06 12:34:49', '2025-01-06 12:34:49'),
(35, 'KYK Handsaw', '../product/productImages/677bce4c925edkyk-handsaw.jpg', 1, '', '2025-01-06 12:36:28', '2025-01-06 12:36:28'),
(36, 'KYK Adjustable Wrench', '../product/productImages/677bced58fa43download-3.jpg', 1, '', '2025-01-06 12:38:45', '2025-01-06 12:38:45'),
(37, 'Butterfly Combination Pliers 7″', '../product/productImages/677bd23f6f911Comb.Plier-butterfly-1.jpg', 1, '', '2025-01-06 12:53:19', '2025-01-06 12:53:19'),
(38, 'Butterfly Wood Chisel', '../product/productImages/677bd2a9aae30butterfly-3-4-1.jpg', 1, '', '2025-01-06 12:55:05', '2025-01-06 12:55:05'),
(39, 'Penguin Steel Brush', '../product/productImages/677bd34021f1esteel-brush-penguin.jpg', 1, '', '2025-01-06 12:57:36', '2025-01-06 12:57:36'),
(40, 'Stanley Wood Chisel', '../product/productImages/677bd3875831fwood-chisel.jpg', 1, '', '2025-01-06 12:58:47', '2025-01-06 12:58:47'),
(41, 'Sandflex Handsaw Blade', '../product/productImages/677bdc82a57fbsandlex.jpg', 1, '', '2025-01-06 13:37:06', '2025-01-06 13:37:06'),
(42, 'Carpenters Tri – Square', '../product/productImages/677bdd8f077b1squala-1.jpg', 2, '', '2025-01-06 13:41:35', '2025-01-06 13:41:35'),
(43, 'Irwin Segmented Diamond Cutting Blade 4&quot;', '../product/productImages/677bfb8d8e5fairwin-segmented-diamond-cutting-blade.jpg', 3, ' • These blades can offer a relatively smooth cut with a fast cutting speed, chipping may still occur\r\n• Durable and have a long blade life compared to other blades.\r\n• Ideal for cutting marble and granite slabs, concrete, asphalt, brick, block, and other building materials\r\n• Commonly used with masonry saws, concrete saws, and circular saws\r\n• Segmented blades are used for low friction applications\r\n• Use to cut materials that don’t require a high quality finish\r\n• Suitable for Cement Sheeting, Concrete, Caly brick & Paving, Concrete Pavers & Piping and Slat   \r\n\r\n', '2025-01-06 15:49:33', '2025-01-06 16:02:30'),
(44, 'Irwin Turbo Diamond Cutting Blade', '../product/productImages/677c00573e1b0irwin-turbo-diamond-cutting-blade.jpg', 3, '• Ability of Colling off and performing at a similar speed to segmented blades.\r\n• Suitable for cement sheeting, concrete, clay brick &amp; pavers, concrete pavers &amp; piping and granite/engineered stone', '2025-01-06 16:09:59', '2025-01-06 16:09:59'),
(45, 'Tailin Cutting Wheel 14″', '../product/productImages/677c00a222277tailin-cutting-wheel-14.jpg', 3, '', '2025-01-06 16:11:14', '2025-01-06 16:11:14'),
(46, 'Tyrolit Metal Cutting Disc', '../product/productImages/677c01148df58tyrolit-metal-cutting-disc.jpg', 3, '', '2025-01-06 16:13:08', '2025-01-06 16:13:08'),
(47, 'PowerHouse Diamond Cutting Wheel 4″', '../product/productImages/677c0187d1e54powerhouse-diamond-cutting-wheel-granite.jpg', 3, '• Used in grinders, circular saws, and tile saws to cut a variety of materials including tile, stone, marble, granite, masonry, and other building materials.', '2025-01-06 16:15:03', '2025-01-06 16:15:03'),
(48, 'Tyrolit Ultra Thin Cutting Disc 4″', '../product/productImages/677c01c4be97etyrolit-ultra-thin-cutting-disc.jpg', 3, '', '2025-01-06 16:16:04', '2025-01-06 16:16:04'),
(49, 'PowerHouse Diamond Cutting Wheel Ultra Thin 4″', '../product/productImages/677c02038cd05powerhouse-Diamond-Cutting-Wheel-Ultra-Thin.jpg', 3, '', '2025-01-06 16:17:07', '2025-01-06 16:17:07'),
(50, 'Stanley Crosscut Saw 20″', '../product/productImages/677c02355810bstanley-crosscut-saw.jpg', 3, '', '2025-01-06 16:17:57', '2025-01-06 16:17:57'),
(51, 'Cutting Wheel 14″', '../product/productImages/677c033822b78IMG_20210702_134938_199-copy.png', 3, 'Usage: Metal &amp; Stainless Steel Cutting', '2025-01-06 16:22:16', '2025-01-06 16:22:16'),
(52, 'Maxsell TCT Circular Saw Blade', '../product/productImages/677c037ea1b9aMaxsell-TCT-Circular-Saw-Blade.jpg', 3, 'Maxsell TCT Circular Saw Blade for Aluminum', '2025-01-06 16:23:26', '2025-01-06 16:23:26'),
(53, 'Irwin Continuous Diamond Cutting Blade', '../product/productImages/677c041c927f2irwin-continuous-diamond-cutting-blade.jpg', 3, '', '2025-01-06 16:26:04', '2025-01-06 16:26:04'),
(54, 'Black Screw Pointed', '../product/productImages/677c04c84f81eblackscrew-pointed-2.jpg', 4, '', '2025-01-06 16:28:56', '2025-01-06 16:28:56'),
(55, 'Black Screw Metal', '../product/productImages/677c051d6c5ffblack-screw-metal-1-300x300.jpg', 4, '', '2025-01-06 16:30:21', '2025-01-06 16:30:21'),
(56, 'Tekscrew', '../product/productImages/677c0563e6c7ctekscrew-300x300.jpg', 4, '', '2025-01-06 16:31:31', '2025-01-06 16:31:31'),
(57, 'Wood Screw Flat Head', '../product/productImages/677c05b7afed8wood-screw-flat-head.jpg', 4, '', '2025-01-06 16:32:55', '2025-01-06 16:32:55'),
(58, 'Nuts', '../product/productImages/677c0600358f3nut-1.jpg', 4, '', '2025-01-06 16:34:08', '2025-01-06 16:34:08'),
(59, 'Wood Screw Pan Head', '../product/productImages/677c064cac4f2wood-screw-pan-head.jpg', 4, '', '2025-01-06 16:35:24', '2025-01-06 16:35:24'),
(60, 'Pvc Clamp 1/2″', '../product/productImages/677c06912cc6fpvc-clamp-1.jpg', 6, '', '2025-01-06 16:36:33', '2025-01-06 17:19:56'),
(61, 'PVC Coated Cup Hook', '../product/productImages/677c0a283e6f6pvc-coated-hook-1.jpg', 4, '', '2025-01-06 16:51:52', '2025-01-06 16:51:52'),
(62, 'Umbrella Nail 3″ ( by kilo )', '../product/productImages/677c0a5a3b847umbrella-nail-1.jpg', 4, '', '2025-01-06 16:52:42', '2025-01-06 16:53:26'),
(63, 'Umbrella Nail 3″ Box', '../product/productImages/677c0a9deee5fumbrella-nail-1.jpg', 4, '', '2025-01-06 16:53:49', '2025-01-06 16:54:31'),
(64, 'G.I Washer', '../product/productImages/677c104ad0771gi-washer-1.jpg', 4, '', '2025-01-06 17:18:02', '2025-01-06 17:18:02'),
(65, 'PVC Clamp 3/4', '../product/productImages/677c10cb2003cpvc-clamp.jpg', 6, '', '2025-01-06 17:20:11', '2025-01-06 17:20:11'),
(66, 'Galvanize Hose Clamp', '../product/productImages/677c10ef95685hose-clamp.jpg', 6, '', '2025-01-06 17:20:47', '2025-01-06 17:20:47'),
(67, 'Metal Clamp', '../product/productImages/677c11418eed2clamp-metal-1-2.jpg', 6, '', '2025-01-06 17:22:09', '2025-01-06 17:22:09'),
(68, 'U-Bolt Clamp', '../product/productImages/677c116c710d4ubolt-clamp-1.jpg', 6, '', '2025-01-06 17:22:52', '2025-01-06 17:22:52'),
(69, 'Stanley 14-556 All-Purpose Straight Pattern Snips 10″', '../product/productImages/677c11ae639aestanley-tinsnip.jpg', 3, '', '2025-01-06 17:23:58', '2025-01-06 17:23:58'),
(70, 'Karet', '../product/productImages/677c11d2878aakaret-scaled.jpg', 3, '', '2025-01-06 17:24:34', '2025-01-06 17:24:34'),
(71, 'Bolt and Nut with Washer 3/4 x 3/4', '../product/productImages/677c12380e39bbolt-and-nut-with-washer-1.jpg', 4, '', '2025-01-06 17:26:16', '2025-01-06 17:26:16'),
(72, 'Tyrolit Metal Grinding Disc 4″', '../product/productImages/677c12ac741adtyrolit-metal-grinding-disc.jpg', 5, '', '2025-01-06 17:28:12', '2025-01-06 17:28:12'),
(73, 'KYK Metal Drill Bit', '../product/productImages/677c149fd6743kyk-metal-drill-bit.jpg', 13, '', '2025-01-06 17:36:31', '2025-01-06 17:36:31'),
(74, 'KYK Masonry Drill Bit', '../product/productImages/677c14dfbd342kyk-metal-drill-bit (1).jpg', 13, '', '2025-01-06 17:37:35', '2025-01-06 17:37:35'),
(75, 'KYK Sharpening Stone 6″', '../product/productImages/677c151d8c556KYK-Sharpening-Stone.jpg', 5, '', '2025-01-06 17:38:37', '2025-01-06 17:38:37'),
(76, 'Powercraft Metal Drill Bit', '../product/productImages/677c153d265b6powercraft-masonry-drillbit.jpg', 13, '', '2025-01-06 17:39:09', '2025-01-06 17:39:09'),
(77, 'Bosch Masonry Drill Bit 10mm', '../product/productImages/677c15897624cBosch-Masonry-Drill-Bit.jpg', 13, '', '2025-01-06 17:40:25', '2025-01-06 17:40:25'),
(78, 'Eagle Cement Advance Bag', '../product/productImages/677c15e86982aeagle-cement-advance.jpg', 9, '', '2025-01-06 17:42:00', '2025-01-06 17:42:00'),
(79, 'Bistay per Sack', '../product/productImages/677c16106f91bbistay.jpg', 9, '', '2025-01-06 17:42:40', '2025-01-06 17:42:40'),
(80, 'Republic Cement', '../product/productImages/677c16368aab2republic-cement.jpg', 9, '', '2025-01-06 17:43:18', '2025-01-06 17:43:18'),
(81, 'Gravel 3/4 per Sack', '../product/productImages/677c166657af1gravel.jpg', 9, '', '2025-01-06 17:44:06', '2025-01-06 17:44:16'),
(82, 'Cement Trowel', '../product/productImages/677c16a516759cement-trowel.jpg', 1, '', '2025-01-06 17:45:09', '2025-01-06 17:45:18'),
(83, 'Neltex Sanitary PVC Pipe S600', '../product/productImages/677c1708e2444pvc-pipe-1.jpg', 9, '', '2025-01-06 17:46:48', '2025-01-06 17:46:48'),
(84, 'Neltex PVC Sanitary Elbow 90°', '../product/productImages/677c17403107aNELTEX-PVC-SANILINE-ELBOW-90.jpg', 9, '', '2025-01-06 17:47:44', '2025-01-06 17:47:44'),
(85, 'Lucky Waterline PVC Pipe', '../product/productImages/677c1786dd7c0blue-pvc-pipe.jpg', 9, '', '2025-01-06 17:48:54', '2025-01-06 17:48:54'),
(86, 'Tubular Bar GI 1x1', '../product/productImages/677c1854a0092tubular-bar-1.jpg', 9, '', '2025-01-06 17:52:20', '2025-01-06 17:52:20'),
(87, 'Tubular Bar GI 1x2', '../product/productImages/677c1888a6486tubular-bar-1.jpg', 9, '', '2025-01-06 17:53:12', '2025-01-06 17:53:12'),
(88, 'C-Purlins BI 2x3', '../product/productImages/677c18c9a1e7bc-purlin.jpg', 9, '', '2025-01-06 17:54:17', '2025-01-06 17:54:17'),
(89, 'C-Purlins BI 2x4', '../product/productImages/677c18ef1bce9c-purlin.jpg', 9, '', '2025-01-06 17:54:55', '2025-01-06 17:54:55'),
(90, 'Electrical Flexible Hose 1/2&quot;', '../product/productImages/677c1950c0915Electrical-Flexible-Hose-1.jpg', 9, '', '2025-01-06 17:56:32', '2025-01-06 17:56:32'),
(91, 'Neltex Utility Box', '../product/productImages/677c19cc80abbutility-box-1.jpg', 9, '', '2025-01-06 17:58:36', '2025-01-06 17:58:36'),
(92, 'Puree Muriatic Acid 1 liter', '../product/productImages/677c1a44d7e12puree-muriatic-acid.jpg', 14, '', '2025-01-06 18:00:36', '2025-01-06 18:00:36'),
(93, 'Nylon Cable Tie', '../product/productImages/677c1a77087danylon-cable-tie.jpg', 14, '', '2025-01-06 18:01:27', '2025-01-06 18:01:27'),
(94, 'Neltex PVC Sanitary Tee', '../product/productImages/677c1abfbdbc9Neltex-tee-sanitary.jpg', 9, '', '2025-01-06 18:02:39', '2025-01-06 18:02:39'),
(95, 'Neltex PVC Sanitary Clean Out', '../product/productImages/677c1aef7c523neltex-clean-out.jpg', 9, '', '2025-01-06 18:03:27', '2025-01-06 18:03:27'),
(96, 'Armak Electrical Tape', '../product/productImages/677c1baabc257armak-1.jpg', 14, '', '2025-01-06 18:06:34', '2025-01-06 18:06:34'),
(97, 'Neltex Junction Box', '../product/productImages/677c1bdf1b3e1neltex-junction-box-1.jpg', 9, '', '2025-01-06 18:07:27', '2025-01-06 18:07:27'),
(98, 'Teflon Tape', '../product/productImages/677c1c0a88a92teflon-tape.jpg', 13, '', '2025-01-06 18:08:10', '2025-01-06 18:08:10'),
(99, 'Boysen Lacquer Thinner B50', '../product/productImages/677c1c4b0618bBoysen-370x370-1.jpg', 7, '', '2025-01-06 18:09:15', '2025-01-06 18:09:15'),
(100, 'Neltex Waterline Elbow with Thread 1/2″', '../product/productImages/677c1c8b21cd7elbow-w-thead.jpg', 9, '', '2025-01-06 18:10:19', '2025-01-06 18:10:19'),
(101, 'PPR Female Adaptor', '../product/productImages/677c1cb5d2b19PPR-Female-Adaptor.jpg', 9, '', '2025-01-06 18:11:01', '2025-01-06 18:11:01'),
(102, 'Shelf Bracket', '../product/productImages/677c1ce5c5e7fshelf-bracket-8-x-10-1.jpg', 9, '', '2025-01-06 18:11:49', '2025-01-06 18:11:49'),
(103, 'Armak Masking Tape', '../product/productImages/677c1d3494c5farmak-masking-tape.jpg', 14, '', '2025-01-06 18:13:08', '2025-01-06 18:13:08'),
(104, 'PPR Lucky Union Socket Type', '../product/productImages/677c1d73e1222Lucky-PPR-Union-Socket.jpg', 9, '', '2025-01-06 18:14:11', '2025-01-06 18:14:11'),
(105, 'Royu Universal Outlet Set', '../product/productImages/677c1dbc6d1f0royu-Universal-Outlet-Set.jpg', 14, '', '2025-01-06 18:15:24', '2025-01-06 18:15:24'),
(106, 'Puree Lacquer Thinner', '../product/productImages/677c1dfddce78puree-laquer-thinner.jpg', 7, '', '2025-01-06 18:16:29', '2025-01-06 18:16:29'),
(107, 'Philips LED Bulb Warm White 6w', '../product/productImages/677c1e59f0237philips-led-ww.jpg', 14, '', '2025-01-06 18:18:01', '2025-01-06 18:18:01'),
(108, 'Davies Megacryl Concrete Primer &amp; Sealer White', '../product/productImages/677c1e9c1d83cdavies-concrete-primer.jpg', 7, '', '2025-01-06 18:19:08', '2025-01-06 18:19:08'),
(109, 'Receptacle #4', '../product/productImages/677c1fa5dfc69receptacle.jpg', 14, '', '2025-01-06 18:23:33', '2025-01-06 18:23:33'),
(110, 'Davies Sun &amp; Rain Tinkerbelle', '../product/productImages/677c1fe219f68SR-TINKERBELLE.jpg', 7, '', '2025-01-06 18:24:34', '2025-01-06 18:24:34'),
(111, 'Firefly Basic Series LED A-Bulb', '../product/productImages/677c201b88800firefly-led-bulb.jpg', 14, '', '2025-01-06 18:25:31', '2025-01-06 18:25:31'),
(112, 'Royu Switch with LED Set', '../product/productImages/677c204af23a0Royu-Switch-with-LED-Set.jpg', 14, '', '2025-01-06 18:26:18', '2025-01-06 18:26:18'),
(113, 'G.I Bolt &amp; Nut 1/2 x 1', '../product/productImages/677c20ac271f8bolt-and-nut-1.jpg', 4, '', '2025-01-06 18:27:56', '2025-01-06 18:27:56'),
(114, 'Bosny Spray Paint Black', '../product/productImages/677c20fb46f36bosny-spray-paint-black.jpg', 7, '', '2025-01-06 18:29:15', '2025-01-06 18:29:15'),
(115, 'Royu Universal Convenience Outlet Black', '../product/productImages/677c2124aad3dUniversal-Convenience-Outlet.jpg', 14, '', '2025-01-06 18:29:56', '2025-01-06 18:30:36'),
(116, 'Royu Universal Convenience Outlet White', '../product/productImages/677c2159c8a70Universal-Convenience-Outlet.jpg', 14, '', '2025-01-06 18:30:49', '2025-01-06 18:30:49');

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
  PRIMARY KEY (`size_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_size`
--

INSERT INTO `product_size` (`size_id`, `product_id`, `size`, `stock`, `price`) VALUES
(24, 11, '4&quot;', 200, 19.00),
(26, 11, '5&quot;', 200, 20.00),
(27, 11, '6&quot;', 200, 25.00),
(28, 10, '1/4&quot;', 101, 494.00),
(30, 10, '1/2&quot;', 99, 885.00),
(31, 10, '3/4&quot;', 100, 1747.00),
(32, 13, '10mm', 98, 190.00),
(33, 13, '10.5mm', 100, 600.00),
(34, 13, '12mm', 100, 274.00),
(37, 15, '5mm x 100', 50, 60.00),
(38, 15, '6.5mm x 200', 50, 140.00),
(39, 17, '8oz', 49, 160.00),
(41, 18, '2&quot;', 20, 82.00),
(43, 18, '4&quot;', 20, 150.00),
(44, 19, '18&quot;', 10, 490.00),
(45, 19, '36&quot;', 10, 780.00),
(46, 20, '5m', 10, 120.00),
(47, 21, '1&quot;', 10, 1780.00),
(48, 21, '1-1/2&quot;', 9, 1710.00),
(49, 21, '1-1/4&quot;', 10, 1780.00),
(50, 22, '1&quot;', 200, 98.00),
(51, 22, '1-1/2&quot;', 200, 98.00),
(53, 22, '1-1/4&quot;', 200, 98.00),
(54, 17, '16oz', 10, 240.00),
(55, 12, 'Sack', 50, 190.00),
(56, 23, 'no size', 100, 45.00),
(61, 27, '1/2&quot;', 100, 15.00),
(62, 27, '1&quot;', 100, 20.00),
(63, 27, '3&quot;', 100, 55.00),
(64, 27, '4&quot;', 100, 85.00),
(65, 27, '3/4&quot;', 100, 15.00),
(66, 30, 'no size', 50, 74.00),
(67, 29, 'no size', 50, 25.00),
(68, 31, 'G60', 50, 18.00),
(69, 31, 'G80', 50, 18.00),
(70, 31, 'G100', 50, 18.00),
(71, 31, 'G120', 50, 18.00),
(72, 32, '1&quot;', 30, 10.00),
(73, 32, '2&quot;', 30, 15.00),
(74, 32, '3&quot;', 30, 20.00),
(75, 33, 'no size', 20, 225.00),
(76, 34, 'no size', 20, 48.00),
(77, 35, '18&quot;', 10, 215.00),
(78, 35, '20&quot;', 10, 248.00),
(79, 36, '8&quot;', 10, 230.00),
(80, 36, '10&quot;', 10, 299.00),
(81, 37, 'no size', 10, 150.00),
(82, 38, '1/2&quot;', 10, 130.00),
(83, 38, '1&quot;', 10, 178.00),
(84, 38, '1-1/2&quot;', 10, 189.00),
(85, 39, 'no size', 10, 55.00),
(86, 40, '1/2&quot;', 0, 305.00),
(87, 40, '1-1/2&quot;', 0, 340.00),
(88, 40, '1', 0, 200.00),
(89, 41, '18-TPI', 50, 45.00),
(90, 41, '24-TPI', 50, 50.00),
(91, 42, '6&quot;', 10, 27.00),
(92, 42, '8&quot;', 10, 32.00),
(93, 42, '10&quot;', 10, 33.00),
(94, 43, 'no size', 20, 341.00),
(95, 44, 'no size', 20, 425.00),
(96, 45, 'no size', 20, 198.00),
(97, 46, '4&quot;', 20, 83.00),
(98, 46, '14&quot;', 20, 630.00),
(99, 47, 'no size', 20, 520.00),
(100, 48, 'no size', 20, 105.00),
(101, 49, 'no size', 20, 364.00),
(102, 50, 'no size', 10, 382.00),
(103, 51, 'no size', 20, 165.00),
(104, 52, '7&quot;', 10, 830.00),
(105, 52, '10&quot;', 10, 2287.00),
(106, 53, 'no size', 10, 375.00),
(107, 54, '1&quot;', 200, 1.00),
(108, 54, '1-1/2&quot;', 200, 1.00),
(109, 54, '1-1/4&quot;', 200, 1.00),
(110, 54, '2&quot;', 200, 1.00),
(111, 55, '1&quot;', 200, 1.00),
(112, 55, '2&quot;', 200, 1.00),
(113, 56, '1&quot;', 200, 2.00),
(114, 56, '2', 200, 2.00),
(115, 57, '6 x 1', 200, 1.00),
(116, 57, '6 x 2', 200, 1.00),
(117, 58, '6mm', 400, 1.00),
(118, 58, '8&quot;', 400, 1.00),
(119, 58, '10', 400, 1.00),
(120, 59, '6 x 1', 400, 0.50),
(121, 59, '8 x 2', 400, 1.00),
(122, 60, 'no size', 500, 4.00),
(123, 61, '1&quot;', 200, 28.00),
(124, 61, '2&quot;', 200, 57.00),
(125, 62, 'no size', 400, 100.00),
(126, 63, 'no size', 20, 1770.00),
(127, 64, '1/2&quot;', 400, 5.00),
(128, 64, '3/8&quot;', 400, 2.00),
(129, 65, 'no size', 400, 5.00),
(130, 66, '1&quot;', 200, 10.00),
(131, 66, '2&quot;', 200, 20.00),
(132, 66, '1/2&quot;', 200, 10.00),
(133, 67, '1&quot;', 200, 20.00),
(134, 67, '3&quot;', 200, 92.00),
(135, 68, '1/2&quot;', 200, 7.00),
(136, 68, '3/4&quot;', 200, 13.00),
(137, 69, 'no size', 10, 384.00),
(138, 70, 'no size', 10, 455.00),
(139, 71, 'no size', 200, 6.00),
(140, 72, 'no size', 10, 110.00),
(141, 73, '2.5mm', 100, 35.00),
(142, 73, '3mm', 100, 39.00),
(143, 74, '1/2&quot;', 100, 106.00),
(144, 74, '1/4&quot;', 100, 48.00),
(145, 74, '1/8&quot;', 100, 33.00),
(146, 75, 'no size', 10, 54.00),
(147, 76, '1/4&quot;', 100, 28.00),
(148, 76, '1/2&quot;', 100, 357.00),
(149, 77, 'no size', 100, 63.00),
(150, 78, 'no size', 200, 232.00),
(151, 79, 'no size', 100, 35.00),
(152, 80, 'no size', 100, 245.00),
(153, 81, 'no size', 400, 200.00),
(154, 82, '6&quot;', 8, 55.00),
(155, 82, '7&quot;', 10, 82.00),
(156, 83, '2&quot;', 15, 375.00),
(157, 83, '3&quot;', 15, 657.00),
(158, 84, '2&quot;', 10, 55.00),
(159, 84, '3&quot;', 10, 90.00),
(160, 85, '1/2&quot;', 20, 83.00),
(161, 85, '3/4&quot;', 20, 115.00),
(162, 86, '1.2mm', 15, 260.00),
(163, 86, '1.5mm', 15, 294.00),
(164, 87, '1.5mm', 10, 474.00),
(165, 87, '1.2mm', 10, 400.00),
(166, 88, '1.2mm', 10, 387.00),
(167, 88, '1.5mm', 10, 500.00),
(168, 89, '1.2mm', 10, 440.00),
(169, 89, '1.5mm', 10, 560.00),
(170, 90, 'Roll ( 50 meters)', 20, 375.00),
(171, 90, 'per Meter', 20, 12.00),
(172, 91, 'no size', 50, 35.00),
(173, 92, 'no size', 10, 40.00),
(174, 93, '4mm x 6&quot;', 100, 1.00),
(175, 93, '4mm x 8&quot;', 100, 2.00),
(176, 94, '2 x 2', 10, 65.00),
(177, 94, '3 x 2', 10, 130.00),
(178, 95, '2&quot;', 15, 30.00),
(179, 95, '3&quot;', 15, 51.00),
(180, 96, 'small', 20, 17.00),
(181, 96, 'big', 20, 38.00),
(182, 97, 'no size', 20, 35.00),
(183, 98, '1/2&quot;', 20, 10.00),
(184, 98, '3/4&quot;', 20, 15.00),
(185, 99, '16L', 10, 2225.00),
(186, 99, '4L', 10, 560.00),
(187, 100, 'no size', 50, 20.00),
(188, 101, '1/2&quot;', 20, 121.00),
(189, 101, '1-1/4&quot;', 10, 682.00),
(190, 102, '4x5', 20, 10.00),
(191, 102, '5x6', 20, 15.00),
(192, 103, '1&quot;', 20, 41.00),
(193, 103, '2&quot;', 15, 82.00),
(194, 104, '1&quot;', 20, 530.00),
(195, 104, '3/4&quot;', 20, 330.00),
(196, 105, '1 Gang', 10, 74.00),
(197, 105, '2 Gang', 10, 123.00),
(198, 105, '3 Gang', 10, 170.00),
(199, 106, '350ml', 10, 39.00),
(200, 106, '4L', 10, 405.00),
(201, 107, 'no size', 20, 152.00),
(202, 108, '4L', 10, 653.00),
(203, 108, '16L', 10, 2600.00),
(204, 109, 'no size', 20, 45.00),
(205, 110, '1L', 10, 205.00),
(206, 110, '4L', 10, 715.00),
(207, 111, '3w', 10, 70.00),
(208, 111, '5w', 10, 80.00),
(209, 112, '1 Gang', 10, 78.00),
(210, 112, '2 Gang', 10, 127.00),
(211, 112, '3 Gang', 10, 175.00),
(212, 113, 'no size', 50, 10.00),
(213, 114, 'no size', 10, 130.00),
(214, 115, '3 Gang', 10, 245.00),
(215, 115, '4 Gang', 10, 265.00),
(216, 116, '3 Gang', 10, 245.00),
(217, 116, '4 Gang', 60, 265.00);

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
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(17, 'ruth', 'asasa@gmail.com', '$2y$10$eG2LwaoihZWCtwzKF6YLiu6AOKwCZsGyZ5Kc6byQNv20NrTUm/0aG', 'customer'),
(18, 'lmarAdmin', 'lmarAdmin@gmail.com', '$2y$10$rXQL80scgKPmfl3nx2MhE.sM23n4p4BtptKbi0rb1LH21dqO.jJJe', 'admin'),
(19, 'Admin2', 'lmarAdmin2@gmail.com', '$2y$10$FJWj6/5GKdt6ld8OXq.dOud1fsxPnM9irTc3.p4lFP9lr5r/XqpLi', 'admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_size`
--
ALTER TABLE `product_size`
  ADD CONSTRAINT `product_size_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
