-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: homestead
-- ------------------------------------------------------
-- Server version	5.7.29-0ubuntu0.18.04.1

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
-- Table structure for table `game_platforms`
--

DROP TABLE IF EXISTS `game_platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `platform_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_platforms_game_id_foreign` (`game_id`),
  KEY `game_platforms_platform_id_foreign` (`platform_id`),
  CONSTRAINT `game_platforms_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_platforms_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_platforms`
--

LOCK TABLES `game_platforms` WRITE;
/*!40000 ALTER TABLE `game_platforms` DISABLE KEYS */;
INSERT INTO `game_platforms` VALUES (1,1,1,'2021-07-22 17:00:01','2021-07-22 17:00:01'),(6,3,1,'2021-07-22 17:00:21','2021-07-22 17:00:21'),(10,4,1,'2021-07-22 17:00:33','2021-07-22 17:00:33'),(15,5,2,'2021-07-22 17:00:41','2021-07-22 17:00:41'),(25,8,2,'2021-07-22 17:02:17','2021-07-22 17:02:17'),(31,10,3,'2021-07-22 17:02:53','2021-07-22 17:02:53'),(36,11,4,'2021-07-22 17:03:20','2021-07-22 17:03:20'),(37,2,1,'2021-07-23 08:27:15','2021-07-23 08:27:15'),(38,6,2,'2021-07-23 08:27:47','2021-07-23 08:27:47'),(39,7,2,'2021-07-23 08:27:55','2021-07-23 08:27:55'),(40,9,3,'2021-07-23 08:28:14','2021-07-23 08:28:14');
/*!40000 ALTER TABLE `game_platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_used_replies`
--

DROP TABLE IF EXISTS `game_used_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_used_replies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_id` int(10) unsigned NOT NULL,
  `used_reply_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game_used_replies_game_id_foreign` (`game_id`),
  KEY `game_used_replies_used_reply_id_foreign` (`used_reply_id`),
  CONSTRAINT `game_used_replies_game_id_foreign` FOREIGN KEY (`game_id`) REFERENCES `games` (`id`) ON DELETE CASCADE,
  CONSTRAINT `game_used_replies_used_reply_id_foreign` FOREIGN KEY (`used_reply_id`) REFERENCES `used_replies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_used_replies`
--

LOCK TABLES `game_used_replies` WRITE;
/*!40000 ALTER TABLE `game_used_replies` DISABLE KEYS */;
INSERT INTO `game_used_replies` VALUES (5,3,5,'2021-07-23 22:06:02','2021-07-23 22:06:02'),(6,3,6,'2021-07-23 22:17:18','2021-07-23 22:17:18'),(8,1,12,'2021-07-23 23:37:52','2021-07-23 23:37:52'),(9,1,13,'2021-07-24 01:26:42','2021-07-24 01:26:42'),(10,1,14,'2021-07-24 01:31:58','2021-07-24 01:31:58');
/*!40000 ALTER TABLE `game_used_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Color Switch','2021-07-22 17:00:01','2021-07-22 17:00:01'),(2,'Color Switch World','2021-07-22 17:00:12','2021-07-22 17:00:12'),(3,'Color Switch Universe','2021-07-22 17:00:21','2021-07-22 17:00:21'),(4,'Color Twist','2021-07-22 17:00:33','2021-07-22 17:00:33'),(5,'Color Flip','2021-07-22 17:00:41','2021-07-22 17:00:41'),(6,'Color Drift','2021-07-22 17:00:53','2021-07-22 17:00:53'),(7,'Color Switch: Kids Edition','2021-07-22 17:01:57','2021-07-22 17:01:57'),(8,'Color Switch: Coloring Book','2021-07-22 17:02:17','2021-07-22 17:02:17'),(9,'Color Blaster','2021-07-22 17:02:38','2021-07-22 17:02:38'),(10,'Color Switch 3','2021-07-22 17:02:53','2021-07-22 17:02:53'),(11,'Color Switch: Augmented Reality','2021-07-22 17:03:20','2021-07-22 17:03:20');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platform_used_replies`
--

