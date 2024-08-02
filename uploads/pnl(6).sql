-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2024 at 01:16 PM
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
-- Database: `pnl`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `CategoryID` int(4) NOT NULL,
  `CategoryName` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES
(1, 'General'),
(2, 'Sports'),
(3, 'Academic');

-- --------------------------------------------------------

--
-- Table structure for table `dean`
--

CREATE TABLE `dean` (
  `DeanID` int(4) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact_No` varchar(15) NOT NULL,
  `UserID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dean`
--

INSERT INTO `dean` (`DeanID`, `Name`, `Email`, `NIC`, `Address`, `Contact_No`, `UserID`) VALUES
(1, 'Mohamed Shukry', 'mhdshukry111@gmail.com', '123456789V', '123 Elm Street, Springfield', '0786543033', 15);

-- --------------------------------------------------------

--
-- Table structure for table `lecturer`
--

CREATE TABLE `lecturer` (
  `LecturerID` int(4) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact_No` varchar(15) NOT NULL,
  `UserID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lecturer`
--

INSERT INTO `lecturer` (`LecturerID`, `Name`, `Email`, `NIC`, `Address`, `Contact_No`, `UserID`) VALUES
(1, 'Fathima Athiyya', 'athiyya1@gmail.com', '112233445V', '789 Oak Road, Springfield', '0767876789', 16);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `NewsID` int(4) NOT NULL,
  `Title` varchar(40) NOT NULL,
  `Content` varchar(800) NOT NULL,
  `DatePublished` datetime NOT NULL,
  `CategoryID` int(4) NOT NULL,
  `UserID` int(4) NOT NULL,
  `LastUpdated` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`NewsID`, `Title`, `Content`, `DatePublished`, `CategoryID`, `UserID`, `LastUpdated`) VALUES
(35, 'Football Fiesta 2024', 'Dear Students, The faculty sports council decided to organize a football fiesta in our faculty on 25th of July 2024. So, Submit your batch team card before 20th of July 2024. Thank you.', '2024-07-15 20:53:39', 2, 15, '2024-07-16 10:01:40'),
(36, 'Academic Strike', 'from 12th of july 2024 to continues strike. so, please leave from hostel before 1.00pm.\r\n', '2024-07-15 20:54:07', 3, 16, '2024-07-16 10:01:40'),
(37, 'General Meeting', 'We are pleased to announce a General Meeting scheduled for 25th of July 2024 in our faculty ground. All members are encouraged to attend. Key topics for discussion include recent developments, upcoming projects.', '2024-07-15 20:54:28', 1, 15, '2024-07-16 10:01:40'),
(38, 'Academic start ', 'academic start on 20th of August 2024.', '2024-07-16 10:01:40', 3, 16, '2024-08-02 16:34:22');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `ReviewID` int(4) NOT NULL,
  `StudentID` int(4) NOT NULL,
  `ReviewText` text NOT NULL,
  `Rating` int(1) NOT NULL CHECK (`Rating` between 1 and 5),
  `DateCreated` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`ReviewID`, `StudentID`, `ReviewText`, `Rating`, `DateCreated`) VALUES
(1, 1, 'Excellent course material and great teaching methods. Highly recommended!', 5, '2024-07-29 10:00:00'),
(2, 1, 'Good course, but the assignments could be more challenging.', 4, '2024-07-30 11:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `StudentID` int(4) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `NIC` varchar(20) NOT NULL,
  `DOB` date NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Contact_No` varchar(15) NOT NULL,
  `UserID` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`StudentID`, `Name`, `Email`, `NIC`, `DOB`, `Address`, `Contact_No`, `UserID`) VALUES
(1, 'Mohamed Shabry', 'abcd@gmail.com', '987654321V', '1998-01-01', '456 Maple Avenue, Springfield', '0715846587', 23);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(4) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Roll` varchar(15) NOT NULL DEFAULT 'Student',
  `ProfilePicture` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `Roll`, `ProfilePicture`) VALUES
(15, 'Mohamed Shukry', 'mhdshukry111@gmail.com', '$2y$10$wBQj4R4fCRIqvJ6llTd1AOOj2dlmj5vfwxMUE9z9o4p06tqPv/A/i', 'Dean', '../uploads/6696969b4dc71.png'),
(16, 'Fathima Athiyya', 'athiyya1@gmail.com', '$2y$10$b/V1MBeeAbZSYH/S8nEvw.NJfqslUG4e7nr4hGDDe3cuD8IUAaB7K', 'Lecturer', '../uploads/66965e5216351.jpg'),
(23, 'Mohamed Shabry', 'abcd@gmail.com', '$2y$10$qpylvH4Or2GmWMoUW8I8l.o7l9OA5rqbbFP7uLfG0wFnKYOYJ6Cri', 'Student', './uploads/66978e8305762.jpeg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `dean`
--
ALTER TABLE `dean`
  ADD PRIMARY KEY (`DeanID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD PRIMARY KEY (`LecturerID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`NewsID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`ReviewID`),
  ADD KEY `StudentID` (`StudentID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`StudentID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `CategoryID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dean`
--
ALTER TABLE `dean`
  MODIFY `DeanID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lecturer`
--
ALTER TABLE `lecturer`
  MODIFY `LecturerID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `ReviewID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `StudentID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dean`
--
ALTER TABLE `dean`
  ADD CONSTRAINT `dean_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `lecturer`
--
ALTER TABLE `lecturer`
  ADD CONSTRAINT `lecturer_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `category` (`CategoryID`),
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `student` (`StudentID`) ON DELETE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
