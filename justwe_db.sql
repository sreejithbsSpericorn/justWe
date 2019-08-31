-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2019 at 03:21 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `justwe_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `DeleteUser` (IN `_user_id` INT)  BEGIN
    
      
    UPDATE  users SET active = 1 WHERE active = 0 AND id=_user_id;
          
      
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPosts` (IN `_post_type` INT, IN `_post_id` INT)  BEGIN
     IF _post_type = 0 AND _post_id = 0 THEN
      
               SELECT posts.* ,COUNT(post_comments.id) AS no_comments,GROUP_CONCAT( CONCAT(post_options.options, ' - ', post_options.id)  SEPARATOR ',') AS poll_options  FROM `posts` LEFT JOIN `post_comments` on `post_comments`.`post_id` = `posts`.`id`  LEFT JOIN `post_options` on FIND_IN_SET(`posts`.`id`,`post_options`.`post_id`) WHERE ( posts.expire_date >= CURDATE() OR posts.expire_date IS  NULL) AND posts.post_type !=4 group by `post_comments`.`id`,`posts`.`id`order by `post_comments`.`id` DESC,`posts`.`id` DESC;
     ELSEIF _post_type != 0 AND _post_id = 0 THEN
       
          SELECT posts.* ,COUNT(post_comments.id) AS no_comments,GROUP_CONCAT(CONCAT(post_options.options, ' - ', post_options.id)  SEPARATOR ',') AS poll_options  FROM `posts` LEFT JOIN `post_comments` on `post_comments`.`post_id` = `posts`.`id`  LEFT JOIN `post_options` on FIND_IN_SET(`posts`.`id`,`post_options`.`post_id`) WHERE ( posts.expire_date >= CURDATE() OR posts.expire_date IS  NULL) AND posts.post_type =_post_type group by `post_comments`.`id`,`posts`.`id`order by `post_comments`.`id` DESC,`posts`.`id` DESC;
          
      
     

     ELSE
           SELECT `posts`.* ,COUNT(post_comments.id) AS no_comments,GROUP_CONCAT( CONCAT(post_options.options, ' - ', post_options.id)  SEPARATOR ',') AS poll_options  FROM `posts` LEFT JOIN `post_comments` on `post_comments`.`post_id` = `posts`.`id`  LEFT JOIN `post_options` on FIND_IN_SET(`posts`.`id`,`post_options`.`post_id`) WHERE ( posts.expire_date >= CURDATE() OR posts.expire_date IS  NULL) AND posts.id =_post_id group by `post_comments`.`id`,`posts`.`id` order by `post_comments`.`id` DESC,`posts`.`id` DESC;

      END IF;

   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUsers` (IN `_type_id` INT, IN `_user_id` INT)  BEGIN
     IF _user_id!=0 THEN
      
        SELECT * FROM users WHERE active = 0 AND id=_user_id;
          
      
     ELSE
       
         SELECT * FROM users WHERE active = 0 AND user_type =_type_id ;
      END IF;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pollings`
--

CREATE TABLE `pollings` (
  `id` int(11) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `post_options_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `post_type` int(11) UNSIGNED NOT NULL,
  `title` longtext NOT NULL,
  `descriptions` longtext,
  `image` varchar(191) DEFAULT NULL,
  `post_tags` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expire_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_type`, `title`, `descriptions`, `image`, `post_tags`, `created_at`, `updated_at`, `expire_date`) VALUES
