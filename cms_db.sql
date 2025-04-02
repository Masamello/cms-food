-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 02, 2025 at 08:04 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_tb`
--

CREATE TABLE `audit_tb` (
  `AuditId` int NOT NULL,
  `TableName` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `RecordId` int NOT NULL,
  `Operation` enum('INSERT','UPDATE','DELETE','') COLLATE utf8mb4_general_ci NOT NULL,
  `OldValues` json DEFAULT NULL,
  `NewValues` json DEFAULT NULL,
  `ChangedBy` int NOT NULL,
  `ChangedAt` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_tb`
--

CREATE TABLE `reservation_tb` (
  `ReservationId` int NOT NULL,
  `CustomerId` int NOT NULL,
  `TableId` int NOT NULL,
  `ReservationDate` date NOT NULL,
  `ReservationTime` time NOT NULL,
  `PartySize` int NOT NULL,
  `SpecialRequests` text COLLATE utf8mb4_general_ci NOT NULL,
  `Status` enum('Pending','Confirmed','Cancelled','') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `table_tb`
--

CREATE TABLE `table_tb` (
  `TableId` int NOT NULL,
  `TableNumber` char(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Capacity` int NOT NULL,
  `Location` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` enum('Available','Reserved','Occupied','Out of Service') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tb`
--

CREATE TABLE `user_tb` (
  `UserId` int NOT NULL,
  `FirstName` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `LastName` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `Password` varchar(300) COLLATE utf8mb4_general_ci NOT NULL,
  `Phone` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `Email` varchar(70) COLLATE utf8mb4_general_ci NOT NULL,
  `Activate` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_tb`
--
ALTER TABLE `audit_tb`
  ADD PRIMARY KEY (`AuditId`);

--
-- Indexes for table `reservation_tb`
--
ALTER TABLE `reservation_tb`
  ADD PRIMARY KEY (`ReservationId`),
  ADD KEY `FK_reservation_tb_user_id` (`CustomerId`),
  ADD KEY `FK_reservation_tb_table_id` (`TableId`);

--
-- Indexes for table `table_tb`
--
ALTER TABLE `table_tb`
  ADD PRIMARY KEY (`TableId`),
  ADD UNIQUE KEY `TableNumber` (`TableNumber`);

--
-- Indexes for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD PRIMARY KEY (`UserId`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_tb`
--
ALTER TABLE `audit_tb`
  MODIFY `AuditId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_tb`
--
ALTER TABLE `reservation_tb`
  MODIFY `ReservationId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `table_tb`
--
ALTER TABLE `table_tb`
  MODIFY `TableId` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `UserId` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation_tb`
--
ALTER TABLE `reservation_tb`
  ADD CONSTRAINT `FK_reservation_tb_table_id` FOREIGN KEY (`TableId`) REFERENCES `table_tb` (`TableId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_reservation_tb_user_id` FOREIGN KEY (`CustomerId`) REFERENCES `user_tb` (`UserId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
