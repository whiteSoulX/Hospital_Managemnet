-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 24, 2024 at 04:36 PM
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
-- Database: `practice_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'admin1', 'admin1@gmail.com', '$2y$10$yYgZn13UwbJk4JTFH.E6pOkz6wxnu4ZgxmuLfpRaBCNsGacUVVYtC');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `username`, `doctor_name`, `appointment_date`, `appointment_time`) VALUES
(1, 'user1', 'Tania Ahmed', '2024-09-25', '19:00:00'),
(2, 'user1', 'Milton Kumar Deb Das', '2024-09-25', '20:00:00'),
(3, 'user2', 'Milton Kumar Deb Das', '2024-09-25', '20:00:00'),
(4, 'user3', 'Sajib Kumar Samaddar', '2024-09-18', '23:00:00'),
(5, 'user3', 'Tania Ahmed', '2024-09-25', '16:50:00'),
(6, 'user5', 'Tania Ahmed', '2024-09-25', '21:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `specialization` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `username`, `email`, `specialization`, `password`) VALUES
(1, 'Tania Ahmed', 'tania@gmail.com', 'Dentist', '$2y$10$wAhU6M5WC6BX4HyKAZ7BGuZtqXPkcOcjcW9L5s1fw9fG.VVqN0KvS'),
(2, 'Milton Kumar Deb Das', 'milton@gmail.com', 'Cardiology', '$2y$10$opFfT9i8X1k/xA/ouUU7w.hWcP14bzxPIbNWJLKZ.W2KT/uYdpKrC'),
(4, 'Sajib Kumar Samaddar', 'sajib@gmail.com', 'Medechine', '$2y$10$DZDKlAf56ZF.dguplFWSS.K1oahjO64CbUoaIXVxP5a2q2.lG6x1K');

-- --------------------------------------------------------

--
-- Table structure for table `doctors_profile`
--

CREATE TABLE `doctors_profile` (
  `username` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `department` varchar(255) DEFAULT NULL,
  `degree` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors_profile`
--

INSERT INTO `doctors_profile` (`username`, `full_name`, `department`, `degree`, `phone_number`) VALUES
('Milton Kumar Deb Das', 'DR. Milton Kumar Debsas', 'Cardiolgy', 'FCPS,MBBS', '1233215154515'),
('Sajib Kumar Samaddar', 'Dr. Sajib Kumar Samaddar', 'Medechine', 'FCPS,MBBS', '1241215235'),
('Tania Ahmed', 'DR. Tania Rahman Bristy', 'Dentist', 'FCPS,MBBS', '1236531234');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `request_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `username`, `name`, `address`, `phone`, `request_time`) VALUES
(1, 'admin1', 'Prisom Halder', 'Basila West Dhanmondi,Mohammadpur,Dhaka', '01982174501', '2024-09-24 12:27:36'),
(2, 'user3', 'Suddho', 'Basila West Dhanmondi,Mohammadpur,Dhaka', '324512351254', '2024-09-24 13:50:06'),
(3, 'user5', 'Prisom Halder', 'Basila West Dhanmondi,Mohammadpur,Dhaka', '01982174501', '2024-09-24 13:59:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES
(1, 'user1', 'user1@gmail.com', '$2y$10$h.wbDSiB45nGoyiJiRqj2.MnlpSW7KQqBhwDke5wZk2NROL1dN6L.'),
(2, 'user2', 'user2@gmail.com', '$2y$10$MBnv2cJB.6sl0bzVvXkscOJnNliKVf.BZnit6xpXePMc/I6skxMBW'),
(3, 'user3', 'user3@gmail.com', '$2y$10$KgCCsWf90hRA4Nlkrupv6.3.VQ9jRw0.XIO8TAFBVw0PMd00fxpzS'),
(4, 'user5', 'user5@gmail.com', '$2y$10$Yen.5LjOxon6wGxHqj.MEOPhbmfacuRMBWkN2jL.RmnCYLh1Bjuoi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors_profile`
--
ALTER TABLE `doctors_profile`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
