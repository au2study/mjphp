-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2024-05-28 15:24:20
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `mahjong`
--

-- --------------------------------------------------------

--
-- 資料表結構 `chapter_progress`
--

CREATE TABLE `chapter_progress` (
  `id` int(3) NOT NULL,
  `user_id` int(3) NOT NULL,
  `chapter_id` int(3) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `course`
--

CREATE TABLE `course` (
  `id` int(5) UNSIGNED NOT NULL,
  `course_name` varchar(50) NOT NULL,
  `course_category_id` int(3) NOT NULL,
  `price` int(6) UNSIGNED NOT NULL,
  `image` varchar(50) NOT NULL,
  `create_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `course`
--

INSERT INTO `course` (`id`, `course_name`, `course_category_id`, `price`, `image`, `create_at`, `updated_at`, `status`) VALUES
(1, 'Spider-Man', 0, 500, 'spiderman.jpg', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(2, 'Superman', 0, 1000, 'superman.png', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(3, 'Wonder Woman', 0, 3000, 'wonderwoman.webp', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(4, 'Iron Man', 0, 10000, 'ironman.png', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(5, 'Batman', 0, 10000, 'batman.webp', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(6, 'Black Widow', 0, 1100, 'blackwidow.jpg', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(7, 'Flash', 0, 800, 'flash.jpg', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(8, 'Captain America', 0, 900, 'captain-america.png', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(9, 'Shazam', 0, 400, 'shazam.jpg', '2024-05-28 15:09:26', '2024-05-28 15:09:26', ''),
(10, 'Thor', 0, 3000, 'thor.jpg', '2024-05-28 15:09:26', '2024-05-28 15:09:26', '');

-- --------------------------------------------------------

--
-- 資料表結構 `course_category`
--

CREATE TABLE `course_category` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `course_chapter`
--

CREATE TABLE `course_chapter` (
  `id` int(3) NOT NULL,
  `course_id` int(11) NOT NULL,
  `chapter_name` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `video_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `course_order`
--

CREATE TABLE `course_order` (
  `id` int(3) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `order_date` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `course_order`
--

INSERT INTO `course_order` (`id`, `user_id`, `course_id`, `status`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 0, 0, 0, '2024-05-28 15:21:47', '2024-05-28 00:00:00', '2024-05-28 00:00:00'),
(2, 0, 0, 0, '2024-05-28 15:21:47', '2024-05-28 00:00:00', '2024-05-28 00:00:00'),
(3, 0, 0, 0, '2024-05-28 15:21:47', '2024-05-28 00:00:00', '2024-05-28 00:00:00'),
(4, 0, 0, 0, '2024-05-28 15:21:47', '2024-05-28 00:00:00', '2024-05-28 00:00:00'),
(5, 0, 0, 0, '2024-05-28 15:21:47', '2024-05-28 00:00:00', '2024-05-28 00:00:00');

-- --------------------------------------------------------

--
-- 資料表結構 `images`
--

CREATE TABLE `images` (
  `id` int(3) NOT NULL,
  `name` varchar(50) NOT NULL,
  `pic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- 傾印資料表的資料 `images`
--

INSERT INTO `images` (`id`, `name`, `pic_name`) VALUES
(1, '???', '7.png');

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(6) UNSIGNED NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `account` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `valid` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `name`, `account`, `password`, `phone`, `email`, `created_at`, `valid`) VALUES
(1, 'Jack', 'Jack', '0', '0922111444', 'se@fe4', '2024-05-16 11:46:35', 1),
(2, 'Sam', 'Sam01', '0', '0917000000', 'may@example.com', '2024-05-16 05:58:50', 1),
(3, 'Jack', 'Jack', '0', '0911111111', 'e@fe', '2024-05-16 05:58:50', 1),
(4, 'Lucy', 'Lucy', '0', '0912003000', 'lucy@example.com', '2024-05-16 05:58:50', 1),
(5, '5566', '5566', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:52:01', 1),
(6, 'dadada', 'dadada', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:40:12', 1),
(7, 'qwee', 'qwee', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:40:36', 1),
(8, 'qqrr', 'qqrr', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:40:46', 1),
(9, 'wwrrr', 'wwrrr', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:40:52', 1),
(10, 'peter', 'peter', '12345', NULL, NULL, '2024-05-20 04:41:02', 1),
(11, 'wwwee', 'wwwee', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:43:01', 1),
(12, 'eeww', 'eeww', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:43:07', 1),
(13, 'ttrr', 'ttrr', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:43:12', 1),
(14, '5533', '5533', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:43:18', 1),
(15, '3344', '3344', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:43:23', 1),
(16, '1616', '1616', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-20 04:43:40', 1),
(18, 'tesla', 'tesla', '827ccb0eea8a706c4c34a16891f84e7b', NULL, NULL, '2024-05-27 10:56:05', 0);

-- --------------------------------------------------------

--
-- 資料表結構 `user_like`
--

CREATE TABLE `user_like` (
  `id` int(6) UNSIGNED NOT NULL,
  `product_id` int(4) UNSIGNED NOT NULL,
  `user_id` int(6) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `user_order`
--

CREATE TABLE `user_order` (
  `id` int(6) UNSIGNED NOT NULL,
  `product_id` int(4) UNSIGNED NOT NULL,
  `amount` int(3) NOT NULL,
  `user_id` int(6) NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user_order`
--

INSERT INTO `user_order` (`id`, `product_id`, `amount`, `user_id`, `order_date`) VALUES
(1, 6, 4, 6, '2024-05-21'),
(2, 5, 3, 5, '2024-05-21'),
(3, 3, 3, 2, '2024-05-20'),
(4, 3, 4, 5, '2024-05-20'),
(5, 3, 5, 6, '2024-05-20'),
(6, 3, 4, 2, '2024-05-19'),
(7, 6, 4, 6, '2024-05-19'),
(8, 7, 5, 1, '2024-05-19'),
(9, 3, 7, 8, '2024-05-18'),
(10, 2, 4, 3, '2024-05-20'),
(11, 4, 5, 6, '2024-05-22'),
(12, 6, 7, 2, '2024-05-22');

-- --------------------------------------------------------

--
-- 資料表結構 `user_order_course`
--

CREATE TABLE `user_order_course` (
  `id` int(5) UNSIGNED NOT NULL,
  `user_id` int(6) NOT NULL,
  `order_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user_order_course`
--

INSERT INTO `user_order_course` (`id`, `user_id`, `order_time`) VALUES
(1, 1, '2024-05-27 15:27:25'),
(2, 1, '2024-05-27 15:48:21'),
(3, 1, '2024-05-27 15:48:25'),
(4, 1, '2024-05-27 15:48:31'),
(5, 1, '2024-05-27 15:48:33'),
(6, 1, '2024-05-27 15:52:09'),
(7, 1, '2024-05-27 15:53:09');

-- --------------------------------------------------------

--
-- 資料表結構 `user_order_course_detail`
--

CREATE TABLE `user_order_course_detail` (
  `id` int(5) UNSIGNED NOT NULL,
  `order_id` int(5) NOT NULL,
  `product_id` int(5) NOT NULL,
  `amount` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 傾印資料表的資料 `user_order_course_detail`
--

INSERT INTO `user_order_course_detail` (`id`, `order_id`, `product_id`, `amount`) VALUES
(1, 6, 3, 0),
(2, 6, 2, 0),
(3, 7, 5, 1),
(4, 7, 6, 1);

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `chapter_progress`
--
ALTER TABLE `chapter_progress`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `course_category`
--
ALTER TABLE `course_category`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `course_chapter`
--
ALTER TABLE `course_chapter`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `course_order`
--
ALTER TABLE `course_order`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_like`
--
ALTER TABLE `user_like`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_order`
--
ALTER TABLE `user_order`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_order_course`
--
ALTER TABLE `user_order_course`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `user_order_course_detail`
--
ALTER TABLE `user_order_course_detail`
  ADD PRIMARY KEY (`id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `chapter_progress`
--
ALTER TABLE `chapter_progress`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course`
--
ALTER TABLE `course`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course_category`
--
ALTER TABLE `course_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course_chapter`
--
ALTER TABLE `course_chapter`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `course_order`
--
ALTER TABLE `course_order`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `images`
--
ALTER TABLE `images`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_like`
--
ALTER TABLE `user_like`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order`
--
ALTER TABLE `user_order`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order_course`
--
ALTER TABLE `user_order_course`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_order_course_detail`
--
ALTER TABLE `user_order_course_detail`
  MODIFY `id` int(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