DROP TABLE IF EXISTS `platform_used_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platform_used_replies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `platform_id` int(10) unsigned NOT NULL,
  `used_reply_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `platform_used_replies_platform_id_foreign` (`platform_id`),
  KEY `platform_used_replies_used_reply_id_foreign` (`used_reply_id`),
  CONSTRAINT `platform_used_replies_platform_id_foreign` FOREIGN KEY (`platform_id`) REFERENCES `platforms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `platform_used_replies_used_reply_id_foreign` FOREIGN KEY (`used_reply_id`) REFERENCES `used_replies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platform_used_replies`
--

LOCK TABLES `platform_used_replies` WRITE;
/*!40000 ALTER TABLE `platform_used_replies` DISABLE KEYS */;
INSERT INTO `platform_used_replies` VALUES (5,1,5,'2021-07-23 22:06:02','2021-07-23 22:06:02'),(6,1,6,'2021-07-23 22:17:18','2021-07-23 22:17:18'),(8,1,12,'2021-07-23 23:37:52','2021-07-23 23:37:52'),(9,1,13,'2021-07-24 01:26:42','2021-07-24 01:26:42'),(10,1,14,'2021-07-24 01:31:58','2021-07-24 01:31:58');
/*!40000 ALTER TABLE `platform_used_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platforms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platforms`
--

LOCK TABLES `platforms` WRITE;
/*!40000 ALTER TABLE `platforms` DISABLE KEYS */;
INSERT INTO `platforms` VALUES (1,'Amazon','2021-07-22 16:59:06','2021-07-22 16:59:06'),(2,'Apple','2021-07-22 16:59:13','2021-07-22 16:59:13'),(3,'Google','2021-07-22 16:59:18','2021-07-22 16:59:18'),(4,'Tencent','2021-07-22 16:59:25','2021-07-22 16:59:25');
/*!40000 ALTER TABLE `platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `replies`
--

DROP TABLE IF EXISTS `replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `replies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `replies`
--

