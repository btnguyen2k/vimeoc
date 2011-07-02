-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 01, 2011 at 10:13 PM
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
  `password` varchar(225) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `arrange` tinyint(2) NOT NULL,
  `thumbnails_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

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
  `thumbnails_path` varchar(255) DEFAULT NULL,
  `arrange` tinyint(2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

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

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
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
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

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
