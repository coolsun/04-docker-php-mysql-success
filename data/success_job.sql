-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2018 at 10:36 AM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 5.6.38-1+ubuntu16.04.1+deb.sury.org+2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `success_job`
--
CREATE DATABASE IF NOT EXISTS `success_job` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `success_job`;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `business_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `business_no` bigint(20) UNSIGNED NOT NULL,
  `business_created_date` date NOT NULL,
  `business_status` enum('0','1','2','3') NOT NULL DEFAULT '0',
  `business_client_name` text NOT NULL,
  `business_product_require_standard` text NOT NULL,
  `business_product_require_description` text NOT NULL,
  `business_product_require_amount` bigint(20) UNSIGNED NOT NULL,
  `business_product_require_date` int(10) UNSIGNED NOT NULL,
  `business_product_application` text NOT NULL,
  `business_product_sales_area` text NOT NULL,
  `business_product_competitor` text NOT NULL,
  `business_product_expected_amount` bigint(20) UNSIGNED NOT NULL,
  `business_product_proposal_standard` text NOT NULL,
  `business_product_type_number` text NOT NULL,
  `business_product_price` bigint(20) UNSIGNED NOT NULL,
  `business_product_min_order_num` bigint(20) UNSIGNED NOT NULL,
  `business_product_cost` bigint(20) NOT NULL,
  `business_product_deliver_date` int(10) UNSIGNED NOT NULL,
  `business_product_supplier` text NOT NULL,
  `business_product_payment_condition` text NOT NULL,
  `business_product_proposal_description` text NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businesses`
--

