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
-- Database: `success_friend`
--
CREATE DATABASE IF NOT EXISTS `success_friend` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `success_friend`;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `user_id`, `post_id`) VALUES
(12, 22, 19),
(13, 22, 18),
(14, 22, 17),
(16, 22, 6),
(17, 22, 16),
(18, 22, 11),
(19, 22, 12),
(20, 21, 18),
(21, 22, 19),
(22, 22, 127),
(23, 22, 142),
(24, 22, 141),
(25, 22, 146);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_body` text NOT NULL,
  `posted_by` varchar(60) NOT NULL,
  `posted_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `removed` varchar(3) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `post_body`, `posted_by`, `posted_to`, `date_added`, `removed`, `post_id`) VALUES
(1, '123\r\n', '??_admin01', '??_admin01', '2018-09-20 06:20:43', 'no', 68),
(2, '...', '??_admin01', '??_admin01', '2018-09-20 06:22:41', 'no', 68),
(3, 'ddd', '測試_admin01', '測試_admin01', '2018-09-20 06:24:31', 'no', 68),
(4, '測試', '123_test', '123_test', '2018-09-24 22:28:54', 'no', 69),
(5, '???', '123_test', '123_test', '2018-09-25 02:04:33', 'no', 71),
(6, 'rt', '123_test', '123_test', '2018-09-25 02:14:06', 'no', 71),
(7, '皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。\r\n大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。\r\n為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。\r\n\r\n南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。 \r\n', '123_test', '123_test', '2018-09-25 02:43:23', 'no', 90),
(8, 'aaaa', '123_test', '123_test', '2018-09-25 02:43:58', 'no', 90),
(9, 'sf', '123_test', '123_test', '2018-09-25 04:39:10', 'no', 69),
(10, 'dtryudtry', '123_test', '測試_admin01', '2018-10-04 16:41:32', 'no', 11),
(11, 'abc\r\n', 'test123', 'test123', '2018-11-10 18:03:11', 'no', 141);

-- --------------------------------------------------------

--
-- Table structure for table `fanpages`
--

CREATE TABLE `fanpages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `intro` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `member_array` text NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `date` varchar(20) NOT NULL,
  `create_date` date NOT NULL,
  `closed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fanpages`
--

INSERT INTO `fanpages` (`id`, `user_id`, `name`, `intro`, `contact`, `num_likes`, `member_array`, `profile_pic`, `date`, `create_date`, `closed`) VALUES
(1, 22, '測試更新', '測試更新', '測試更新', 1, ',21,22,', 'assets/images/profile_pics/測試更新e0fe1035fe02f3774d7b6a3406b274cfn.jpeg', '2018年2月3日', '2018-11-01', 'no'),
(2, 22, 'second', '', '', 1, ',', 'assets/images/profile_pics/defaults/default.png', '', '2018-11-01', 'no'),
(3, 24, 'e5y', 'eeeey', 'e6yye', 0, ',', 'assets/images/profile_pics/defaults/default.png', '2016年2月3日', '2018-11-06', 'no'),
(4, 24, 'awet', 'awet', 'atwet', 0, ',', 'assets/images/profile_pics/defaults/default.png', '2017年3月3日', '2018-11-06', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `fanpage_likes`
--

CREATE TABLE `fanpage_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fanpage_likes`
--

INSERT INTO `fanpage_likes` (`id`, `user_id`, `group_id`) VALUES
(41, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fanpage_messages`
--

CREATE TABLE `fanpage_messages` (
  `id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `statuses` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `statuses`, `created_at`, `updated_at`) VALUES
(31, 22, 21, '', '2018-11-01 07:59:57', '2018-11-01 07:59:57'),
(32, 21, 22, '', '2018-11-01 07:59:57', '2018-11-01 07:59:57');

-- --------------------------------------------------------

--
-- Table structure for table `friend_requests`
--

CREATE TABLE `friend_requests` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_to_Name` varchar(100) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `user_from_Name` varchar(100) NOT NULL,
  `user_from_Pic` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `gallery_name` varchar(100) NOT NULL,
  `gallery_create_time` datetime NOT NULL,
  `gallery_description` varchar(200) NOT NULL,
  `gallery_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `user_id`, `gallery_name`, `gallery_create_time`, `gallery_description`, `gallery_path`) VALUES
(1, '22', 'test', '2018-11-01 11:57:50', '', './album/gallery/test3fff983dcfe57ca86f7014d1305d3860Chrysanthemum .jpg'),
(2, '22', 'test', '2018-11-01 11:57:50', '', './album/gallery/test3fff983dcfe57ca86f7014d1305d3860Desert.jpg'),
(3, '22', 'test', '2018-11-01 12:01:08', '', './album/gallery/test74d6d661bde7767fd77d9b3eb40da57aDesert.jpg'),
(4, '22', 'eee', '2018-11-01 12:02:09', '', './album/gallery/eee099f974f97f02bbb302d3bc7fea022c6Desert.jpg'),
(5, '22', 'test', '2018-11-01 13:34:48', '', './album/gallery/testb7ae429cc8a7eaba0b1ce88fa906b540skype.png'),
(6, '22', 'eee', '2018-11-01 13:35:16', '', './album/gallery/eeeefacf25e8ea58b058aa697975a67b12bChrysanthemum .jpg'),
(7, '21', 'test', '2018-11-01 14:20:44', '', './album/gallery/testd2d808957abc15ff42e35ba59684c182Chrysanthemum .jpg'),
(8, '21', 'test', '2018-11-01 14:20:44', '', './album/gallery/testd2d808957abc15ff42e35ba59684c182yahoo.png'),
(9, '21', 'test', '2018-11-01 14:47:35', '', './album/gallery/teste3cf1a944bc2504c56e1c264b1f8f4b0擷取2.PNG'),
(10, '22', 'qwertyu', '2018-11-01 16:25:58', '', './album/gallery/qwertyu9fdb3dcdc009ac77ec1fe853d8cfc83eDesert.jpg'),
(11, '22', 'qwertyu', '2018-11-01 16:25:58', '', './album/gallery/qwertyu9fdb3dcdc009ac77ec1fe853d8cfc83eDesert.jpg'),
(12, '22', 'eee', '2018-11-01 16:27:44', '', './album/gallery/eee646f42911beaf1209e086eb06b1f1d13Chrysanthemum .jpg'),
(13, '22', 'qwertyu', '2018-11-01 16:31:13', '', './album/gallery/qwertyucd2277133ba1f01f799ce877ee926823aasad.PNG'),
(14, '22', 'eee', '2018-11-01 16:32:48', '', './album/gallery/eeeb5297ce29c2e63a1f64e2a6c83681057Desert.jpg'),
(15, '22', 'qwe', '2018-11-01 16:33:05', '', './album/gallery/qweccc6c5cc7c8d3426f2764ce3acd4b10943284906_714566882275304_8740883657159344128_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `username`, `post_id`) VALUES
(65, '123_test', 69),
(66, '123_test', 89),
(67, '123_test', 11),
(68, 'test123', 140),
(70, 'test123', 141),
(71, 'test123', 138),
(72, 'test123', 137),
(73, 'test123', 147);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `body` text NOT NULL,
  `date` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_to`, `user_from`, `body`, `date`, `opened`, `viewed`, `deleted`) VALUES
