-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: success_job
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `success_job`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `success_job` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `success_job`;

--
-- Table structure for table `businesses`
--

DROP TABLE IF EXISTS `businesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `businesses` (
  `business_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `business_no` bigint(20) unsigned NOT NULL,
  `business_created_date` date NOT NULL,
  `business_status` enum('0','1','2','3') NOT NULL DEFAULT '0',
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
  PRIMARY KEY (`business_id`),
  UNIQUE KEY `user_business_no` (`user_id`,`business_no`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `businesses`
--

LOCK TABLES `businesses` WRITE;
/*!40000 ALTER TABLE `businesses` DISABLE KEYS */;
INSERT INTO `businesses` VALUES (1,1,1,'0000-00-00','0','統神','121212','',123123,0,'','','',0,'123123','',12,0,6,0,'','','','2018-02-13 02:33:03'),(2,1,2,'0000-00-00','2','123','5454','',12,0,'','','',0,'555','',55,0,22,0,'','','','2018-02-13 02:33:35');
/*!40000 ALTER TABLE `businesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `businesses_metadata`
--

DROP TABLE IF EXISTS `businesses_metadata`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `businesses_metadata` (
  `user_id` int(10) unsigned NOT NULL,
  `business_last_no` bigint(20) unsigned NOT NULL,
  `business_num` bigint(20) unsigned NOT NULL,
  `business_max_num` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `businesses_metadata`
--

LOCK TABLES `businesses_metadata` WRITE;
/*!40000 ALTER TABLE `businesses_metadata` DISABLE KEYS */;
INSERT INTO `businesses_metadata` VALUES (1,2,2,2);
/*!40000 ALTER TABLE `businesses_metadata` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `engine`
--

DROP TABLE IF EXISTS `engine`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `engine` (
  `user_id` int(10) unsigned NOT NULL,
  `engine_result` text NOT NULL,
  `first_id` bigint(20) unsigned NOT NULL,
  `last_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `engine`
--

LOCK TABLES `engine` WRITE;
/*!40000 ALTER TABLE `engine` DISABLE KEYS */;
/*!40000 ALTER TABLE `engine` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobnotes`
--

DROP TABLE IF EXISTS `jobnotes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobnotes` (
  `jobnote_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `jobnote_title` text NOT NULL,
  `jobnote_content` text NOT NULL,
  `modified_datetime` datetime NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY (`jobnote_id`,`user_id`),
  UNIQUE KEY `jobnote_id` (`jobnote_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobnotes`
--

LOCK TABLES `jobnotes` WRITE;
/*!40000 ALTER TABLE `jobnotes` DISABLE KEYS */;
INSERT INTO `jobnotes` VALUES (1,1,'建立網站','<p style=&#34;color: rgb(85, 85, 85);&#34;>智慧與悟性所啟發的網站</p><p style=&#34;color: rgb(85, 85, 85);&#34;>願上帝與我同在賜給我力量</p>','2018-08-27 03:44:58','2018-08-27 03:44:58'),(2,1,'test','testtesttset','2018-08-29 09:40:02','2018-08-29 09:40:02');
/*!40000 ALTER TABLE `jobnotes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `job_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `job_title` text NOT NULL,
  `job_priority` enum('0','1','2') NOT NULL DEFAULT '1',
  `job_status` enum('0','1','2','3') NOT NULL,
  `job_start_date` date NOT NULL,
  `job_end_date` date NOT NULL,
  `job_description` text NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY (`job_id`),
  UNIQUE KEY `user_job_id` (`user_id`,`job_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
INSERT INTO `jobs` VALUES (1,1,'吃飯','1','0','2018-02-14','2018-02-27','','2018-02-13 02:48:30'),(2,1,'睡覺','1','0','2018-02-06','2018-02-28','','2018-02-13 02:49:01'),(3,1,'a','1','0','2018-08-29','2018-08-29','','2018-08-29 09:25:00'),(4,1,'B','1','0','2018-08-29','2018-08-29','','2018-08-29 09:25:00'),(5,1,'V','1','0','2018-08-29','2018-08-29','','2018-08-29 09:25:00'),(6,1,'買菜','1','0','2018-08-29','2018-08-29','','2018-08-29 09:39:08'),(7,1,'購物','1','0','2018-08-29','2018-08-29','','2018-08-29 09:39:08');
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `session_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `session_title` text NOT NULL,
  `session_date` date NOT NULL,
  `session_start_time` time NOT NULL,
  `session_end_time` time NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY (`session_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjobs`
--

DROP TABLE IF EXISTS `subjobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subjobs` (
  `subjob_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `parent_job_id` bigint(20) unsigned NOT NULL,
  `subjob_title` text NOT NULL,
  `subjob_priority` enum('0','1','2') NOT NULL DEFAULT '1',
  `subjob_status` enum('0','1','2','3') NOT NULL,
  `subjob_start_date` date NOT NULL,
  `subjob_end_date` date NOT NULL,
  `subjob_description` text NOT NULL,
  `created_datetime` datetime NOT NULL,
  PRIMARY KEY (`subjob_id`),
  UNIQUE KEY `user_job_id` (`subjob_id`,`parent_job_id`),
  KEY `job_subjob_relation` (`parent_job_id`),
  CONSTRAINT `job_subjob_relation` FOREIGN KEY (`parent_job_id`) REFERENCES `jobs` (`job_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjobs`
--

LOCK TABLES `subjobs` WRITE;
/*!40000 ALTER TABLE `subjobs` DISABLE KEYS */;
INSERT INTO `subjobs` VALUES (1,1,2,'作夢','1','0','2018-02-17','2018-02-18','','2018-02-13 02:49:01');
/*!40000 ALTER TABLE `subjobs` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-26  3:40:27