(1, 7, 2, 'non tech', 'non tech', NULL, NULL, '2019-08-28 09:37:00', '0000-00-00 00:00:00', NULL),
(2, 7, 3, 'test', 'lllllllllllllllllllll', '/uploads/posts/1567238454.jpg', NULL, '2019-08-31 11:31:23', '0000-00-00 00:00:00', '2019-08-30'),
(3, 38, 4, 'Highcharts Demo', 'fdf', NULL, NULL, '2019-08-30 06:05:24', '2019-08-30 06:05:24', NULL),
(4, 36, 1, 'Title', 'Description', 'Description', '[\"PHP\",\"Python\"]', '2019-08-31 02:28:41', '2019-08-31 02:28:41', NULL),
(5, 36, 1, 'Title', 'Description', NULL, '[\"PHP\",\"Python\"]', '2019-08-31 02:29:06', '2019-08-31 02:29:06', NULL),
(6, 36, 1, 'Title', 'Description', NULL, '[\"PHP\",\"Python\"]', '2019-08-31 02:29:32', '2019-08-31 02:29:32', NULL),
(7, 36, 1, 'Title', 'Description', NULL, '[\"PHP\",\"Python\"]', '2019-08-31 02:30:24', '2019-08-31 02:30:24', NULL),
(8, 36, 1, 'dfgnd', 'dfn', '/uploads/posts/1567238454.jpg', '[\"PHP\",\"Python\"]', '2019-08-31 02:30:54', '2019-08-31 02:30:54', NULL),
(9, 36, 1, 'dfsb', 'sdfh', '/uploads/posts/1567240050.jpg', '[\"PHP\",\"Python\"]', '2019-08-31 02:57:30', '2019-08-31 02:57:30', NULL),
(10, 36, 1, 'dfsb', 'sdfh', '/uploads/posts/1567240067.jpg', '[\"PHP\",\"Python\"]', '2019-08-31 02:57:47', '2019-08-31 02:57:47', NULL),
(11, 36, 1, 'sdfn', 'sdfh', '/uploads/posts/1567240083.jpg', '[\"PHP\",\"Python\"]', '2019-08-31 02:58:03', '2019-08-31 02:58:03', NULL),
(12, 36, 1, 'rtyj', 'rtyg', '/uploads/posts/1567240156.jpg', '[\"Python\",\"Android\"]', '2019-08-31 02:59:16', '2019-08-31 02:59:16', NULL),
(13, 36, 1, 'dc', 'df', NULL, '[\"PHP\"]', '2019-08-31 03:12:30', '2019-08-31 03:12:30', NULL),
(14, 36, 1, 's', 's', NULL, NULL, '2019-08-31 03:16:16', '2019-08-31 03:16:16', NULL),
(15, 36, 2, 'd', 'd', NULL, NULL, '2019-08-31 03:16:34', '2019-08-31 03:16:34', NULL),
(16, 36, 1, 'sdfb', 'ds', '/uploads/posts/1567241521.jpg', '[\"PHP\"]', '2019-08-31 03:22:01', '2019-08-31 03:22:01', NULL),
(17, 36, 1, 'dfb', 'dfb', '/uploads/posts/1567241597.jpg', NULL, '2019-08-31 03:23:17', '2019-08-31 03:23:17', NULL),
(18, 36, 2, 'dfbdf', 'dfh', NULL, NULL, '2019-08-31 03:35:08', '2019-08-31 03:35:08', NULL),
(19, 36, 1, 'My Post', 'My Description', '/uploads/posts/1567244190.jpg', '[\"PHP\",\"iOS\",\"UI\"]', '2019-08-31 04:06:30', '2019-08-31 04:06:30', NULL),
(20, 36, 1, 'ds', 's', NULL, '[\"Python\"]', '2019-08-31 06:13:05', '2019-08-31 06:13:05', NULL),
(21, 36, 1, 'sdg', 'dsg', '/uploads/posts/1567255758.jpg', '[\"PHP\",\"Android\"]', '2019-08-31 07:19:18', '2019-08-31 07:19:18', NULL),
(22, 36, 1, 'df', 'dfnh', '/uploads/posts/1567255781.jpg', '[\"Python\"]', '2019-08-31 07:19:41', '2019-08-31 07:19:41', NULL),
(23, 36, 1, 'tttttttttttt', 'dfgnhhhhhhhh', NULL, '[\"PHP\",\"Python\"]', '2019-08-31 07:20:40', '2019-08-31 07:20:40', NULL),
(24, 36, 1, '12121', 'dsfgdsfgdf', '/uploads/posts/1567256510.png', '[\"Python\",\"Android\"]', '2019-08-31 07:31:50', '2019-08-31 07:31:50', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comments` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_comments`
--

INSERT INTO `post_comments` (`id`, `post_id`, `user_id`, `comments`, `created_at`, `updated_at`) VALUES
(2, 1, 35, 'dfdf', '2019-08-30 12:13:44', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_images`
--

CREATE TABLE `post_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `image` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `post_options`
--

CREATE TABLE `post_options` (
  `id` int(10) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `options` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_options`
--

INSERT INTO `post_options` (`id`, `post_id`, `options`, `created_at`, `updated_at`) VALUES
(1, 2, 'a', '2019-08-28 09:38:06', '0000-00-00 00:00:00'),
(2, 2, 'b', '2019-08-28 09:38:15', '0000-00-00 00:00:00'),
(3, 2, 'c', '2019-08-28 09:38:24', '0000-00-00 00:00:00'),
(4, 2, 'd', '2019-08-28 09:38:30', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `post_types`
--

CREATE TABLE `post_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(25) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '0->show 1->not show',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `post_types`
--

INSERT INTO `post_types` (`id`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Technical', 0, '2019-08-27 03:56:56', '0000-00-00 00:00:00'),
(2, 'Non-Technical', 0, '2019-08-27 03:57:12', '0000-00-00 00:00:00'),
(3, 'Poll', 1, '2019-08-27 03:58:47', '0000-00-00 00:00:00'),
(4, 'Complaints', 1, '2019-08-27 03:59:02', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `empl_id` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_type` int(11) UNSIGNED NOT NULL DEFAULT '3',
  `active` int(11) NOT NULL DEFAULT '0' COMMENT '0->active 1->inactive',
  `pass_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_delete` int(11) NOT NULL DEFAULT '0' COMMENT '0->active 1->delete'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`, `empl_id`, `designation`, `user_type`, `active`, `pass_text`, `is_delete`) VALUES
(3, 'Shibila BS', 'shibilabs23@gmail.com', NULL, NULL, '9MqJcPMpU9OoRpn4zc9MMmqt6URLYIy3MsEMYqxcFZnGBICCrR2nCjrHOu0V', '2019-08-26 05:17:21', '2019-08-26 05:17:21', '110597619798452201090', '', '', 3, 0, NULL, 0),
(7, 'Admin', 'admin@spericorn.com', NULL, '$2y$10$0vubRL8bYUZfcypmpMNrGOvFuZF5bbqN4xqUM9ddarowgthwYlrOK', NULL, '2019-08-27 03:58:20', '2019-08-27 03:58:20', NULL, NULL, NULL, 1, 0, NULL, 0),
(35, 'Shibila B', 'shibila.b@spericorn.com', NULL, NULL, 'lEhnV5LC3kyXTwZqROEehnsa9nWKgHllf1KtHEvtZfFE6unOqu61i3Nwp096', '2019-08-27 23:22:51', '2019-08-27 23:22:51', '110501969154466681683', NULL, NULL, 3, 0, NULL, 0),
(36, 'Sreejith B S', 'sreejith@spericorn.com', NULL, NULL, 'Kfq2qZN33TJGDlGP7nhgWy3Mlyw87tOWdhdOm1GUgr4unz6l6D8DkY0c9PzC', '2019-08-27 23:28:07', '2019-08-27 23:28:07', '117422074489297320832', NULL, NULL, 3, 0, NULL, 0),
(37, 'Sumesh M', 'sumesh.m@spericorn.com', NULL, NULL, 'BvHQRbJob0k72tEOzFdp0NdUyk0DtxrWJ526eSGxodwWePpvXD3JzUesaUkq', '2019-08-28 05:17:48', '2019-08-28 05:17:48', '115692105470834413430', NULL, NULL, 3, 0, NULL, 0),
(38, 'Anonymous', 'anonymous@spericorn.com', NULL, '$2y$10$oc81Udd.kSw4tFJ3RVOPROLn2Cn8C/oezoK2roodnPrkySj32uO8y', NULL, '2019-08-28 06:20:01', '2019-08-28 06:20:01', NULL, NULL, NULL, 2, 0, 'User@123', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `id` int(11) UNSIGNED NOT NULL,
  `type` varchar(25) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2019-08-26 14:58:11', '0000-00-00 00:00:00'),
(2, 'anonymous', '2019-08-26 14:57:59', '0000-00-00 00:00:00'),
(3, 'user', '2019-08-26 14:58:17', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pollings`
--
ALTER TABLE `pollings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `post_options_id` (`post_options_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_type` (`post_type`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_images`
--
ALTER TABLE `post_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_options`
--
ALTER TABLE `post_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post_types`
--
ALTER TABLE `post_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_type` (`user_type`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pollings`
--
ALTER TABLE `pollings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_options`
--
ALTER TABLE `post_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `post_types`
--
ALTER TABLE `post_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pollings`
--
ALTER TABLE `pollings`
  ADD CONSTRAINT `pollings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pollings_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pollings_ibfk_3` FOREIGN KEY (`post_options_id`) REFERENCES `post_options` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`post_type`) REFERENCES `post_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`post_type`) REFERENCES `post_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `posts_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_images`
--
ALTER TABLE `post_images`
  ADD CONSTRAINT `post_images_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post_options`
--
ALTER TABLE `post_options`
  ADD CONSTRAINT `post_options_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type`) REFERENCES `user_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
