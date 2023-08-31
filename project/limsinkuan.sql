-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2023 at 04:49 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `limsinkuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

DROP TABLE IF EXISTS `contact_us`;
CREATE TABLE IF NOT EXISTS `contact_us` (
  `firstname` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lastname` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `email` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `phone_number` text CHARACTER SET latin1 COLLATE latin1_spanish_ci NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `user_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `user_password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `first_name` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `last_name` varchar(20) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `gender` enum('Male','Female','Others') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `registration_date_time` datetime NOT NULL,
  `account_status` enum('Active','Inactive') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Active',
  `image` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `user_name`, `user_password`, `first_name`, `last_name`, `gender`, `date_of_birth`, `email`, `registration_date_time`, `account_status`, `image`) VALUES
(5, 'ali1234', '$2y$10$xwvoP53N4INfDd5KbAyVnOgJf2/GT28KrTqnCjWRLx2H4kF4Zm1M6', 'Tan', 'Ali', 'Male', '2023-01-01', 'tanali1234@gmail.com', '2023-08-07 16:09:17', 'Active', ''),
(4, 'tankienming', '$2y$10$0qwoCCcaN0Kz9uz0RB3uoukir5Xd0kk2KOD11XqgfHypRNYA4k.Ya', 'Kien Ming', 'Tan', 'Male', '2002-09-16', 'tankienming@gmail.com', '2023-08-07 15:27:47', 'Active', 'uploads/0719e6f29071bc3a064ce4aa0011e15357e2e3ff-tkm.jpeg'),
(13, 'stephenchow', '$2y$10$qXHN3E.GFKXWU9pU2Tp8jup9S2dGdYt4IO.afqkFz5pwH11Wqlo7.', 'Chow', 'Stephen', 'Male', '2000-01-01', 'stephenchow@gmail.com', '2023-08-21 13:18:32', 'Active', 'uploads/932a3106e3b8067b90d04c44365c86151645e137-stephenchow.jpg'),
(14, 'leebai', '$2y$10$r/D5I93gIgMs6K3uY4cqKeRm47K.DmmQ4UgV5BujnCnRQsRGVpsmK', 'Lee ', 'Bai', 'Male', '1988-01-01', 'leebai@gmail.com', '2023-08-21 16:18:14', 'Active', 'uploads/146d938ac63d2dcfc00115598c658f017c7c22fd-leebai.jpeg'),
(15, 'brucelee', '$2y$10$APTbMo0chujGc7gTL6XH2uGNZWMfV.ty7PsGIcibiTcmoeDws6KTO', 'Bruce', 'Lee', 'Male', '1987-01-01', 'brucelee@gmail.com', '2023-08-21 16:20:13', 'Active', 'uploads/bd5d3d696ada730e383135d14d4e75b7b29ac83b-brucelee.jpeg'),
(16, 'ali12345', '$2y$10$ZJ.kGru2DAsEeI46enMbkOuHTzOSmRQrNMyefDFoUo5dpWDaUdPNK', 'Ali', 'Tan', 'Male', '2023-01-01', 'ali@gmail.com', '2023-08-28 07:46:15', 'Active', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`order_detail_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`order_detail_id`, `order_id`, `product_id`, `quantity`) VALUES
(62, 9, 2, 100),
(61, 9, 1, 100),
(60, 8, 4, 1),
(59, 8, 7, 150),
(58, 8, 6, 200),
(68, 11, 5, 1),
(67, 10, 7, 1),
(66, 10, 6, 2),
(65, 10, 5, 1),
(64, 9, 4, 100),
(63, 9, 3, 100),
(71, 12, 2, 1),
(69, 11, 6, 2),
(70, 11, 7, 1),
(57, 8, 5, 10),
(72, 12, 1, 1),
(73, 12, 3, 1),
(74, 12, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

DROP TABLE IF EXISTS `order_summary`;
CREATE TABLE IF NOT EXISTS `order_summary` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `total_amount` double NOT NULL,
  `order_date` datetime NOT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`order_id`, `customer_id`, `total_amount`, `order_date`) VALUES
(8, 13, 1589, '2023-08-28 08:31:54'),
(9, 14, 1700, '2023-08-28 09:19:08'),
(11, 15, 70.6, '2023-08-28 09:23:16'),
(10, 15, 70.6, '2023-08-28 09:22:03'),
(12, 16, 17, '2023-08-28 09:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `category_id` int NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `price` double NOT NULL,
  `promotion_price` double NOT NULL,
  `manufacture_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `description`, `price`, `promotion_price`, `manufacture_date`, `expired_date`, `image`, `created`, `modified`) VALUES
