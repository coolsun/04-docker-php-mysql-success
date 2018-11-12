-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: friend_social
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
-- Current Database: `friend_social`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `friend_social` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `friend_social`;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_body` text CHARACTER SET utf8 NOT NULL,
  `posted_by` varchar(60) CHARACTER SET utf8 NOT NULL,
  `posted_to` varchar(60) CHARACTER SET utf8 NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) CHARACTER SET utf8 NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comments`
--

LOCK TABLES `comments` WRITE;
/*!40000 ALTER TABLE `comments` DISABLE KEYS */;
INSERT INTO `comments` VALUES (1,'123\r\n','??_admin01','??_admin01','2018-09-20 06:20:43','no',68),(2,'...','??_admin01','??_admin01','2018-09-20 06:22:41','no',68),(3,'ddd','測試_admin01','測試_admin01','2018-09-20 06:24:31','no',68),(4,'測試','123_test','123_test','2018-09-24 22:28:54','no',69),(5,'???','123_test','123_test','2018-09-25 02:04:33','no',71),(6,'rt','123_test','123_test','2018-09-25 02:14:06','no',71),(7,'皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。\r\n大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。\r\n為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。\r\n\r\n南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。 \r\n','123_test','123_test','2018-09-25 02:43:23','no',90),(8,'aaaa','123_test','123_test','2018-09-25 02:43:58','no',90),(9,'sf','123_test','123_test','2018-09-25 04:39:10','no',69);
/*!40000 ALTER TABLE `comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friend_requests`
--

DROP TABLE IF EXISTS `friend_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_from` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friend_requests`
--

LOCK TABLES `friend_requests` WRITE;
/*!40000 ALTER TABLE `friend_requests` DISABLE KEYS */;
INSERT INTO `friend_requests` VALUES (32,'123_test',''),(33,'測試_admin01',''),(34,'測試_admin01',''),(35,'測試_admin01',''),(36,'測試_admin01',''),(37,'測試_admin01',''),(38,'123_test',''),(39,'測試_admin01','13'),(40,'123_test',''),(41,'123_test',''),(42,'測試_admin01','123_test'),(43,'測試_admin01','123_test'),(44,'123_test','測試_admin01');
/*!40000 ALTER TABLE `friend_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `likes`
--

DROP TABLE IF EXISTS `likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) CHARACTER SET utf8 NOT NULL,
  `post_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `likes`
--

LOCK TABLES `likes` WRITE;
/*!40000 ALTER TABLE `likes` DISABLE KEYS */;
INSERT INTO `likes` VALUES (65,'123_test',69),(66,'123_test',89);
/*!40000 ALTER TABLE `likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_to` varchar(50) CHARACTER SET utf8 NOT NULL,
  `user_from` varchar(50) CHARACTER SET utf8 NOT NULL,
  `message` text CHARACTER SET ucs2 NOT NULL,
  `link` varchar(100) CHARACTER SET utf8 NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) CHARACTER SET utf8 NOT NULL,
  `viewed` varchar(3) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,'??_admin01','??_admin01','?㼠䅤浩渰ㄠ捯浭敮瑥搠潮⁡⁰潳琠祯甠捯浭敮瑥搠潮','post.php?id=68','2018-09-20 06:20:43','no','no'),(2,'??_admin01','??_admin01','?㼠䅤浩渰ㄠ捯浭敮瑥搠潮⁡⁰潳琠祯甠捯浭敮瑥搠潮','post.php?id=68','2018-09-20 06:22:41','no','no'),(3,'??_admin01','??_admin01','?㼠䅤浩渰ㄠ捯浭敮瑥搠潮⁡⁰潳琠祯甠捯浭敮瑥搠潮','post.php?id=68','2018-09-20 06:24:31','no','no');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `body` text CHARACTER SET utf8 NOT NULL,
  `added_by` varchar(60) CHARACTER SET utf8 NOT NULL,
  `user_to` varchar(60) CHARACTER SET utf8 NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) CHARACTER SET utf8 NOT NULL,
  `deleted` varchar(3) CHARACTER SET utf8 NOT NULL,
  `likes` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (66,21,'zsdf','測試_admin01','none','2018-09-19 07:33:45','no','no',0),(67,21,'zsdf','測試_admin01','none','2018-09-19 07:33:46','no','no',0),(68,21,'fsdf','測試_admin01','none','2018-09-19 07:33:48','no','no',0),(69,22,'yoyooyoyoyooy','123_test','none','2018-09-21 03:08:02','no','no',1),(70,22,'皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。<br /> 大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。<br /> 為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。<br /> <br /> 南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。','123_test','none','2018-09-24 23:11:33','no','yes',0),(72,22,'皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。<br /> 大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。<br /> 為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。<br /> <br /> 南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。','123_test','none','2018-09-24 23:14:08','no','yes',0),(73,22,'皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。<br /> 大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。<br /> 為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。<br /> <br /> 南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。','123_test','none','2018-09-24 23:14:39','no','yes',0),(74,22,'皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。<br /> 大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。<br /> 為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。<br /> <br /> 南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。','123_test','none','2018-09-24 23:14:44','no','yes',0),(75,22,'test','123_test','none','2018-09-25 01:49:59','no','yes',0),(76,22,'test','123_test','none','2018-09-25 01:50:08','no','yes',0),(77,22,'test','123_test','none','2018-09-25 01:50:12','no','yes',0),(78,22,'test','123_test','none','2018-09-25 01:50:19','no','yes',0),(79,22,'test','123_test','none','2018-09-25 01:50:37','no','yes',0),(80,22,'test','123_test','none','2018-09-25 01:50:56','no','yes',0),(81,22,'test','123_test','none','2018-09-25 01:51:01','no','yes',0),(82,22,'test','123_test','none','2018-09-25 01:51:28','no','yes',0),(83,22,'test','123_test','none','2018-09-25 01:51:36','no','yes',0),(84,22,'test','123_test','none','2018-09-25 01:51:41','no','yes',0),(85,22,'test','123_test','none','2018-09-25 01:51:55','no','yes',0),(86,22,'test','123_test','none','2018-09-25 01:52:07','no','yes',0),(89,22,'ttt','123_test','none','2018-09-25 02:11:00','no','no',1),(90,22,'ttt','123_test','none','2018-09-25 02:11:46','no','no',0),(94,22,'çšˆä¾ä¸‰å¯¶ï¼Œçšˆä¾å¤§æ‚²æ¸¡ä¸–çš„è§€ä¸–éŸ³è©è–©ï¼Œä¸–é–“æ„Ÿå—ä¸€åˆ‡ææ€–ç—…è‹¦çš„çœ¾ç”Ÿï¼Œè¦èª“é¡˜å®£èªªå»£å¤§åœ“æ»¿ç„¡ç¤™å¤§æ‚²æ•‘è‹¦æ•‘é›£çš„çœŸè¨€ï¼Œè¦çœ‹ç ´ç”Ÿæ­»ç…©æƒ±ï¼Œäº†æ‚ŸçœŸå¯¦å…‰æ˜Žï¼Œçšˆä¾æ–¼å¤§æ…ˆå¤§æ‚²ã€éš¨å¿ƒè‡ªåœ¨çš„è§€ä¸–è©è–©ã€‚ç¥ˆæ±‚ä¸€åˆ‡åœ“æ»¿ï¼Œä¸å—ä¸€åˆ‡é¬¼å’çš„ä¾µå®³ï¼Œçšˆå‘½æ–¼ç‚ºè§€ä¸–éŸ³è©è–©è«‹èªªå»£å¤§åœ“æ»¿ç„¡ç¤™å¤§æ‚²å¿ƒé™€ç¾…å°¼çš„æœ¬å°Šï¼åƒå…‰çŽ‹éœä½å¦‚ä¾†ã€‚èƒ½å¾—æ¸…æ·¨åœ“æ˜Žçš„å…‰è¼ï¼Œèƒ½é™¤ç„¡æ˜Žç½£ç¤™çš„ç…©æƒ±ï¼Œè¦ä¿®å¾—ç„¡ä¸Šçš„åŠŸå¾·ï¼Œæ–¹ä¸è‡´æ²ˆæ·ªåœ¨ç„¡é‚ŠåŸ·è‘—çš„è‹¦æµ·ä¹‹ä¸­ã€‚<br /> å¤§æ…ˆå¤§æ‚²çš„è§€ä¸–éŸ³è©è–©ï¼Œå¸¸ä»¥è«¸ä½›è©è–©çš„åŒ–èº«ï¼Œæ‚ æ¸¸æ–¼å¤§åƒä¸–ç•Œï¼Œå¯†æ”¾ç¥žé€šï¼Œéš¨ç·£åŒ–æ¸¡ï¼Œä¸€å¦‚è©è–©é¡¯åŒ–çš„ç…å­çŽ‹æ³•èº«ï¼Œå¼•å°Žæœ‰ç·£çœ¾ç”Ÿé é›¢ç½ªæƒ¡ï¼Œå¿˜å»ç”Ÿæ­»ç…©æƒ±ï¼Œçšˆå‘çœŸå¯¦å…‰æ˜Žã€‚å¤§æ…ˆå¤§æ‚²çš„è§€ä¸–éŸ³è©è–©ä»¥æ¸…æ·¨ç„¡åž¢è–æ½”è“®è¯çš„æ³•èº«ï¼Œé †æ™‚é †æ•™ï¼Œä½¿çœ¾ç”Ÿäº†æ‚Ÿä½›å› ï¼Œå¤§æ…ˆå¤§æ‚²çš„è§€ä¸–éŸ³è©è–©ï¼Œå°æ–¼æµå¸ƒæ¯’å®³çœ¾ç”Ÿçš„è²ªã€çž‹ã€ç™¡ä¸‰é­”ï¼Œæ›´ä»¥åš´å³»å¤§åŠ›çš„æ³•èº«äºˆä»¥é™ä¼ï¼Œä½¿ä¿®æŒçœ¾ç”Ÿå¾—èƒ½æ¸…æ·¨ï¼Œè©è–©æ›´ä»¥æ¸…æ·¨è“®è¯ï¼Œé¡¯ç¾æ…ˆæ‚²ï¼Œæšç‘ç”˜éœ²ï¼Œæ•‘æ¸¡çœ¾ç”Ÿè„«é›¢è‹¦é›£ã€‚åªæ˜¯å¨‘å©†ä¸–ç•Œçœ¾ç”Ÿï¼Œå¸¸ç¿’æ–¼åæƒ¡ä¹‹è‹¦ï¼Œä¸çŸ¥è‡ªè¦ºï¼Œä¸è‚¯è„«é›¢ï¼Œä½¿è¡Œè«¸åˆ©æ¨‚çš„è©è–©ï¼Œå¸¸è¦å¿å—æ€¨å«‰ç…©æƒ±ã€‚ç„¶è€Œè©è–©æ…ˆæ‚²ï¼Œç‚ºæ•‘çœ¾ç”Ÿç™¡è¿·ï¼Œå¾©é¡¯åŒ–æ˜ŽçŽ‹æ³•èº«ï¼Œä»¥ç„¡ä¸Šæ™ºæ…§ç ´è§£ç…©æƒ±æ¥­éšœï¼Œé é›¢ä¸€åˆ‡ææ€–å±é›£ã€‚å¤§æ…ˆå¤§æ‚²è§€ä¸–éŸ³è©è–©é¡¯åŒ–ä¹‹è«¸èˆ¬æ³•ç›¸ï¼Œå¸¸åœ¨çœ¾ç”Ÿä¹‹ä¸­ï¼Œéš¨ç·£éš¨ç¾ï¼Œä½¿çœ¾ç”Ÿæ†¶ä½›å¿µä½›ï¼Œè¿·é€”çŸ¥æ‚Ÿã€‚<br /> ç‚ºä½¿çœ¾ç”Ÿæ—©æ—¥çšˆä¾æ­¡å–œåœ“æ»¿ï¼Œç„¡ç‚ºè™›ç©ºçš„æ¶…ç›¤ä¸–ç•Œï¼Œè©è–©å¾©è¡Œå¤§æ…ˆå¤§æ‚²çš„èª“é¡˜ï¼Œæ‰‹æŒå¯¶å¹¢ï¼Œå¤§æ”¾å…‰æ˜Žï¼Œæ¸¡åŒ–çœ¾ç”Ÿé€šé”ä¸€åˆ‡æ³•é–€ï¼Œä½¿çœ¾ç”Ÿéš¨è¡Œç›¸æ‡‰ï¼Œè‡ªç”±è‡ªåœ¨å¾—åˆ°ç„¡ä¸Šæˆå°±ã€‚è©è–©çš„ç„¡é‡ä½›æ³•ï¼Œå»£è¢«å¤§çœ¾ï¼Œæ°ä¼¼æ³•èžºå‚³è²ï¼Œä½¿è«¸å¤©å–„ç¥žå‡ç¾æ­¡å–œå½±ç›¸ï¼Œäº¦ä½¿çœ¾ç”Ÿæ–¼è½èžä½›æ³•ä¹‹å¾Œï¼Œèƒ½ç½ªéšœæ»…é™¤ï¼Œå„å¾—æˆå°±ã€‚ä¸ç®¡æ˜¯è±¬é¢ã€ç…é¢ï¼Œä¸ç®¡æ˜¯å–„é¢ã€æƒ¡é¢ï¼Œå‡¡èƒ½å—æ­¤æŒ‡å¼•ï¼Œéƒ½èƒ½å¾—è«¸æˆå°±ï¼Œå³ä½¿ä½ä¸–ä¹‹é»‘è‰²å¡µé­”ï¼Œè©è–©äº¦ä»¥é¡¯åŒ–ä¹‹å¤§å‹‡æ³•ç›¸ï¼ŒæŒæ–æŒ‡å¼•ï¼Œæ¸¡å…¶çšˆä¾ä¸‰å¯¶ã€‚<br /> <br /> å—ç„¡å¤§æ…ˆå¤§æ‚²è–è§€ä¸–éŸ³è©è–©ï¼Œé¡˜èª å¿ƒèª¦æŒæ­¤çœŸè¨€è€…ï¼Œçš†å¾—æ¶…ç›¤ã€‚ ','123_test','none','2018-09-25 16:44:54','no','no',0);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trends`
--

DROP TABLE IF EXISTS `trends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trends` (
  `title` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trends`
--

LOCK TABLES `trends` WRITE;
/*!40000 ALTER TABLE `trends` DISABLE KEYS */;
INSERT INTO `trends` VALUES ('Yoyooyoyoyooy',1),('Br',24),('Test',12),('Deletebr',2),('Ttt',5);
/*!40000 ALTER TABLE `trends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_details`
--

DROP TABLE IF EXISTS `user_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `introduction` varchar(255) DEFAULT NULL,
  `location` varchar(50) DEFAULT NULL,
  `relation_status` varchar(20) DEFAULT NULL,
  `school1` varchar(50) DEFAULT NULL,
  `concentration1` varchar(50) DEFAULT NULL,
  `school2` varchar(50) DEFAULT NULL,
  `concentration2` varchar(50) DEFAULT NULL,
  `workplace1` varchar(50) DEFAULT NULL,
  `workplace2` varchar(50) DEFAULT NULL,
  `music` varchar(50) DEFAULT NULL,
  `book` varchar(50) DEFAULT NULL,
  `movie` varchar(50) DEFAULT NULL,
  `food` varchar(50) DEFAULT NULL,
  `travel` varchar(50) DEFAULT NULL,
  `activity` varchar(50) DEFAULT NULL,
  `exercise` varchar(50) DEFAULT NULL,
  `others` varchar(255) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_details`
--

LOCK TABLES `user_details` WRITE;
/*!40000 ALTER TABLE `user_details` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `last_name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(25) CHARACTER SET utf8 NOT NULL,
  `username` varchar(100) CHARACTER SET utf8 NOT NULL,
  `gender` varchar(1) CHARACTER SET utf8 NOT NULL,
  `birthday` varchar(20) CHARACTER SET utf8 NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) CHARACTER SET utf8 NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) CHARACTER SET utf8 NOT NULL,
  `friend_array` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (21,'admin01','18c6d818ae35a3e8279b5330eda01498','Admin01','測試','測試_admin01','男','2001-4-28','2018-09-18','assets/images/profile_pics/defaults/head_emerald.png',6,0,'no',','),(22,'test123@gmail.com','cc03e747a6afbbcbf8be7668acfebee5','Test','123','123_test','男','2002-4-1','2018-09-18','assets/images/profile_pics/123_test83d192f57ad7fed8686598249d8acd0fn.jpeg',26,2,'no',',');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-26  3:40:47
