-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2024 at 01:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `docudata_doctors`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `UpdateTables` ()   BEGIN
    DECLARE Done INT DEFAULT 0;
    DECLARE Tablename VARCHAR(255);
    DECLARE cur CURSOR FOR 
        SELECT Table_Name
        FROM information_schema.tables
        WHERE Table_Schema = 'docudata_doctors'
        AND (TABLE_NAME LIKE 'doctors_%' 
             OR TABLE_NAME LIKE 'standing_%' 
             OR TABLE_NAME LIKE 'medication_record')
        AND TABLE_NAME NOT IN ('doctors_order_categories');

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET Done = 1;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO Tablename;
        IF Done THEN 
            LEAVE read_loop;
        END IF;

        SET @alterSQL = CONCAT('ALTER TABLE ', Tablename, ' ADD Deletion_Date DATE;');
        PREPARE stmt FROM @alterSQL;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

    END LOOP;

    CLOSE cur;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `doctors_order`
--

CREATE TABLE `doctors_order` (
  `Doctor_Order_ID` int(11) NOT NULL,
  `Ordered_by_Doctor` int(20) DEFAULT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Doctor_Order_Date` datetime DEFAULT NULL,
  `Observation_Progress` text DEFAULT NULL,
  `Doctor_Order` text DEFAULT NULL,
  `Current_Status` varchar(1) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors_order`
--

INSERT INTO `doctors_order` (`Doctor_Order_ID`, `Ordered_by_Doctor`, `Patient_ID`, `Doctor_Order_Date`, `Observation_Progress`, `Doctor_Order`, `Current_Status`, `Status`, `Deletion_Date`) VALUES
(1, 202409676, 202409564, '2024-09-25 09:54:40', 'Test', 'Test', 'E', 'x', '2024-11-04');

-- --------------------------------------------------------

--
-- Table structure for table `doctors_order_categories`
--

CREATE TABLE `doctors_order_categories` (
  `Status` varchar(1) NOT NULL,
  `Status_Categories` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors_order_categories`
--

INSERT INTO `doctors_order_categories` (`Status`, `Status_Categories`) VALUES
('A', 'Administered / Started'),
('C', 'Carried Out'),
('D', 'Discontinued'),
('E', 'Endorsed'),
('R', 'Requested');

-- --------------------------------------------------------

--
-- Table structure for table `medication_record_prn`
--

CREATE TABLE `medication_record_prn` (
  `Medication_PRN_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_By_Doctor` int(20) DEFAULT NULL,
  `Medication_PRN_Date` date DEFAULT NULL,
  `PRN_Medication` text DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_record_prn`
--

INSERT INTO `medication_record_prn` (`Medication_PRN_ID`, `Patient_ID`, `Ordered_By_Doctor`, `Medication_PRN_Date`, `PRN_Medication`, `Status`, `Deletion_Date`) VALUES
(1, 202409564, 202409676, '2024-10-04', 'aaaaaaaaaaaaaaaa', 'o', NULL),
(2, 202409564, 202409676, '2024-10-05', 'bbbbbbbbbb', 'o', NULL),
(3, 202409564, 202409676, '2024-11-01', 'czcxcxz', 'x', '2024-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `medication_record_so`
--

CREATE TABLE `medication_record_so` (
  `Medication_SO_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_By_Doctor` int(20) DEFAULT NULL,
  `Medication_SO_Date` date DEFAULT NULL,
  `Hospital_Day` varchar(10) DEFAULT NULL,
  `Standing_Order` text DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_record_so`
--

INSERT INTO `medication_record_so` (`Medication_SO_ID`, `Patient_ID`, `Ordered_By_Doctor`, `Medication_SO_Date`, `Hospital_Day`, `Standing_Order`, `Status`, `Deletion_Date`) VALUES
(1, 202409564, 202409676, '2024-10-04', 'Friday', 'AAAAAAAAAAAAAAA', 'o', NULL),
(2, 202409564, 202409676, '2024-10-05', 'Saturday', 'BBBBBBBBBBBBBBBBBBB', 'o', NULL),
(3, 202409564, 202409676, '2024-11-01', 'Friday', 'CCCCCCC', 'x', '2024-11-01');

-- --------------------------------------------------------

--
-- Table structure for table `medication_record_stat`
--

CREATE TABLE `medication_record_stat` (
  `Medication_STAT_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_By_Doctor` int(20) DEFAULT NULL,
  `Medication_STAT_Date` date DEFAULT NULL,
  `STAT_Order` text DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_record_stat`
--

INSERT INTO `medication_record_stat` (`Medication_STAT_ID`, `Patient_ID`, `Ordered_By_Doctor`, `Medication_STAT_Date`, `STAT_Order`, `Status`, `Deletion_Date`) VALUES
(1, 202409564, 202409676, '2024-10-04', 'aAaAaAaAaAaAaAa', 'o', NULL),
(2, 202409564, 202409676, '2024-10-05', 'bBbBbBbBbBb', 'o', NULL),
(4, 202409564, 202409676, '2024-11-01', 'kwkwkwkwkwkwk', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `standing_order`
--

CREATE TABLE `standing_order` (
  `Standing_Order_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_by_Doctor` int(20) DEFAULT NULL,
  `Date_Ordered` date DEFAULT NULL,
  `Order` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standing_order`
--

INSERT INTO `standing_order` (`Standing_Order_ID`, `Patient_ID`, `Ordered_by_Doctor`, `Date_Ordered`, `Order`) VALUES
(1, 202409564, 202409676, '2024-09-24', 'test'),
(3, 202409564, 202409676, '2024-10-01', 'AAAAAAAAAA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `doctors_order`
--
ALTER TABLE `doctors_order`
  ADD PRIMARY KEY (`Doctor_Order_ID`),
  ADD KEY `Ordered_by_Doctor` (`Ordered_by_Doctor`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Current_Status` (`Current_Status`);

--
-- Indexes for table `doctors_order_categories`
--
ALTER TABLE `doctors_order_categories`
  ADD PRIMARY KEY (`Status`);

--
-- Indexes for table `medication_record_prn`
--
ALTER TABLE `medication_record_prn`
  ADD PRIMARY KEY (`Medication_PRN_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Ordered_By_Doctor` (`Ordered_By_Doctor`);

--
-- Indexes for table `medication_record_so`
--
ALTER TABLE `medication_record_so`
  ADD PRIMARY KEY (`Medication_SO_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Ordered_By_Doctor` (`Ordered_By_Doctor`);

--
-- Indexes for table `medication_record_stat`
--
ALTER TABLE `medication_record_stat`
  ADD PRIMARY KEY (`Medication_STAT_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Ordered_By_Doctor` (`Ordered_By_Doctor`);

--
-- Indexes for table `standing_order`
--
ALTER TABLE `standing_order`
  ADD PRIMARY KEY (`Standing_Order_ID`),
  ADD KEY `Ordered_by_Doctor` (`Ordered_by_Doctor`),
  ADD KEY `Patient_ID` (`Patient_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `doctors_order`
--
ALTER TABLE `doctors_order`
  MODIFY `Doctor_Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `medication_record_prn`
--
ALTER TABLE `medication_record_prn`
  MODIFY `Medication_PRN_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `medication_record_so`
--
ALTER TABLE `medication_record_so`
  MODIFY `Medication_SO_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medication_record_stat`
--
ALTER TABLE `medication_record_stat`
  MODIFY `Medication_STAT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `standing_order`
--
ALTER TABLE `standing_order`
  MODIFY `Standing_Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `doctors_order`
--
ALTER TABLE `doctors_order`
  ADD CONSTRAINT `doctors_order_ibfk_1` FOREIGN KEY (`Ordered_by_Doctor`) REFERENCES `docudata`.`user_tbl` (`User_ID`),
  ADD CONSTRAINT `doctors_order_ibfk_2` FOREIGN KEY (`Patient_ID`) REFERENCES `docudata`.`patient_info` (`Patient_ID`),
  ADD CONSTRAINT `doctors_order_ibfk_3` FOREIGN KEY (`Current_Status`) REFERENCES `doctors_order_categories` (`Status`);

--
-- Constraints for table `medication_record_prn`
--
ALTER TABLE `medication_record_prn`
  ADD CONSTRAINT `medication_record_prn_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `docudata`.`patient_info` (`Patient_ID`),
  ADD CONSTRAINT `medication_record_prn_ibfk_2` FOREIGN KEY (`Ordered_By_Doctor`) REFERENCES `docudata`.`user_tbl` (`User_ID`);

--
-- Constraints for table `medication_record_so`
--
ALTER TABLE `medication_record_so`
  ADD CONSTRAINT `medication_record_so_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `docudata`.`patient_info` (`Patient_ID`),
  ADD CONSTRAINT `medication_record_so_ibfk_2` FOREIGN KEY (`Ordered_By_Doctor`) REFERENCES `docudata`.`user_tbl` (`User_ID`);

--
-- Constraints for table `medication_record_stat`
--
ALTER TABLE `medication_record_stat`
  ADD CONSTRAINT `medication_record_stat_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `docudata`.`patient_info` (`Patient_ID`),
  ADD CONSTRAINT `medication_record_stat_ibfk_2` FOREIGN KEY (`Ordered_By_Doctor`) REFERENCES `docudata`.`user_tbl` (`User_ID`);

--
-- Constraints for table `standing_order`
--
ALTER TABLE `standing_order`
  ADD CONSTRAINT `standing_order_ibfk_1` FOREIGN KEY (`Ordered_by_Doctor`) REFERENCES `docudata`.`user_tbl` (`User_ID`),
  ADD CONSTRAINT `standing_order_ibfk_2` FOREIGN KEY (`Patient_ID`) REFERENCES `docudata`.`patient_info` (`Patient_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
