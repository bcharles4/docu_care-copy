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
-- Database: `docudata`
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
        WHERE Table_Schema = 'docudata'
        AND (TABLE_NAME LIKE 'ivfr_%' 
             OR TABLE_NAME LIKE 'kardex_%' 
             OR TABLE_NAME LIKE 'medication_record' 
             OR TABLE_NAME LIKE 'nurse_%' 
             OR TABLE_NAME LIKE 'patient_%' 
             OR TABLE_NAME like 'rooms%' 
             OR TABLE_NAME LIKE 'standing%' 
             OR TABLE_NAME LIKE 'tpr%' 
             OR TABLE_NAME LIKE 'user_%'); 

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
-- Table structure for table `ivfr_fast_drip`
--

CREATE TABLE `ivfr_fast_drip` (
  `Patient_ID` int(20) DEFAULT NULL,
  `SFD_Date` date DEFAULT NULL,
  `IVF` varchar(255) DEFAULT NULL,
  `Volume` varchar(255) DEFAULT NULL,
  `Incorporation` varchar(255) DEFAULT NULL,
  `Time_Taken` time DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ivfr_fast_drip`
--

INSERT INTO `ivfr_fast_drip` (`Patient_ID`, `SFD_Date`, `IVF`, `Volume`, `Incorporation`, `Time_Taken`, `Remarks`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'TEST', 'TEST', 'TEST', '15:50:49', 'TEST', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'TEST1', 'TEST1', 'TEST1', '16:00:49', 'TEST1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ivfr_iv`
--

CREATE TABLE `ivfr_iv` (
  `Patient_ID` int(20) DEFAULT NULL,
  `IV_Date` date DEFAULT NULL,
  `Bottle_No` varchar(255) DEFAULT NULL,
  `IV_Solution` varchar(255) DEFAULT NULL,
  `Volume` varchar(255) DEFAULT NULL,
  `Incorporation` varchar(255) DEFAULT NULL,
  `Regulation` varchar(255) DEFAULT NULL,
  `Start_Time` time DEFAULT NULL,
  `Time_End` datetime DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ivfr_iv`
--

INSERT INTO `ivfr_iv` (`Patient_ID`, `IV_Date`, `Bottle_No`, `IV_Solution`, `Volume`, `Incorporation`, `Regulation`, `Start_Time`, `Time_End`, `Remarks`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'TEST', 'TEST', 'TEST', 'TEST', 'TEST', '15:45:28', '2024-09-12 16:00:28', 'TEST', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'TEST1', 'TEST1', 'TEST1', 'TEST1', 'TEST1', '15:45:28', '2024-09-13 16:00:28', 'TEST1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ivfr_side_drips`
--

CREATE TABLE `ivfr_side_drips` (
  `Patient_ID` int(20) DEFAULT NULL,
  `SD_Date` date DEFAULT NULL,
  `Bottle_No` varchar(255) DEFAULT NULL,
  `IV_Solution` varchar(255) DEFAULT NULL,
  `Volume` varchar(255) DEFAULT NULL,
  `Incorporation` varchar(255) DEFAULT NULL,
  `Regulation` varchar(255) DEFAULT NULL,
  `Start_Time` time DEFAULT NULL,
  `Time_End` datetime DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ivfr_side_drips`
--

INSERT INTO `ivfr_side_drips` (`Patient_ID`, `SD_Date`, `Bottle_No`, `IV_Solution`, `Volume`, `Incorporation`, `Regulation`, `Start_Time`, `Time_End`, `Remarks`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'TEST', 'TEST', 'TEST', 'TEST', 'TEST', '15:47:13', '2024-09-12 16:00:28', 'TEST', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'TEST1', 'TEST1', 'TEST1', 'TEST1', 'TEST1', '15:47:13', '2024-09-13 16:00:13', 'TEST1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_diagnostics`
--

CREATE TABLE `kardex_diagnostics` (
  `Patient_ID` int(20) NOT NULL,
  `Diagnostic_Date` date NOT NULL,
  `Diagnostics` varchar(255) DEFAULT NULL,
  `Diagnostics_Category` int(11) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_diagnostics`
--

INSERT INTO `kardex_diagnostics` (`Patient_ID`, `Diagnostic_Date`, `Diagnostics`, `Diagnostics_Category`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'Test 1', 5, 202409673, 'o', NULL),
(202409564, '2024-09-13', 'Test2', 2, 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_diagnostics_categories`
--

CREATE TABLE `kardex_diagnostics_categories` (
  `Diagnostics_Checks` int(11) NOT NULL,
  `Categories` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_diagnostics_categories`
--

INSERT INTO `kardex_diagnostics_categories` (`Diagnostics_Checks`, `Categories`) VALUES
(1, 'Request'),
(2, 'Extracted/Done'),
(3, 'Results in'),
(4, 'Relayed'),
(5, 'Acknowledge');

-- --------------------------------------------------------

--
-- Table structure for table `kardex_diet`
--

CREATE TABLE `kardex_diet` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Diet_Date` date DEFAULT NULL,
  `Diet_Category` int(11) DEFAULT NULL,
  `Other_Info` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_diet`
--

INSERT INTO `kardex_diet` (`Patient_ID`, `Diet_Date`, `Diet_Category`, `Other_Info`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 9, 'Fruits and Vegetables', 202409673, 'o', NULL),
(202409564, '2024-09-13', 1, NULL, 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_diet_categories`
--

CREATE TABLE `kardex_diet_categories` (
  `Diet_Checks` int(11) NOT NULL,
  `Categories` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_diet_categories`
--

INSERT INTO `kardex_diet_categories` (`Diet_Checks`, `Categories`) VALUES
(1, 'NPO'),
(2, 'DAT'),
(3, 'BRAT DIET'),
(4, 'SOFT DIET'),
(5, 'General Liquid'),
(6, 'Clear Liquid'),
(7, 'Diet for Age'),
(8, 'Breast Feeding'),
(9, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `kardex_diet_last_meal`
--

CREATE TABLE `kardex_diet_last_meal` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Meal_Date` date DEFAULT NULL,
  `Last_Meal` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_diet_last_meal`
--

INSERT INTO `kardex_diet_last_meal` (`Patient_ID`, `Meal_Date`, `Last_Meal`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'Fruits and Vegetables', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'NPO', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_drips_transfusion`
--

CREATE TABLE `kardex_drips_transfusion` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Drips_Transfusion_Date` date DEFAULT NULL,
  `Drips_Transfusion` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_drips_transfusion`
--

INSERT INTO `kardex_drips_transfusion` (`Patient_ID`, `Drips_Transfusion_Date`, `Drips_Transfusion`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'test', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'test1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_endorsements`
--

CREATE TABLE `kardex_endorsements` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Endorsement_Date` date DEFAULT NULL,
  `Special_Endorsement` text DEFAULT NULL,
  `Endorsement_Remarks` text DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_endorsements`
--

INSERT INTO `kardex_endorsements` (`Patient_ID`, `Endorsement_Date`, `Special_Endorsement`, `Endorsement_Remarks`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'test', 'test', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'test1', 'test1', 202409673, 'o', NULL),
(202409564, '2024-10-27', 'dfh', 'sdgs', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_io`
--

CREATE TABLE `kardex_io` (
  `Patient_ID` int(20) DEFAULT NULL,
  `IO_Date` date NOT NULL,
  `IO_Category` int(11) DEFAULT NULL,
  `Other_Info` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_io`
--

INSERT INTO `kardex_io` (`Patient_ID`, `IO_Date`, `IO_Category`, `Other_Info`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 5, 'Test1', 202409673, 'o', NULL),
(202409564, '2024-09-13', 1, NULL, 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_io_categories`
--

CREATE TABLE `kardex_io_categories` (
  `IO_Checks` int(11) NOT NULL,
  `Categories` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_io_categories`
--

INSERT INTO `kardex_io_categories` (`IO_Checks`, `Categories`) VALUES
(1, 'Q1'),
(2, 'Q2'),
(3, 'Q4'),
(4, 'Q Shift'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `kardex_iv`
--

CREATE TABLE `kardex_iv` (
  `Patient_ID` int(20) NOT NULL,
  `IVFluid_Date` date NOT NULL,
  `IVFluid` varchar(255) NOT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_iv`
--

INSERT INTO `kardex_iv` (`Patient_ID`, `IVFluid_Date`, `IVFluid`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'Test', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'test1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_medications`
--

CREATE TABLE `kardex_medications` (
  `Patient_ID` int(20) NOT NULL,
  `Date` date DEFAULT NULL,
  `Medication_Name` varchar(255) NOT NULL,
  `Medication_Remarks` varchar(255) NOT NULL,
  `Entered_By_Nurse` int(20) NOT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_medications`
--

INSERT INTO `kardex_medications` (`Patient_ID`, `Date`, `Medication_Name`, `Medication_Remarks`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'Biogesic', 'Good', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'Lagundi', 'Veri Nais', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_notes`
--

CREATE TABLE `kardex_notes` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Date` date NOT NULL,
  `Contraptions` text DEFAULT NULL,
  `Monitoring` text DEFAULT NULL,
  `Other_Endorsement` text DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_notes`
--

INSERT INTO `kardex_notes` (`Patient_ID`, `Date`, `Contraptions`, `Monitoring`, `Other_Endorsement`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'Test', 'Test', 'Test', 202409673, 'o', NULL),
(202409564, '2024-09-13', 'Test1', 'Test1', 'Test1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_tbl`
--

CREATE TABLE `kardex_tbl` (
  `Patient_ID` int(20) NOT NULL,
  `Date` date NOT NULL,
  `Precautions` mediumtext NOT NULL,
  `Hospital_Num` varchar(25) NOT NULL,
  `Weight` float NOT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_tbl`
--

INSERT INTO `kardex_tbl` (`Patient_ID`, `Date`, `Precautions`, `Hospital_Num`, `Weight`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12', 'Test', '0558373285', 67.74, 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_vitals`
--

CREATE TABLE `kardex_vitals` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Vitals_Date` date NOT NULL,
  `Vitals_Category` int(11) DEFAULT NULL,
  `Other_Info` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_vitals`
--

INSERT INTO `kardex_vitals` (`Patient_ID`, `Vitals_Date`, `Vitals_Category`, `Other_Info`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-13', NULL, 'Test', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kardex_vitals_categories`
--

CREATE TABLE `kardex_vitals_categories` (
  `Vitals_Checks` int(11) NOT NULL,
  `Categories` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kardex_vitals_categories`
--

INSERT INTO `kardex_vitals_categories` (`Vitals_Checks`, `Categories`) VALUES
(1, 'Q1'),
(2, 'Q2'),
(3, 'Q4'),
(4, 'FHT'),
(5, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `medication_record_prn_response`
--

CREATE TABLE `medication_record_prn_response` (
  `Medication_PRN_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_By_Doctor` int(20) DEFAULT NULL,
  `PRN_10_6` varchar(20) DEFAULT NULL,
  `PRN_6_2` varchar(20) DEFAULT NULL,
  `PRN_2_10` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_record_prn_response`
--

INSERT INTO `medication_record_prn_response` (`Medication_PRN_ID`, `Patient_ID`, `Ordered_By_Doctor`, `PRN_10_6`, `PRN_6_2`, `PRN_2_10`) VALUES
(1, 202409564, 202409673, 'cccccccc', 'bbbbbbb', 'aaaaaaa'),
(2, 202409564, 202409673, 'zzzzzz', 'xxxxxx', 'ccccccc');

-- --------------------------------------------------------

--
-- Table structure for table `medication_record_so_response`
--

CREATE TABLE `medication_record_so_response` (
  `Medication_SO_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_By_Doctor` int(20) DEFAULT NULL,
  `SO_10_6` varchar(20) DEFAULT NULL,
  `SO_6_2` varchar(20) DEFAULT NULL,
  `SO_2_10` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_record_so_response`
--

INSERT INTO `medication_record_so_response` (`Medication_SO_ID`, `Patient_ID`, `Ordered_By_Doctor`, `SO_10_6`, `SO_6_2`, `SO_2_10`) VALUES
(1, 202409564, 202409673, 'AAAAAAAAAA', 'BBBBBBBBB', 'CCCCCCCC'),
(2, 202409564, 202409673, 'zzzzzz', 'xxxxxx', 'yyyyyy');

-- --------------------------------------------------------

--
-- Table structure for table `medication_record_stat_response`
--

CREATE TABLE `medication_record_stat_response` (
  `Medication_STAT_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Ordered_By_Doctor` int(20) DEFAULT NULL,
  `STAT_10_6` varchar(20) DEFAULT NULL,
  `STAT_6_2` varchar(20) DEFAULT NULL,
  `STAT_2_10` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medication_record_stat_response`
--

INSERT INTO `medication_record_stat_response` (`Medication_STAT_ID`, `Patient_ID`, `Ordered_By_Doctor`, `STAT_10_6`, `STAT_6_2`, `STAT_2_10`) VALUES
(2, 202409564, 202409673, 'Stat4', 'Stat5', 'Stat6'),
(1, 202409564, 202409673, 'Stat1', 'Stat2', 'Stat3');

-- --------------------------------------------------------

--
-- Table structure for table `nurse_notes`
--

CREATE TABLE `nurse_notes` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Date_Time` datetime DEFAULT NULL,
  `Shift` varchar(255) DEFAULT NULL,
  `Focus` varchar(255) DEFAULT NULL,
  `Action_Response` text DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse_notes`
--

INSERT INTO `nurse_notes` (`Patient_ID`, `Entered_By_Nurse`, `Date_Time`, `Shift`, `Focus`, `Action_Response`, `Status`, `Deletion_Date`) VALUES
(202409564, 202409673, '2024-09-12 14:33:51', 'PM', 'Test', 'Test', 'o', NULL),
(202409564, 202409673, '2024-09-13 09:33:51', 'AM', 'Test1', 'Test1', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `nurse_sched`
--

CREATE TABLE `nurse_sched` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Day_Shift_Nurse_ID` int(20) DEFAULT NULL,
  `Day_Shift_Start` time DEFAULT NULL,
  `Day_Shift_End` time DEFAULT NULL,
  `Night_Shift_Nurse_ID` int(20) DEFAULT NULL,
  `Night_Shift_Start` time DEFAULT NULL,
  `Night_Shift_End` time DEFAULT NULL,
  `Entered_By_Nurse` int(11) NOT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nurse_sched`
--

INSERT INTO `nurse_sched` (`Patient_ID`, `Date`, `Day_Shift_Nurse_ID`, `Day_Shift_Start`, `Day_Shift_End`, `Night_Shift_Nurse_ID`, `Night_Shift_Start`, `Night_Shift_End`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-03', 202409673, '07:00:00', '15:00:00', 202409674, '15:00:00', '23:00:00', 202409675, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `outpatient_info`
--

CREATE TABLE `outpatient_info` (
  `Outpatient_ID` int(20) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Civil_Status` varchar(20) DEFAULT NULL,
  `Patient_Companion` varchar(20) DEFAULT NULL,
  `Relation_To_Patient` varchar(20) DEFAULT NULL,
  `Travel_History` varchar(5) DEFAULT NULL,
  `Travel_Location` varchar(30) DEFAULT NULL,
  `Travel_Date` date DEFAULT NULL,
  `Chief_Complain` text DEFAULT NULL,
  `History_of_Illness` text DEFAULT NULL,
  `Present_History` text DEFAULT NULL,
  `Blood_Pressure` varchar(10) DEFAULT NULL,
  `Temperature` double DEFAULT NULL,
  `Respiratory_Rate` int(11) DEFAULT NULL,
  `Pulse_Rate` int(11) DEFAULT NULL,
  `Weight` double DEFAULT NULL,
  `Height` double DEFAULT NULL,
  `FHT` int(11) DEFAULT NULL,
  `Pertinent_Findings` text DEFAULT NULL,
  `Impression_Diagnosis` text DEFAULT NULL,
  `Plan` text DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `outpatient_info`
--

INSERT INTO `outpatient_info` (`Outpatient_ID`, `Patient_ID`, `Civil_Status`, `Patient_Companion`, `Relation_To_Patient`, `Travel_History`, `Travel_Location`, `Travel_Date`, `Chief_Complain`, `History_of_Illness`, `Present_History`, `Blood_Pressure`, `Temperature`, `Respiratory_Rate`, `Pulse_Rate`, `Weight`, `Height`, `FHT`, `Pertinent_Findings`, `Impression_Diagnosis`, `Plan`, `Date`, `Entered_By_Nurse`) VALUES
(1, 202409576, 'Single', 'Althea Lois Castro', 'Friend', 'Yes', 'Pampanga', '2024-10-01', 'High Fever ', 'Allergic to penicillin', 'The patient is a 28-year-old Female presenting with a high fever that started two days ago, reaching up to 40°C. The patient reports feeling fatigued and has experienced chills and muscle aches. They have taken acetaminophen with minimal relief.', '112/82', 39.5, 92, 84, 70, 5, NULL, 'Crazy? I was crazy once. They locked me in a room,', 'a rubber room, a rubber room filled with rats,', 'rats make me crazy', '2024-10-12', 202409673);

-- --------------------------------------------------------

--
-- Table structure for table `patient_contacts`
--

CREATE TABLE `patient_contacts` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Mother_Name` varchar(255) DEFAULT NULL,
  `Mother_Contact` varchar(25) DEFAULT NULL,
  `Father_Name` varchar(255) DEFAULT NULL,
  `Father_Contact` varchar(25) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_contacts`
--

INSERT INTO `patient_contacts` (`Patient_ID`, `Mother_Name`, `Mother_Contact`, `Father_Name`, `Father_Contact`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, 'Yulette Chavez', '09969482742', 'Rizalde Chavez', '09968372913', 202409673, 'o', NULL),
(202409566, 'Test1', '099876465239', 'Test2', '05839186812', 202409673, 'o', NULL),
(202409576, 'fahajfg', '05438271245', 'aagDHFDJ', '60327562150', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_emergency_contact`
--

CREATE TABLE `patient_emergency_contact` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Emergency_Contact_Name` varchar(255) DEFAULT NULL,
  `Emergency_Contact` varchar(25) DEFAULT NULL,
  `Relation_to_Patient` varchar(255) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_emergency_contact`
--

INSERT INTO `patient_emergency_contact` (`Patient_ID`, `Emergency_Contact_Name`, `Emergency_Contact`, `Relation_to_Patient`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, 'Yulette Chavez', '09969482742', 'Mother', 202409673, 'o', NULL),
(202409566, 'Test 1', '099876465239', 'Mother', 202409673, 'o', NULL),
(202409576, 'asfhsha', '09684732106', 'Guh', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_info`
--

CREATE TABLE `patient_info` (
  `Patient_ID` int(20) NOT NULL,
  `Admission_Date` datetime DEFAULT NULL,
  `Patient_FName` varchar(30) DEFAULT NULL,
  `Patient_MName` varchar(30) NOT NULL,
  `Patient_LName` varchar(30) NOT NULL,
  `Patient_Type` varchar(20) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Sex` varchar(255) DEFAULT NULL,
  `Room_Num` int(11) DEFAULT NULL,
  `Street` varchar(50) NOT NULL,
  `House_Num` varchar(50) NOT NULL,
  `Subdivision` varchar(50) DEFAULT NULL,
  `Barangay` varchar(50) NOT NULL,
  `City` varchar(50) NOT NULL,
  `Province` varchar(50) NOT NULL,
  `Birthplace` varchar(255) DEFAULT NULL,
  `DoB` date DEFAULT NULL,
  `Attending_Physician` varchar(255) DEFAULT NULL,
  `Admitting_Diagnosis` mediumtext DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_info`
--

INSERT INTO `patient_info` (`Patient_ID`, `Admission_Date`, `Patient_FName`, `Patient_MName`, `Patient_LName`, `Patient_Type`, `Age`, `Sex`, `Room_Num`, `Street`, `House_Num`, `Subdivision`, `Barangay`, `City`, `Province`, `Birthplace`, `DoB`, `Attending_Physician`, `Admitting_Diagnosis`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-01 13:14:15', 'Vincent Enrique', 'Luangco', 'Chavez', 'Inpatient', 12, 'Male', 206, 'Palmera', 'Block 24 Lot 5 & 6', 'Amaia Scapes', 'Dagatan', 'Lipa', 'Batangas', 'Makati', '2002-07-31', 'Dr. Asclepius', 'Dengue', 202409673, 'o', NULL),
(202409566, '2024-09-26 09:48:00', 'Mitsuha', '', 'Miyamizu', 'Inpatient', 17, 'Female', 208, 'Anahaw', '7563', NULL, 'Dagatan', 'Lipa', 'Batangas', 'Lipa', '2007-06-03', 'Dr. Roman', 'Dengue', 202409674, 'o', NULL),
(202409576, '2024-10-05 17:09:37', 'Luna', '', 'King', 'Outpatient', 28, 'Female', NULL, 'Molave', '2517', NULL, 'Olympia', 'Makati', 'Makati', 'Makati', '1996-10-10', 'Dr. Roman', '', 202409673, 'o', NULL),
(202409580, '2024-11-01 15:49:31', 'adsasd', 'asdasda', 'sdadad', 'Inpatient', 13, 'Male', 210, 'asdasd', 'asdadas', 'dasdasd', 'asdadas', 'asdas', 'dasdasd', 'asdasd', '2017-11-08', 'sdaasdas', 'asdasds', 202409673, 'o', NULL),
(202409581, '2023-11-01 15:49:31', 'adsasd', 'asdasda', 'sdadad', 'Inpatient', 13, 'Male', 210, 'asdasd', 'asdadas', 'dasdasd', 'asdadas', 'asdas', 'dasdasd', 'asdasd', '2017-11-08', 'sdaasdas', 'asdasds', 202409673, 'o', NULL),
(202409582, '2024-10-01 15:49:31', 'adsasd', 'asdasda', 'sdadad', 'Inpatient', 13, 'Male', 210, 'asdasd', 'asdadas', 'dasdasd', 'asdadas', 'asdas', 'dasdasd', 'asdasd', '2017-11-08', 'sdaasdas', 'asdasds', 202409673, 'o', NULL),
(202409583, '2024-11-03 17:00:15', 'asdas', 'zczcz', 'xzczxc', 'Inpatient', 12, 'Female', 210, 'asfsa', 'sfasf', 'sfasf', 'Dagatan', 'Lipa', 'Batangas', 'asfasf', '2024-11-01', 'asdsa', 'Fever', 202409673, 'o', NULL),
(202409585, '2024-11-04 13:25:43', 'Kurt William', 'Luangco', 'Chavez', 'Inpatient', 18, 'Male', 208, 'sada', 'sadad', 'asdasd', 'asdasd', 'asdas', 'sadasd', 'sdasd', '2014-11-11', 'asdas', 'Cold', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_info_notes`
--

CREATE TABLE `patient_info_notes` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Medical_History` text DEFAULT NULL,
  `Allergies` text DEFAULT NULL,
  `Current_Medication` text DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_info_notes`
--

INSERT INTO `patient_info_notes` (`Patient_ID`, `Medical_History`, `Allergies`, `Current_Medication`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, 'TEST', 'TEST', 'TEST', 202409673, 'o', NULL),
(202409564, 'Test1', 'Test1', 'Test1', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_intake`
--

CREATE TABLE `patient_intake` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Intake_Date` date DEFAULT NULL,
  `Intake_Time` char(5) DEFAULT NULL,
  `Intake_Type` varchar(20) DEFAULT NULL,
  `Intake_Measure` decimal(5,2) DEFAULT NULL,
  `Intake_Remarks` text DEFAULT NULL,
  `Status` char(2) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_intake`
--

INSERT INTO `patient_intake` (`Patient_ID`, `Entered_By_Nurse`, `Intake_Date`, `Intake_Time`, `Intake_Type`, `Intake_Measure`, `Intake_Remarks`, `Status`, `Deletion_Date`) VALUES
(202409564, 202409673, '2024-11-04', 'AM', 'Oral', 2.10, 'AAA', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'AM', 'Parental', 1.00, 'AAA', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'AM', 'Other', 0.00, 'AAA', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'PM', 'Oral', 0.50, 'BBB', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'PM', 'Parental', 3.00, 'BBB', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'PM', 'Other', 1.30, 'BBB', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'Night', 'Oral', 0.80, 'CCC', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'Night', 'Parental', 2.60, 'CCC', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'Night', 'Other', 0.90, 'CCC', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'AM', 'Oral', 4.00, 'DDD', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'AM', 'Parental', 2.30, 'DDD', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'AM', 'Other', 0.30, 'DDD', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'PM', 'Oral', 2.80, 'EEE', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'PM', 'Parental', 1.80, 'EEE', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'PM', 'Other', 0.67, 'EEE', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_lab_results`
--

CREATE TABLE `patient_lab_results` (
  `Lab_Result_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` varchar(30) DEFAULT NULL,
  `File_Name` varchar(255) DEFAULT NULL,
  `Upload_Date` datetime DEFAULT NULL,
  `Image_Location` varchar(255) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_lab_results`
--

INSERT INTO `patient_lab_results` (`Lab_Result_ID`, `Patient_ID`, `Entered_By_Nurse`, `File_Name`, `Upload_Date`, `Image_Location`, `Status`, `Deletion_Date`) VALUES
(22, 202409564, 'Althea Lois Castro', '1728464862.gif', '2024-10-09 11:07:42', 'upload/1728464862.gif', 'o', NULL),
(23, 202409564, 'Neville Longbottom', '1728716065.gif', '2024-10-12 08:54:25', 'upload/1728716065.gif', 'x', '2024-10-23');

-- --------------------------------------------------------

--
-- Table structure for table `patient_output`
--

CREATE TABLE `patient_output` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Output_Date` date DEFAULT NULL,
  `Output_Time` char(5) DEFAULT NULL,
  `Output_Type` varchar(20) DEFAULT NULL,
  `Output_Measure` decimal(5,2) DEFAULT NULL,
  `Output_Remarks` text DEFAULT NULL,
  `Status` char(2) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_output`
--

INSERT INTO `patient_output` (`Patient_ID`, `Entered_By_Nurse`, `Output_Date`, `Output_Time`, `Output_Type`, `Output_Measure`, `Output_Remarks`, `Status`, `Deletion_Date`) VALUES
(202409564, 202409673, '2024-11-04', 'AM', 'Urine', 2.40, 'AAA', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'AM', 'Stool', 1.50, 'AAA', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'AM', 'Drainage', 1.70, 'AAA', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'PM', 'Urine', 3.10, 'BBB', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'PM', 'Stool', 2.80, 'BBB', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'PM', 'Drainage', 0.30, 'BBB', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'Night', 'Urine', 1.30, 'CCC', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'Night', 'Stool', 4.10, 'CCC', 'o', NULL),
(202409564, 202409673, '2024-11-04', 'Night', 'Drainage', 0.00, 'CCC', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'AM', 'Urine', 1.20, 'DDD', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'AM', 'Stool', 3.60, 'DDD', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'AM', 'Drainage', 0.00, 'DDD', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'PM', 'Urine', 2.60, 'EEE', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'PM', 'Stool', 2.50, 'EEE', 'o', NULL),
(202409564, 202409673, '2024-11-05', 'PM', 'Drainage', 1.30, 'EEE', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_scan_results`
--

CREATE TABLE `patient_scan_results` (
  `Scan_Result_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` varchar(30) DEFAULT NULL,
  `File_Name` varchar(255) DEFAULT NULL,
  `Upload_Date` datetime DEFAULT NULL,
  `Image_Location` varchar(255) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_scan_results`
--

INSERT INTO `patient_scan_results` (`Scan_Result_ID`, `Patient_ID`, `Entered_By_Nurse`, `File_Name`, `Upload_Date`, `Image_Location`, `Status`, `Deletion_Date`) VALUES
(2, 202409564, 'Althea Lois Castro', '1728464967.gif', '2024-10-09 11:09:27', 'upload/1728464967.gif', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `patient_vital_signs`
--

CREATE TABLE `patient_vital_signs` (
  `Patient_ID` int(20) NOT NULL,
  `Vitals_DateTime` datetime NOT NULL,
  `Blood_Pressure` varchar(10) NOT NULL,
  `Respiratory_Rate` int(11) NOT NULL,
  `Pulse_Rate` int(11) NOT NULL,
  `Temperature` double NOT NULL,
  `Oxygen_Lvl` int(11) NOT NULL,
  `Weight` double NOT NULL,
  `Pain_Scale` int(11) NOT NULL,
  `Intervention` mediumtext NOT NULL,
  `Entered_By_Nurse` int(20) NOT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient_vital_signs`
--

INSERT INTO `patient_vital_signs` (`Patient_ID`, `Vitals_DateTime`, `Blood_Pressure`, `Respiratory_Rate`, `Pulse_Rate`, `Temperature`, `Oxygen_Lvl`, `Weight`, `Pain_Scale`, `Intervention`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-01 14:44:56', '120/80', 18, 72, 36.8, 98, 68, 2, 'Test', 202409673, 'o', NULL),
(202409564, '2024-09-24 07:50:51', '110/80', 85, 82, 36.5, 100, 70.74, 1, 'Test1', 202409673, 'o', NULL),
(202409564, '2024-10-25 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-25 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-25 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-25 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-25 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-25 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-26 15:15:23', '120/80', 85, 82, 36.5, 100, 67.74, 1, 'sfasfasfa', 202409673, 'o', NULL),
(202409564, '2024-10-26 16:08:32', '110/80', 89, 80, 38.5, 100, 67.74, 1, 'cxvvxczvz', 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `Room_Number` int(11) NOT NULL,
  `Room_Type` varchar(20) DEFAULT NULL,
  `Bed_Capacity` int(11) DEFAULT NULL,
  `Available_Beds` int(11) DEFAULT NULL,
  `Room_Status` varchar(20) DEFAULT NULL,
  `Scheduled_Maintenance` datetime DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`Room_Number`, `Room_Type`, `Bed_Capacity`, `Available_Beds`, `Room_Status`, `Scheduled_Maintenance`, `Status`, `Deletion_Date`) VALUES
(206, 'Single', 1, 0, 'Occupied', '2024-09-30 16:01:28', 'o', NULL),
(207, 'Double', 2, 2, 'Available', '2024-09-27 16:01:28', 'o', NULL),
(208, 'Double', 2, 1, 'Available', '2024-10-02 09:43:55', 'o', NULL),
(209, 'Single', 1, 1, 'Available', '2024-10-01 09:43:55', 'o', NULL),
(210, 'Double', 2, 2, 'Available', '2024-09-29 10:36:30', 'o', NULL),
(211, 'Double', 2, 2, 'Available', '2024-10-08 10:36:30', 'o', NULL),
(212, 'Double', 2, 2, 'Available', '2024-10-22 14:09:22', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_information`
--

CREATE TABLE `rooms_information` (
  `Room_Number` int(11) DEFAULT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Day_Shift_Nurse_ID` int(20) DEFAULT NULL,
  `Night_Shift_Nurse_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_information`
--

INSERT INTO `rooms_information` (`Room_Number`, `Patient_ID`, `Day_Shift_Nurse_ID`, `Night_Shift_Nurse_ID`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(206, 202409564, 202409673, 202409674, 202409675, 'o', NULL),
(208, 202409566, 202409673, 202409674, 202409675, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rooms_maintenance`
--

CREATE TABLE `rooms_maintenance` (
  `Room_Number` int(11) DEFAULT NULL,
  `Scheduled_Maintenance` datetime DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_maintenance`
--

INSERT INTO `rooms_maintenance` (`Room_Number`, `Scheduled_Maintenance`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(206, '2024-10-16 13:35:31', 202409675, 'o', NULL),
(212, '2024-10-16 15:23:40', 202409675, 'o', NULL),
(212, '2024-10-16 15:24:34', 202409675, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `standing_order_response`
--

CREATE TABLE `standing_order_response` (
  `Standing_Order_ID` int(11) NOT NULL,
  `Patient_ID` int(20) DEFAULT NULL,
  `Order_Start_Date` date DEFAULT NULL,
  `Order_Discontinued_Date` date DEFAULT NULL,
  `Remarks` text DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `standing_order_response`
--

INSERT INTO `standing_order_response` (`Standing_Order_ID`, `Patient_ID`, `Order_Start_Date`, `Order_Discontinued_Date`, `Remarks`, `Entered_By_Nurse`) VALUES
(3, 202409564, '2024-10-28', '2024-10-28', 'asdsad', 202409673),
(1, 202409564, '2024-10-27', '2024-10-29', 'zxczczx', 202409673);

-- --------------------------------------------------------

--
-- Table structure for table `tpr_initial_vitals`
--

CREATE TABLE `tpr_initial_vitals` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Initial_Vitals_Date` datetime DEFAULT NULL,
  `Blood_Pressure` varchar(10) DEFAULT NULL,
  `Pulse_Rate` int(11) DEFAULT NULL,
  `Respiratory_Rate` int(11) DEFAULT NULL,
  `Temperature` double DEFAULT NULL,
  `Weight` double DEFAULT NULL,
  `IE` double DEFAULT NULL,
  `FHT` int(11) DEFAULT NULL,
  `Entered_By_Nurse` int(11) NOT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tpr_initial_vitals`
--

INSERT INTO `tpr_initial_vitals` (`Patient_ID`, `Initial_Vitals_Date`, `Blood_Pressure`, `Pulse_Rate`, `Respiratory_Rate`, `Temperature`, `Weight`, `IE`, `FHT`, `Entered_By_Nurse`, `Status`, `Deletion_Date`) VALUES
(202409564, '2024-09-12 12:20:42', '120/80', 80, 89, 35.6, 67.74, NULL, NULL, 202409673, 'o', NULL),
(202409564, '2024-09-26 14:00:27', '110/80', 82, 85, 36.5, 70.74, NULL, NULL, 202409673, 'o', NULL),
(202409564, '2024-10-13 12:46:30', '115/83', 87, 90, 37.8, 71, NULL, NULL, 202409673, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tpr_vital_signs`
--

CREATE TABLE `tpr_vital_signs` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Vitals_Date` date DEFAULT NULL,
  `Day_Number` int(11) DEFAULT NULL,
  `Vitals_Time_Check` time NOT NULL,
  `Temperature` decimal(5,2) NOT NULL,
  `Pulse` int(11) NOT NULL,
  `Respiration` int(11) NOT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tpr_vital_signs`
--

INSERT INTO `tpr_vital_signs` (`Patient_ID`, `Entered_By_Nurse`, `Vitals_Date`, `Day_Number`, `Vitals_Time_Check`, `Temperature`, `Pulse`, `Respiration`, `Status`, `Deletion_Date`) VALUES
(202409564, 202409673, '2024-10-25', 1, '00:49:00', 36.50, 72, 22, 'o', NULL),
(202409564, 202409673, '2024-10-25', 1, '06:18:18', 36.00, 86, 20, 'o', NULL),
(202409564, 202409673, '2024-10-25', 1, '10:18:18', 65.00, 87, 31, 'o', NULL),
(202409564, 202409673, '2024-10-25', 1, '13:05:00', 23.00, 62, 41, 'o', NULL),
(202409564, 202409673, '2024-10-25', 1, '18:23:02', 61.00, 23, 1, 'o', NULL),
(202409564, 202409673, '2024-10-25', 1, '22:41:00', 24.00, 14, 2, 'o', NULL),
(202409564, 202409673, '2024-10-26', 2, '00:49:00', 36.50, 62, 23, 'o', NULL),
(202409564, 202409673, '2024-10-26', 2, '06:18:18', 78.00, 26, 21, 'o', NULL),
(202409564, 202409673, '2024-10-26', 2, '10:18:18', 85.00, 67, 51, 'o', NULL),
(202409564, 202409673, '2024-10-26', 2, '13:05:00', 26.00, 75, 43, 'o', NULL),
(202409564, 202409673, '2024-10-26', 2, '18:23:02', 35.00, 22, 74, 'o', NULL),
(202409564, 202409673, '2024-10-26', 2, '22:41:00', 31.00, 46, 1, 'o', NULL),
(202409564, 202409673, '2024-10-27', 3, '00:49:00', 36.50, 72, 22, 'o', NULL),
(202409564, 202409673, '2024-10-27', 3, '06:18:18', 36.00, 86, 20, 'o', NULL),
(202409564, 202409673, '2024-10-27', 3, '10:18:18', 65.00, 87, 31, 'o', NULL),
(202409564, 202409673, '2024-10-27', 3, '13:05:00', 23.00, 62, 41, 'o', NULL),
(202409564, 202409673, '2024-10-27', 3, '18:23:02', 61.00, 23, 1, 'o', NULL),
(202409564, 202409673, '2024-10-27', 3, '22:41:00', 24.00, 14, 2, 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tpr_vital_signs_output`
--

CREATE TABLE `tpr_vital_signs_output` (
  `Patient_ID` int(20) DEFAULT NULL,
  `Entered_By_Nurse` int(20) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Output_Time_Check` time NOT NULL,
  `Blood_Pressure` varchar(7) NOT NULL,
  `Urine` varchar(255) NOT NULL,
  `Stool` varchar(255) NOT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tpr_vital_signs_output`
--

INSERT INTO `tpr_vital_signs_output` (`Patient_ID`, `Entered_By_Nurse`, `Date`, `Output_Time_Check`, `Blood_Pressure`, `Urine`, `Stool`, `Status`, `Deletion_Date`) VALUES
(202409564, 202409673, '2024-10-25', '03:54:41', '120/80', '1', '2', 'o', NULL),
(202409564, 202409673, '2024-10-25', '18:47:11', '110/84', '3', '4', 'o', NULL),
(202409564, 202409673, '2024-10-25', '22:05:21', '100/80', '5', '6', 'o', NULL),
(202409564, 202409673, '2024-10-26', '03:54:41', '125/85', '7', '8', 'o', NULL),
(202409564, 202409673, '2024-10-26', '18:47:11', '115/89', '9', '10', 'o', NULL),
(202409564, 202409673, '2024-10-26', '22:05:21', '105/85', '11', '12', 'o', NULL),
(202409564, 202409673, '2024-10-27', '03:54:41', '130/90', '13', '14', 'o', NULL),
(202409564, 202409673, '2024-10-27', '18:47:11', '120/94', '15', '16', 'o', NULL),
(202409564, 202409673, '2024-10-27', '22:05:21', '110/90', '17', '18', 'o', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `User_ID` int(11) NOT NULL,
  `User_FName` varchar(30) NOT NULL,
  `User_MName` varchar(30) NOT NULL,
  `User_LName` varchar(30) NOT NULL,
  `Contact_Num` varchar(25) NOT NULL,
  `Department` varchar(255) NOT NULL,
  `Position` varchar(25) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Account_Created` date DEFAULT NULL,
  `Status` char(3) DEFAULT NULL,
  `Deletion_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`User_ID`, `User_FName`, `User_MName`, `User_LName`, `Contact_Num`, `Department`, `Position`, `Email`, `Password`, `Account_Created`, `Status`, `Deletion_Date`) VALUES
(202409673, 'Althea Lois', 'Lalican', 'Castro', '09592852735', 'Pediatrics', 'Nurse 1', 'Thea@gmail.com', '1111', '2024-09-09', 'o', NULL),
(202409674, 'Neville', '', 'Longbottom', '09592855832', 'Pediatrics', 'Nurse 1', 'Neville@gmail.com', '1111', '2024-09-10', 'o', NULL),
(202409675, 'Severus', '', 'Snape', '09592856831', 'Pediatrics', 'Nurse 2', 'Snape@gmail.com', '1111', '2024-09-10', 'o', NULL),
(202409676, 'Regulus', 'Arcturus', 'Black', '09248127465', 'Pediatrics', 'Doctor', 'RAB@gmail.com', '1234', '2024-09-15', 'o', NULL),
(202409677, 'Sirius', 'Orion', 'Black', '09582746124', 'Pediatrics', 'Admin', 'SOB@gmail.com', '1234', '2024-09-20', 'o', NULL),
(202409678, 'AAAA', 'BBBB', 'CCCC', '0948742841', 'GUH', 'Doctor', 'test@gmail.com', '1111', '2024-09-20', 'o', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ivfr_fast_drip`
--
ALTER TABLE `ivfr_fast_drip`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `ivfr_iv`
--
ALTER TABLE `ivfr_iv`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `ivfr_side_drips`
--
ALTER TABLE `ivfr_side_drips`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_diagnostics`
--
ALTER TABLE `kardex_diagnostics`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Diagnostics_Category` (`Diagnostics_Category`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_diagnostics_categories`
--
ALTER TABLE `kardex_diagnostics_categories`
  ADD PRIMARY KEY (`Diagnostics_Checks`);

--
-- Indexes for table `kardex_diet`
--
ALTER TABLE `kardex_diet`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Diet_Category` (`Diet_Category`),
  ADD KEY `kardex_diet_ibfk_3` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_diet_categories`
--
ALTER TABLE `kardex_diet_categories`
  ADD PRIMARY KEY (`Diet_Checks`);

--
-- Indexes for table `kardex_diet_last_meal`
--
ALTER TABLE `kardex_diet_last_meal`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_drips_transfusion`
--
ALTER TABLE `kardex_drips_transfusion`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_endorsements`
--
ALTER TABLE `kardex_endorsements`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_io`
--
ALTER TABLE `kardex_io`
  ADD KEY `IO_Category` (`IO_Category`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_io_categories`
--
ALTER TABLE `kardex_io_categories`
  ADD PRIMARY KEY (`IO_Checks`);

--
-- Indexes for table `kardex_iv`
--
ALTER TABLE `kardex_iv`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_medications`
--
ALTER TABLE `kardex_medications`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_notes`
--
ALTER TABLE `kardex_notes`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_tbl`
--
ALTER TABLE `kardex_tbl`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_vitals`
--
ALTER TABLE `kardex_vitals`
  ADD KEY `Vitals_Category` (`Vitals_Category`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `kardex_vitals_categories`
--
ALTER TABLE `kardex_vitals_categories`
  ADD PRIMARY KEY (`Vitals_Checks`);

--
-- Indexes for table `medication_record_prn_response`
--
ALTER TABLE `medication_record_prn_response`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Ordered_By_Doctor` (`Ordered_By_Doctor`),
  ADD KEY `Medication_PRN_ID` (`Medication_PRN_ID`);

--
-- Indexes for table `medication_record_so_response`
--
ALTER TABLE `medication_record_so_response`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Ordered_By_Doctor` (`Ordered_By_Doctor`),
  ADD KEY `Medication_SO_ID` (`Medication_SO_ID`);

--
-- Indexes for table `medication_record_stat_response`
--
ALTER TABLE `medication_record_stat_response`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Ordered_By_Doctor` (`Ordered_By_Doctor`),
  ADD KEY `Medication_STAT_ID` (`Medication_STAT_ID`);

--
-- Indexes for table `nurse_notes`
--
ALTER TABLE `nurse_notes`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `nurse_sched`
--
ALTER TABLE `nurse_sched`
  ADD KEY `Day_Shift_Nurse_ID` (`Day_Shift_Nurse_ID`),
  ADD KEY `Night_Shift_Nurse_ID` (`Night_Shift_Nurse_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`),
  ADD KEY `Patient_ID` (`Patient_ID`);

--
-- Indexes for table `outpatient_info`
--
ALTER TABLE `outpatient_info`
  ADD PRIMARY KEY (`Outpatient_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `patient_contacts`
--
ALTER TABLE `patient_contacts`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `patient_emergency_contact`
--
ALTER TABLE `patient_emergency_contact`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `patient_info`
--
ALTER TABLE `patient_info`
  ADD PRIMARY KEY (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`),
  ADD KEY `Room_Num` (`Room_Num`);

--
-- Indexes for table `patient_info_notes`
--
ALTER TABLE `patient_info_notes`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `patient_intake`
--
ALTER TABLE `patient_intake`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `patient_lab_results`
--
ALTER TABLE `patient_lab_results`
  ADD PRIMARY KEY (`Lab_Result_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`);

--
-- Indexes for table `patient_output`
--
ALTER TABLE `patient_output`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `patient_scan_results`
--
ALTER TABLE `patient_scan_results`
  ADD PRIMARY KEY (`Scan_Result_ID`),
  ADD KEY `Patient_ID` (`Patient_ID`);

--
-- Indexes for table `patient_vital_signs`
--
ALTER TABLE `patient_vital_signs`
  ADD KEY `vitals_tbl_ibfk_1` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`Room_Number`);

--
-- Indexes for table `rooms_information`
--
ALTER TABLE `rooms_information`
  ADD KEY `Room_Number` (`Room_Number`),
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Day_Shift_Nurse_ID` (`Day_Shift_Nurse_ID`),
  ADD KEY `Night_Shift_Nurse_ID` (`Night_Shift_Nurse_ID`),
  ADD KEY `fk_entered_by_nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `rooms_maintenance`
--
ALTER TABLE `rooms_maintenance`
  ADD KEY `Room_Number` (`Room_Number`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `standing_order_response`
--
ALTER TABLE `standing_order_response`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`),
  ADD KEY `Standing_Order_ID` (`Standing_Order_ID`);

--
-- Indexes for table `tpr_initial_vitals`
--
ALTER TABLE `tpr_initial_vitals`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `tpr_vital_signs`
--
ALTER TABLE `tpr_vital_signs`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `tpr_vital_signs_output`
--
ALTER TABLE `tpr_vital_signs_output`
  ADD KEY `Patient_ID` (`Patient_ID`),
  ADD KEY `Entered_By_Nurse` (`Entered_By_Nurse`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `outpatient_info`
--
ALTER TABLE `outpatient_info`
  MODIFY `Outpatient_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `patient_info`
--
ALTER TABLE `patient_info`
  MODIFY `Patient_ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202409587;

--
-- AUTO_INCREMENT for table `patient_lab_results`
--
ALTER TABLE `patient_lab_results`
  MODIFY `Lab_Result_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `patient_scan_results`
--
ALTER TABLE `patient_scan_results`
  MODIFY `Scan_Result_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202409679;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ivfr_fast_drip`
--
ALTER TABLE `ivfr_fast_drip`
  ADD CONSTRAINT `ivfr_fast_drip_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `ivfr_fast_drip_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `ivfr_iv`
--
ALTER TABLE `ivfr_iv`
  ADD CONSTRAINT `ivfr_iv_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `ivfr_iv_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `ivfr_side_drips`
--
ALTER TABLE `ivfr_side_drips`
  ADD CONSTRAINT `ivfr_side_drips_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `ivfr_side_drips_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_diagnostics`
--
ALTER TABLE `kardex_diagnostics`
  ADD CONSTRAINT `kardex_diagnostics_ibfk_2` FOREIGN KEY (`Diagnostics_Category`) REFERENCES `kardex_diagnostics_categories` (`Diagnostics_Checks`),
  ADD CONSTRAINT `kardex_diagnostics_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_diagnostics_ibfk_4` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_diet`
--
ALTER TABLE `kardex_diet`
  ADD CONSTRAINT `kardex_diet_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_diet_ibfk_2` FOREIGN KEY (`Diet_Category`) REFERENCES `kardex_diet_categories` (`Diet_Checks`),
  ADD CONSTRAINT `kardex_diet_ibfk_3` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_diet_last_meal`
--
ALTER TABLE `kardex_diet_last_meal`
  ADD CONSTRAINT `kardex_diet_last_meal_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_diet_last_meal_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_drips_transfusion`
--
ALTER TABLE `kardex_drips_transfusion`
  ADD CONSTRAINT `kardex_drips_transfusion_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_drips_transfusion_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_endorsements`
--
ALTER TABLE `kardex_endorsements`
  ADD CONSTRAINT `kardex_endorsements_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_endorsements_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_io`
--
ALTER TABLE `kardex_io`
  ADD CONSTRAINT `kardex_io_ibfk_2` FOREIGN KEY (`IO_Category`) REFERENCES `kardex_io_categories` (`IO_Checks`),
  ADD CONSTRAINT `kardex_io_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_io_ibfk_4` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_iv`
--
ALTER TABLE `kardex_iv`
  ADD CONSTRAINT `kardex_iv_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_iv_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_medications`
--
ALTER TABLE `kardex_medications`
  ADD CONSTRAINT `kardex_medications_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_medications_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_notes`
--
ALTER TABLE `kardex_notes`
  ADD CONSTRAINT `kardex_notes_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_notes_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_tbl`
--
ALTER TABLE `kardex_tbl`
  ADD CONSTRAINT `kardex_tbl_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_tbl_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `kardex_vitals`
--
ALTER TABLE `kardex_vitals`
  ADD CONSTRAINT `kardex_vitals_ibfk_2` FOREIGN KEY (`Vitals_Category`) REFERENCES `kardex_vitals_categories` (`Vitals_Checks`),
  ADD CONSTRAINT `kardex_vitals_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `kardex_vitals_ibfk_4` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `medication_record_prn_response`
--
ALTER TABLE `medication_record_prn_response`
  ADD CONSTRAINT `medication_record_prn_response_ibfk_1` FOREIGN KEY (`Medication_PRN_ID`) REFERENCES `docudata_doctors`.`medication_record_prn` (`Medication_PRN_ID`),
  ADD CONSTRAINT `medication_record_prn_response_ibfk_2` FOREIGN KEY (`Ordered_By_Doctor`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `medication_record_prn_response_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `medication_record_so_response`
--
ALTER TABLE `medication_record_so_response`
  ADD CONSTRAINT `medication_record_so_response_ibfk_1` FOREIGN KEY (`Medication_SO_ID`) REFERENCES `docudata_doctors`.`medication_record_so` (`Medication_SO_ID`),
  ADD CONSTRAINT `medication_record_so_response_ibfk_2` FOREIGN KEY (`Ordered_By_Doctor`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `medication_record_so_response_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `medication_record_stat_response`
--
ALTER TABLE `medication_record_stat_response`
  ADD CONSTRAINT `medication_record_stat_response_ibfk_1` FOREIGN KEY (`Medication_STAT_ID`) REFERENCES `docudata_doctors`.`medication_record_stat` (`Medication_STAT_ID`),
  ADD CONSTRAINT `medication_record_stat_response_ibfk_2` FOREIGN KEY (`Ordered_By_Doctor`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `medication_record_stat_response_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `nurse_notes`
--
ALTER TABLE `nurse_notes`
  ADD CONSTRAINT `nurse_notes_ibfk_1` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `nurse_notes_ibfk_2` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `nurse_sched`
--
ALTER TABLE `nurse_sched`
  ADD CONSTRAINT `nurse_sched_ibfk_1` FOREIGN KEY (`Day_Shift_Nurse_ID`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `nurse_sched_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `nurse_sched_ibfk_3` FOREIGN KEY (`Night_Shift_Nurse_ID`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `nurse_sched_ibfk_4` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `outpatient_info`
--
ALTER TABLE `outpatient_info`
  ADD CONSTRAINT `outpatient_info_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `outpatient_info_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `patient_contacts`
--
ALTER TABLE `patient_contacts`
  ADD CONSTRAINT `patient_contacts_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `patient_contacts_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `patient_emergency_contact`
--
ALTER TABLE `patient_emergency_contact`
  ADD CONSTRAINT `patient_emergency_contact_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `patient_emergency_contact_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `patient_info`
--
ALTER TABLE `patient_info`
  ADD CONSTRAINT `patient_info_ibfk_1` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `patient_info_ibfk_2` FOREIGN KEY (`Room_Num`) REFERENCES `rooms` (`Room_Number`);

--
-- Constraints for table `patient_info_notes`
--
ALTER TABLE `patient_info_notes`
  ADD CONSTRAINT `patient_info_notes_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `patient_info_notes_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `patient_intake`
--
ALTER TABLE `patient_intake`
  ADD CONSTRAINT `patient_intake_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `patient_intake_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `patient_lab_results`
--
ALTER TABLE `patient_lab_results`
  ADD CONSTRAINT `patient_lab_results_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `patient_output`
--
ALTER TABLE `patient_output`
  ADD CONSTRAINT `patient_output_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `patient_output_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `patient_scan_results`
--
ALTER TABLE `patient_scan_results`
  ADD CONSTRAINT `patient_scan_results_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `patient_vital_signs`
--
ALTER TABLE `patient_vital_signs`
  ADD CONSTRAINT `patient_vital_signs_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `patient_vital_signs_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);

--
-- Constraints for table `rooms_information`
--
ALTER TABLE `rooms_information`
  ADD CONSTRAINT `rooms_information_ibfk_1` FOREIGN KEY (`Day_Shift_Nurse_ID`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `rooms_information_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `rooms_information_ibfk_3` FOREIGN KEY (`Night_Shift_Nurse_ID`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `rooms_information_ibfk_4` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `rooms_information_ibfk_5` FOREIGN KEY (`Room_Number`) REFERENCES `rooms` (`Room_Number`);

--
-- Constraints for table `rooms_maintenance`
--
ALTER TABLE `rooms_maintenance`
  ADD CONSTRAINT `rooms_maintenance_ibfk_1` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `rooms_maintenance_ibfk_2` FOREIGN KEY (`Room_Number`) REFERENCES `rooms` (`Room_Number`);

--
-- Constraints for table `standing_order_response`
--
ALTER TABLE `standing_order_response`
  ADD CONSTRAINT `standing_order_response_ibfk_1` FOREIGN KEY (`Standing_Order_ID`) REFERENCES `docudata_doctors`.`standing_order` (`Standing_Order_ID`),
  ADD CONSTRAINT `standing_order_response_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `standing_order_response_ibfk_3` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `tpr_initial_vitals`
--
ALTER TABLE `tpr_initial_vitals`
  ADD CONSTRAINT `tpr_initial_vitals_ibfk_1` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `tpr_initial_vitals_ibfk_2` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `tpr_vital_signs`
--
ALTER TABLE `tpr_vital_signs`
  ADD CONSTRAINT `tpr_vital_signs_ibfk_1` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`),
  ADD CONSTRAINT `tpr_vital_signs_ibfk_2` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`);

--
-- Constraints for table `tpr_vital_signs_output`
--
ALTER TABLE `tpr_vital_signs_output`
  ADD CONSTRAINT `tpr_vital_signs_output_ibfk_1` FOREIGN KEY (`Patient_ID`) REFERENCES `patient_info` (`Patient_ID`),
  ADD CONSTRAINT `tpr_vital_signs_output_ibfk_2` FOREIGN KEY (`Entered_By_Nurse`) REFERENCES `user_tbl` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
