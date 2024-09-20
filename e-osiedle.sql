-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 19, 2024 at 10:36 PM
-- Server version: 11.5.2-MariaDB
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-osiedle`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `user_id`, `address_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image_path` varchar(2047) DEFAULT NULL,
  `date_published` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `text`, `image_path`, `date_published`, `user_id`) VALUES
(4, 'Gryzonie', 'Uprzejmie prosimy wszystkich mieszkańców budynku o zamykanie głównych drzwi wejściowych z powodu wchodzenia gryzoni, które w rezultacie niszczą dobra innych mieszkańców', '/uploads/66ec3cebe45ad_66e2059397243_th.jpeg', '2024-09-19 15:02:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

CREATE TABLE `apartments` (
  `id` int(11) NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `number` int(11) NOT NULL,
  `letter` varchar(1) DEFAULT NULL,
  `floor` int(11) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`id`, `address_id`, `number`, `letter`, `floor`, `owner`, `amount`) VALUES
(1, 1, 0, '', 0, NULL, NULL),
(2, 1, 1, '', 1, 1, NULL),
(3, 1, 2, '', 1, NULL, NULL),
(4, 1, 3, '', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `recurrence` varchar(255) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `start_date`, `end_date`, `recurrence`, `address_id`) VALUES
(1, 'Przyjazd śmieciarki', 'Śmieciarka zabiera śmieci ze strony ul. Zachodniej', '2024-09-16 12:00:00', '2024-09-16 12:10:00', 'WEEKLY,MO,TH', 1),
(2, 'HB', '100', '2024-10-04 00:00:00', '2024-10-04 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `multifamily_residential`
--

CREATE TABLE `multifamily_residential` (
  `id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `block` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `multifamily_residential`
--

INSERT INTO `multifamily_residential` (`id`, `address`, `block`) VALUES
(1, 'Piotrkowska 1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `amount` decimal(7,2) NOT NULL,
  `month_year` date NOT NULL,
  `payment_date` date DEFAULT NULL,
  `status` enum('paid','unpaid','overdue') DEFAULT 'unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('open','in_progress','resolved') DEFAULT 'open'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `report_images`
--

CREATE TABLE `report_images` (
  `id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `residency_history`
--

CREATE TABLE `residency_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `apartment_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `residency_history`
--

INSERT INTO `residency_history` (`id`, `user_id`, `apartment_id`, `start_date`, `end_date`) VALUES
(2, 1, 2, '2024-09-19', '2024-09-19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(127) NOT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(127) NOT NULL,
  `email` varchar(127) NOT NULL,
  `name` varchar(31) NOT NULL,
  `last_name` varchar(31) NOT NULL,
  `apartment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `email`, `name`, `last_name`, `apartment_id`) VALUES
(1, 'admin', '$2y$10$JmkSz8wuLeVUlRqdgTXLlehD9//ETxSMGrIq4hhsZeU21JvaNO8mG', 'cfe2d82fa5ba8fb19b2c53a88260de4d', 'stanislav.mykhalevskyi@oulook.com', 'Stanislav', 'Mykhalevskyi', 2),
(2, 'jan_kowalski', '$2y$10$ZGwQz9bVxfzyEse2TH1sTOz5xZ9MhinoAD0c6v0GT83ZY9HNmKbqK', '018925c528ee6bf717ebefc5c8d0aa51', 'jan.kowalski@gmail.com', 'Jan', 'Kowalski', NULL),
(3, 'piotr_nowak', '$2y$10$RHNkNg8NQXPOmYU2/RuMze3PmyGwRW3JLj5vseFfuKhbvvinIc452', 'd38c16fcd7658b139d881e54807a1e9e', 'piotr.nowak@gmail.com', 'Piotr', 'Nowak', NULL),
(4, 'anna_kowalska', '$2y$10$FJlefIpmcaitzfK8eNm.2uuqrAk9zJvWo9zX9t/5LTsBf45lnqGYm', '39fad6a27fa8eaded49e8dabcb75acd9', 'anna.kowalska@gmail.com', 'Anna', 'Kowalska', 2),
(5, 'tomasz_wisnieski', '$2y$10$7aGUsHm3PwUnW1.Mwtyw.OMTwPqYMZ1Qi18mQ2P0kLtkEQcXrNcmK', 'a61cbbc83d17b7c54ab4a24310521a78', 'tomasz.wisniewski@gmail.com', 'Tomasz', 'Wiśniewski', NULL),
(6, 'marcin_wojcik', '$2y$10$ZQMISR9Ftj1fAFWFaSMsjud.OluIxV2xu9P9ddTDjHULs/ZCaaLZ6', '5df6296831af39bd620857e8efc7ba79', 'marcin.wojcik@gmail.com', 'Marcin', 'Wójcik', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `apartments`
--
ALTER TABLE `apartments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `owner_id` (`owner`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_ibfk_1` (`address_id`);

--
-- Indexes for table `multifamily_residential`
--
ALTER TABLE `multifamily_residential`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apartment_id` (`apartment_id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_apartment` (`apartment_id`);

--
-- Indexes for table `report_images`
--
ALTER TABLE `report_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_id` (`issue_id`);

--
-- Indexes for table `residency_history`
--
ALTER TABLE `residency_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `apartment_id` (`apartment_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apartment_id` (`apartment_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `apartments`
--
ALTER TABLE `apartments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `multifamily_residential`
--
ALTER TABLE `multifamily_residential`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `report_images`
--
ALTER TABLE `report_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `residency_history`
--
ALTER TABLE `residency_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrators`
--
ALTER TABLE `administrators`
  ADD CONSTRAINT `administrators_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `administrators_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `multifamily_residential` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION;

--
-- Constraints for table `apartments`
--
ALTER TABLE `apartments`
  ADD CONSTRAINT `address_id` FOREIGN KEY (`address_id`) REFERENCES `multifamily_residential` (`id`),
  ADD CONSTRAINT `owner_id` FOREIGN KEY (`owner`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`address_id`) REFERENCES `multifamily_residential` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_apartment` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`);

--
-- Constraints for table `report_images`
--
ALTER TABLE `report_images`
  ADD CONSTRAINT `report_images_ibfk_1` FOREIGN KEY (`issue_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `residency_history`
--
ALTER TABLE `residency_history`
  ADD CONSTRAINT `fk_residency_apartment` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_residency_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_apartment` FOREIGN KEY (`apartment_id`) REFERENCES `apartments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