(1, 'test123', '唐若秦', '.', '2018-10-26 09:02:21', 'yes', 'no', 'no'),
(2, 'test123', '唐若秦', '.', '2018-10-26 09:02:22', 'yes', 'no', 'no'),
(3, '唐若秦', 'test123', '>', '2018-10-26 09:05:23', 'yes', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_to` varchar(50) NOT NULL,
  `user_from` varchar(50) NOT NULL,
  `message` text CHARACTER SET ucs2 NOT NULL,
  `link` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `opened` varchar(3) NOT NULL,
  `viewed` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_to`, `user_from`, `message`, `link`, `datetime`, `opened`, `viewed`) VALUES
(1, '??_admin01', '??_admin01', '?㼠䅤浩渰ㄠ捯浭敮瑥搠潮⁡⁰潳琠祯甠捯浭敮瑥搠潮', 'post.php?id=68', '2018-09-20 06:20:43', 'no', 'no'),
(2, '??_admin01', '??_admin01', '?㼠䅤浩渰ㄠ捯浭敮瑥搠潮⁡⁰潳琠祯甠捯浭敮瑥搠潮', 'post.php?id=68', '2018-09-20 06:22:41', 'no', 'no'),
(3, '??_admin01', '??_admin01', '?㼠䅤浩渰ㄠ捯浭敮瑥搠潮⁡⁰潳琠祯甠捯浭敮瑥搠潮', 'post.php?id=68', '2018-09-20 06:24:31', 'no', 'no'),
(4, '測試_admin01', '123_test', '123 Test liked your post', 'post.php?id=11', '2018-10-04 16:40:41', 'no', 'no'),
(5, '測試_admin01', '123_test', '123 Test commented on your post', 'post.php?id=11', '2018-10-04 16:41:32', 'no', 'no'),
(6, 'test123', 'ttttest', 'ttttest liked your post', 'post.php?id=18', '2018-10-29 15:10:22', 'no', 'no'),
(7, 'test123', 'ttttest', 'ttttest liked your post', 'post.php?id=18', '2018-10-29 15:10:24', 'no', 'no'),
(8, 'ttttest', 'test123', 'test123 liked your post', 'post.php?id=34', '2018-11-02 17:32:26', 'no', 'no'),
(9, 'ttttest', 'test123', 'test123 liked your post', 'post.php?id=139', '2018-11-09 12:02:01', 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `user_id` varchar(100) NOT NULL,
  `album_id` int(11) DEFAULT NULL,
  `album_name` varchar(100) NOT NULL,
  `photo_name` varchar(200) NOT NULL,
  `create_time` datetime NOT NULL,
  `album_description` varchar(200) NOT NULL,
  `album_path` varchar(200) NOT NULL,
  `photo_path` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `user_id`, `album_id`, `album_name`, `photo_name`, `create_time`, `album_description`, `album_path`, `photo_path`) VALUES
(2, '21', NULL, '', 'yahoo.png', '2018-11-01 14:30:07', '', '', './album/photos/f0720b0d2e55043a5d24f00f47155279yahoo.png'),
(3, '22', NULL, '', 'aasad.PNG', '2018-11-01 16:36:25', '', '', './album/photos/713ea478eedf9dc0b89a24a7de89c395aasad.PNG');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL,
  `body` text NOT NULL,
  `added_by` varchar(60) NOT NULL,
  `user_to` varchar(60) NOT NULL,
  `date_added` datetime NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `deleted` varchar(3) NOT NULL,
  `likes` int(11) NOT NULL,
  `shares` int(11) NOT NULL,
  `collections` int(11) NOT NULL,
  `image` varchar(500) NOT NULL,
  `position` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `page_id`, `body`, `added_by`, `user_to`, `date_added`, `user_closed`, `deleted`, `likes`, `shares`, `collections`, `image`, `position`) VALUES