INSERT INTO `businesses` (`business_id`, `user_id`, `business_no`, `business_created_date`, `business_status`, `business_client_name`, `business_product_require_standard`, `business_product_require_description`, `business_product_require_amount`, `business_product_require_date`, `business_product_application`, `business_product_sales_area`, `business_product_competitor`, `business_product_expected_amount`, `business_product_proposal_standard`, `business_product_type_number`, `business_product_price`, `business_product_min_order_num`, `business_product_cost`, `business_product_deliver_date`, `business_product_supplier`, `business_product_payment_condition`, `business_product_proposal_description`, `created_datetime`) VALUES
(1, 1, 1, '0000-00-00', '0', '統神', '121212', '', 123123, 0, '', '', '', 0, '123123', '', 12, 0, 6, 0, '', '', '', '2018-02-13 02:33:03'),
(2, 1, 2, '0000-00-00', '2', '123', '5454', '', 12, 0, '', '', '', 0, '555', '', 55, 0, 22, 0, '', '', '', '2018-02-13 02:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `businesses_metadata`
--

CREATE TABLE `businesses_metadata` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `business_last_no` bigint(20) UNSIGNED NOT NULL,
  `business_num` bigint(20) UNSIGNED NOT NULL,
  `business_max_num` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `businesses_metadata`
--

INSERT INTO `businesses_metadata` (`user_id`, `business_last_no`, `business_num`, `business_max_num`) VALUES
(1, 2, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `engine`
--

CREATE TABLE `engine` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `engine_result` text NOT NULL,
  `first_id` bigint(20) UNSIGNED NOT NULL,
  `last_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobnotes`
--

CREATE TABLE `jobnotes` (
  `jobnote_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `jobnote_title` text NOT NULL,
  `jobnote_content` text NOT NULL,
  `modified_datetime` datetime NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobnotes`
--

INSERT INTO `jobnotes` (`jobnote_id`, `user_id`, `jobnote_title`, `jobnote_content`, `modified_datetime`, `created_datetime`) VALUES
(1, 1, '建立網站', '<p style=&#34;color: rgb(85, 85, 85);&#34;>智慧與悟性所啟發的網站</p><p style=&#34;color: rgb(85, 85, 85);&#34;>願上帝與我同在賜給我力量</p>', '2018-08-27 03:44:58', '2018-08-27 03:44:58'),
(2, 1, 'test', 'testtesttset', '2018-08-29 09:40:02', '2018-08-29 09:40:02');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `job_title` text NOT NULL,
  `job_priority` enum('0','1','2') NOT NULL DEFAULT '1',
  `job_status` enum('0','1','2','3') NOT NULL,
  `job_start_date` date NOT NULL,
  `job_end_date` date NOT NULL,
  `job_description` text NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_id`, `user_id`, `job_title`, `job_priority`, `job_status`, `job_start_date`, `job_end_date`, `job_description`, `created_datetime`) VALUES
(1, 1, '吃飯', '1', '0', '2018-02-14', '2018-02-27', '', '2018-02-13 02:48:30'),
(2, 1, '睡覺', '1', '0', '2018-02-06', '2018-02-28', '', '2018-02-13 02:49:01'),
(3, 1, 'a', '1', '0', '2018-08-29', '2018-08-29', '', '2018-08-29 09:25:00'),
(4, 1, 'B', '1', '0', '2018-08-29', '2018-08-29', '', '2018-08-29 09:25:00'),
(5, 1, 'V', '1', '0', '2018-08-29', '2018-08-29', '', '2018-08-29 09:25:00'),
(6, 1, '買菜', '1', '0', '2018-08-29', '2018-08-29', '', '2018-08-29 09:39:08'),
(7, 1, '購物', '1', '0', '2018-08-29', '2018-08-29', '', '2018-08-29 09:39:08');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `session_title` text NOT NULL,
  `session_date` date NOT NULL,
  `session_start_time` time NOT NULL,
  `session_end_time` time NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjobs`
--

CREATE TABLE `subjobs` (
  `subjob_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `parent_job_id` bigint(20) UNSIGNED NOT NULL,
  `subjob_title` text NOT NULL,
  `subjob_priority` enum('0','1','2') NOT NULL DEFAULT '1',
  `subjob_status` enum('0','1','2','3') NOT NULL,
  `subjob_start_date` date NOT NULL,
  `subjob_end_date` date NOT NULL,
  `subjob_description` text NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjobs`
--

INSERT INTO `subjobs` (`subjob_id`, `user_id`, `parent_job_id`, `subjob_title`, `subjob_priority`, `subjob_status`, `subjob_start_date`, `subjob_end_date`, `subjob_description`, `created_datetime`) VALUES
(1, 1, 2, '作夢', '1', '0', '2018-02-17', '2018-02-18', '', '2018-02-13 02:49:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `businesses`
--
ALTER TABLE `businesses`
  ADD PRIMARY KEY (`business_id`),
  ADD UNIQUE KEY `user_business_no` (`user_id`,`business_no`);

--
-- Indexes for table `businesses_metadata`
--
ALTER TABLE `businesses_metadata`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `engine`
--
ALTER TABLE `engine`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `jobnotes`
--
ALTER TABLE `jobnotes`
  ADD PRIMARY KEY (`jobnote_id`,`user_id`),
  ADD UNIQUE KEY `jobnote_id` (`jobnote_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`job_id`),
  ADD UNIQUE KEY `user_job_id` (`user_id`,`job_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`,`user_id`);

--
-- Indexes for table `subjobs`
--
ALTER TABLE `subjobs`
  ADD PRIMARY KEY (`subjob_id`),
  ADD UNIQUE KEY `user_job_id` (`subjob_id`,`parent_job_id`),
  ADD KEY `job_subjob_relation` (`parent_job_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `businesses`
--
ALTER TABLE `businesses`
  MODIFY `business_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobnotes`
--
ALTER TABLE `jobnotes`
  MODIFY `jobnote_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `job_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subjobs`
--
ALTER TABLE `subjobs`
  MODIFY `subjob_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjobs`
--
ALTER TABLE `subjobs`
  ADD CONSTRAINT `job_subjob_relation` FOREIGN KEY (`parent_job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
