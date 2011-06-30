START TRANSACTION;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `vimeoc`
--

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `password_hint`, `account_locked`, `account_enabled`, `full_name`, `website`, `profile_alias`, `creation_date`, `avatar`) VALUES
(20, 'shunda320@yahoo.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'shunda320@yahoo.com', NULL, b'0', b'1', 'Hai', NULL, NULL, '2011-05-26 11:07:09', NULL),
(21, 'shunda1@yahoo.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'shunda1@yahoo.com', NULL, b'0', b'1', 'Hai Pham', NULL, NULL, '2011-05-26 11:07:46', NULL),
(22, 'truonghai.ad@yahoo.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'truonghai.ad@yahoo.com', NULL, b'0', b'1', 'Truong Hai', NULL, NULL, '2011-05-26 11:08:26', NULL),
(23, 'truonghai.pham@gmail.com', '1dsat4a3d4512812aaa4d3f977a04e00a74ebaa04ebfe1', 'truonghai.pham@gmail.com', NULL, b'0', b'1', 'Hai', NULL, NULL, '2011-05-26 11:10:01', NULL);


--
-- Dumping data for table `role`
--
INSERT INTO `role` (`id`, `name`) VALUES
(-9, 'ROLE_ADMIN'),
(1, 'ROLE_USER');


--
-- Dumping data for table `user_role`
--
INSERT INTO `user_role` (`user_id`, `role_id`, `creation_date`) VALUES
(20, 1, '2011-05-24 11:16:48'),
(21, 1, '2011-05-24 11:16:48'),
(22, 1, '2011-05-24 11:16:48'),
(23, 1, '2011-05-24 11:16:48');


--
-- Dumping data for table `album`
--

INSERT INTO `album` (`id`, `user_id`, `album_name`, `album_locked`, `album_alias`, `creation_date`, `description`) VALUES
(1, 23, 'HAI', b'1', NULL, '2011-05-26 11:50:52', NULL),
(2, 21, 'HaiPham', b'0', NULL, '2011-05-26 11:58:47', NULL);

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

COMMIT;