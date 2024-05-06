-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2024 at 07:16 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hcmccapstone_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_user_info`
--

CREATE TABLE `account_user_info` (
  `user_info_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `First_Name` varchar(200) DEFAULT NULL,
  `Middle_Name` varchar(200) DEFAULT NULL,
  `Last_Name` varchar(200) DEFAULT NULL,
  `DateofBirth` date DEFAULT NULL,
  `Sex` varchar(200) DEFAULT NULL,
  `Contact_Number` int(11) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account_user_info`
--

INSERT INTO `account_user_info` (`user_info_ID`, `User_ID`, `First_Name`, `Middle_Name`, `Last_Name`, `DateofBirth`, `Sex`, `Contact_Number`, `Address`) VALUES
(1, 1, 'FirstnameSample', 'MiddleNamE', 'ThelastName', '2024-04-17', 'male', 32546, 'Theaddress'),
(2, 2, 'SampleFirstname', 'Doe', 'JoNhy', '2024-04-17', 'male', 1234569721, 'Theaddress'),
(3, 3, 'SampleFirstname', 'Doe', 'JoNhy', '2024-04-10', 'male', 1234569721, 'Theaddress');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accounts`
--

CREATE TABLE `tbl_accounts` (
  `User_ID` int(11) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `userType` varchar(50) DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_accounts`
--

INSERT INTO `tbl_accounts` (`User_ID`, `Email`, `Password`, `userType`) VALUES
(1, 'sampleEmail@gmail.com', '$2y$10$1rXS6tvbN7GSX6GAVAgc3OaqDH71LJccIb2TYmNFSjxWTiwsv7YOi', 'patient'),
(2, 'sampleemail0235@gmail.com', '$2y$10$ZnaV1a3UIxaDHITIcHMp2u2Fnf5WUIPKb1jfKpPjgdO9fIu9g0th6', 'patient'),
(3, 'sampleemail123@gmail.com', '$2y$10$crw.xFf27Mu64.12CD46mO4O5kpQFC4Q5KeWawt6PtqhSdDJtw4w.', 'patient'),
(5, 'doctorEmail@gmail.com', '123', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointment`
--

CREATE TABLE `tbl_appointment` (
  `Appointment_ID` int(11) NOT NULL,
  `user_info_ID` int(11) DEFAULT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `Appointment_schedule` datetime DEFAULT NULL,
  `Purpose` varchar(200) DEFAULT NULL,
  `Status` varchar(200) DEFAULT NULL,
  `Appointment_type` varchar(200) DEFAULT NULL,
  `Vaccination` varchar(200) DEFAULT NULL,
  `First_Name` varchar(200) DEFAULT NULL,
  `Middle_Name` varchar(200) DEFAULT NULL,
  `Last_Name` varchar(200) DEFAULT NULL,
  `DateofBirth` date DEFAULT NULL,
  `Sex` varchar(200) DEFAULT NULL,
  `Contact_Number` int(11) DEFAULT NULL,
  `Address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_availability`
--

CREATE TABLE `tbl_availability` (
  `Availability_ID` int(11) NOT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `Specialty` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_availability`
--

INSERT INTO `tbl_availability` (`Availability_ID`, `Staff_ID`, `Date`, `StartTime`, `EndTime`, `Specialty`) VALUES
(1, 1, '2024-04-18', '03:43:55', '07:43:55', 'PEdia');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_records`
--

CREATE TABLE `tbl_records` (
  `Record_ID` int(11) NOT NULL,
  `Appointment_ID` int(11) DEFAULT NULL,
  `Temperature` varchar(200) DEFAULT NULL,
  `Blood_Pressure` varchar(200) DEFAULT NULL,
  `Saturation` varchar(200) DEFAULT NULL,
  `Chief_complaint` varchar(200) DEFAULT NULL,
  `Objective` varchar(200) DEFAULT NULL,
  `Assessment` varchar(200) DEFAULT NULL,
  `Plan` varchar(200) DEFAULT NULL,
  `Blood_type` varchar(200) DEFAULT NULL,
  `Health_card` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_specialty`
--

CREATE TABLE `tbl_specialty` (
  `Specialty` varchar(200) DEFAULT NULL,
  `Staff_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `Staff_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `First_Name` varchar(200) DEFAULT NULL,
  `Middle_Name` varchar(200) DEFAULT NULL,
  `Last_Name` varchar(200) DEFAULT NULL,
  `Contact_number` varchar(200) DEFAULT NULL,
  `Sex` varchar(200) DEFAULT NULL,
  `Role` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`Staff_ID`, `User_ID`, `First_Name`, `Middle_Name`, `Last_Name`, `Contact_number`, `Sex`, `Role`) VALUES
(1, 5, 'doctorfirstname', 'Nomiddlename', 'Thelastname', '0912345631', 'Sige', 'doctor');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_user_info`
--
ALTER TABLE `account_user_info`
  ADD PRIMARY KEY (`user_info_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  ADD PRIMARY KEY (`User_ID`);

--
-- Indexes for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD PRIMARY KEY (`Appointment_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`),
  ADD KEY `user_info_ID` (`user_info_ID`);

--
-- Indexes for table `tbl_availability`
--
ALTER TABLE `tbl_availability`
  ADD PRIMARY KEY (`Availability_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `tbl_records`
--
ALTER TABLE `tbl_records`
  ADD PRIMARY KEY (`Record_ID`),
  ADD KEY `Appointment_ID` (`Appointment_ID`);

--
-- Indexes for table `tbl_specialty`
--
ALTER TABLE `tbl_specialty`
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`Staff_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_user_info`
--
ALTER TABLE `account_user_info`
  MODIFY `user_info_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_accounts`
--
ALTER TABLE `tbl_accounts`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  MODIFY `Appointment_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_availability`
--
ALTER TABLE `tbl_availability`
  MODIFY `Availability_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_records`
--
ALTER TABLE `tbl_records`
  MODIFY `Record_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `account_user_info`
--
ALTER TABLE `account_user_info`
  ADD CONSTRAINT `account_user_info_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `tbl_accounts` (`User_ID`);

--
-- Constraints for table `tbl_appointment`
--
ALTER TABLE `tbl_appointment`
  ADD CONSTRAINT `tbl_appointment_ibfk_2` FOREIGN KEY (`Staff_ID`) REFERENCES `tbl_staff` (`Staff_ID`),
  ADD CONSTRAINT `tbl_appointment_ibfk_3` FOREIGN KEY (`user_info_ID`) REFERENCES `account_user_info` (`user_info_ID`);

--
-- Constraints for table `tbl_availability`
--
ALTER TABLE `tbl_availability`
  ADD CONSTRAINT `tbl_availability_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `tbl_staff` (`Staff_ID`);

--
-- Constraints for table `tbl_specialty`
--
ALTER TABLE `tbl_specialty`
  ADD CONSTRAINT `tbl_specialty_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `tbl_staff` (`Staff_ID`);

--
-- Constraints for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `tbl_staff_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `tbl_accounts` (`User_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
