-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 10, 2025 at 11:55 PM
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
  `RecordId` int DEFAULT NULL,
  `Operation` enum('insert','update','delete','') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `JsonData` json DEFAULT NULL,
  `AuditDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_tb`
--

INSERT INTO `audit_tb` (`AuditId`, `TableName`, `RecordId`, `Operation`, `JsonData`, `AuditDate`) VALUES
(34, 'user_tb', 100, 'insert', '{\"email\": \"rafaela@gmail.com\", \"phone\": \"888888\", \"avatar\": \"1744315612.jpeg\", \"roleId\": \"1\", \"activate\": 1, \"lastName\": \"Santos\", \"password\": \"$2y$12$0FJdIHiNWr70rlt2jJ2u8emNrXqG4GqOYEhhCgYYaBXyRwIvP5iwi\", \"firstName\": \"Rafaela\"}', '2025-04-10 20:06:52'),
(35, 'user_tb', 105, 'insert', '{\"email\": \"anderson@gmail.com\", \"phone\": \"4373857225\", \"avatar\": \"1744316095.jpeg\", \"roleId\": \"1\", \"activate\": 1, \"lastName\": \"Santos\", \"password\": \"$2y$12$YXYRwBr8Kv9N84BHvGGgbuloKe1mOq6UEyAwGX99hyzycrebGLzpi\", \"firstName\": \"Anderson\"}', '2025-04-10 20:14:56'),
(36, 'user_tb', 100, 'update', '{\"email\": \"mario@gmail.com\", \"phone\": \"12121212\", \"roleId\": 1, \"lastName\": \"Mugroso Cabrone\", \"password\": \"$2y$12$PE3IjNbBQaMPdMlK95Jdj.vggsQvSWwFcIsRHR4iRoAVYgfzjU0Xm\", \"firstName\": \"Mario\"}', '2025-04-10 20:16:28'),
(37, 'reservation_tb', 23, 'insert', '{\"status\": \"Confirmed\", \"endTime\": \"2025-04-10 16:00:00\", \"tableId\": 1, \"partySize\": 2, \"startTime\": \"2025-04-10 15:00:00\", \"customerId\": 100, \"specialRequests\": \"Vegan food only.\"}', '2025-04-10 20:29:46'),
(38, 'user_tb', 106, 'insert', '{\"email\": \"anderson@gmail.com\", \"phone\": \"4373857225\", \"avatar\": \"1744317361.jpeg\", \"roleId\": \"1\", \"activate\": 1, \"lastName\": \"Santos\", \"password\": \"$2y$12$8P47h18BWiJltaYMAODLde1QLy1oYGmB6E.H2qvTZ7kcPVXuMGZgK\", \"firstName\": \"Anderson\"}', '2025-04-10 20:36:02');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_tb`
--

CREATE TABLE `reservation_tb` (
  `ReservationId` int NOT NULL,
  `CustomerId` int NOT NULL,
  `TableId` int NOT NULL,
  `StartTime` datetime NOT NULL,
  `EndTime` datetime NOT NULL,
  `PartySize` int NOT NULL,
  `SpecialRequests` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Status` enum('Pending','Confirmed','Cancelled','') COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles_tb`
--

CREATE TABLE `roles_tb` (
  `RoleId` int NOT NULL,
  `RoleName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles_tb`
--

INSERT INTO `roles_tb` (`RoleId`, `RoleName`) VALUES
(1, 'Admin'),
(2, 'Editor'),
(3, 'Viewer');

-- --------------------------------------------------------

--
-- Table structure for table `table_tb`
--

CREATE TABLE `table_tb` (
  `TableId` int NOT NULL,
  `TableNumber` char(10) COLLATE utf8mb4_general_ci NOT NULL,
  `Capacity` int NOT NULL,
  `Location` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `Status` enum('Available','Reserved','Out of Service') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table_tb`
--

INSERT INTO `table_tb` (`TableId`, `TableNumber`, `Capacity`, `Location`, `Status`) VALUES
(1, 'G9', 5, 'Bar', 'Available'),
(14, 'L1', 8, 'Patio', 'Available');

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
  `Avatar` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `Activate` tinyint NOT NULL,
  `RoleId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tb`
--

INSERT INTO `user_tb` (`UserId`, `FirstName`, `LastName`, `Password`, `Phone`, `Email`, `Avatar`, `Activate`, `RoleId`) VALUES
(106, 'Anderson', 'Santos', '$2y$12$8P47h18BWiJltaYMAODLde1QLy1oYGmB6E.H2qvTZ7kcPVXuMGZgK', '4373857225', 'anderson@gmail.com', '1744317361.jpeg', 1, 1);

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
  ADD KEY `FK_reservation_tb_table_id` (`TableId`),
  ADD KEY `ReservationDate` (`StartTime`),
  ADD KEY `EndTime` (`EndTime`);

--
-- Indexes for table `roles_tb`
--
ALTER TABLE `roles_tb`
  ADD PRIMARY KEY (`RoleId`);

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
  ADD UNIQUE KEY `Email` (`Email`),
  ADD KEY `FK_role_tb_role_id` (`RoleId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_tb`
--
ALTER TABLE `audit_tb`
  MODIFY `AuditId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `reservation_tb`
--
ALTER TABLE `reservation_tb`
  MODIFY `ReservationId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `roles_tb`
--
ALTER TABLE `roles_tb`
  MODIFY `RoleId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `table_tb`
--
ALTER TABLE `table_tb`
  MODIFY `TableId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_tb`
--
ALTER TABLE `user_tb`
  MODIFY `UserId` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation_tb`
--
ALTER TABLE `reservation_tb`
  ADD CONSTRAINT `FK_reservation_tb_table_id` FOREIGN KEY (`TableId`) REFERENCES `table_tb` (`TableId`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `FK_reservation_tb_user_id` FOREIGN KEY (`CustomerId`) REFERENCES `user_tb` (`UserId`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `user_tb`
--
ALTER TABLE `user_tb`
  ADD CONSTRAINT `FK_role_tb_role_id` FOREIGN KEY (`RoleId`) REFERENCES `roles_tb` (`RoleId`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
