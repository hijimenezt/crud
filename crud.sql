-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 01, 2025 at 05:58 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int NOT NULL,
  `category` varchar(255) NOT NULL,
  `is_actived` tinyint NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category`, `is_actived`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 'Category 1', 1, 1, '2025-03-31 18:52:23', 1, '2025-04-01 05:48:54'),
(2, 'Category 2', 1, 1, '2025-03-31 18:52:23', 1, '2025-04-01 05:48:23'),
(3, 'Category 3', 1, 1, '2025-04-01 05:44:07', 2, '2025-04-01 11:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int NOT NULL,
  `category_id` int NOT NULL,
  `product` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `is_actived` tinyint NOT NULL DEFAULT '1',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int DEFAULT NULL,
  `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `category_id`, `product`, `description`, `price`, `photo`, `is_actived`, `created_by`, `created_at`, `modified_by`, `modified_at`) VALUES
(1, 1, 'asdasd', 'asdasd', '123.00', 'img_67eae95fe5c482.79184214.png', 0, 1, '2025-03-31 19:13:35', 1, '2025-03-31 19:53:31'),
(2, 1, 'asd', 'asdasd', '123123.00', 'img_67eaeca8092a09.61797186.png', 0, 1, '2025-03-31 19:27:36', 1, '2025-03-31 19:53:24'),
(3, 2, 'Test 11', 'asdasd 111', '123.80', 'img_67eb77a20903a5.27221803.jpg', 1, 1, '2025-03-31 19:34:34', 1, '2025-04-01 05:20:34'),
(4, 1, 'sdfasd', 'asdasd', '123123.00', 'img_67eaee5c034540.50599701.png', 1, 1, '2025-03-31 19:34:52', NULL, '2025-03-31 19:34:52'),
(5, 3, 'Product #3', 'Lorem empsiaodadas', '200.00', 'img_67eb7edc4249d6.53771241.png', 1, 2, '2025-04-01 05:51:24', 2, '2025-04-01 05:51:35');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_actived` tinyint NOT NULL DEFAULT '1',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int DEFAULT NULL,
  `modified_on` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `is_actived`, `created_by`, `created_at`, `modified_by`, `modified_on`) VALUES
(1, 'mateo', '$2y$10$w1EUZ8PZ4jZN/w4C3bETj.3JRQLeFQdvVOS5/hRdbOzdKWAM73UAO', 1, NULL, '2025-03-31 16:40:56', NULL, NULL),
(2, 'hamlet', '$2y$10$PyoClTf16tEOx3L.fmMayulULXdklCBU1bEciQN6K3nq/i93Kb6IO', 1, NULL, '2025-04-01 05:50:39', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
