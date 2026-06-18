-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 29, 2026 at 10:47 AM
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
-- Database: `harwest_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`) VALUES
(1, 'admin@harwesthub.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `bid_amount` decimal(10,2) DEFAULT NULL,
  `bidder_name` varchar(100) DEFAULT NULL,
  `bid_time` datetime DEFAULT current_timestamp(),
  `is_highest` tinyint(1) DEFAULT 0,
  `is_winner` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `product_id`, `bid_amount`, `bidder_name`, `bid_time`, `is_highest`, `is_winner`, `created_at`, `user_id`) VALUES
(1, 1, 10.00, 'abcd', '2026-01-26 11:03:20', 0, 0, '2026-01-30 09:47:00', 0),
(2, 1, 11.00, 'dcs', '2026-01-26 11:11:13', 0, 0, '2026-01-30 09:47:00', 0),
(3, 1, 2.00, 'a', '2026-01-26 11:12:00', 0, 0, '2026-01-30 09:47:00', 0),
(4, 1, 5.00, 'sd', '2026-01-26 11:15:40', 0, 0, '2026-01-30 09:47:00', 0),
(5, 1, 12.00, 'd', '2026-01-26 11:21:03', 0, 0, '2026-01-30 09:47:00', 0),
(6, 1, 13.00, 'r', '2026-01-26 11:21:37', 0, 0, '2026-01-30 09:47:00', 0),
(7, 1, 15.00, 'y', '2026-01-26 11:44:03', 0, 0, '2026-01-30 09:47:00', 0),
(8, 1, 16.00, 'q', '2026-01-26 12:25:45', 0, 0, '2026-01-30 09:47:00', 0),
(9, 1, 17.00, 'w', '2026-01-27 14:45:41', 0, 0, '2026-01-30 09:47:00', 0),
(13, 3, 12.00, 'a', '2026-01-27 15:17:11', 0, 0, '2026-01-30 09:47:00', 0),
(14, 3, 13.00, 'br', '2026-01-27 15:22:54', 0, 0, '2026-01-30 09:47:00', 0),
(15, 3, 25.00, 'abcd', '2026-01-27 15:26:21', 0, 0, '2026-01-30 09:47:00', 0),
(16, 3, 30.00, 'adge', '2026-01-28 14:39:56', 1, 1, '2026-01-30 09:47:00', 0),
(17, 8, 231.00, NULL, '2026-01-31 11:43:59', 0, 0, '2026-01-31 06:13:59', 10),
(18, 5, 55.00, NULL, '2026-01-31 11:44:27', 1, 0, '2026-01-31 06:14:27', 10),
(19, 8, 233.00, NULL, '2026-01-31 11:48:18', 0, 0, '2026-01-31 06:18:18', 10),
(20, 7, 182.00, NULL, '2026-01-31 11:48:33', 0, 0, '2026-01-31 06:18:33', 10),
(21, 6, 110.00, NULL, '2026-01-31 11:48:44', 1, 0, '2026-01-31 06:18:44', 10),
(22, 4, 105.00, NULL, '2026-01-31 11:48:59', 1, 0, '2026-01-31 06:18:59', 10),
(23, 7, 190.00, NULL, '2026-01-31 11:53:45', 1, 0, '2026-01-31 06:23:45', 10),
(24, 8, 239.00, NULL, '2026-02-01 14:18:00', 1, 0, '2026-02-01 08:48:00', 11),
(25, 9, 105.00, NULL, '2026-02-01 14:23:04', 0, 0, '2026-02-01 08:53:04', 11),
(26, 9, 110.00, NULL, '2026-02-03 20:19:28', 0, 0, '2026-02-03 14:49:28', 11),
(27, 9, 111.00, NULL, '2026-02-04 18:58:00', 1, 0, '2026-02-04 13:28:00', 11),
(28, 12, 11.00, NULL, '2026-02-07 13:09:57', 1, 0, '2026-02-07 07:39:57', 11),
(29, 16, 100.00, NULL, '2026-02-07 15:12:11', 0, 0, '2026-02-07 09:42:11', 11),
(30, 16, 105.00, NULL, '2026-02-07 15:12:24', 1, 0, '2026-02-07 09:42:24', 11),
(31, 17, 105.00, NULL, '2026-02-07 15:30:17', 1, 1, '2026-02-07 10:00:17', 11),
(32, 19, 1600.00, NULL, '2026-02-08 21:55:15', 1, 1, '2026-02-08 16:25:15', 11),
(33, 21, 1000.00, NULL, '2026-02-09 12:44:31', 0, 0, '2026-02-09 07:14:31', 11),
(34, 21, 2000.00, NULL, '2026-02-09 12:44:49', 0, 0, '2026-02-09 07:14:49', 11),
(35, 21, 10008.00, NULL, '2026-02-09 12:46:39', 1, 1, '2026-02-09 07:16:39', 18),
(36, 23, 18.00, NULL, '2026-02-09 19:41:06', 0, 0, '2026-02-09 14:11:06', 11),
(37, 23, 19.00, NULL, '2026-02-09 19:41:32', 0, 0, '2026-02-09 14:11:32', 11),
(38, 23, 1600.00, NULL, '2026-02-09 19:48:35', 0, 0, '2026-02-09 14:18:35', 11),
(39, 23, 1710.00, NULL, '2026-02-09 19:49:03', 0, 0, '2026-02-09 14:19:03', 11),
(40, 23, 1710.00, NULL, '2026-02-09 19:54:26', 0, 0, '2026-02-09 14:24:26', 11),
(41, 23, 1730.00, NULL, '2026-02-09 20:19:16', 1, 0, '2026-02-09 14:49:16', 11),
(42, 26, 804000.00, NULL, '2026-02-17 14:03:52', 0, 1, '2026-02-17 08:33:52', 11),
(43, 26, 808000.00, NULL, '2026-02-17 14:04:30', 1, 1, '2026-02-17 08:34:30', 11),
(44, 25, 7750.00, NULL, '2026-02-17 14:05:22', 0, 1, '2026-02-17 08:35:22', 11),
(45, 25, 7850.00, NULL, '2026-02-17 14:05:49', 1, 1, '2026-02-17 08:35:49', 11),
(46, 27, 800.00, NULL, '2026-02-23 11:23:22', 0, 1, '2026-02-23 05:53:22', 11),
(47, 27, 825.00, NULL, '2026-02-23 11:24:01', 1, 1, '2026-02-23 05:54:01', 11),
(48, 28, 30020.00, NULL, '2026-03-08 14:46:42', 0, 0, '2026-03-08 09:16:42', 11),
(49, 28, 30220.00, NULL, '2026-03-08 14:46:59', 0, 0, '2026-03-08 09:16:59', 11),
(50, 28, 30570.00, NULL, '2026-03-08 14:47:14', 0, 0, '2026-03-08 09:17:14', 11),
(51, 28, 30830.00, NULL, '2026-03-08 14:47:28', 0, 0, '2026-03-08 09:17:28', 11),
(52, 28, 31110.00, NULL, '2026-03-08 14:49:02', 0, 0, '2026-03-08 09:19:02', 20),
(53, 28, 31320.00, NULL, '2026-03-08 14:49:10', 0, 0, '2026-03-08 09:19:10', 20),
(54, 28, 31550.00, NULL, '2026-03-08 14:49:17', 1, 0, '2026-03-08 09:19:17', 20),
(55, 29, 21890.00, NULL, '2026-03-10 11:21:34', 0, 0, '2026-03-10 05:51:34', 23),
(56, 29, 22885.00, NULL, '2026-03-10 11:21:44', 0, 0, '2026-03-10 05:51:44', 23),
(57, 29, 23283.00, NULL, '2026-03-10 11:22:24', 0, 0, '2026-03-10 05:52:24', 22),
(58, 29, 23880.00, NULL, '2026-03-10 11:22:46', 1, 1, '2026-03-10 05:52:46', 11),
(59, 32, 5500.00, NULL, '2026-03-25 17:01:06', 0, 1, '2026-03-25 11:31:06', 11),
(60, 32, 5530.00, NULL, '2026-03-25 17:02:15', 1, 1, '2026-03-25 11:32:15', 11),
(61, 33, 303000.00, NULL, '2026-03-27 12:20:37', 0, 0, '2026-03-27 06:50:37', 11),
(62, 33, 304500.00, NULL, '2026-03-27 12:20:54', 0, 0, '2026-03-27 06:50:54', 11),
(63, 33, 306000.00, NULL, '2026-03-27 12:21:06', 0, 0, '2026-03-27 06:51:06', 11),
(64, 33, 315000.00, NULL, '2026-03-27 12:29:02', 1, 1, '2026-03-27 06:59:02', 25);

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'axit', 'ab@gmail', 'you are doing great task for farmer and also consumer', '2026-01-28 09:41:27'),
(2, 'axit', 'a@gmail.com', 'heey i need help', '2026-01-28 09:41:45'),
(3, 'axit', 'a@gmail.com', 'heey i need help', '2026-01-28 09:47:43'),
(4, 'Dev Yadav', 'devmyadav27@gmail.com', 'hello', '2026-02-04 13:27:17'),
(5, 'Dev Yadav', 'devmyadav27@gmail.com', 'hello', '2026-02-04 14:09:17'),
(6, 'John Doe', 'john@test.com', 'I need help with my account.', '2026-02-06 17:11:39'),
(7, 'Sara Smith', 'sara@test.com', 'How do I become a farmer?', '2026-02-06 17:11:39');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('farmer','consumer') NOT NULL,
  `location` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`id`, `name`, `role`, `location`, `rating`, `review`, `created_at`) VALUES