(39, 'Emoji Stickers [drool] x 5', 17, '5 pcs of Drool emoji stickers', 5, 0, '2023-01-01', '0000-00-00', 'uploads/5357082130feee390044c048730db9d5119921c8-[drool].png', '2023-08-28 09:47:42', '2023-08-28 01:47:42'),
(1, 'Emoji Stickers [angry] x 5', 17, '5 pieces of angry stickers', 5, 4, '2023-01-01', '2023-12-31', 'uploads/d55e16fc128f2b5edebfee186af8cbad688f3b91-[angry].png', '2023-08-21 06:09:30', '2023-08-27 09:25:46'),
(2, 'Emoji Stickers [cry] x 5', 17, '5 pieces of cry stickers', 5, 4, '2023-01-01', '2023-12-31', 'uploads/6a65f73aaaa5508fa2bf4bceeaf0795b68bcc86d-[cry].png', '2023-08-21 06:10:06', '2023-08-27 09:25:39'),
(3, 'Emoji Stickers [chuckle] x 5', 17, '5 pieces of chuckle stickers', 5, 0, '2023-01-01', '2023-12-31', 'uploads/180aeb60a01fe9c647274417b082fddd85f6bea3-[chuckle].png', '2023-08-21 06:10:57', '2023-08-27 09:25:30'),
(4, 'Emoji Stickers [clap] x 5', 17, '5 pieces of clap stickers', 5, 4, '2023-01-01', '2023-12-31', 'uploads/936ec7e3e96d8b023342e8312e11809e9fcba523-[clap].png', '2023-08-21 06:11:23', '2023-08-27 09:25:21'),
(40, 'Emoji Stickers [frown] x 5', 1, '5 pcs of Frown emoji stickers', 5, 4, '2023-01-01', '0000-00-00', 'uploads/6599ad8bf7d238db07ee28a1eaf3207893a1466b-[frown].png', '2023-08-28 09:48:38', '2023-08-28 01:48:38'),
(38, 'Emoji Stickers [dizzy] x 5', 17, '5 pcs of Dizzy emoji stickers', 5, 0, '2023-01-01', '0000-00-00', 'uploads/2e37dd91db2ef3fc2c50c6f93df6b0a3a514c526-[dizzy].png', '2023-08-28 09:38:53', '2023-08-28 01:38:53'),
(5, 'A4 paper (Carton)', 1, '2500 sheets of A4 paper.', 67, 63, '2023-01-01', '2023-12-31', 'uploads/10681e249b670cbfb2a0fb6294321b498d887da9-a4paper.jpg', '2023-08-21 08:23:29', '2023-08-27 09:03:52'),
(6, 'Ossayi 2B Pencil x5', 1, '5 PCS of Ossayi Wooden Pencil', 2, 1.85, '2023-01-01', '0000-00-00', 'uploads/d005c765d643204a2a1631e50d0b33e1016d4758-ossayi_pencil.jpg', '2023-08-27 08:08:51', '2023-08-27 09:02:12'),
(7, 'Faber Castell Eraser x 6', 1, '6 pcs of Faber Castell Dust Free Eraser', 4, 3.9, '2023-01-01', '2023-12-31', 'uploads/4a95acb988b0e2ef8994b6a8f2197a4c743b5ba1-eraser.jpg', '2023-08-27 08:16:04', '2023-08-27 09:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE IF NOT EXISTS `product_category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(30) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `description` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `category_name`, `description`) VALUES
(1, 'Drawing Instruments', 'brushes, pens, colour pencils, crayons, water colour'),
(2, 'Erasers', 'erasers'),
(3, 'Ink And Toner', 'Dot matrix printer\'s ink ribbon, Inkjet cartridge, Laser printer toner, Photocopier toner'),
(4, 'Filing And Storage', 'Expandable file, File folder, Hanging file folder, Index cards and files, Two-pocket portfolios'),
(5, 'Mailing And Shipping Supplies', 'Envelope'),
(6, 'Paper And Pad', 'Notebooks, wirebound notebook, writing pads, college ruled paper, wide-ruled paper'),
(17, 'Stickers', 'emoji stickers'),
(7, 'Business Stationery', 'Business card, letterhead, invoices, receipts'),
(8, 'Desktop Instruments', 'hole punch, stapler and staples, tapes and tape dispensers,');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
