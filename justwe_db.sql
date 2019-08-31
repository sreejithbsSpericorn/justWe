-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 31, 2019 at 08:27 PM
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
       
          SELECT posts.* ,COUNT(post_comments.id) AS no_comments,GROUP_CONCAT(CONCAT(post_options.options, ' - ', post_options.id)  SEPARATOR ',') AS poll_options  FROM `posts` LEFT JOIN `post_comments` on `post_comments`.`post_id` = `posts`.`id`  LEFT JOIN `post_options` on FIND_IN_SET(`posts`.`id`,`post_options`.`post_id`) WHERE  posts.post_type =_post_type group by `post_comments`.`id`,`posts`.`id`order by `post_comments`.`id` DESC,`posts`.`id` DESC;
          
      
     

     ELSE
           SELECT `posts`.* ,COUNT(post_comments.id) AS no_comments,GROUP_CONCAT( CONCAT(post_options.options, ' - ', post_options.id)  SEPARATOR ',') AS poll_options  FROM `posts` LEFT JOIN `post_comments` on `post_comments`.`post_id` = `posts`.`id`  LEFT JOIN `post_options` on FIND_IN_SET(`posts`.`id`,`post_options`.`post_id`) WHERE ( posts.expire_date >= CURDATE() OR posts.expire_date IS  NULL) AND posts.id =_post_id group by `post_comments`.`id`,`posts`.`id` order by `post_comments`.`id` DESC,`posts`.`id` DESC;

      END IF;

   
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUsers` (IN `_type_id` INT, IN `_user_id` INT)  BEGIN
     IF _user_id!=0 THEN
      
        SELECT * FROM users WHERE is_delete = 0 AND id=_user_id;
          
      
     ELSE
       
         SELECT * FROM users WHERE is_delete = 0 AND user_type =_type_id ;
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

--
-- Dumping data for table `pollings`
--

INSERT INTO `pollings` (`id`, `user_id`, `post_id`, `post_options_id`, `created_at`, `updated_at`) VALUES
(3, 43, 51, 41, '2019-08-31 12:54:57', '2019-08-31 12:54:57');

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
  `created_by` int(11) DEFAULT NULL,
  `expire_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `post_type`, `title`, `descriptions`, `image`, `post_tags`, `created_at`, `updated_at`, `created_by`, `expire_date`) VALUES