(1, 'Yadav Dev M.', 'consumer', 'Bhavnagar', 5, 'Give you best', '2026-02-05 15:11:04'),
(2, 'dev', 'farmer', 'Bhavnagar', 5, '😍', '2026-02-05 15:19:32'),
(3, 'dev', 'farmer', 'Bhavnagar', 5, '😍', '2026-02-05 15:20:09'),
(4, 'hemanshu', 'consumer', 'Bhavnagar', 5, 'looking nice for best quality at low price !', '2026-02-09 07:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `product_id`, `message`, `is_read`, `created_at`) VALUES
(12, 5, 'New highest bid ₹55 by ew', 0, '2026-01-31 11:44:27'),
(15, 6, 'New highest bid ₹110 by ew', 0, '2026-01-31 11:48:44'),
(16, 4, 'New highest bid ₹105.00 by ew', 0, '2026-01-31 11:48:59'),
(17, 7, 'New highest bid ₹190 by ew', 0, '2026-01-31 11:53:45'),
(18, 8, 'New highest bid ₹239 by Yadav Dev M.', 0, '2026-02-01 14:18:00'),
(21, 9, 'New highest bid ₹111 by Yadav Dev M.', 0, '2026-02-04 18:58:00'),
(22, 12, 'New highest bid ₹11.00 by Yadav Dev M.', 0, '2026-02-07 13:09:57'),
(24, 16, 'New highest bid ₹105 by Yadav Dev M.', 0, '2026-02-07 15:12:24'),
(25, 17, 'New highest bid ₹105 by Yadav Dev M.', 0, '2026-02-07 15:30:17'),
(26, 19, 'New highest bid ₹1600 by Yadav Dev M.', 0, '2026-02-08 21:55:15'),
(29, 21, 'New highest bid ₹10008 by hemanshu', 0, '2026-02-09 12:46:39'),
(35, 23, 'New highest bid ₹1730 (Rate: ₹17.3/kg) by Yadav Dev M.', 1, '2026-02-09 20:19:16'),
(37, 26, 'New highest bid ₹808000 (Rate: ₹40.4/kg) by Yadav Dev M.', 0, '2026-02-17 14:04:30'),
(39, 25, 'New highest bid ₹7850 (Rate: ₹15.7/kg) by Yadav Dev M.', 0, '2026-02-17 14:05:49'),
(41, 27, 'New highest bid ₹825 (Rate: ₹16.5/kg) by Yadav Dev M.', 0, '2026-02-23 11:24:01'),
(48, 28, 'New highest bid ₹31550 (Rate: ₹31.55/kg) by Mr. Yadav', 0, '2026-03-08 14:49:17'),
(52, 29, 'New highest bid ₹23880 (Rate: ₹120/kg) by Yadav Dev M.', 0, '2026-03-10 11:22:46'),
(54, 32, 'New highest bid ₹5530 (Rate: ₹55.3/kg) by Yadav Dev M.', 0, '2026-03-25 17:02:15'),
(58, 33, 'New highest bid ₹315000 (Rate: ₹105/kg) by ABC', 0, '2026-03-27 12:29:02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `category` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_value` decimal(12,2) NOT NULL DEFAULT 0.00,
  `bid_end` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `is_sold` tinyint(1) DEFAULT 0,
  `farmer_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `created_at`, `price`, `image`, `description`, `base_price`, `quantity`, `total_value`, `bid_end`, `status`, `is_sold`, `farmer_id`, `user_id`) VALUES
(17, 'Wheath', '', '2026-02-09 13:14:04', NULL, 'wheat.jpg', 'Best Wheaths', 100.00, 0.00, 0.00, '2026-02-07 15:35:00', 'sold', 1, 12, 0),
(25, 'Baby Corn', 'vegetables', '2026-02-17 08:30:30', NULL, '1771317030_699427268b4c4.jpeg', 'price are pices', 15.00, 500.00, 7500.00, '2026-04-30 12:00:00', 'sold', 1, 12, 12),
(26, 'Basmati Rice', 'vegetables', '2026-02-17 08:32:31', NULL, '1771317151_6994279f77de1.jpeg', 'Best Quality of rice ', 40.00, 20000.00, 800000.00, '2026-05-30 12:00:00', 'sold', 1, 12, 12),
(27, 'rice', 'vegetables', '2026-02-23 05:52:22', NULL, '1771825942_699beb1665e7e.jpeg', 'fye8rtle', 15.00, 50.00, 750.00, '2026-02-28 11:22:00', 'sold', 1, 12, 12),
(29, 'Baby Corn', 'vegetables', '2026-03-10 05:51:16', NULL, '1773121876_69afb154e878a.jpeg', 'jgjyfgyuqewt', 100.00, 199.00, 19900.00, '2026-03-25 11:20:00', 'sold', 1, 12, 12),
(30, 'Jay', 'vegetables', '2026-03-11 15:20:42', NULL, '1773242442_69b1884a5df70.jpg', 'Best jay', 12.00, 50.00, 600.00, '2026-03-16 20:50:00', 'expired', 0, 12, 12),
(31, 'Honey ', 'vegetables', '2026-03-11 15:21:45', NULL, '1773242505_69b188899c350.jpg', 'Hahh', 50.00, 60.00, 3000.00, '2026-03-17 20:51:00', 'expired', 0, 12, 12),
(32, 'Apple', 'fruits', '2026-03-25 11:29:48', NULL, '1774438188_69c3c72c4e3d3.jpg', 'Best quality', 50.00, 100.00, 5000.00, '2026-03-29 16:59:00', 'sold', 1, 12, 12),
(33, 'Basmati Rice', 'vegetables', '2026-03-27 06:35:31', NULL, '1774593331_69c6253370c59.jpeg', 'Best Basmati Rice...', 100.00, 3000.00, 300000.00, '2026-12-30 01:00:00', 'sold', 1, 24, 24),
(34, 'Baby Corn', 'vegetables', '2026-03-27 06:37:53', NULL, '1774593473_69c625c1e35cf.jpeg', '100% Organic And Best Quality', 90.00, 500.00, 45000.00, '2026-05-01 01:00:00', 'active', 0, 24, 24),
(35, 'Wheath', 'vegetables', '2026-03-27 06:41:58', NULL, '1774593718_69c626b67cb7a.jpg', 'Best Bhaliya Wheath...', 90.00, 9000.00, 810000.00, '2027-06-30 01:00:00', 'active', 0, 24, 24);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `purchase_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `transaction_id` varchar(100) DEFAULT NULL,
  `purchase_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','completed','delivered','cancelled') DEFAULT 'completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `product_id`, `user_id`, `purchase_amount`, `payment_method`, `transaction_id`, `purchase_date`, `status`) VALUES
(1, 17, 11, 110.25, 'card', 'TXN5627281770465418', '2026-02-07 17:26:58', 'completed'),
(2, 19, 11, 1680.00, 'card', 'TXN6073381770567990', '2026-02-08 21:56:30', 'completed'),
(3, 21, 18, 10508.40, 'upi', 'TXN3903851770621467', '2026-02-09 12:47:47', 'completed'),
(4, 26, 11, 848400.00, 'card', 'TXN7712561771317719', '2026-02-17 14:11:59', 'completed'),
(5, 25, 11, 8242.50, 'upi', 'TXN5985971771318075', '2026-02-17 14:17:55', 'completed'),
(6, 27, 11, 866.25, 'card', 'TXN3735231771826198', '2026-02-23 11:26:38', 'completed'),
(7, 29, 11, 25074.00, 'card', 'TXN1737581773122050', '2026-03-10 11:24:10', 'completed'),
(8, 32, 11, 5806.50, 'card', 'TXN9472261774438386', '2026-03-25 17:03:06', 'completed'),
(9, 33, 25, 330750.00, 'card', 'TXN8604231774596632', '2026-03-27 13:00:32', 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('farmer','consumer') DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`) VALUES
(11, 'Yadav Dev M.', 'devmyadav27@gmail.com', '$2y$10$s1hoCLA0lj78h1CYHzzztO29gK/loirW4E70BhZMlvdVBSzTttylm', 'consumer', '2026-02-01 14:16:47'),
(12, 'Jay Vaghela ', 'ydevm27@gmail.com', '$2y$10$C.8cSDNI89SLbDXCs5dMr.BDPGnSc2N16i1CcJTMKeDXQWVzkvCkS', 'farmer', '2026-02-01 14:18:59'),
(14, 'Rahul Farmer', 'rahul@farm.com', '$2y$10$RBoxhhOuyM.CB9U3LTItlO6ho6DBe3vf/eAOXLKgnDqLMnVmA0WeK', 'farmer', '2026-02-06 22:41:39'),
(15, 'Priya Consumer', 'priya@buy.com', '$2y$10$RBoxhhOuyM.CB9U3LTItlO6ho6DBe3vf/eAOXLKgnDqLMnVmA0WeK', 'consumer', '2026-02-06 22:41:39'),
(16, 'Amit Farmer', 'amit@farm.com', '$2y$10$RBoxhhOuyM.CB9U3LTItlO6ho6DBe3vf/eAOXLKgnDqLMnVmA0WeK', 'farmer', '2026-02-06 22:41:39'),
(17, 'Mr. Honey', 'honey01@gmail.com', '$2y$10$iMb4CPcCmRB0o3yD/L8cc.c6cWGd4i2YG.8VInlBr9UqyEoUMIn6.', 'farmer', '2026-02-07 14:01:45'),
(18, 'hemanshu', 'hemanshu@gmail.com', '$2y$10$2jwVSmwIMhRYIIiqdxV4kOWODbF8tRo3atXDQwvGCn24L3nvT4Bke', 'consumer', '2026-02-09 12:45:44'),
(19, 'Mr. Vaghela', 'jaydvaghela12@gmail.com', '$2y$10$1Di.QNA3iTl948L0g0Vi9.TfXZjouAJNcBF6otCcG.MKQgdtrpE.S', 'farmer', '2026-02-14 16:58:19'),
(20, 'Mr. Yadav', 'dev13@gmail.com', '$2y$10$8DzBn5HWQwyO3GCb//rcJuONsud9gh.NqfKlNJ.jbtgICiuTwNFSG', 'consumer', '2026-03-08 14:48:38'),
(21, 'PRADHAN HEMANSHU', 'pradhanhemanshu06@gmail.com', '$2y$10$mSGghqkt3lFKYyyY4FPhGex/ZsQKUP8QhiVBWOOU7BvFz6J1SKsza', 'consumer', '2026-03-10 11:19:57'),
(22, 'PRADHAN HEMANSHU', 'dhavalprathan@gmail.com', '$2y$10$n75i22YNW20kZaWaO6AFpeg9MXv.gjEueiwmdzIW1rzBOYE87M1b.', 'consumer', '2026-03-10 11:20:16'),
(23, 'Krish', 'krish@gmail.com', '$2y$10$kqRwiZS/afTe07Tna16HCO8AzJWvKxGJcoBKtNLxVk3DGn/CJAEy2', 'consumer', '2026-03-10 11:20:20'),
(24, 'XYZ', 'xyz@gmail.com', '$2y$10$M33NW0NLLGbVdm07ZjmKd.JqmCuUQNxXlEJJFMQzYLVdK/rfLrel2', 'farmer', '2026-03-26 21:54:50'),
(25, 'ABC', 'abc@gmail.com', '$2y$10$4NBk/3ypLmplN3LJrG3Xhe47rVSCCTT7PTV3kVKfBIiicnMojdW9O', 'consumer', '2026-03-26 22:13:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
