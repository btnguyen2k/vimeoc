-- MySQL dump 10.13  Distrib 5.1.52, for redhat-linux-gnu (i386)
--
-- Host: localhost    Database: vimeoc
-- ------------------------------------------------------
-- Server version	5.1.52

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
-- Table structure for table `album`
--

DROP TABLE IF EXISTS `album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `album_locked` bit(1) NOT NULL DEFAULT b'0',
  `album_alias` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` tinytext,
  `thumbnail` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `album_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album`
--

LOCK TABLES `album` WRITE;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` VALUES (1,23,'HAI','',NULL,'2011-05-26 11:50:52',NULL,NULL),(2,21,'HaiPham','\0',NULL,'2011-05-26 11:58:47',NULL,NULL);
/*!40000 ALTER TABLE `album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `album_video`
--

DROP TABLE IF EXISTS `album_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `album_video` (
  `album_id` bigint(20) NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`album_id`,`video_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `album_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `album_video_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `album_video`
--

LOCK TABLES `album_video` WRITE;
/*!40000 ALTER TABLE `album_video` DISABLE KEYS */;
INSERT INTO `album_video` VALUES (1,1,'2011-05-26 12:10:11'),(1,2,'2011-05-26 12:10:18'),(1,3,'2011-05-26 12:10:23'),(1,4,'2011-05-26 12:10:29'),(1,5,'2011-05-26 12:10:34'),(2,6,'2011-05-26 12:07:55'),(2,7,'2011-05-26 12:08:01'),(2,8,'2011-05-26 12:08:07'),(2,9,'2011-05-26 12:08:14'),(2,10,'2011-05-26 12:08:19');
/*!40000 ALTER TABLE `album_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channel`
--

DROP TABLE IF EXISTS `channel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `channel_name` varchar(255) NOT NULL,
  `channel_locked` bit(1) NOT NULL DEFAULT b'0',
  `channel_alias` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel`
--

LOCK TABLES `channel` WRITE;
/*!40000 ALTER TABLE `channel` DISABLE KEYS */;
/*!40000 ALTER TABLE `channel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channel_video`
--

DROP TABLE IF EXISTS `channel_video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `channel_video` (
  `channel_id` bigint(20) NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`channel_id`,`video_id`),
  KEY `video_id` (`video_id`),
  CONSTRAINT `channel_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `channel_video_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channel_video`
--

LOCK TABLES `channel_video` WRITE;
/*!40000 ALTER TABLE `channel_video` DISABLE KEYS */;
/*!40000 ALTER TABLE `channel_video` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `component_type` tinyint(2) NOT NULL,
  `component_id` bigint(20) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `content` tinytext NOT NULL,
  `comment_locked` bit(1) NOT NULL DEFAULT b'0',
  `user_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `like`
--

DROP TABLE IF EXISTS `like`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `like` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `component_type` tinyint(2) NOT NULL,
  `component_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `like` bit(1) NOT NULL DEFAULT b'1',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `like`
--

LOCK TABLES `like` WRITE;
/*!40000 ALTER TABLE `like` DISABLE KEYS */;
/*!40000 ALTER TABLE `like` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (-9,'ROLE_ADMIN'),(1,'ROLE_USER');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tag_locked` bit(1) NOT NULL DEFAULT b'0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag`
--

LOCK TABLES `tag` WRITE;
/*!40000 ALTER TABLE `tag` DISABLE KEYS */;
INSERT INTO `tag` VALUES (1,'game','\0','2011-06-12 09:09:05'),(2,' education','\0','2011-06-12 09:09:05'),(3,' english','\0','2011-06-12 09:09:05'),(4,'test','\0','2011-06-13 06:14:10'),(5,' ','\0','2011-06-13 14:29:45'),(6,'test1','\0','2011-06-14 04:21:43'),(7,'education','\0','2011-06-14 16:45:38'),(8,'123','\0','2011-06-14 16:47:31'),(9,'sdf','\0','2011-06-14 16:54:17'),(10,'s','\0','2011-06-14 16:54:40'),(11,'dsfs','\0','2011-06-15 14:33:36'),(12,'sasadasd','\0','2011-06-15 14:33:45'),(13,'df','\0','2011-06-15 14:33:57'),(14,'sport','\0','2011-06-15 14:35:16'),(15,'asd','\0','2011-06-15 14:35:29'),(16,'music','\0','2011-06-15 14:37:33');
/*!40000 ALTER TABLE `tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_component`
--

DROP TABLE IF EXISTS `tag_component`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag_component` (
  `tag_id` bigint(20) NOT NULL,
  `component_type` tinyint(2) NOT NULL,
  `component_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`,`component_type`,`component_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_component`
--

LOCK TABLES `tag_component` WRITE;
/*!40000 ALTER TABLE `tag_component` DISABLE KEYS */;
INSERT INTO `tag_component` VALUES (1,0,12,'2011-06-12 09:09:05'),(2,0,12,'2011-06-12 09:09:05'),(3,0,12,'2011-06-12 09:09:05'),(4,0,11,'2011-06-13 06:14:10'),(5,0,12,'2011-06-13 14:29:45'),(6,0,11,'2011-06-14 04:21:43'),(7,0,15,'2011-06-14 16:45:38'),(5,0,15,'2011-06-14 16:45:38'),(4,0,15,'2011-06-14 16:47:07'),(8,0,15,'2011-06-14 16:47:31'),(9,0,15,'2011-06-14 16:54:17'),(10,0,15,'2011-06-14 16:54:40'),(11,0,12,'2011-06-15 14:33:36'),(12,0,12,'2011-06-15 14:33:45'),(13,0,12,'2011-06-15 14:33:57'),(7,0,20,'2011-06-15 14:34:44'),(4,0,20,'2011-06-15 14:34:54'),(14,0,20,'2011-06-15 14:35:16'),(15,0,20,'2011-06-15 14:35:29'),(16,0,20,'2011-06-15 14:37:33');
/*!40000 ALTER TABLE `tag_component` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'key',
  `username` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password` varchar(255) CHARACTER SET latin1 NOT NULL,
  `email` varchar(255) CHARACTER SET latin1 NOT NULL,
  `password_hint` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `account_locked` bit(1) NOT NULL DEFAULT b'0',
  `account_enabled` bit(1) NOT NULL DEFAULT b'1',
  `full_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `website` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `profile_alias` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (20,'shunda320@yahoo.com','1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1','shunda320@yahoo.com',NULL,'\0','','Hai',NULL,NULL,'2011-05-26 11:07:09',NULL),(21,'shunda1@yahoo.com','1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1','shunda1@yahoo.com',NULL,'\0','','Hai Pham',NULL,NULL,'2011-05-26 11:07:46',NULL),(22,'truonghai.ad@yahoo.com','1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1','truonghai.ad@yahoo.com',NULL,'\0','','Truong Hai',NULL,NULL,'2011-05-26 11:08:26',NULL),(23,'truonghai.pham@gmail.com','1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1','truonghai.pham@gmail.com',NULL,'\0','','Hai',NULL,NULL,'2011-05-26 11:10:01',NULL),(24,'tringuyen@ongsoft.com','1dsat40113c8f6c2c2e1760c8bb10921efbff57c0589d9','tringuyen@ongsoft.com',NULL,'\0','','Tri Nguyen',NULL,'test','2011-06-04 05:20:57','syrlelrk60ky0g3wq2lacaw23h4pbeny.jpg'),(25,'phuthuy842001@yahoo.com','1dsat4b86fd942375522fb29da98092d0eebcb380a95e8','phuthuy842001@yahoo.com',NULL,'\0','','Ngoc Thy','http://thyvo.com','tvo34','2011-06-05 07:59:23','zn8akz35jesjw5xzirel6qgyu0sdo9ep.gif'),(26,'karen160584@yahoo.com','1dsat4b86fd942375522fb29da98092d0eebcb380a95e8','karen160584@yahoo.com',NULL,'\0','','Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy Vo Thy',NULL,NULL,'2011-06-06 13:21:23',NULL),(27,'thyvothyvothyvothyvothyvothyvothyvothyvothyvothyvothythyvothyvothyvothyvothyvo@yahoo.com','1dsat4b86fd942375522fb29da98092d0eebcb380a95e8','thyvothyvothyvothyvothyvothyvothyvothyvothyvothyvothythyvothyvothyvothyvothyvo@yahoo.com',NULL,'\0','','Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy vo Thy',NULL,NULL,'2011-06-06 13:47:35',NULL),(28,'a@yahoo.com','1dsat4b86fd942375522fb29da98092d0eebcb380a95e8','a@yahoo.com',NULL,'\0','','aaa',NULL,NULL,'2011-06-06 15:20:35',NULL),(29,'b@yahoo.com','1dsat4a1f47e1162a2e1767e284c41c1b4705d305b771e','b@yahoo.com',NULL,'\0','','testb',NULL,NULL,'2011-06-07 16:13:21',NULL),(30,'c@yahoo.com','1dsat4a1f47e1162a2e1767e284c41c1b4705d305b771e','c@yahoo.com',NULL,'\0','','test',NULL,NULL,'2011-06-07 16:16:55',NULL),(31,'d@yahoo.com','1dsat4b86fd942375522fb29da98092d0eebcb380a95e8','d@yahoo.com',NULL,'\0','','Thy Vo',NULL,NULL,'2011-06-07 16:28:35',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (20,1,'2011-05-24 11:16:48'),(21,1,'2011-05-24 11:16:48'),(22,1,'2011-05-24 11:16:48'),(23,1,'2011-05-24 11:16:48'),(24,1,'2011-06-04 05:20:57'),(25,1,'2011-06-05 07:59:23'),(26,1,'2011-06-06 13:21:23'),(27,1,'2011-06-06 13:47:35'),(28,1,'2011-06-06 15:20:35'),(29,1,'2011-06-07 16:13:21'),(30,1,'2011-06-07 16:16:55'),(31,1,'2011-06-07 16:28:35');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `video_title` varchar(255) DEFAULT NULL,
  `pre_roll` int(11) DEFAULT NULL,
  `post_roll` int(11) DEFAULT NULL,
  `video_path` varchar(255) NOT NULL,
  `thumbnails_path` varchar(255) DEFAULT NULL,
  `video_theme` varchar(1000) DEFAULT NULL,
  `video_alias` varchar(255) DEFAULT NULL,
  `play_count` int(10) NOT NULL DEFAULT '0',
  `comment_count` int(10) NOT NULL DEFAULT '0',
  `like_count` int(10) NOT NULL DEFAULT '0',
  `video_locked` bit(1) NOT NULL DEFAULT b'0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` tinytext,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `video_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `video`
--

LOCK TABLES `video` WRITE;
/*!40000 ALTER TABLE `video` DISABLE KEYS */;
INSERT INTO `video` VALUES (1,23,NULL,NULL,NULL,'C:\\Users\\son\\Desktop\\entertaiment',NULL,NULL,NULL,6,7,8,'\0','2011-05-26 11:19:39',NULL),(2,23,NULL,NULL,NULL,'C:\\Users\\son\\Desktop\\entertaimentss',NULL,NULL,NULL,10,9,12,'','2011-05-26 11:21:22',NULL),(3,23,NULL,NULL,NULL,'C:\\Users\\son\\VIDEO\\entertaiment',NULL,NULL,NULL,9,7,5,'\0','2011-05-26 11:24:29',NULL),(4,23,NULL,NULL,NULL,'D:\\Users\\son\\Desktop\\entertaiment',NULL,NULL,NULL,25000,50,2000,'\0','2011-05-26 11:25:32',NULL),(5,23,NULL,NULL,NULL,'E:\\Users\\son\\Desktop\\video',NULL,NULL,NULL,56,12,12,'','2011-05-26 11:27:39',NULL),(6,21,NULL,NULL,NULL,'C:\\Users\\son\\Desktop\\entertaiment',NULL,NULL,NULL,8,7,6,'\0','2011-05-26 11:35:17',NULL),(7,21,NULL,NULL,NULL,'D:\\Users\\son\\Desktop\\entertaiment',NULL,NULL,NULL,23,21,45,'\0','2011-05-26 11:35:48',NULL),(8,21,NULL,NULL,NULL,'C:\\Users\\son\\VIDEO\\entertaiment',NULL,NULL,NULL,54,34,4,'\0','2011-05-26 11:36:54',NULL),(9,21,NULL,NULL,NULL,'E:\\Users\\son\\Desktop\\video',NULL,NULL,NULL,21,12,56,'\0','2011-05-26 11:37:27',NULL),(10,21,NULL,NULL,NULL,'C:\\Users\\son\\VIDEO\\entertaiment',NULL,NULL,NULL,0,0,0,'\0','2011-05-26 11:41:23',NULL),(11,24,'Test',NULL,NULL,'yn5tupug3q1z3yuqzw6pers8i4soiakr.flv',NULL,NULL,NULL,0,0,0,'\0','2011-06-10 04:53:40','Test'),(12,25,'Possibilities',NULL,NULL,'llfz3dic507ydkjp453zqmkdi4gx7lai.flv',NULL,NULL,'test',0,0,0,'\0','2011-06-12 06:25:39','dsafs'),(13,24,NULL,NULL,NULL,'ff9cfw04y6rlmi2quogwqlhlvs50dnm9.flv',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 04:31:49',NULL),(14,24,NULL,NULL,NULL,'tymm76lv5y5xem383b86htnlaeiip3bv.flv',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 04:33:40',NULL),(15,25,'Possibilities',NULL,NULL,'86egnahpj3j751x0f6j8200l67xx58cr.flv',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 14:19:52','second life'),(16,25,NULL,NULL,NULL,'o45foifhfas53kpb7fz889vr6qvomo5s.flv',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 15:01:15',NULL),(17,25,NULL,NULL,NULL,'3yi1hq1u0tctfnw6y7qfc7hh5pfulxjn.avi',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 15:10:26',NULL),(18,25,NULL,NULL,NULL,'yx3wmcu3vfrnxx4q800gs1i1wlua3di3.avi',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 15:14:02',NULL),(19,25,NULL,NULL,NULL,'tprvltwk12rgju58ptx34vvot0dxzkrk.wmv',NULL,NULL,NULL,0,0,0,'\0','2011-06-14 15:44:08',NULL),(20,25,'education',NULL,NULL,'n0prdnlcurk50xvn3gqxhnpb46trupft.wmv',NULL,NULL,'1tvo',0,0,0,'\0','2011-06-14 15:46:31','education'),(21,28,NULL,NULL,NULL,'k0wyib49keri67a1ncl7hz2ew7dz6lrn.wmv',NULL,NULL,'educations',0,0,0,'\0','2011-06-15 15:59:03',NULL);
/*!40000 ALTER TABLE `video` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2011-06-17  3:57:21
