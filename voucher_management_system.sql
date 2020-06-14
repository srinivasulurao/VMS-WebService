-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2020 at 03:46 AM
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
-- Table structure for table `communications`
--

CREATE TABLE `communications` (
  `message_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `message_from` varchar(200) NOT NULL,
  `message_date` datetime NOT NULL,
  `user_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

CREATE TABLE `discounts` (
  `discount_id` int(200) NOT NULL,
  `discount_amount` varchar(200) NOT NULL,
  `discount_type` enum('percentage','price') NOT NULL,
  `vouchers` varchar(4000) NOT NULL,
  `user_id` int(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`discount_id`, `discount_amount`, `discount_type`, `vouchers`, `user_id`) VALUES
(1, '20', 'percentage', 'CAOK65517,BAOK65812', 1);

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
(6, '3KH9957721510724S', 1, '{\"create_time\":\"2020-02-03T10:34:33Z\",\"update_time\":\"2020-02-03T10:34:58Z\",\"id\":\"3KH9957721510724S\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"payer\":{\"email_address\":\"srinivasulu.rao.buyer@gmail.com\",\"payer_id\":\"PYKHTL5QJ4CL4\",\"address\":{\"country_code\":\"US\"},\"name\":{\"given_name\":\"N Srinivasulu\",\"surname\":\"Rao\"}},\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"value\":\"5.00\",\"currency_code\":\"USD\"},\"payee\":{\"email_address\":\"srinivasulu.rao.seller@gmail.com\",\"merchant_id\":\"5UNY4AY39TJXL\"},\"shipping\":{\"name\":{\"full_name\":\"N Srinivasulu Rao\"},\"address\":{\"address_line_1\":\"1 Main St\",\"admin_area_2\":\"San Jose\",\"admin_area_1\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}},\"payments\":{\"captures\":[{\"status\":\"COMPLETED\",\"id\":\"4R008620LB978352T\",\"final_capture\":true,\"create_time\":\"2020-02-03T10:34:58Z\",\"update_time\":\"2020-02-03T10:34:58Z\",\"amount\":{\"value\":\"5.00\",\"currency_code\":\"USD\"},\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/4R008620LB978352T\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/4R008620LB978352T/refund\",\"rel\":\"refund\",\"method\":\"POST\",\"title\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/3KH9957721510724S\",\"rel\":\"up\",\"method\":\"GET\",\"title\":\"GET\"}]}]}}],\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/3KH9957721510724S\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"}]}', '2020-02-03 10:35:00', 'COMPLETED', 7),
(7, '0K821290BP7531922', 1, '{\"create_time\":\"2020-06-04T19:46:54Z\",\"update_time\":\"2020-06-04T19:49:32Z\",\"id\":\"0K821290BP7531922\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"payer\":{\"email_address\":\"srinivasulu.rao.buyer@gmail.com\",\"payer_id\":\"PYKHTL5QJ4CL4\",\"address\":{\"country_code\":\"US\"},\"name\":{\"given_name\":\"N Srinivasulu\",\"surname\":\"Rao\"}},\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"value\":\"1.00\",\"currency_code\":\"USD\"},\"payee\":{\"email_address\":\"srinivasulu.rao.seller@gmail.com\",\"merchant_id\":\"5UNY4AY39TJXL\"},\"shipping\":{\"name\":{\"full_name\":\"N Srinivasulu Rao\"},\"address\":{\"address_line_1\":\"1 Main St\",\"admin_area_2\":\"San Jose\",\"admin_area_1\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}},\"payments\":{\"captures\":[{\"status\":\"COMPLETED\",\"id\":\"8R8353594W084131J\",\"final_capture\":true,\"create_time\":\"2020-06-04T19:49:32Z\",\"update_time\":\"2020-06-04T19:49:32Z\",\"amount\":{\"value\":\"1.00\",\"currency_code\":\"USD\"},\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/8R8353594W084131J\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/8R8353594W084131J/refund\",\"rel\":\"refund\",\"method\":\"POST\",\"title\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/0K821290BP7531922\",\"rel\":\"up\",\"method\":\"GET\",\"title\":\"GET\"}]}]}}],\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/0K821290BP7531922\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"}]}', '2020-06-04 19:49:32', 'COMPLETED', 8),
(8, '14D51469SS277270N', 1, '{\"create_time\":\"2020-06-04T21:01:53Z\",\"update_time\":\"2020-06-04T21:02:21Z\",\"id\":\"14D51469SS277270N\",\"intent\":\"CAPTURE\",\"status\":\"COMPLETED\",\"payer\":{\"email_address\":\"srinivasulu.rao.buyer@gmail.com\",\"payer_id\":\"PYKHTL5QJ4CL4\",\"address\":{\"country_code\":\"US\"},\"name\":{\"given_name\":\"N Srinivasulu\",\"surname\":\"Rao\"}},\"purchase_units\":[{\"reference_id\":\"default\",\"amount\":{\"value\":\"1.00\",\"currency_code\":\"USD\"},\"payee\":{\"email_address\":\"srinivasulu.rao.seller@gmail.com\",\"merchant_id\":\"5UNY4AY39TJXL\"},\"shipping\":{\"name\":{\"full_name\":\"N Srinivasulu Rao\"},\"address\":{\"address_line_1\":\"1 Main St\",\"admin_area_2\":\"San Jose\",\"admin_area_1\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}},\"payments\":{\"captures\":[{\"status\":\"COMPLETED\",\"id\":\"4YW59387C2181693W\",\"final_capture\":true,\"create_time\":\"2020-06-04T21:02:21Z\",\"update_time\":\"2020-06-04T21:02:21Z\",\"amount\":{\"value\":\"1.00\",\"currency_code\":\"USD\"},\"seller_protection\":{\"status\":\"ELIGIBLE\",\"dispute_categories\":[\"ITEM_NOT_RECEIVED\",\"UNAUTHORIZED_TRANSACTION\"]},\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/4YW59387C2181693W\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"},{\"href\":\"https://api.sandbox.paypal.com/v2/payments/captures/4YW59387C2181693W/refund\",\"rel\":\"refund\",\"method\":\"POST\",\"title\":\"POST\"},{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/14D51469SS277270N\",\"rel\":\"up\",\"method\":\"GET\",\"title\":\"GET\"}]}]}}],\"links\":[{\"href\":\"https://api.sandbox.paypal.com/v2/checkout/orders/14D51469SS277270N\",\"rel\":\"self\",\"method\":\"GET\",\"title\":\"GET\"}]}', '2020-06-04 21:02:23', 'COMPLETED', 9);

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
-- Table structure for table `products_1`
--

CREATE TABLE `products_1` (
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
-- Dumping data for table `products_1`
--

INSERT INTO `products_1` (`product_id`, `product_name`, `specification`, `specification_options`, `price`, `user_id`, `quantity`, `product_image`) VALUES
(12, 'Samsung Galaxy M30', '3 GB RAM, Snapdragon 665', 'Color:red,blue,red|RAM:3GB,4GB', '200', 1, 30, '1591477559_1551217932_635_samsung_galaxy_m30.jpg'),
(13, 'Redmi K20 Pro', 'Flagship Killer', 'Color:red,blue,green|RAM:4GB,6GB', '350', 1, 30, '1591478580_61I1+ybyOVL._AC_SX522_.jpg');

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
  `product_table` varchar(200) NOT NULL,
  `params` varchar(2000) NOT NULL,
  `currency` enum('INR','USD','GBP','EUR','AUD','CAD','SGD') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `phone_no`, `paypal_email`, `password`, `activation`, `account_created`, `last_login`, `company_name`, `company_logo`, `opted_plan`, `voucher_table`, `product_table`, `params`, `currency`) VALUES
(1, 'n.srinivasulurao@gmail.com', '8792394035', 'n.srinivasulurao@gmail.com', '06cbdb7f3f86a3712c1d67f4920af6a0', 1, '2019-02-05 00:00:00', '2020-06-07 23:41:38', 'Tirupati Balaji Enterprises', '1591569808_tirupati-balaji-hd-wallpaper-01.jpg', 4, 'vouchers_1', 'products_1', '[{\"plan_slno\":\"0\",\"plan_id\":4,\"end_date\":\"2020-05-01 00:00:00\"}]', 'USD'),
(8, 'doru.arfire.1279@gmail.com', '8792394035', NULL, '52009b678822e10a047f3d500fe2efb3', 1, '2020-06-04 19:49:32', '2020-06-04 19:53:26', 'NetApp Solutions', '1591300172_61I1+ybyOVL._AC_SX522_.jpg', 1, 'vouchers_1', 'products_1', '[{\"plan_slno\":0,\"plan_id\":\"1\",\"end_date\":\"2020-06-09 19:49:32\"}]', 'USD'),
(9, 'doru.arfire.1279d@gmail.com', '8792394035', NULL, '52009b678822e10a047f3d500fe2efb3', 1, '2020-06-04 21:02:22', '2020-06-04 21:02:22', 'NetApp Solutions', '1591304542_1_J2ZX6RL0WJklkNslowf1SA.jpeg', 1, 'vouchers_1', 'products_1', '[{\"plan_slno\":0,\"plan_id\":\"1\",\"end_date\":\"2020-06-09 21:02:22\"}]', 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers_1`
--

CREATE TABLE `vouchers_1` (
  `voucher_id` int(11) NOT NULL,
  `user_id` int(200) NOT NULL,
  `coupon_code` varchar(200) NOT NULL,
  `redemption_status` int(11) NOT NULL,
  `enabled` int(11) NOT NULL DEFAULT '1',
  `validity` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `redeemed_on` datetime DEFAULT NULL,
  `product_linked` int(100) DEFAULT NULL,
  `notes` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vouchers_1`
--

INSERT INTO `vouchers_1` (`voucher_id`, `user_id`, `coupon_code`, `redemption_status`, `enabled`, `validity`, `created_on`, `redeemed_on`, `product_linked`, `notes`) VALUES
(28, 1, 'CAOK65517', 1, 1, '2033-10-11 00:00:00', '2020-06-06 00:00:00', '2020-06-18 00:00:00', 13, 'Send this coupon code to Travis Cable'),
(29, 1, 'BAOK65812', 1, 1, '2020-05-29 00:00:00', '2020-06-06 00:00:00', '2020-06-06 00:00:00', 12, ''),
(30, 1, 'ABOK21312', 0, 1, '2020-05-30 00:00:00', '2020-06-06 00:00:00', NULL, NULL, 'Send this coupon code to Catherine');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `communications`
--
ALTER TABLE `communications`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `discounts`
--
ALTER TABLE `discounts`
  ADD PRIMARY KEY (`discount_id`);

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
-- Indexes for table `products_1`
--
ALTER TABLE `products_1`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vouchers_1`
--
ALTER TABLE `vouchers_1`
  ADD PRIMARY KEY (`voucher_id`),
  ADD UNIQUE KEY `coupon_code` (`coupon_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `communications`
--
ALTER TABLE `communications`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discounts`
--
ALTER TABLE `discounts`
  MODIFY `discount_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_transactions`
--
ALTER TABLE `payment_transactions`
  MODIFY `payment_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products_1`
--
ALTER TABLE `products_1`
  MODIFY `product_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `vouchers_1`
--
ALTER TABLE `vouchers_1`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
