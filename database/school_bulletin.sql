-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 02:40 AM
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
-- Database: `school_bulletin`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` enum('urgent','reminder','due date','important') NOT NULL DEFAULT 'reminder',
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `expired_date` date DEFAULT NULL,
  `status` enum('pending','approved','dismissed','deleted') NOT NULL DEFAULT 'pending',
  `posted_by` int(11) NOT NULL,
  `approved_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcement_id`, `title`, `category`, `description`, `date`, `expired_date`, `status`, `posted_by`, `approved_by`) VALUES
(1, 'aerol pumasok ka', 'urgent', 'ayaw pumasok amp \r\nasdn asd sd\r\nasd asdasd \r\nasda sdasd \r\nasdasdasda\r\ndasdasdasd', '2025-05-03 10:31:14', '2025-05-17', 'approved', 2, '2'),
(3, 'marcus', 'reminder', 'tanginamo', '2025-05-03 16:11:21', NULL, 'approved', 2, '2'),
(4, 'aerol', 'reminder', 'testing', '2025-05-03 16:31:43', NULL, 'approved', 3, '2'),
(5, 'adjnakjsd', 'reminder', 'daskjndad\r\n', '2025-05-04 00:32:51', NULL, 'pending', 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('admin','student','professor') NOT NULL DEFAULT 'student',
  `email` varchar(100) NOT NULL,
  `user_code` varchar(10) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `password`, `user_type`, `email`, `user_code`, `date`) VALUES
(2, 'dreyu', 'dreyu', '$2y$10$IPV9JodFCN75jnsV8wxSKexlXICHzISg7J2qXpSUpAU1bd0ckAWmy', 'admin', 'dreyujhon@gmail.com', 'E9CC3', '2025-05-02 04:10:50'),
(3, 'aerol', 'aerol123', '$2y$10$z9DxZ26HjLb1QKtxNTxbHeCSR7MYRavI1HhukymobWSP1WhEL1eQi', 'professor', 'aerol@gmail.com', '1B215', '2025-05-03 16:29:27'),
(4, 'marcus', 'tasho', '$2y$10$xjZwVE72xaeNK8x06ehRdOgADrHphgNO5E7x5BJaZeq1GVSrKA0B2', 'student', 'tasho@gmail.com', 'F881E', '2025-05-03 16:29:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
