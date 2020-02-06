-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 06, 2020 at 04:43 AM
-- Server version: 10.4.10-MariaDB
-- PHP Version: 7.3.12

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
-- Table structure for table `payment_transactions`
--

CREATE TABLE `payment_transactions` (
  `payment_id` int(200) NOT NULL,
  `transaction_id` varchar(200) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `transaction_details` varchar(5000) NOT NULL,
  `created_on` datetime NOT NULL,
  `status` varchar(200) NOT NULL,
  `user_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_transactions`
--

INSERT INTO `payment_transactions` (`payment_id`, `transaction_id`, `plan_id`, `transaction_details`, `created_on`, `status`, `user_id`) VALUES
(5, '5FX01702L4596624X', 1, '{\"create_time\":\"2020-01-30T13:52:14Z\",\"update_time\":\"2020-01-30T13:52:36Z\",\"id\":\"5FX01702L4596624X\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"payer\":{\"email_address\":\"srinivasulu.rao.buyer@gmail.com\",\"payer_id\":\"PYKHTL5QJ4CL4\",\"address\":{\"country_code\":\"US\"},\"name\":{\"given_name\":\"N Srinivasulu\",\"surname\":\"Rao\"}},\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"value\":\"1.00\",\"currency_code\":\"USD\"},\"payee\":{\"email_address\":\"srinivasulu.rao.seller@gmail.com\",\"merchant_id\":\"5UNY4AY39TJXL\"},\"shipping\":{\"name\":{\"full_name\":\"N Srinivasulu Rao\"},\"address\":{\"address_line_1\":\"1 Main St\",\"admin_area_2\":\"San Jose\",\"admin_area_1\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}},\"payments\":{\"captures\":[{\"status\":\"COMPLETED\",\"id\":\"8L22417053405645G\",\"final_capture\":true,\"create_time\":\"2020-01-30T13:52:36Z\",\"update_time\":\"2020-01-30T13:52:36Z\",\"amount\":{\"value\":\"1.00\",\"currency_code\":\"USD\"},\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/8L22417053405645G\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/8L22417053405645G/refund\",\"rel\":\"refund\",\"method\":\"POST\",\"title\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/5FX01702L4596624X\",\"rel\":\"up\",\"method\":\"GET\",\"title\":\"GET\"}]}]}}],\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/5FX01702L4596624X\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"}]}', '2020-01-30 13:52:38', 'COMPLETED', 6),
(6, '3KH9957721510724S', 1, '{\"create_time\":\"2020-02-03T10:34:33Z\",\"update_time\":\"2020-02-03T10:34:58Z\",\"id\":\"3KH9957721510724S\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"payer\":{\"email_address\":\"srinivasulu.rao.buyer@gmail.com\",\"payer_id\":\"PYKHTL5QJ4CL4\",\"address\":{\"country_code\":\"US\"},\"name\":{\"given_name\":\"N Srinivasulu\",\"surname\":\"Rao\"}},\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"value\":\"5.00\",\"currency_code\":\"USD\"},\"payee\":{\"email_address\":\"srinivasulu.rao.seller@gmail.com\",\"merchant_id\":\"5UNY4AY39TJXL\"},\"shipping\":{\"name\":{\"full_name\":\"N Srinivasulu Rao\"},\"address\":{\"address_line_1\":\"1 Main St\",\"admin_area_2\":\"San Jose\",\"admin_area_1\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}},\"payments\":{\"captures\":[{\"status\":\"COMPLETED\",\"id\":\"4R008620LB978352T\",\"final_capture\":true,\"create_time\":\"2020-02-03T10:34:58Z\",\"update_time\":\"2020-02-03T10:34:58Z\",\"amount\":{\"value\":\"5.00\",\"currency_code\":\"USD\"},\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/4R008620LB978352T\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/4R008620LB978352T/refund\",\"rel\":\"refund\",\"method\":\"POST\",\"title\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/3KH9957721510724S\",\"rel\":\"up\",\"method\":\"GET\",\"title\":\"GET\"}]}]}}],\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/3KH9957721510724S\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"}]}', '2020-02-03 10:35:00', 'COMPLETED', 7);

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(100) NOT NULL,
  `plan_price` int(11) NOT NULL,
  `duration` int(11) NOT NULL COMMENT 'Duration in days',
  `coupon_limit` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`plan_id`, `plan_name`, `plan_price`, `duration`, `coupon_limit`) VALUES
(1, 'Trial', 1, 5, '10'),
(2, 'One Month', 10, 30, '100'),
(3, 'Six Months', 50, 180, '500'),
(4, 'Twelve Months', 100, 360, '1000');

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
  `user_id` int(200) NOT NULL,
  `quantity` int(200) NOT NULL,
  `product_image` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `specification`, `specification_options`, `price`, `user_id`, `quantity`, `product_image`) VALUES
