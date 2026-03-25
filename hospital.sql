-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2026 at 03:36 PM
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
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `appointment_time` time DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `user_id`, `department`, `reason`, `appointment_date`, `appointment_time`, `status`) VALUES
(1, 1, 'Dermatology', 'Doctor Wang', '2026-03-26', '11:30:00', 'Approved'),
(2, 4, 'General Medicine', 'Nothing', '2026-03-31', '15:30:00', 'Approved'),
(3, 4, 'Dermatology', 'asdasdasd', '2026-03-26', '08:30:00', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `staff_users`
--

CREATE TABLE `staff_users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `department` varchar(100) NOT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_users`
--

INSERT INTO `staff_users` (`id`, `fullname`, `username`, `password`, `department`, `status`, `created_at`) VALUES
(1, 'Test Staff', 'staff_admin', '$2y$10$bzmq5MaXDuKRYyAo4NWgEOO7EMD2AfMV.seumEeGdjnxdICrS9UC.', 'General Medicine', 'Active', '2026-03-25 12:03:37'),
(2, 'Vina Grace', 'vina@staff.com', '$2y$10$hD.ZBxj8/C8WQo8Nqe4J7uFmg1NKiHaQTeTNdb.ea/32GorqUs546', 'OPD', 'Active', '2026-03-25 14:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'patient',
  `department` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `department`, `created_at`) VALUES
(1, 'Shaina Jane Tanguan', 'shaynatanguan@gmail.com', '$2y$10$BDhGKgOko5oJMTWl7TBpo.ElAwUjHzV3BwDYyIYTgOcdl8Ut.P1He', 'patient', NULL, '2026-03-25 12:16:37'),
(2, 'Shaina Jane Tanguan', 'staff_01', '$2y$10$nQgW8euhfpAtTDU3BMv0deYFAjPxubLxENFLk./MDsYOMEhPtenDC', 'staff', 'OPD', '2026-03-25 12:16:37'),
(3, 'John Cruz', 'staff_02', '$2y$10$UEw4d6OmN1si3jU1kyxUyusOGzfGYX/h.9vnHdWl8ELA9jhnlJW0y', 'staff', 'Pediatrics', '2026-03-25 12:16:37'),
(4, 'Iares Gymn Villajuan', 'iaresgymnv@gmail.com', 'iaresgymnv', 'patient', NULL, '2026-03-25 13:05:03'),
(5, 'Shaina Jane Benosa Tanguan', 'shaina@gmail.com', '$2y$10$aSnLahIImbZQ1ugcBOcs4u89K/qlVmxVH6ymhb2rU8mWk8DDVtJNO', 'staff', NULL, '2026-03-25 13:57:27'),
(7, 'Vina Grace', 'vina@staff.com', '$2y$10$wm6m8q58.jqU2BhPHnWU3.J1PKYKrbacAtpZsSJvrytYDr7nhT82u', 'staff', NULL, '2026-03-25 14:11:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staff_users`
--
ALTER TABLE `staff_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff_users`
--
ALTER TABLE `staff_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