(6, 22, 0, 'Sorry, we need the PHP debug logs, as I mentioned above, please try enable PHP debugging, like this:<br /> In case you think that Types or Views are doing something wrong (what we call a bug), you should enable PHP error logging. Again, edit your wp-config.php file and add the following:<br /> <br /> ini_set(\'log_errors\',TRUE);<br /> ini_set(\'error_reporting\', E_ALL);<br /> ini_set(\'error_log\', dirname(__FILE__) . \'/error_log.txt\');<br /> This will produce a file called ‘error_log.txt’ in your WordPress root directory. Make sure that the web server can create and write this file. If it cannot, use an FTP program to create the file and make it writable to Apache (normally, user www-data).', 'test123', 'none', '2018-10-04 09:16:04', 'no', 'no', 0, 0, 1, '', 'none'),
(7, 24, 0, '當您開始使用 Google 服務，即表示您信賴我們對您個人資訊的處理方式。我們深知這份責任重大，因此會盡力保護您的資訊，並為您提供相關的管理功能。<br /> <br /> 本《隱私權政策》旨在協助您瞭解 Google 收集的資訊類型以及收集這些資訊的原因，也說明了您可以如何更新、管理、匯出與刪除資訊。<br /> <br /> 生效日：2018年5月25日 | 封存版本 | 下載 PDF', 'ttttest', 'none', '2018-10-04 09:16:45', 'no', 'no', 0, 0, 0, '', 'none'),
(8, 24, 0, '皈依三寶，皈依大悲渡世的觀世音菩薩，世間感受一切恐怖病苦的眾生，要誓願宣說廣大圓滿無礙大悲救苦救難的真言，要看破生死煩惱，了悟真實光明，皈依於大慈大悲、隨心自在的觀世菩薩。祈求一切圓滿，不受一切鬼卒的侵害，皈命於為觀世音菩薩請說廣大圓滿無礙大悲心陀羅尼的本尊－千光王靜住如來。能得清淨圓明的光輝，能除無明罣礙的煩惱，要修得無上的功德，方不致沈淪在無邊執著的苦海之中。 大慈大悲的觀世音菩薩，常以諸佛菩薩的化身，悠游於大千世界，密放神通，隨緣化渡，一如菩薩顯化的獅子王法身，引導有緣眾生遠離罪惡，忘卻生死煩惱，皈向真實光明。大慈大悲的觀世音菩薩以清淨無垢聖潔蓮華的法身，順時順教，使眾生了悟佛因，大慈大悲的觀世音菩薩，對於流布毒害眾生的貪、瞋、癡三魔，更以嚴峻大力的法身予以降伏，使修持眾生得能清淨，菩薩更以清淨蓮華，顯現慈悲，揚灑甘露，救渡眾生脫離苦難。只是娑婆世界眾生，常習於十惡之苦，不知自覺，不肯脫離，使行諸利樂的菩薩，常要忍受怨嫉煩惱。然而菩薩慈悲，為救眾生癡迷，復顯化明王法身，以無上智慧破解煩惱業障，遠離一切恐怖危難。大慈大悲觀世音菩薩顯化之諸般法相，常在眾生之中，隨緣隨現，使眾生憶佛念佛，迷途知悟。 為使眾生早日皈依歡喜圓滿，無為虛空的涅盤世界，菩薩復行大慈大悲的誓願，手持寶幢，大放光明，渡化眾生通達一切法門，使眾生隨行相應，自由自在得到無上成就。菩薩的無量佛法，廣被大眾，恰似法螺傳聲，使諸天善神均現歡喜影相，亦使眾生於聽聞佛法之後，能罪障滅除，各得成就。不管是豬面、獅面，不管是善面、惡面，凡能受此指引，都能得諸成就，即使住世之黑色塵魔，菩薩亦以顯化之大勇法相，持杖指引，渡其皈依三寶。 南無大慈大悲聖觀世音菩薩，願誠心誦持此真言者，皆得涅盤。', 'ttttest', 'none', '2018-10-04 09:17:02', 'no', 'no', 0, 0, 0, '', 'none'),
(9, 22, 0, ' 相信很多人寫php利用mysql資料庫時常會遇到亂碼問題，我也不例外，網路上教學文很多，需要了解原理的請自行google一下。 進入主題，這次遇到的事件是將.sql匯入資料庫後，phpmyadmin裡中文顯示正常，但是透過php撈出資料呈現在網頁上卻是一堆問號，經過google以後確認應該要在連結資料庫之後，讀取資料之前，加入 mysql_query("SET NAMES UTF8"); 這段語法，原因我也說不上來，請參考此站說明。重點來了，我的資料庫是用mysqli_query去連結執行，而非mysql_query，有發現差別嗎？就差一個英文字i，就"深入淺出 PHP 與 MySQL"這本書後面附錄所說，兩者差別不大，而且只有資料量大才會顯示出其差別，但是要記得，語法也有所不同，mysqli_query則需寫成 mysqli_query(連結名稱,"SET CHARACTER SET UTF8"); ，希望跟我遇到一樣問題的人可以看到這篇文章，減少許多冤枉路。', 'test123', 'none', '2018-10-04 09:17:35', 'no', 'no', 0, 0, 0, '', 'none'),
(10, 22, 0, '強颱康芮持續逼近，天氣風險公司天氣分析師吳聖宇在臉書「天氣職人—吳聖宇」說明，颱風強度已經達到顛峰，最近幾個小時的掃瞄雲圖清楚可見雙眼牆的結構，加上接下來颱風路徑將經過潭美颱風遺留的冷水坑，OHC相當低，對於強度發展不利，預估今晚之後強度將逐漸減弱，靠近台灣時為中度颱風等級。 吳聖宇表示，由目前高壓實際的強度來看，颱風路徑預估仍將通過宮古島附近後逐漸北轉，略偏西的話有機會經過宮古島到石垣島之間的海域，依照CWB下午所給出的預報路徑，暴風圈邊緣仍可能略過海上警報發布線，是否發布颱風警報仍值得觀察。如果需要發布颱風警報的話，時間點可能落在周四清晨。由於雙眼牆結構的關係，颱風移動過程會有忽西忽北擺動的狀況，大方向還是以西北為主，短時間的擺動不太會造成明顯的路徑改變。 吳聖宇表示，颱風移動速度比預期要來得快，顯示引導氣流還算明顯，明天周三起外圍環流雲層水氣接近，迎風面北部、東北部、東部逐漸有短暫陣雨，周四、周五受颱風外圍環流影響，北部、東北部、東部持續有陣雨，山區有較大雨勢或較大累積雨量，沿海有強陣風，中南部及東南部受影響較為有限，由於速度快，最接近台灣的時間點將提前到周五白天期間，週五晚間後開始逐漸遠離，周末期間（6至7日）颱風遠離，較乾燥北風接手，天氣預估較為穩定，但是海邊海上風浪仍大，海邊活動不宜。', 'test123', 'none', '2018-10-04 09:18:04', 'no', 'no', 0, 0, 0, '', 'none'),
(11, 21, 0, '22,1 22,1 24,0 24,0 22,1', 'admin01測試', 'none', '2018-10-04 12:27:52', 'no', 'no', 1, 1, 1, '', 'none'),
(12, 22, 0, 'wet', 'test123', 'none', '2018-10-11 15:42:58', 'no', 'no', 0, 0, 1, '', 'none'),
(14, 22, 0, 'test', 'test123', 'none', '2018-10-11 15:57:04', 'no', 'no', 0, 0, 0, '', 'none'),
(15, 22, 0, 'aa', 'test123', 'none', '2018-10-11 15:59:58', 'no', 'no', 0, 0, 0, '', 'none'),
(16, 24, 0, 'hi', 'ttttest', 'none', '2018-10-17 16:42:35', 'no', 'no', 0, 1, 1, '', 'none'),
(17, 22, 0, '1<br /> 2', 'test123', 'none', '2018-10-25 11:21:32', 'no', 'no', 0, 0, 1, '', 'none'),
(18, 22, 0, '???', 'test123', 'none', '2018-10-25 16:11:37', 'no', 'no', 0, 0, 2, '', 'none'),
(19, 31, 0, ';k<br /> 妳好!', '唐若秦', 'none', '2018-10-25 18:29:04', 'no', 'no', 0, 0, 2, '', 'none'),
(20, 22, 0, '<br><iframe width=\'420\' height=\'315\' src=\'https://www.youtube.com/embed/8SbUC-UaAxE\'></iframe><br>', 'test123', 'none', '2018-11-02 15:24:18', 'no', 'no', 0, 0, 0, '', 'none'),
(21, 22, 0, 'test', 'test123', 'none', '2018-11-02 15:55:42', 'no', 'no', 0, 0, 0, '', 'none'),
(22, 22, 0, 'test', 'test123', 'none', '2018-11-02 16:00:52', 'no', 'no', 0, 0, 0, '', 'none'),
(23, 22, 0, 'de', 'test123', 'none', '2018-11-02 16:04:45', 'no', 'no', 0, 0, 0, 'assets/images/posts/5bdc051d1314743284906_714566882275304_8740883657159344128_n.jpg', 'none'),
(24, 22, 0, 'ew', 'test123', 'none', '2018-11-02 16:13:33', 'no', 'no', 0, 0, 0, 'assets/images/posts/5bdc072ddb1c1Desert.jpg', 'none'),
(25, 22, 0, 'https://stackoverflow.com/questions/22292410/open-the-file-upload-dialogue-box-onclick-the-image', 'test123', 'none', '2018-11-02 16:17:38', 'no', 'no', 0, 0, 0, '', 'none'),
(26, 22, 0, 'hi', 'test123', 'none', '2018-11-02 16:46:52', 'no', 'no', 0, 0, 0, '', 'none'),
(27, 22, 0, '?', 'test123', 'none', '2018-11-02 16:51:39', 'no', 'no', 0, 0, 0, '', 'none'),
(28, 22, 0, '?', 'test123', 'none', '2018-11-02 16:53:05', 'no', 'no', 0, 0, 0, '', 'none'),
(29, 22, 0, 'a', 'test123', 'none', '2018-11-02 16:55:18', 'no', 'no', 0, 0, 0, '', 'none'),
(30, 22, 0, '?', 'test123', 'none', '2018-11-02 16:56:26', 'no', 'no', 0, 0, 0, '', 'none'),
(31, 22, 0, 'e', 'test123', 'none', '2018-11-02 16:58:18', 'no', 'no', 0, 0, 0, '', 'none'),
(32, 22, 0, 'eee', 'test123', 'none', '2018-11-02 17:00:23', 'no', 'no', 0, 0, 0, '', 'none'),
(33, 22, 0, '?', 'test123', 'none', '2018-11-02 17:13:59', 'no', 'no', 0, 0, 0, '', 'none'),
(34, 22, 0, 'eeet', 'test123', 'ttttest', '2018-11-02 17:32:26', 'no', 'no', 0, 1, 0, '', 'none'),
(35, 22, 1, 'hi', 'test123', 'none', '2018-11-04 16:46:30', 'no', 'no', 0, 0, 0, '', 'none'),
(36, 22, 0, 'yrt', 'test123', 'none', '2018-11-04 16:50:45', 'no', 'no', 0, 0, 0, '', 'none'),
(37, 22, 0, 'fd', 'test123', 'none', '2018-11-04 17:59:49', 'no', 'no', 0, 0, 0, '', 'none'),
(38, 22, 1, '?', 'test123', 'none', '2018-11-04 19:55:53', 'no', 'no', 0, 0, 0, '', 'none'),
(39, 22, 1, '123', 'test123', 'none', '2018-11-04 19:58:46', 'no', 'no', 0, 0, 0, '', '所羅門群島'),
(40, 22, 1, 'ew', 'test123', 'none', '2018-11-04 20:01:04', 'no', 'no', 0, 0, 0, '', 'none'),
(41, 22, 1, 's', 'test123', 'none', '2018-11-04 20:01:36', 'no', 'no', 0, 0, 0, '', 'none'),
(42, 22, 2, 'e', 'test123', 'none', '2018-11-04 20:07:56', 'no', 'no', 0, 0, 0, '', 'none'),
(43, 22, 1, 'yahoo', 'test123', 'none', '2018-11-05 10:47:34', 'no', 'no', 0, 0, 0, 'assets/images/posts/5bdfaf4658a6ayahoo.png', 'none'),
(44, 22, 1, '1', 'test123', 'none', '2018-11-07 14:31:38', 'no', 'no', 0, 0, 0, 'assets/images/posts/5be286ca8890dChrysanthemum .jpg', 'none'),
(45, 22, 0, ' <br /> ', 'test123', 'none', '2018-11-08 15:13:31', 'no', 'no', 0, 0, 0, '', 'LA'),
(46, 22, 0, 'ff', 'test123', 'none', '2018-11-08 16:02:46', 'no', 'no', 0, 0, 0, '', 'none'),
(47, 22, 0, 'ddd', 'test123', 'none', '2018-11-08 16:06:43', 'no', 'no', 0, 0, 0, '', '瓜地馬拉'),
(48, 22, 0, 'ffddd', 'test123', 'none', '2018-11-08 16:09:28', 'no', 'no', 0, 0, 0, '', 'none'),
(49, 22, 0, 'det', 'test123', 'none', '2018-11-08 16:09:44', 'no', 'no', 0, 0, 0, '', '台北'),
(50, 22, 0, 'test', 'test123', 'none', '2018-11-08 16:28:24', 'no', 'no', 0, 0, 0, '', 'none'),
(51, 22, 0, 'test', 'test123', 'none', '2018-11-08 16:31:56', 'no', 'no', 0, 0, 0, '', 'none'),
(52, 22, 0, 'test<br /> ', 'test123', 'none', '2018-11-08 16:32:47', 'no', 'no', 0, 0, 0, '', 'none'),
(54, 22, 0, 'rryrur', 'test123', 'none', '2018-11-08 16:34:07', 'no', 'no', 0, 0, 0, '', 'none'),
(56, 22, 0, 'aasdasd', 'test123', 'none', '2018-11-08 16:34:58', 'no', 'no', 0, 0, 0, '', '高雄'),
(57, 22, 0, 'as', 'test123', 'none', '2018-11-08 16:36:08', 'no', 'no', 0, 0, 0, '', '大阿拉伯利比亞人民社會主義民眾國'),
(58, 22, 0, 'asasas', 'test123', 'none', '2018-11-08 16:36:48', 'no', 'no', 0, 0, 0, '', 'The United Kingdom of Great Britain and Northern Ireland'),
(59, 22, 0, 'test', 'test123', 'none', '2018-11-08 16:37:09', 'no', 'no', 0, 0, 0, '', 'none'),
(60, 22, 0, 'test', 'test123', 'none', '2018-11-08 16:37:23', 'no', 'no', 0, 0, 0, '', 'none'),
(61, 22, 0, 'were<br /> <br /> f<br /> ', 'test123', 'none', '2018-11-08 17:04:54', 'no', 'no', 0, 0, 0, '', 's'),
(64, 22, 0, 'https://phppot.com/php/extract-content-using-php-and-preview-like-facebook/', 'test123', 'none', '2018-11-09 01:09:33', 'no', 'no', 0, 0, 0, '', 'none'),
(68, 22, 0, '<br><a href=\'https://phppot.com/php/extract-content-using-php-and-preview-like-facebook/\'>https://phppot.com/php/extract-content-using-php-and-preview-like-facebook/</a>', 'test123', 'none', '2018-11-09 01:22:03', 'no', 'no', 0, 0, 0, '', 'none'),
(69, 22, 0, 'test<br /> test<br><a href=\'\'></a>', 'test123', 'none', '2018-11-09 01:22:29', 'no', 'no', 0, 0, 0, '', 'none'),
(70, 22, 0, ' test<br /> t<br><a href=\'\'></a>', 'test123', 'none', '2018-11-09 01:22:43', 'no', 'no', 0, 0, 0, '', 'none'),
(71, 22, 0, 'te <br /> t e', 'test123', 'none', '2018-11-09 01:23:06', 'no', 'no', 0, 0, 0, '', 'none'),
(75, 22, 0, 'sd sa<br /> eq<br><a href=\'\'></a>', 'test123', 'none', '2018-11-09 01:29:24', 'no', 'no', 0, 0, 0, '', 'none'),
(82, 22, 0, '回車和換行<br /> 今天，我總算搞清楚“回車”（carriage return）和“換行”（line feed）這兩個概念的來歷和區別了。<br /> 在計算機還沒有出現之前，有一種叫做電傳打字機（Teletype Model 33）的玩意，每秒鐘可以打10個字符。但是它有一個問題，就是打完一行換行的時候，要用去0.2秒，正好可以打兩個字符。要是在這0.2秒裡面，又有新的字符傳過來，那麼這個字符將丟失。<br /> <br /> 於是，研製人員想了個辦法解決這個問題，就是在每行後面加兩個表示結束的字符。一個叫做“回車”，告訴打字機把打印頭定位在左邊界；另一個叫做“換行”，告訴打字機把紙向下移一行。<br /> <br /> 這就是“換行”和“回車”的來歷，從它們的英語名字上也可以看出一二。<br /> <br /> 後來，計算機發明了，這兩個概念也就被般到了計算機上。那時，存儲器很貴，一些科學家認為在每行結尾加兩個字符太浪費了，加一個就可以。於是，就出現了分歧。', 'test123', 'none', '2018-11-09 01:58:44', 'no', 'no', 0, 0, 0, '', 'none'),
(85, 22, 0, '回車和換行<br /> 今天，我總算搞清楚“回車”（carriage return）和“換行”（line feed）這兩個概念的來歷和區別了。<br /> 在計算機還沒有出現之前，有一種叫做電傳打字機（Teletype Model 33）的玩意，每秒鐘可以打10個字符。但是它有一個問題，就是打完一行換行的時候，要用去0.2秒，正好可以打兩個字符。要是在這0.2秒裡面，又有新的字符傳過來，那麼這個字符將丟失。<br /> <br /> 於是，研製人員想了個辦法解決這個問題，就是在每行後面加兩個表示結束的字符。一個叫做“回車”，告訴打字機把打印頭定位在左邊界；另一個叫做“換行”，告訴打字機把紙向下移一行。<br /> <br /> 這就是“換行”和“回車”的來歷，從它們的英語名字上也可以看出一二。<br /> <br /> 後來，計算機發明了，這兩個概念也就被般到了計算機上。那時，存儲器很貴，一些科學家認為在每行結尾加兩個字符太浪費了，加一個就可以。於是，就出現了分歧。', 'test123', 'none', '2018-11-09 02:00:29', 'no', 'no', 0, 0, 0, '', 'none'),
(103, 22, 0, '<br>', 'test123', 'none', '2018-11-09 02:15:13', 'no', 'no', 0, 0, 0, '', 'none'),
(107, 22, 0, '<br><a href=\'http://seacatcr-y.pixnet.net/bl-og/post/1373206-1-%E3%80%90%E8%-BD%89%E8%B2%BC%-E3%80%91%5Cr%5C-n%E5%92%8C%5Cn%-E7%9A%84%E5%B7%-AE%E7%95%B0C%5C-n%E7%9A%84%E5%B-7%AE%E7%95%B0C%-5Cn%E7%9A%84%E5-%B7%AE%E7%95%B0-C%5Cn%E7%9A%84%-E5%B7%AE%E7%95%-B0C%5Cn%E7%9A%8-4%E5%B7%AE%E7%9-5%B0C%5Cn%E7%9A-%84%E5%B7%AE%E7-%95%B0C%5Cn%E7%-9A%84%E5%B7%AE%-E7%95%B0C%5Cn%E-7%9A%84%E5%B7%A-E%E7%95%B0C%5Cn-%E7%9A%84%E5%B7-%AE%E7%95%B0C%5-Cn%E7%9A%84%E5%-B7%AE%E7%95%B0C-%5Cn%E7%9A%84%E-5%B7%AE%E7%95%B-0C%5Cn%E7%9A%84-%E5%B7%AE%E7%95-%B0 \'>http://seacatcr--y.pixnet.net/b-l-og/post/13732-06-1-%E3%80%90%-E8%-BD%89%E8%B2-%BC%-E3%80%91%5-Cr%5C-n%E5%92%8-C%5Cn%-E7%9A%84-%E5%B7%-AE%E7%9-5%B0C%5C-n%E7%9-A%84%E5%B-7%AE%-E7%95%B0C%-5Cn%-E7%9A%84%E5-%B7-%AE%E7%95%B0-C%-5Cn%E7%9A%84%-E-5%B7%AE%E7%95%--B0C%5Cn%E7%9A%8--4%E5%B7%AE%E7%-9-5%B0C%5Cn%E7%-9A-%84%E5%B7%AE-%E7-%95%B0C%5Cn-%E7%-9A%84%E5%B-7%AE%-E7%95%B0C-%5Cn%E-7%9A%84%-E5%B7%A-E%E7%95-%B0C%5Cn-%E7%9A-%84%E5%B7-%AE%E-7%95%B0C%5-Cn%E-7%9A%84%E5%-B7%-AE%E7%95%B0C-%5-Cn%E7%9A%84%E-5-%B7%AE%E7%95%B--0C%5Cn%E7%9A%84--%E5%B7%AE%E7%9-5-%B0 </a>', 'test123', 'none', '2018-11-09 02:19:40', 'no', 'no', 0, 0, 0, '', 'none'),
(108, 22, 0, '<br><a href=\'http://seacatcry.pixnet.net/blog/post/13732061-%E3%80%90%E8%BD%89%E8%B2%BC-%E3%80%91%5Cr%5Cn%E5%92%8C%5Cn%E7%9A%84%E5%B7%AE%E7%95%B0\'>http://seacatcr-y.pixnet.net/bl-og/post/1373206-1-%E3%80%90%E8%-BD%89%E8%B2%BC--%E3%80%91%5Cr%5-Cn%E5%92%8C%5Cn-%E7%9A%84%E5%B7-%AE%E7%95%B0</a>', 'test123', 'none', '2018-11-09 02:24:49', 'no', 'no', 0, 0, 0, '', 'none'),
(110, 22, 0, '<br><a href=\'\'></a>', 'test123', 'none', '2018-11-09 02:25:29', 'no', 'no', 0, 0, 0, '', 'none'),
(111, 22, 0, '<br><a href=\'http://seacatcry.pixnet.net/blog/post/13732061-%E3%80%90%E8%BD%89%E8%B2%BC-%E3%80%91%5Cr%5Cn%E5%92%8C%5Cn%E7%9A%84%E5%B7%AE%E7%95%B0\'>http://seacatcr-y.pixnet.net/bl-og/post/1373206-1-%E3%80%90%E8%-BD%89%E8%B2%BC--%E3%80%91%5Cr%5-Cn%E5%92%8C%5Cn-%E7%9A%84%E5%B7-%AE%E7%95%B0</a>', 'test123', 'none', '2018-11-09 02:26:31', 'no', 'no', 0, 0, 0, '', 'none'),
(112, 22, 0, '<br><a href=\'https://www.facebook.com/\'>https://www.fac-ebook.com/</a>', 'test123', 'none', '2018-11-09 02:46:22', 'no', 'no', 0, 0, 0, '', 'none'),
(114, 22, 0, '<br><a href=\'http://seacatcry.pixnet.net/blog/post/13732061-%E3%80%90%E8%BD%89%E8%B2%BC%E3%80%91%5Cr%5Cn%E5%92%8C%5Cn%E7%9A%84%E5%B7%AE%E7%95%B0\'>http://seacatcry.pixnet.net/bl-og/post/13732061-%E3%80%90%E8%-BD%89%E8%B2%BC%E3%80%91%5Cr%5C-n%E5%92%8C%5Cn%E7%9A%84%E5%B7%-AE%E7%95%B0</a>', 'test123', 'none', '2018-11-09 02:47:19', 'no', 'no', 0, 0, 0, '', 'none'),
(115, 22, 0, '<br><a href=\'http://seacatcr--y.pixnet.net/b-l-og/post/13732-06-1-%E3%80%90%-E8%-BD%89%E8%B2-%BC%-E3%80%91%5-Cr%5C-n%E5%92%8-C%5Cn%-E7%9A%84-%E5%B7%-AE%E7%9-5%B0C%5C-n%E7%9-A%84%E5%B-7%AE%-E7%95%B0C%-5Cn%-E7%9A%84%E5-%B7-%AE%E7%95%B0-C%-5Cn%E7%9A%84%-E-5%B7%AE%E7%95%--B0C%5Cn%E7%9A%8--4%E5%B7%AE%E7%-9-5%B0C%5Cn%E7%-9A-%84%E5%B7%AE-%E7-%95%B0C%5Cn-%E7%-9A%84%E5%B-7%AE%-E7%95%B0C-%5Cn%E-7%9A%84%-E5%B7%A-E%E7%95-%B0C%5Cn-%E7%9A-%84%E5%B7-%AE%E-7%95%B0C%5-Cn%E-7%9A%84%E5%-B7%-AE%E7%95%B0C-%5-Cn%E7%9A%84%E-5-%B7%AE%E7%95%B--0C%5Cn%E7%9A%84--%E5%B7%AE%E7%9-5-%B0 \'>http://seacatcr--y.pixnet.net/-b-l-og/post/13732-06-1-%E3%80%-90%-E8%-BD%89%E8%B2-%BC%-E3%80-%91%5-Cr%5C-n%E5%92%8-C%5Cn%-E-7%9A%84-%E5%B7%-AE%E7%9-5%B0C%-5C-n%E7%9-A%84%E5%B-7%AE%-E7%9-5%B0C%-5Cn%-E7%9A%84%E5-%B7-%A-E%E7%95%B0-C%-5Cn%E7%9A%84%-E--5%B7%AE%E7%95%--B0C%5Cn%E7%9A%-8--4%E5%B7%AE%E7%-9-5%B0C%5Cn%-E7%-9A-%84%E5%B7%AE-%E7-%95%B0-C%5Cn-%E7%-9A%84%E5%B-7%AE%-E7-%95%B0C-%5Cn%E-7%9A%84%-E5%B7%-A-E%E7%95-%B0C%5Cn-%E7%9A-%84%-E5%B7-%AE%E-7%95%B0C%5-Cn%E-7%-9A%84%E5%-B7%-AE%E7%95%B0C-%5--Cn%E7%9A%84%E-5-%B7%AE%E7%95%B---0C%5Cn%E7%9A%84--%E5%B7%AE%E-7%9-5-%B0 </a>', 'test123', 'none', '2018-11-09 02:47:40', 'no', 'no', 0, 0, 0, '', 'none'),
(116, 22, 0, '<br><a href=\'http://seacatcry.pixnet.net/blog/post/13732061-%E3%80%90%E8%BD%89%E8%B2%BC%E3%80%91%5Cr%5Cn%E5%92%8C%5Cn%E7%9A%84%E5%B7%AE%E7%95%B0\'>http://seacatcry.pixnet.net/bl-og/post/13732061-%E3%80%90%E8%-BD%89%E8%B2%BC%E3%80%91%5Cr%5C-n%E5%92%8C%5Cn%E7%9A%84%E5%B7%-AE%E7%95%B0</a>', 'test123', 'none', '2018-11-09 02:52:58', 'no', 'no', 0, 0, 0, '', 'none'),
(125, 22, 0, '<img src=\'./assets/images/emoji/1.jpg\'>', 'test123', 'none', '2018-11-09 03:33:31', 'no', 'no', 0, 1, 0, '', 'none'),
(126, 22, 0, '測試TEST<img src=\'./assets/images/emoji/1.jpg\'>', 'test123', 'none', '2018-11-09 03:44:38', 'no', 'no', 0, 0, 0, '', 'none'),
(127, 22, 0, '<img src=\'./assets/images/emoji/1.jpg\'>', 'test123', 'none', '2018-11-09 03:47:59', 'no', 'no', 0, 3, 1, '', 'none'),
(128, 22, 0, '<img src=\'./assets/images/emoji/1.jpg\'><img src=\'./assets/images/emoji/2.jpg\'><img src=\'./assets/images/emoji/3.jpg\'><img src=\'./assets/images/emoji/4.jpg\'><img src=\'./assets/images/emoji/5.jpg\'><img src=\'./assets/images/emoji/6.jpg\'><img src=\'./assets/images/emoji/7.jpg\'><img src=\'./assets/images/emoji/8.jpg\'><img src=\'./assets/images/emoji/9.jpg\'><img src=\'./assets/images/emoji/10.jpg\'><img src=\'./assets/images/emoji/11.jpg\'><img src=\'./assets/images/emoji/12.jpg\'><img src=\'./assets/images/emoji/13.jpg\'><img src=\'./assets/images/emoji/14.jpg\'><img src=\'./assets/images/emoji/15.jpg\'><img src=\'./assets/images/emoji/16.jpg\'><img src=\'./assets/images/emoji/17.jpg\'><img src=\'./assets/images/emoji/18.jpg\'><img src=\'./assets/images/emoji/19.jpg\'><img src=\'./assets/images/emoji/20.jpg\'><img src=\'./assets/images/emoji/21.jpg\'><img src=\'./assets/images/emoji/22.jpg\'><img src=\'./assets/images/emoji/23.jpg\'><img src=\'./assets/images/emoji/24.jpg\'>', 'test123', 'none', '2018-11-09 04:25:30', 'no', 'no', 0, 3, 0, '', 'none'),
(134, 22, 0, ';k<br /> 妳好!', 'test123', 'none', '2018-11-09 10:06:51', 'no', 'no', 0, 1, 0, '', 'none'),
(135, 22, 0, ';k<br /> 妳好!', 'test123', 'none', '2018-11-09 10:08:23', 'no', 'no', 0, 0, 0, '', 'none'),
(136, 22, 0, 'eeet', 'test123', 'none', '0000-00-00 00:00:00', 'no', 'no', 0, 0, 0, '', 'none'),
(137, 22, 0, 'hi', 'test123', 'none', '2018-11-09 10:15:52', 'no', 'no', 1, 1, 0, '', 'none'),
(138, 22, 0, ';k<br /> 妳好!', 'test123', 'none', '2018-11-09 10:16:24', 'no', 'no', 1, 1, 0, '', 'none'),
(139, 22, 0, '<img src=\'./assets/images/emoji/2.jpg\'>', 'test123', 'ttttest', '2018-11-09 12:02:01', 'no', 'no', 0, 0, 0, '', 'none'),
(140, 22, 0, '<img src=\'./assets/images/emoji/1.jpg\'>', 'test123', 'none', '2018-11-09 12:50:49', 'no', 'no', 1, 0, 0, '', 'none'),
(141, 22, 0, 'aaa<br><a href=\'tw.yahoo.com\'>tw.yahoo.com</a>', 'test123', 'none', '2018-11-09 12:52:57', 'no', 'no', 1, 2, 1, 'assets/images/posts/5be512a9278855313057_1408107-1_thumb.jpg', '台中'),
(142, 22, 0, 'hi', 'test123', 'none', '2018-11-09 13:02:23', 'no', 'no', 0, 3, 1, '', 'none'),
(143, 22, 0, '22,1 22,1 24,0 24,0 22,1', 'test123', 'none', '2018-11-09 13:03:00', 'no', 'no', 0, 0, 0, '', 'none'),
(144, 22, 0, 'hi', 'test123', 'none', '0000-00-00 00:00:00', 'no', 'no', 0, 0, 0, '', 'none'),
(145, 22, 0, 'hi', 'test123', 'none', '0000-00-00 00:00:00', 'no', 'no', 0, 0, 0, '', 'none'),
(146, 22, 0, 'hi', 'test123', 'none', '0000-00-00 00:00:00', 'no', 'no', 0, 0, 1, '', 'none'),
(147, 22, 0, ';k<br /> 妳好!', 'test123', 'none', '2018-11-09 13:05:17', 'no', 'no', 1, 0, 0, '', 'none'),
(148, 22, 0, '<img src=\'./assets/images/emoji/17.jpg\'>aaa<img src=\'./assets/images/emoji/23.jpg\'>bbb<img src=\'./assets/images/emoji/16.jpg\'>ccc', 'test123', 'none', '2018-11-09 13:14:17', 'no', 'no', 0, 0, 0, '', 'none'),
(149, 22, 0, '<img src=\'./assets/images/emoji/4.jpg\'>', 'test123', 'none', '2018-11-09 13:14:51', 'no', 'no', 0, 0, 0, '', 'none');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reported_user` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `reported_user`, `post_id`) VALUES
(6, 22, 31, 19),
(7, 22, 31, 0);

-- --------------------------------------------------------

--
-- Table structure for table `trends`
--

CREATE TABLE `trends` (
  `title` varchar(50) NOT NULL,
  `hits` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `trends`
--

INSERT INTO `trends` (`title`, `hits`) VALUES
('Test', 7),
('De', 1),
('Ew', 2),
('Hi', 2),
('Eee', 1),
('Eeet', 1),
('Yrt', 1),
('Fd', 1),
('123', 1),
('Yahoo', 1),
('1', 1),
('Br', 31),
('Ff', 1),
('Ddd', 1),
('Ffddd', 1),
('Det', 1),
('Testbr', 3),
('Rryrur', 1),
('Aasdasd', 1),
('Asasas', 1),
('Werebr', 1),
('Fbr', 1),
('0', 1),
('Testbra', 1),
('Hrefa', 8),
('Tbra', 1),
('Te', 1),
('Tbr', 2),
('Ttbra', 1),
('Ebra', 1),
('Ebr', 1),
('Rbr', 1),
('Rbra', 1),
('Sd', 1),
('Sabr', 1),
('Eqbra', 1),
('Carriage', 3),
('Returnline', 3),
('Feedbr', 3),
('Teletype', 3),
('Model', 3),
('3310br', 1),
('02br', 2),
('33100202br', 2),
('Bra', 3),
('Hreflinkarealinkareaa', 1),
('Assetsimagespostsemoji1jpg', 1),
('Img', 12),
('Srcassetsimagespostsemoji1jpg', 2),
('Srcassetsimagesemojiemoji1jpg', 3),
('Srcassetsimagesemoji1jpg', 4),
('TESTimg', 1),
('Srcassetsimagesemoji1jpgimg', 1),
('Srcassetsimagesemoji2jpgimg', 1),
('Srcassetsimagesemoji3jpgimg', 1),
('Srcassetsimagesemoji4jpgimg', 1),
('Srcassetsimagesemoji5jpgimg', 1),
('Srcassetsimagesemoji6jpgimg', 1),
('Srcassetsimagesemoji7jpgimg', 1),
('Srcassetsimagesemoji8jpgimg', 1),
('Srcassetsimagesemoji9jpgimg', 1),
('Srcassetsimagesemoji10jpgimg', 1),
('Srcassetsimagesemoji11jpgimg', 1),
('Srcassetsimagesemoji12jpgimg', 1),
('Srcassetsimagesemoji13jpgimg', 1),
('Srcassetsimagesemoji14jpgimg', 1),
('Srcassetsimagesemoji15jpgimg', 1),
('Srcassetsimagesemoji16jpgimg', 1),
('Srcassetsimagesemoji17jpgimg', 1),
('Srcassetsimagesemoji18jpgimg', 1),
('Srcassetsimagesemoji19jpgimg', 1),
('Srcassetsimagesemoji20jpgimg', 1),
('Srcassetsimagesemoji21jpgimg', 1),
('Srcassetsimagesemoji22jpgimg', 1),
('Srcassetsimagesemoji23jpgimg', 1),
('Srcassetsimagesemoji24jpg', 1),
('Dttd', 1),
('Rr6r', 1),
('Dt', 1),
('Rfy', 1),
('Af', 1),
('Srcassetsimagesemoji2jpg', 1),
('Aaabra', 1),
('Hreftwyahoocomtwyahoocoma', 1),
('Srcassetsimagesemoji17jpgaaaimg', 1),
('Srcassetsimagesemoji23jpgbbbimg', 1),
('Srcassetsimagesemoji16jpgccc', 1),
('Srcassetsimagesemoji4jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `first_name` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `birthday` varchar(20) NOT NULL,
  `signup_date` date NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `num_posts` int(11) NOT NULL,
  `num_likes` int(11) NOT NULL,
  `user_closed` varchar(3) NOT NULL,
  `friend_array` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `last_name`, `first_name`, `username`, `gender`, `birthday`, `signup_date`, `profile_pic`, `num_posts`, `num_likes`, `user_closed`, `friend_array`) VALUES
(21, 'admin01@gmail.com', '18c6d818ae35a3e8279b5330eda01498', 'Admin01', '測試', 'admin01測試', '女', '2004年6月8日', '2018-09-18', 'assets/images/profile_pics/defaults/head_emerald.png', 8, 1, 'no', ',123_test,'),
(22, 'test123@gmail.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'Test', '123', 'test123', '女', '2004年6月8日', '2018-09-18', 'assets/images/profile_pics/test1231c1707b84dddd57bfb3550808accd652n.jpeg', 160, 7, 'no', ',測試_admin01,aaa_qqq,'),
(23, 'qqqaaa@yahoo.com', 'bbd6a3cfe054981f89f80fb128821940', 'qqq', 'aaa', 'qqqaaa', '女', '2004年6月8日', '2018-09-27', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ',123_test,'),
(24, 'test123@yahoo.com', 'cc03e747a6afbbcbf8be7668acfebee5', 'ttt', 'test', 'ttttest', '女', '2004年6月8日', '2018-10-04', 'assets/images/profile_pics/defaults/head_deep_blue.png', 6, 0, 'no', ','),
(25, 'st6090110245@gmail.com', 'b09a15d9b26b7119913314e17bfd2ae1', 'TANG', 'JO', 'tangjo', '女', '2004年6月8日', '2018-10-11', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ','),
(26, 'zzzxxx@gmail.com', 'c08654f13e6bccf71e9b8a21784a2e2a', 'zzzxx', 'zx', 'zzzxxzx', '女', '2004年6月8日', '2018-10-11', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ','),
(27, 'qazwsx@gmail.com', '76419c58730d9f35de7ac538c2fd6737', 'TANG', 'JO', 'tangjo_1', '女', '2001年2月25日', '2018-10-16', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ','),
(28, 'text123@yahoo.com', 'bcc720f2981d1a68dbd66ffd67560c37', 'tt', 'tt', 'tttt', '女', '2001年1月15日', '2018-10-16', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ','),
(29, 'st6090110245@yahoo.com', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', 'TANG', 'JO', 'tangjo_1_2', '女', '2001年2月18日', '2018-10-16', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ','),
(30, 'asasd@g.com', '5abd06d6f6ef0e022e11b8a41f57ebda', 'qqq', 'sad', 'qqqsad', '男', '2000年1月19日', '2018-10-16', 'assets/images/profile_pics/defaults/head_emerald.png', 0, 0, 'no', ','),
(31, 'test@test.com', 'cc03e747a6afbbcbf8be7668acfebee5', '唐', '若秦', '唐若秦', '男', '2000年2月19日', '2018-10-25', 'assets/images/profile_pics/defaults/head_deep_blue.png', 1, 0, 'no', ','),
(32, 'haha@haha.com', '01ddae4032e17a1c338baac9c4322b30', 'haha', 'JOhaha', 'JOhahahaha', '男', '2001年3月18日', '2018-10-26', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ','),
(33, 'haha@haha1.com', '01ddae4032e17a1c338baac9c4322b30', 'haha', 'JOhaha', 'JOhaha haha', '男', '2000年4月19日', '2018-10-26', 'assets/images/profile_pics/defaults/head_deep_blue.png', 0, 0, 'no', ',');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

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
  `mobile` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `introduction`, `location`, `relation_status`, `school1`, `concentration1`, `school2`, `concentration2`, `workplace1`, `workplace2`, `music`, `book`, `movie`, `food`, `travel`, `activity`, `exercise`, `others`, `mobile`) VALUES
(1, 22, '生活是藝術 每個小願望的達成', '台中', '穩定交往中', '妳好', '研究所', '台中', '大學', 'google', '兆宏', '音樂', '書籍', '電影', '美食', '旅遊', '活動', '運動', '其他', '6268635279'),
(2, 21, '生活是藝術 每個小願望的達成', '台中', '單身', '台中', '國小', '台中', '專科', 'sdg', '兆宏', '音樂', '書籍', '電影', '美食', '旅遊', '活動', '運動', '其他', '6268635279');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fanpages`
--
ALTER TABLE `fanpages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fanpage_likes`
--
ALTER TABLE `fanpage_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fanpage_messages`
--
ALTER TABLE `fanpage_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friend_requests`
--
ALTER TABLE `friend_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `fanpages`
--
ALTER TABLE `fanpages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `fanpage_likes`
--
ALTER TABLE `fanpage_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `fanpage_messages`
--
ALTER TABLE `fanpage_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `friend_requests`
--
ALTER TABLE `friend_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
