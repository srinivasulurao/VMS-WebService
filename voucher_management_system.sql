-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2019 at 08:05 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `voucher_management_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `redeemed_coupons` varchar(200) NOT NULL,
  `billing_address` varchar(2000) NOT NULL,
  `shipping_address` varchar(2000) NOT NULL,
  `amount` varchar(200) NOT NULL,
  `product_specifications` varchar(2000) NOT NULL,
  `order_delivered` int(11) NOT NULL,
  `email_sent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `plan_price` int(11) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in days'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_name`, `plan_price`, `duration`) VALUES
(1, 'Free', 0, 5),
(2, 'One Month', 10, 30),
(3, 'Six Months', 50, 180),
(4, 'Twelve Months', 100, 360);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(200) NOT NULL,
  `product_name` varchar(1000) NOT NULL,
  `specification` varchar(2000) NOT NULL,
  `specification_options` varchar(2000) NOT NULL,
  `price` varchar(2000) NOT NULL,
  `user_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `specification`, `specification_options`, `price`, `user_id`) VALUES
(1, 'IPhone-X', '', '', '', 1),
(2, 'Asus Zenfone Max Pro M2', '', '', '', 1),
(3, 'Xiomi Note 7', '', '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `activation` int(11) NOT NULL,
  `account_created` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `opted_plan` int(11) NOT NULL,
  `voucher_table` varchar(100) NOT NULL,
  `params` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `activation`, `account_created`, `last_login`, `company_name`, `opted_plan`, `voucher_table`, `params`) VALUES
(1, 'n.srinivasulurao@gmail.com', '93a1fcb8369359638eeefe22f0f3a544', 1, '2019-02-05 00:00:00', '2019-05-02 05:33:36', 'Flipkart India Pvt Ltd', 1, 'voucher_admin', '');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_admin`
--

CREATE TABLE `voucher_admin` (
  `voucher_id` int(11) NOT NULL,
  `coupon_code` varchar(200) NOT NULL,
  `redemption_status` int(11) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1',
  `validity` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `redeemed_on` datetime NOT NULL,
  `product_linked` int(100) NOT NULL,
  `notes` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher_admin`
--

INSERT INTO `voucher_admin` (`voucher_id`, `coupon_code`, `redemption_status`, `enabled`, `validity`, `created_on`, `redeemed_on`, `product_linked`, `notes`) VALUES
(2, 'xyzdsd', 1, 1, '2019-03-29 00:00:00', '2034-01-14 00:00:00', '2019-05-01 00:00:00', 1, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.'),
(3, 'kgjgjjjgkkkj', 1, 1, '2019-03-01 00:00:00', '2019-01-07 00:00:00', '2019-02-11 00:00:00', 2, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.'),
(4, 'jkhkk', 1, 1, '2019-03-23 00:00:00', '2019-03-19 00:00:00', '2019-04-11 11:04:09', 3, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`plan_id`);

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
-- Indexes for table `voucher_admin`
--
ALTER TABLE `voucher_admin`
  ADD PRIMARY KEY (`voucher_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `voucher_admin`
--
ALTER TABLE `voucher_admin`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