(1, 7, 2, 'non tech', 'non tech', NULL, NULL, '2019-08-28 09:37:00', '0000-00-00 00:00:00', 7, NULL),
(29, 37, 2, 'zxzx', 'cxcxcxcxc', NULL, NULL, '2019-08-31 10:21:00', '2019-08-31 10:21:00', NULL, NULL),
(30, 37, 1, 'xx', 'xxx', NULL, NULL, '2019-08-31 10:22:02', '2019-08-31 10:22:02', NULL, NULL),
(31, 37, 1, 'hai shibila', 'xcxcx', NULL, '[\"Python\"]', '2019-08-31 10:22:27', '2019-08-31 10:22:27', NULL, NULL),
(32, 37, 1, 'god god', 'xcxcxc', NULL, '[\"Python\",\"Android\"]', '2019-08-31 10:23:28', '2019-08-31 10:23:28', NULL, NULL),
(33, 37, 1, 'xcfg', 'dfdf', NULL, '[\"Python\"]', '2019-08-31 10:23:52', '2019-08-31 10:23:52', NULL, NULL),
(36, 7, 3, 'Highcharts Demo god', NULL, '/uploads/posts/1567267742.jpg', NULL, '2019-08-31 16:09:02', '2019-08-31 10:39:02', NULL, '2019-09-15'),
(37, 7, 3, 'Test New Poll', NULL, '/uploads/posts/1567269359.jpg', NULL, '2019-08-31 16:35:59', '2019-08-31 11:05:59', NULL, '2019-12-11'),
(51, 7, 3, 'Which logo you like the most from the below image ?', NULL, '/uploads/posts/1567275309.png', NULL, '2019-08-31 18:15:09', '2019-08-31 12:45:09', NULL, '2019-11-14'),
(52, 38, 4, 'Suggestion regarding washroom', 'Men\'s washroom needs a better cleanliness.', NULL, NULL, '2019-08-31 12:47:58', '2019-08-31 12:47:58', NULL, NULL),
(53, 42, 1, 'What is a CSRF token ? What is its importance and how does it work?', 'I am writing an application (Django, it so happens) and I just want an idea of what actually a \"CSRF token\" is and how it protects the data. Is the post data not safe if you do not use CSRF tokens?', NULL, '[\"PHP\",\"Android\"]', '2019-08-31 12:52:12', '2019-08-31 12:52:12', NULL, NULL),
(54, 43, 1, 'heerh', 'rehraeh', '/uploads/posts/1567276048.jpg', '[\"Python\"]', '2019-08-31 12:57:28', '2019-08-31 12:57:28', NULL, NULL);

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
(6, 53, 42, 'Anyone?', '2019-08-31 12:52:29', '2019-08-31 12:52:29'),
(7, 53, 42, 'Second Comment', '2019-08-31 12:53:11', '2019-08-31 12:53:11'),
(8, 53, 43, 'Yes, the post data is safe. But the origin of that data is not. This way somebody can trick user with JS into logging in to your site, while browsing attacker\'s web page.\n\nIn order to prevent that, django will send a random key both in cookie, and form data. Then, when users POSTs, it will check if two keys are identical. In case where user is tricked, 3rd party website cannot get your site\'s cookies, thus causing auth error.', '2019-08-31 12:54:30', '2019-08-31 12:54:30');

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
(32, 36, 'xx', '2019-08-31 16:09:02', '0000-00-00 00:00:00'),
(33, 36, 'ccc', '2019-08-31 16:09:02', '0000-00-00 00:00:00'),
(34, 37, 'A', '2019-08-31 16:36:00', '0000-00-00 00:00:00'),
(35, 37, 'B', '2019-08-31 16:36:00', '0000-00-00 00:00:00'),
(36, 37, 'C', '2019-08-31 16:36:00', '0000-00-00 00:00:00'),
(37, 37, 'D', '2019-08-31 16:36:00', '0000-00-00 00:00:00'),
(41, 51, 'Logo 1', '2019-08-31 18:15:09', '0000-00-00 00:00:00'),
(42, 51, 'Logo 2', '2019-08-31 18:15:09', '0000-00-00 00:00:00'),
(43, 51, 'Logo 3', '2019-08-31 18:15:09', '0000-00-00 00:00:00');

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
(3, 'Shibila BS', 'shibilabs23@gmail.com', NULL, NULL, '9MqJcPMpU9OoRpn4zc9MMmqt6URLYIy3MsEMYqxcFZnGBICCrR2nCjrHOu0V', '2019-08-26 05:17:21', '2019-08-31 01:17:31', '110597619798452201090', '', '', 3, 0, NULL, 0),
(7, 'Admin', 'admin@spericorn.com', NULL, '$2y$10$0vubRL8bYUZfcypmpMNrGOvFuZF5bbqN4xqUM9ddarowgthwYlrOK', NULL, '2019-08-27 03:58:20', '2019-08-27 03:58:20', NULL, NULL, NULL, 1, 0, NULL, 0),
(37, 'Sumesh M', 'sumesh.m@spericorn.com', NULL, NULL, 'Ll53HKBNp5ByIlfSdc57TJR3WEo9KGqehRbhrKxP2wPu5hBC7TBEdOwaSkqW', '2019-08-28 05:17:48', '2019-08-31 10:50:53', '115692105470834413430', NULL, NULL, 3, 1, NULL, 0),
(38, 'Anonymous', 'anonymous@spericorn.com', NULL, '$2y$10$oc81Udd.kSw4tFJ3RVOPROLn2Cn8C/oezoK2roodnPrkySj32uO8y', NULL, '2019-08-28 06:20:01', '2019-08-28 06:20:01', NULL, NULL, NULL, 2, 0, 'User@123', 0),
(39, 'Shibila B', 'shibila.b@spericorn.com', NULL, NULL, '5OUaevxJD2BTFbuiYCFjWfUXdiz1UG4QMkLLuZEmDfksgJaSuR5XrDwZkckN', '2019-08-31 10:07:16', '2019-08-31 10:07:16', '110501969154466681683', NULL, NULL, 3, 0, NULL, 0),
(42, 'Sreejith B S', 'sreejith@spericorn.com', NULL, NULL, 'GFQ7d47hTG6outbFPwxzT2uqrcxlqNeYDHcyQRPbt3fXrV8l0MV5haGNAHZP', '2019-08-31 12:50:57', '2019-08-31 12:50:57', '117422074489297320832', NULL, NULL, 3, 0, NULL, 0),
(43, 'Jijo Jannest', 'jijo@spericorn.com', NULL, NULL, 'lDxg1ReGmkISq7AmKmk0bZtr7xlx40zBrlXzUR5g9BpChCFDvChFAwkdtEWm', '2019-08-31 12:53:49', '2019-08-31 12:53:49', '106429882794129134696', NULL, NULL, 3, 0, NULL, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `post_images`
--
ALTER TABLE `post_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_options`
--
ALTER TABLE `post_options`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `post_types`
--
ALTER TABLE `post_types`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

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
