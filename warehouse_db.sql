-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 02:40 PM
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
-- Database: `warehouse_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_ID` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_ID`, `category_name`) VALUES
(1, 'Power Tools'),
(2, 'Hand Tools'),
(3, 'Machinery'),
(4, 'Electrical Components'),
(5, 'Plumbing Tools'),
(6, 'Safety Equipment'),
(7, 'Material');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_inventory`
--

CREATE TABLE `tbl_inventory` (
  `inventory_ID` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_ID` varchar(255) DEFAULT NULL,
  `product_price` float DEFAULT NULL,
  `product_quantity` int(11) DEFAULT NULL,
  `product_category` varchar(255) DEFAULT NULL,
  `category_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_inventory`
--

INSERT INTO `tbl_inventory` (`inventory_ID`, `product_name`, `product_ID`, `product_price`, `product_quantity`, `product_category`, `category_ID`) VALUES
(244, 'Rubber', 'PJ-8551-GY', 91813.6, 78, '0', 7),
(255, 'Aluminum', 'QU-2368-QH', 78290.9, 65, 'Material', 7),
(398, 'Steel', 'IS-5876-GR', 70062.3, 52, 'Material', 7),
(557, 'Red Wood', 'XM-0812-FG', 33833.1, 86, 'Material', 7),
(607, 'Brass', 'ZG-3943-JH', 12329.1, 12, 'Material', 7),
(873, 'Vinyl', 'DH-0513-WX', 97072.7, 25, 'Material', 7),
(1022, 'Screwdriver Set', 'SD-1022-BB', 25.49, 80, 'Tools', 1),
(1023, 'Power Drill', 'PD-1023-CC', 89.99, 40, 'Electrical Components', 4),
(1024, 'Circular Saw', 'CS-1024-DE', 150, 25, 'Material', 1),
(1027, 'Plywood (4x8)', 'PW-1027-GG', 45.99, 58, 'Wood', 3),
(1028, 'Lumber (2x4)', 'LB-1028-HH', 25.99, 70, 'Wood', 3),
(1029, 'Paint (1 gallon)', 'PT-1029-II', 32.99, 60, 'Finishing Materials', 4),
(1030, 'Paint Brush Set', 'PB-1030-JJ', 12.49, 100, 'Finishing Materials', 4),
(1032, 'PVC Pipes (10 ft)', 'PP-1032-LL', 14.99, 150, 'Plumbing', 5),
(1033, 'Pipe Fittings (Set)', 'PF-1033-MM', 19.99, 19, 'Plumbing', 5),
(1034, 'Wrench Set', 'WR-1034-NN', 29.99, 60, 'Tools', 1),
(1035, 'Sandpaper (Pack of 10)', 'SP-1035-OO', 7.99, 120, 'Finishing Materials', 4),
(1037, 'Steel Rebar (10 ft)', 'SR-1037-QQ', 12.99, 100, 'Metal', 6),
(1039, 'Tape Measure', 'TM-1039-SS', 8.99, 90, 'Tools', 1),
(1040, 'Ladder (6 ft)', 'LD-1040-TT', 75, 15, 'Tools', 1),
(1041, 'Hammer', 'PD-1130-ST', 25.99, 50, 'Tools', 1),
(1042, 'Screw Nails (Pack)', 'SR-1138-QQ\r\n', 12.49, 200, 'Hardware', 2),
(1043, 'Paint Roller', 'ZG-6969-JH\r\n', 9.99, 150, 'Finishing Materials', 4),
(1044, 'PVC Pipe (15 ft)', 'IS-9999-GR', 29.99, 120, 'Plumbing', 5),
(1045, 'Steel Beam (20 ft)', 'PF-1213-MM\r\n', 120, 28, 'Metal', 6),
(1047, 'Wood Glue', 'DH-7777-WX\r\n', 6.99, 100, 'Material', 7),
(1049, 'Sandbag (80L)', 'testCat', 2, 30, 'Fortification', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_logs`
--

CREATE TABLE `tbl_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_logs`
--

INSERT INTO `tbl_logs` (`log_id`, `user_id`, `timestamp`) VALUES
(1, 110002, '2024-12-09 21:57:48'),
(2, 110001, '2024-12-09 21:59:06'),
(3, 110002, '2024-12-09 22:13:41'),
(4, 110002, '2024-12-09 22:18:41'),
(5, 110001, '2024-12-09 22:18:58'),
(6, 110001, '2024-12-09 22:25:27'),
(7, 110001, '2024-12-09 22:25:55'),
(8, 110001, '2024-12-10 23:42:57'),
(9, 110001, '2024-12-10 23:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `transaction_ID` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `inventory_ID` int(11) DEFAULT NULL,
  `transaction_type` varchar(255) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`transaction_ID`, `user_ID`, `inventory_ID`, `transaction_type`, `transaction_date`) VALUES
(1, 110025, 255, 'restock + 26', '2024-12-02'),
(2, 110025, 255, 'deduct - 26', '2024-12-01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `userID` int(11) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `usertype` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`userID`, `username`, `password`, `firstname`, `lastname`, `usertype`) VALUES
(110025, 'admin', 'adminpass', 'test', 'sysadmin', 'Admin'),
(110026, 'user', 'userpass', 'test', 'sysuser', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_ID`);

--
-- Indexes for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD PRIMARY KEY (`inventory_ID`),
  ADD KEY `fk_category` (`category_ID`);

--
-- Indexes for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`transaction_ID`),
  ADD KEY `user_ID` (`user_ID`),
  ADD KEY `tbl_transaction_ibfk_2` (`inventory_ID`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  MODIFY `inventory_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1050;

--
-- AUTO_INCREMENT for table `tbl_logs`
--
ALTER TABLE `tbl_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `transaction_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110028;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_inventory`
--
ALTER TABLE `tbl_inventory`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_ID`) REFERENCES `tbl_categories` (`category_ID`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD CONSTRAINT `tbl_transaction_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `tbl_users` (`userID`),
  ADD CONSTRAINT `tbl_transaction_ibfk_2` FOREIGN KEY (`inventory_ID`) REFERENCES `tbl_inventory` (`inventory_ID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
