-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2017 at 09:03 AM
-- Server version: 5.7.14-log
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `network`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `cat_parent_name` varchar(50) NOT NULL DEFAULT '0',
  `cat_child_name` varchar(50) NOT NULL,
  `cat_description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invite`
--

CREATE TABLE `invite` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `invite code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `network`
--

CREATE TABLE `network` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `order_num` int(11) NOT NULL,
  `delivery address` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `total price` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_items`
--

CREATE TABLE `tbl_items` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(512) NOT NULL,
  `category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_items`
--

INSERT INTO `tbl_items` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created_at`, `updated_at`) VALUES
(1, 'LG P880 4X HD', 'My first awesome phone!', 336, '', 3, '2014-06-01 01:12:26', '2014-05-31 14:12:26'),
(2, 'Google Nexus 4', 'The most awesome phone of 2013!', 299, '', 2, '2014-06-01 01:12:26', '2014-05-31 14:12:26'),
(3, 'Samsung Galaxy S4', 'How about no?', 600, '', 3, '2014-06-01 01:12:26', '2014-05-31 14:12:26'),
(6, 'Bench Shirt', 'The best shirt!', 29, '', 1, '2014-06-01 01:12:26', '2014-05-30 23:12:21'),
(7, 'Lenovo Laptop', 'My business partner.', 399, '', 2, '2014-06-01 01:13:45', '2014-05-30 23:13:39'),
(8, 'Samsung Galaxy Tab 10.1', 'Good tablet.', 259, '', 2, '2014-06-01 01:14:13', '2014-05-30 23:14:08'),
(9, 'Spalding Watch', 'My sports watch.', 199, '', 1, '2014-06-01 01:18:36', '2014-05-30 23:18:31'),
(10, 'Sony Smart Watch', 'The coolest smart watch!', 300, '', 2, '2014-06-06 17:10:01', '2014-06-05 15:09:51'),
(11, 'Huawei Y300', 'For testing purposes.', 100, '', 2, '2014-06-06 17:11:04', '2014-06-05 15:10:54'),
(12, 'Abercrombie Lake Arnold Shirt', 'Perfect as gift!', 60, '', 1, '2014-06-06 17:12:21', '2014-06-05 15:12:11'),
(13, 'Abercrombie Allen Brook Shirt', 'Cool red shirt!', 70, '', 1, '2014-06-06 17:12:59', '2014-06-05 15:12:49'),
(26, 'Another product', 'Awesome product!', 555, '', 2, '2014-11-22 19:07:34', '2014-11-21 17:07:34'),
(27, 'Bag', 'Awesome bag for you!', 999, '', 1, '2014-12-04 21:11:36', '2014-12-03 19:11:36'),
(28, 'Wallet', 'You can absolutely use this one!', 799, '', 1, '2014-12-04 21:12:03', '2014-12-03 19:12:03'),
(30, 'Wal-mart Shirt', '', 555, '', 2, '2014-12-13 00:52:29', '2014-12-11 22:52:29'),
(31, 'Amanda Waller Shirt', 'New awesome shirt!', 333, '', 1, '2014-12-13 00:52:54', '2014-12-11 22:52:54'),
(32, 'Washing Machine Model PTRR', 'Some new product.', 999, '', 1, '2015-01-08 22:44:15', '2015-01-07 20:44:15');

-- --------------------------------------------------------

--
-- Table structure for table `tl_items`
--

CREATE TABLE `tl_items` (
  `id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_price` varchar(50) NOT NULL,
  `item_description` varchar(50) NOT NULL,
  `created_date` varchar(50) NOT NULL,
  `updated_date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `mname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_num` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `mname`, `lname`, `email`, `password`, `phone_num`, `address`, `profile_pic`, `user_type`) VALUES
(1, 'Robel', 'Getachew', 'Somebody', 'test2@gmail.com', '$2y$10$4R2nHjMXQVmUYcyAvB.cDOCSIr8HN.uOggmXssEj5t9i1BQeIxUPK', '0912312453', 'Hawassa', 'pic.jpg', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_items`
--
ALTER TABLE `tbl_items`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `tbl_items`
--
ALTER TABLE `tbl_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
