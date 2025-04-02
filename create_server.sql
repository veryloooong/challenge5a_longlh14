-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2025 at 04:54 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `challenge5a_longlh14`
--

-- --------------------------------------------------------

--
-- Table structure for table `homework`
--

CREATE TABLE `homework` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework`
--

INSERT INTO `homework` (`id`, `title`, `description`) VALUES
(1, 'a', 'b'),
(2, 'SQL', 'wtf'),
(3, 'Fake', '123'),
(4, 'Test2', 'lamdi');

-- --------------------------------------------------------

--
-- Table structure for table `homework_files`
--

CREATE TABLE `homework_files` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `homework_files`
--

INSERT INTO `homework_files` (`id`, `assignment_id`, `path`) VALUES
(1, 1, '/uploads/teachers/8cd58cda8e10991f9a0bc41189ba87b87c547bba.pdf'),
(2, 2, '/uploads/teachers/3c1f0584773a2a60ec07ec70aa1368943ed37ee8.pdf'),
(3, 3, '/uploads/teachers/ff38137f103a900361957876c9b3c671f128a6f9.pdf'),
(4, 3, '/uploads/teachers/fb56b1e61d65654ad5d0362f7b854a940624c94c.pdf'),
(5, 4, '/uploads/teachers/3c1f0584773a2a60ec07ec70aa1368943ed37ee8.pdf'),
(6, 4, '/uploads/teachers/39eb581cabc2017927c0f25b1da081a5e5ba7382.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `content` mediumtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_from` int(11) NOT NULL,
  `user_to` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `content`, `created_at`, `user_from`, `user_to`) VALUES
(2, '1234 2341', '2025-03-26 08:24:15', 1, 3),
(3, 'hack', '2025-03-26 08:24:19', 1, 3),
(5, '<script>alert(1)</script>', '2025-03-26 08:29:43', 1, 3),
(8, 'leuleu', '2025-04-02 14:52:24', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `assignment_id`, `student_id`) VALUES
(3, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `submissions_files`
--

CREATE TABLE `submissions_files` (
  `id` int(11) NOT NULL,
  `submission_id` int(11) NOT NULL,
  `path` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions_files`
--

INSERT INTO `submissions_files` (`id`, `submission_id`, `path`) VALUES
(3, 3, '/uploads/students/39eb581cabc2017927c0f25b1da081a5e5ba7382.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `is_teacher` tinyint(1) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `name_first` varchar(100) NOT NULL,
  `name_last` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_teacher`, `email`, `phone`, `name_first`, `name_last`) VALUES
(1, 'teacher1', '$2y$10$qGjjRwbLK02UW5WhYFPx7u1gxMMI8PVIW58oTxOp8PG/aa5IgX/ZW', 1, 'teacher1@gmail.com', '0912345679', 'A', 'Nguyen Van'),
(2, 'teacher2', '$2y$10$EbwVvDJ2vEnJiwd1tZ//eu1/dX0.DKX99Krv6SYef9DOQrWTO/b/a', 1, 'teacher2@gmail.com', '0912345678', 'B', 'Nguyen Thi'),
(3, 'student1', '$2y$10$op1OdEudAQZJTpB1QluVh.XZJpLoWM6kgQaxAaBxVunpCXGXuSvx2', 0, 'student1@gmail.com', '0912345678', 'A', 'Le Van'),
(4, 'student2', '$2y$10$aCPZ8ICGs6diE2TjJZjhHOwEDWyXTWuZwX.8asqxIENAdKjmm630O', 0, 'student2@gmail.com', '0912345678', 'B', 'Le Thi'),
(5, 'student3', '$2y$10$XWynuQ0rbY6WcBJfAN2hzOwhIV3Belp6gP565KxjmAhJY7dzHJ/5C', 0, 'a@a.com', '0123456789', 'C', 'Nguyen Van');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `homework`
--
ALTER TABLE `homework`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homework_files`
--
ALTER TABLE `homework_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_messages_from` (`user_from`),
  ADD KEY `fk_messages_to` (`user_to`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `submissions_files`
--
ALTER TABLE `submissions_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_uniq_username` (`username`),
  ADD UNIQUE KEY `idx_uniq_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `homework`
--
ALTER TABLE `homework`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `homework_files`
--
ALTER TABLE `homework_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `submissions_files`
--
ALTER TABLE `submissions_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `homework_files`
--
ALTER TABLE `homework_files`
  ADD CONSTRAINT `homework_files_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `homework` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_from` FOREIGN KEY (`user_from`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_messages_to` FOREIGN KEY (`user_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `homework` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `submissions_files`
--
ALTER TABLE `submissions_files`
  ADD CONSTRAINT `submissions_files_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