LOCK TABLES `replies` WRITE;
/*!40000 ALTER TABLE `replies` DISABLE KEYS */;
INSERT INTO `replies` VALUES (1,'I am sorry to hear that you were one of our affected players from the update. You will be glad to know that our tech team is currently working on a patch to resolve it, which we will release as soon as it is ready. Thank you for being a part of the Color Switch family!','2021-07-22 17:22:52','2021-07-22 17:22:52'),(2,'Hey there! We\'re so, so sorry to hear you\'re experiencing this. It is most definitely not the norm. Can you reach out to our team as support@colorswitch.co? We\'d love the opportunity to help trouble shoot the issue, but will need more detail from you to do so. Thank you!','2021-07-22 17:23:56','2021-07-22 17:23:56'),(3,'Hi! Please reach out to our team at support@colorswitch.co. They may be able to help you regain your lost progress. Sorry this happened to you!\r\n','2021-07-22 17:24:59','2021-07-22 17:27:20'),(4,'Hey there! We’re constantly working on improving our free user ad experience. Feel free to take advantage of our in app purchases to get rid of ads completely. Thanks for stopping by and thank you for being a part of the Color Switch Family!','2021-07-22 17:25:28','2021-07-22 17:25:28'),(5,'Hi - We\'re constantly working on improving our free user ad experience, so we appreciate your feedback. We do offer in app purchases that will get rid of the ads for you! Please feel free to take advantage of that.','2021-07-22 17:25:43','2021-07-22 17:27:48'),(6,'Hi- We hear you. Ads can be super annoying sometimes! We are constantly working on our free user ad experience, so we really appreciate your feedback. As a reminder, we do offer in-app purchases that will take care of those ads for you. Let us know if we can help you with anything else!','2021-07-22 17:26:04','2021-07-22 17:27:37'),(7,'Bugs are in all software. We do the best we can to remove them when they are identified. Email details on the bugs you are referencing to support@colorswitch.co and we\'ll get them removed.','2021-07-22 17:26:58','2021-07-22 17:26:58'),(8,'The new update is out and if you were one of the affected users please contact us via support@colorswitch.co and we can help you restore your progress. Thank you for being a part of the Color Switch family!','2021-07-22 17:28:09','2021-07-22 17:28:09'),(9,'Hi - We\'re constantly working on improving our free user ad experience, so we appreciate your feedback. We do offer in app purchases that will get rid of the ads for you! Please feel free to take advantage of that.','2021-07-22 17:28:39','2021-07-23 10:31:39'),(10,'I am sorry to hear that you were one of our affected players from the update. You will be glad to know that our tech team is currently working on a patch to resolve it, which we will release as soon as it is ready. Thank you for being a part of the Color Switch family!','2021-07-22 17:29:57','2021-07-22 17:29:57'),(11,'Hi! Please send us an email at support@colorswitch.co. Our tech teach can help fix this!','2021-07-22 17:32:06','2021-07-22 17:32:06'),(13,'Laggy - 1','2021-07-24 01:15:34','2021-07-24 01:15:34'),(14,'Laggy - 2','2021-07-24 01:15:46','2021-07-24 01:15:46'),(15,'Laggy - 3','2021-07-24 01:24:56','2021-07-24 01:24:56'),(16,'Laggy - 4','2021-07-24 01:25:25','2021-07-24 01:25:25');
/*!40000 ALTER TABLE `replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reply_review_categories`
--

DROP TABLE IF EXISTS `reply_review_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reply_review_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reply_id` int(10) unsigned NOT NULL,
  `review_category_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reply_review_categories_reply_id_foreign` (`reply_id`),
  KEY `reply_review_categories_review_category_id_foreign` (`review_category_id`),
  CONSTRAINT `reply_review_categories_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reply_review_categories_review_category_id_foreign` FOREIGN KEY (`review_category_id`) REFERENCES `review_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reply_review_categories`
--

LOCK TABLES `reply_review_categories` WRITE;
/*!40000 ALTER TABLE `reply_review_categories` DISABLE KEYS */;
INSERT INTO `reply_review_categories` VALUES (1,1,7,'2021-07-22 17:22:52','2021-07-22 17:22:52'),(2,2,12,'2021-07-22 17:23:56','2021-07-22 17:23:56'),(3,3,6,'2021-07-22 17:24:59','2021-07-22 17:24:59'),(4,4,13,'2021-07-22 17:25:28','2021-07-22 17:25:28'),(5,5,8,'2021-07-22 17:25:43','2021-07-22 17:25:43'),(6,6,8,'2021-07-22 17:26:04','2021-07-22 17:26:04'),(7,7,10,'2021-07-22 17:26:58','2021-07-22 17:26:58'),(8,8,7,'2021-07-22 17:28:09','2021-07-22 17:28:09'),(9,9,14,'2021-07-22 17:28:39','2021-07-22 17:28:39'),(10,10,6,'2021-07-22 17:29:57','2021-07-22 17:29:57'),(11,11,15,'2021-07-22 17:32:06','2021-07-22 17:32:06'),(27,13,1,'2021-07-24 01:15:34','2021-07-24 01:15:34'),(28,14,1,'2021-07-24 01:15:46','2021-07-24 01:15:46'),(29,15,1,'2021-07-24 01:24:56','2021-07-24 01:24:56'),(30,16,1,'2021-07-24 01:25:25','2021-07-24 01:25:25');
/*!40000 ALTER TABLE `reply_review_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_categories`
--

DROP TABLE IF EXISTS `review_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_categories`
--

LOCK TABLES `review_categories` WRITE;
/*!40000 ALTER TABLE `review_categories` DISABLE KEYS */;
INSERT INTO `review_categories` VALUES (1,'Laggy','Mentions the game being laggy','2021-07-22 17:03:47','2021-07-22 17:03:47'),(2,'Drains Battery','Mentions the game draining battery quickly','2021-07-22 17:04:05','2021-07-22 17:04:05'),(3,'Crashes','Mentions the game crashing at all','2021-07-22 17:04:18','2021-07-22 17:04:18'),(4,'Low FPS','Mentions the game having low fps','2021-07-22 17:04:42','2021-07-22 17:04:42'),(5,'Bad Graphics','Mentions the game not having good graphics','2021-07-22 17:05:00','2021-07-22 17:05:00'),(6,'Lost Progress','Mentions losing progress in the game','2021-07-22 17:05:36','2021-07-22 17:05:36'),(7,'Bad Update','Mentions an update not being good ','2021-07-22 17:05:49','2021-07-22 17:05:49'),(8,'Too many ads','Mentions the game having too many ads','2021-07-22 17:06:02','2021-07-22 17:06:02'),(9,'Glitchy','Mentions the game being \"glitchy\"','2021-07-22 17:06:19','2021-07-22 17:06:19'),(10,'Bug','Mentions something that sounds like a bug','2021-07-22 17:06:44','2021-07-22 17:06:44'),(11,'Wont Start','Mentions the game not even starting','2021-07-22 17:10:59','2021-07-22 17:10:59'),(12,'Jumping Doesn\'t Work','Mentions tapping/jumping input not working','2021-07-22 17:23:41','2021-07-22 17:23:41'),(13,'Freezes','Mentions the game freezing','2021-07-22 17:25:18','2021-07-22 17:25:18'),(14,'Too Hard','Mentions the game being too hard','2021-07-22 17:28:29','2021-07-22 17:28:29'),(15,'Lost Purchase','Mentions a purchase not working','2021-07-22 17:31:57','2021-07-22 17:31:57');
/*!40000 ALTER TABLE `review_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_category_used_replies`
--

DROP TABLE IF EXISTS `review_category_used_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_category_used_replies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `review_category_id` int(10) unsigned NOT NULL,
  `used_reply_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `review_category_used_replies_review_category_id_foreign` (`review_category_id`),
  KEY `review_category_used_replies_used_reply_id_foreign` (`used_reply_id`),
  CONSTRAINT `review_category_used_replies_review_category_id_foreign` FOREIGN KEY (`review_category_id`) REFERENCES `review_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `review_category_used_replies_used_reply_id_foreign` FOREIGN KEY (`used_reply_id`) REFERENCES `used_replies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_category_used_replies`
--

LOCK TABLES `review_category_used_replies` WRITE;
/*!40000 ALTER TABLE `review_category_used_replies` DISABLE KEYS */;
INSERT INTO `review_category_used_replies` VALUES (5,7,5,'2021-07-23 22:06:02','2021-07-23 22:06:02'),(6,7,6,'2021-07-23 22:17:18','2021-07-23 22:17:18'),(8,15,12,'2021-07-23 23:37:52','2021-07-23 23:37:52'),(9,1,13,'2021-07-24 01:26:42','2021-07-24 01:26:42'),(10,1,14,'2021-07-24 01:31:58','2021-07-24 01:31:58');
/*!40000 ALTER TABLE `review_category_used_replies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `used_replies`
--

DROP TABLE IF EXISTS `used_replies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `used_replies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reply_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `used_replies_reply_id_foreign` (`reply_id`),
  CONSTRAINT `used_replies_reply_id_foreign` FOREIGN KEY (`reply_id`) REFERENCES `replies` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `used_replies`
--

LOCK TABLES `used_replies` WRITE;
/*!40000 ALTER TABLE `used_replies` DISABLE KEYS */;
INSERT INTO `used_replies` VALUES (5,1,'2021-07-23 22:06:02','2021-07-23 22:06:02'),(6,8,'2021-07-23 22:17:18','2021-07-23 22:17:18'),(12,11,'2021-07-23 23:37:52','2021-07-23 23:37:52'),(13,13,'2021-07-24 01:26:42','2021-07-24 01:26:42'),(14,14,'2021-07-24 01:31:58','2021-07-24 01:31:58');
/*!40000 ALTER TABLE `used_replies` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-07-24  1:52:51
