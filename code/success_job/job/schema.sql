-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2017 at 11:17 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `successnetpc_db`
--
CREATE DATABASE `successnetpc_db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `successnetpc_db`;

-- --------------------------------------------------------

--
-- Table structure for table `businesses`
--

CREATE TABLE `businesses` (
  `business_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `business_no` bigint(20) unsigned NOT NULL,
  `business_created_date` date NOT NULL,
  `business_status` enum('0','1','2','3') NOT NULL default '0',
  `business_client_name` text NOT NULL,
  `business_product_require_standard` text NOT NULL,
  `business_product_require_description` text NOT NULL,
  `business_product_require_amount` bigint(20) unsigned NOT NULL,
  `business_product_require_date` int(10) unsigned NOT NULL,
  `business_product_application` text NOT NULL,
  `business_product_sales_area` text NOT NULL,
  `business_product_competitor` text NOT NULL,
  `business_product_expected_amount` bigint(20) unsigned NOT NULL,
  `business_product_proposal_standard` text NOT NULL,
  `business_product_type_number` text NOT NULL,
  `business_product_price` bigint(20) unsigned NOT NULL,
  `business_product_min_order_num` bigint(20) unsigned NOT NULL,
  `business_product_cost` bigint(20) NOT NULL,
  `business_product_deliver_date` int(10) unsigned NOT NULL,
  `business_product_supplier` text NOT NULL,
  `business_product_payment_condition` text NOT NULL,
  `business_product_proposal_description` text NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY  (`business_id`),
  UNIQUE KEY `user_business_no` (`user_id`,`business_no`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `businesses_metadata`
--

CREATE TABLE `businesses_metadata` (
  `user_id` int(10) unsigned NOT NULL,
  `business_last_no` bigint(20) unsigned NOT NULL,
  `business_num` bigint(20) unsigned NOT NULL,
  `business_max_num` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `engine`
--

CREATE TABLE `engine` (
  `user_id` int(10) unsigned NOT NULL,
  `engine_result` text NOT NULL,
  `first_id` bigint(20) unsigned NOT NULL,
  `last_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobnotes`
--

CREATE TABLE `jobnotes` (
  `jobnote_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `jobnote_title` text NOT NULL,
  `jobnote_content` text NOT NULL,
  `modified_datetime` datetime NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY  (`jobnote_id`,`user_id`),
  UNIQUE KEY `jobnote_id` (`jobnote_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `job_title` text NOT NULL,
  `job_priority` enum('0','1','2') NOT NULL default '1',
  `job_status` enum('0','1','2','3') NOT NULL,
  `job_start_date` date NOT NULL,
  `job_end_date` date NOT NULL,
  `job_description` text NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY  (`job_id`),
  UNIQUE KEY `user_job_id` (`user_id`,`job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `session_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `session_title` text NOT NULL,
  `session_date` date NOT NULL,
  `session_start_time` time NOT NULL,
  `session_end_time` time NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY  (`session_id`,`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `subjobs`
--

CREATE TABLE `subjobs` (
  `subjob_id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned NOT NULL,
  `parent_job_id` bigint(20) unsigned NOT NULL,
  `subjob_title` text NOT NULL,
  `subjob_priority` enum('0','1','2') NOT NULL default '1',
  `subjob_status` enum('0','1','2','3') NOT NULL,
  `subjob_start_date` date NOT NULL,
  `subjob_end_date` date NOT NULL,
  `subjob_description` text NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY  (`subjob_id`),
  UNIQUE KEY `user_job_id` (`subjob_id`,`parent_job_id`),
  KEY `job_subjob_relation` (`parent_job_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subjobs`
--
ALTER TABLE `subjobs`
  ADD CONSTRAINT `job_subjob_relation` FOREIGN KEY (`parent_job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE;

