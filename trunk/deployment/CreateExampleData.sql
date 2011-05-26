-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 26, 2011 at 12:16 CH
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vimeoc`
--

-- --------------------------------------------------------

--
-- Table structure for table `album`
--

CREATE TABLE IF NOT EXISTS `album` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `album_name` varchar(255) NOT NULL,
  `album_locked` bit(1) NOT NULL DEFAULT b'0',
  `album_alias` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` tinytext,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `user_id`, `album_name`, `album_locked`, `album_alias`, `creation_date`, `description`) VALUES
(1, 23, 'HAI', b'1', NULL, '2011-05-26 11:50:52', NULL),
(2, 21, 'HaiPham', b'0', NULL, '2011-05-26 11:58:47', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `album_video`
--

CREATE TABLE IF NOT EXISTS `album_video` (
  `album_id` bigint(20) NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`album_id`,`video_id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `album_video`
--

INSERT INTO `album_video` (`album_id`, `video_id`, `creation_date`) VALUES
(1, 1, '2011-05-26 12:10:11'),
(1, 2, '2011-05-26 12:10:18'),
(1, 3, '2011-05-26 12:10:23'),
(1, 4, '2011-05-26 12:10:29'),
(1, 5, '2011-05-26 12:10:34'),
(2, 6, '2011-05-26 12:07:55'),
(2, 7, '2011-05-26 12:08:01'),
(2, 8, '2011-05-26 12:08:07'),
(2, 9, '2011-05-26 12:08:14'),
(2, 10, '2011-05-26 12:08:19');

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE IF NOT EXISTS `channel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `channel_name` varchar(255) NOT NULL,
  `channel_locked` bit(1) NOT NULL DEFAULT b'0',
  `channel_alias` varchar(255) DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `description` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `channel`
--


-- --------------------------------------------------------

--
-- Table structure for table `channel_video`
--

CREATE TABLE IF NOT EXISTS `channel_video` (
  `channel_id` bigint(20) NOT NULL,
  `video_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`channel_id`,`video_id`),
  KEY `video_id` (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channel_video`
--


-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
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
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `like`
--

CREATE TABLE IF NOT EXISTS `like` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `component_type` tinyint(2) NOT NULL,
  `component_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `like` bit(1) NOT NULL DEFAULT b'1',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `like`
--


-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `role`
--


-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tag_locked` bit(1) NOT NULL DEFAULT b'0',
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tag`
--


-- --------------------------------------------------------

--
-- Table structure for table `tag_component`
--

CREATE TABLE IF NOT EXISTS `tag_component` (
  `tag_id` bigint(20) NOT NULL,
  `component_type` tinyint(2) NOT NULL,
  `component_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tag_id`,`component_type`,`component_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tag_component`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `password_hint`, `account_locked`, `account_enabled`, `full_name`, `website`, `profile_alias`, `creation_date`, `avatar`) VALUES
(20, 'shunda320@yahoo.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'shunda320@yahoo.com', NULL, b'0', b'1', 'Hai', NULL, NULL, '2011-05-26 11:07:09', NULL),
(21, 'shunda1@yahoo.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'shunda1@yahoo.com', NULL, b'0', b'1', 'Hai Pham', NULL, NULL, '2011-05-26 11:07:46', NULL),
(22, 'truonghai.ad@yahoo.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'truonghai.ad@yahoo.com', NULL, b'0', b'1', 'Truong Hai', NULL, NULL, '2011-05-26 11:08:26', NULL),
(23, 'truonghai.pham@gmail.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'truonghai.pham@gmail.com', NULL, b'0', b'1', 'Hai', NULL, NULL, '2011-05-26 11:10:01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE IF NOT EXISTS `user_role` (
  `user_id` bigint(20) NOT NULL,
  `role_id` bigint(20) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_role`
--


-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
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
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`id`, `user_id`, `video_path`, `thumbnails_path`, `video_theme`, `video_alias`, `play_count`, `comment_count`, `like_count`, `video_locked`, `creation_date`, `description`) VALUES
(1, 23, 'C:\\Users\\son\\Desktop\\entertaiment', NULL, NULL, NULL, 6, 7, 8, b'0', '2011-05-26 11:19:39', NULL),
(2, 23, 'C:\\Users\\son\\Desktop\\entertaimentss', NULL, NULL, NULL, 10, 9, 12, b'1', '2011-05-26 11:21:22', NULL),
(3, 23, 'C:\\Users\\son\\VIDEO\\entertaiment', NULL, NULL, NULL, 9, 7, 5, b'0', '2011-05-26 11:24:29', NULL),
(4, 23, 'D:\\Users\\son\\Desktop\\entertaiment', NULL, NULL, NULL, 25000, 50, 2000, b'0', '2011-05-26 11:25:32', NULL),
(5, 23, 'E:\\Users\\son\\Desktop\\video', NULL, NULL, NULL, 56, 12, 12, b'1', '2011-05-26 11:27:39', NULL),
(6, 21, 'C:\\Users\\son\\Desktop\\entertaiment', NULL, NULL, NULL, 8, 7, 6, b'0', '2011-05-26 11:35:17', NULL),
(7, 21, 'D:\\Users\\son\\Desktop\\entertaiment', NULL, NULL, NULL, 23, 21, 45, b'0', '2011-05-26 11:35:48', NULL),
(8, 21, 'C:\\Users\\son\\VIDEO\\entertaiment', NULL, NULL, NULL, 54, 34, 4, b'0', '2011-05-26 11:36:54', NULL),
(9, 21, 'E:\\Users\\son\\Desktop\\video', NULL, NULL, NULL, 21, 12, 56, b'0', '2011-05-26 11:37:27', NULL),
(10, 21, 'C:\\Users\\son\\VIDEO\\entertaiment', NULL, NULL, NULL, 0, 0, 0, b'0', '2011-05-26 11:41:23', NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `album`
--
ALTER TABLE `album`
  ADD CONSTRAINT `album_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `album_video`
--
ALTER TABLE `album_video`
  ADD CONSTRAINT `album_video_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `album_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `channel_video`
--
ALTER TABLE `channel_video`
  ADD CONSTRAINT `channel_video_ibfk_1` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `channel_video_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `video` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
