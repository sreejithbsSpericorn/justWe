-- phpMyAdmin SQL Dump
-- version 4.8.0-dev
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2019 at 09:35 AM
-- Server version: 5.5.62-0ubuntu0.14.04.1
-- PHP Version: 7.2.8-1+ubuntu14.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gmaildb`
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
  `descriptions` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) NOT NULL,
  `expire_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_type`, `title`, `descriptions`, `created_at`, `updated_at`, `created_by`, `expire_date`) VALUES
(1, 7, 2, 'non tech', 'non tech', '2019-08-28 09:37:00', '0000-00-00 00:00:00', 7, NULL),
(2, 7, 3, 'test', '', '2019-08-30 12:00:23', '0000-00-00 00:00:00', 0, '2019-08-30'),
(3, 38, 4, 'Highcharts Demo', 'fdf', '2019-08-30 06:05:24', '2019-08-30 06:05:24', 38, NULL);

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
  `pass_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `google_id`, `empl_id`, `designation`, `user_type`, `active`, `pass_text`) VALUES
(3, 'Shibila BS', 'shibilabs23@gmail.com', NULL, NULL, '9MqJcPMpU9OoRpn4zc9MMmqt6URLYIy3MsEMYqxcFZnGBICCrR2nCjrHOu0V', '2019-08-26 05:17:21', '2019-08-26 05:17:21', '110597619798452201090', '', '', 3, 0, NULL),
(7, 'Admin', 'admin@spericorn.com', NULL, '$2y$10$0vubRL8bYUZfcypmpMNrGOvFuZF5bbqN4xqUM9ddarowgthwYlrOK', NULL, '2019-08-27 03:58:20', '2019-08-27 03:58:20', NULL, NULL, NULL, 1, 0, NULL),
(35, 'Shibila B', 'shibila.b@spericorn.com', NULL, NULL, 'lEhnV5LC3kyXTwZqROEehnsa9nWKgHllf1KtHEvtZfFE6unOqu61i3Nwp096', '2019-08-27 23:22:51', '2019-08-27 23:22:51', '110501969154466681683', NULL, NULL, 3, 0, NULL),
(36, 'Sreejith B S', 'sreejith@spericorn.com', NULL, NULL, 'fPLkqGMTlvoXjfRVCGu1xuOvYZBUjz6pJjp78ySvaYKzV9xnf3snmfAHjAsw', '2019-08-27 23:28:07', '2019-08-27 23:28:07', '117422074489297320832', NULL, NULL, 3, 0, NULL),
(37, 'Sumesh M', 'sumesh.m@spericorn.com', NULL, NULL, 'BvHQRbJob0k72tEOzFdp0NdUyk0DtxrWJ526eSGxodwWePpvXD3JzUesaUkq', '2019-08-28 05:17:48', '2019-08-28 05:17:48', '115692105470834413430', NULL, NULL, 3, 0, NULL),
(38, 'Anonymous', 'anonymous@spericorn.com', NULL, '$2y$10$oc81Udd.kSw4tFJ3RVOPROLn2Cn8C/oezoK2roodnPrkySj32uO8y', NULL, '2019-08-28 06:20:01', '2019-08-28 06:20:01', NULL, NULL, NULL, 2, 0, 'User@123');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