(1, 'IPhone-X', 'Retina Display', 'Memory:128GB,256GB,512GB', '999.00', 1, 10, ''),
(2, 'Asus Zenfone Max Pro M2', 'Flagship Killer', 'color:space blue, black silver|RAM:4gb,6gb', '150.00', 1, 10, '1577314685_thumb_130911_product_td_300.jpeg'),
(3, 'Xiomi Note 7', '', '', '360.00', 1, 10, ''),
(4, 'One Plus 7 Pro', 'Flagship Killer', 'RAM:6GB,8GB,12GB', '669.00', 1, 20, ''),
(5, 'Xiomi K20 Pro', '', '', '360.00', 1, 30, ''),
(8, 'Nike SB Delta Sneakers', 'Skateboard Sneakers', 'color:white,blue,black|size:6,7,8,9,10,11,12', '200', 1, 30, ''),
(9, 'Redmi K20 Pro', 'Snapdragon 855', 'color:red,blue,black|RAM:4GB,6GB,8GB,12GB', '360.00', 1, 30, '1571602262_RedmiK20Pro.jpg'),
(10, 'Test', 'Test', 'Test:test,test', '12', 1, 20, ''),
(11, 'Huawei P30 Lite', 'Pop up selfie camera', 'RAM:4,6,64|ROM:64gb, 128gb,256gb', '210', 1, 50, '1573395644_61I1+ybyOVL._AC_SX522_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `phone_no` varchar(200) NOT NULL,
  `paypal_email` varchar(200) DEFAULT NULL,
  `password` varchar(200) NOT NULL,
  `activation` int(11) NOT NULL,
  `account_created` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `company_name` varchar(200) NOT NULL,
  `company_logo` varchar(2000) NOT NULL,
  `opted_plan` int(11) NOT NULL,
  `voucher_table` varchar(100) NOT NULL,
  `params` varchar(2000) NOT NULL,
  `currency` enum('INR','USD','GBP','EUR','AUD','CAD','SGD') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone_no`, `paypal_email`, `password`, `activation`, `account_created`, `last_login`, `company_name`, `company_logo`, `opted_plan`, `voucher_table`, `params`, `currency`) VALUES
(1, 'n.srinivasulurao@gmail.com', '8792394035', 'n.srinivasulurao@gmail.com', '52009b678822e10a047f3d500fe2efb3', 1, '2019-02-05 00:00:00', '2020-02-03 10:31:59', 'Flipkart India Pvt Ltd', 'flipkart.png', 4, 'voucher_admin', '[{\"plan_slno\":\"0\",\"plan_id\":4,\"end_date\":\"2020-05-01 00:00:00\"}]', 'USD'),
(7, 'doru.arfire.1279@gmail.com', '8792394035', NULL, '52009b678822e10a047f3d500fe2efb3', 1, '2020-02-03 10:35:00', '2020-02-03 10:35:00', 'NetApp Solutions', '1580726100_Ladder.jpg', 1, 'voucher_admin', '[{\"plan_slno\":0,\"plan_id\":\"1\",\"end_date\":\"2020-02-08 10:35:00\"}]', 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `voucher_admin`
--

CREATE TABLE `voucher_admin` (
  `voucher_id` int(11) NOT NULL,
  `coupon_code` varchar(200) NOT NULL,
  `redemption_status` int(11) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT 1,
  `validity` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `redeemed_on` datetime DEFAULT NULL,
  `product_linked` int(100) DEFAULT NULL,
  `notes` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `voucher_admin`
--

INSERT INTO `voucher_admin` (`voucher_id`, `coupon_code`, `redemption_status`, `enabled`, `validity`, `created_on`, `redeemed_on`, `product_linked`, `notes`) VALUES
(2, 'xyzdsd', 1, 1, '2019-03-29 00:00:00', '2034-01-14 00:00:00', '2019-07-18 08:47:53', 1, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.'),
(3, 'kgjgjjjgkkkj', 1, 1, '2019-03-01 00:00:00', '2019-01-07 00:00:00', '2019-05-04 12:53:55', 2, 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs. The passage is attributed to an unknown typesetter in the 15th century who is thought to have scrambled parts of Cicero\'s De Finibus Bonorum et Malorum for use in a type specimen book.'),
(22, 'CAOK65517', 1, 1, '2020-05-23 00:00:00', '2019-06-03 00:00:00', '2019-06-04 08:31:26', 1, 'Send this coupon code to Travis Cable'),
(23, 'BAOK65812', 1, 1, '2020-05-29 00:00:00', '2019-06-03 00:00:00', '2019-06-04 08:31:28', NULL, ''),
(24, 'ABOK21312', 1, 1, '2020-05-30 00:00:00', '2019-06-03 00:00:00', '2019-06-04 08:31:29', NULL, 'Send this coupon code to Catherine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  ADD PRIMARY KEY (`payment_id`);

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
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `payment_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `voucher_admin`
--
ALTER TABLE `voucher_admin`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
