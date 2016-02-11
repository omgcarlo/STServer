-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2016 at 03:25 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `socialtutor`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `activityId` int(11) NOT NULL,
  `ownerId` varchar(30) NOT NULL,
  `act_description` varchar(200) DEFAULT NULL,
  `from_id` varchar(45) DEFAULT NULL COMMENT 'post id or user id',
  `date` datetime NOT NULL,
  `status` varchar(45) DEFAULT 'A'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityId`, `ownerId`, `act_description`, `from_id`, `date`, `status`) VALUES
(19, '121-122', 'commented', '28', '2016-02-08 05:28:42', 'A'),
(20, '121-122', 'followed', '12-1987-804', '2016-02-08 05:58:35', 'A'),
(21, '123', 'followed', '121-122', '2016-02-08 05:59:08', 'A'),
(22, '121-122', 'commented', '29', '2016-02-08 06:31:13', 'A'),
(23, '121-122', 'commented', '29', '2016-02-08 06:32:40', 'A'),
(24, '121-122', 'followed', '12-1987-804', '2016-02-08 07:27:13', 'A'),
(25, '121-122', 'followed', '123', '2016-02-08 07:27:20', 'A'),
(26, '121-122', 'followed', '123', '2016-02-08 04:28:46', 'A'),
(27, '121-122', 'followed', '12-1987-804', '2016-02-09 12:56:58', 'A'),
(28, '12-1987-804', 'followed', '121-122', '2016-02-09 12:57:59', 'A'),
(29, '123', 'commented', '28', '2016-02-09 01:00:12', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `college`
--

CREATE TABLE IF NOT EXISTS `college` (
  `CollegeCode` varchar(10) NOT NULL,
  `CollegeName` varchar(150) DEFAULT NULL,
  `dean` varchar(255) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `status` char(1) DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `college`
--

INSERT INTO `college` (`CollegeCode`, `CollegeName`, `dean`, `created_date`, `status`) VALUES
('CAS', 'College of Arts and Sciences', NULL, NULL, 'A'),
('CCS', 'College of Computer Studies', 'Cherry Lyn', '2016-06-01', 'A'),
('CEA', 'College of Engineering and Architecture', NULL, '2016-06-01', 'A'),
('COC', 'College of Commerce', NULL, '2016-06-01', 'A'),
('COE', 'College of Education', NULL, NULL, 'A'),
('CON', 'College of Nursing', NULL, NULL, 'A'),
('CAS', 'College of Arts and Sciences', NULL, NULL, 'A'),
('CCS', 'College of Computer Studies', 'Cherry Lyn', '2016-06-01', 'A'),
('CEA', 'College of Engineering and Architecture', NULL, '2016-06-01', 'A'),
('COC', 'College of Commerce', NULL, '2016-06-01', 'A'),
('COE', 'College of Education', NULL, NULL, 'A'),
('CON', 'College of Nursing', NULL, NULL, 'A'),
('CAS', 'College of Arts and Sciences', NULL, NULL, 'A'),
('CCS', 'College of Computer Studies', 'Cherry Lyn', '2016-06-01', 'A'),
('CEA', 'College of Engineering and Architecture', NULL, '2016-06-01', 'A'),
('COC', 'College of Commerce', NULL, '2016-06-01', 'A'),
('COE', 'College of Education', NULL, NULL, 'A'),
('CON', 'College of Nursing', NULL, NULL, 'A'),
('CAS', 'College of Arts and Sciences', NULL, NULL, 'A'),
('CCS', 'College of Computer Studies', 'Cherry Lyn', '2016-06-01', 'A'),
('CEA', 'College of Engineering and Architecture', NULL, '2016-06-01', 'A'),
('COC', 'College of Commerce', NULL, '2016-06-01', 'A'),
('COE', 'College of Education', NULL, NULL, 'A'),
('CON', 'College of Nursing', NULL, NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `commentId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `userId` varchar(30) NOT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `status` varchar(45) DEFAULT 'A'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentId`, `postId`, `userId`, `comment`, `isApproved`, `status`) VALUES
(23, 28, '121-122', 'dd3', 1, 'A'),
(24, 29, '121-122', 'tesy1', 0, 'A'),
(25, 29, '121-122', 'test2', 0, 'A'),
(26, 28, '123', 'buang ka', 0, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseId` int(11) NOT NULL,
  `programIds` varchar(100) DEFAULT NULL,
  `courseNo` varchar(45) DEFAULT NULL,
  `descriptive_title` varchar(100) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT 'A'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseId`, `programIds`, `courseNo`, `descriptive_title`, `created_date`, `status`) VALUES
(1, '1', 'CCS222', 'Data Structure', NULL, 'A'),
(2, '1', 'CCS110', 'Fundamentals', NULL, 'A'),
(1, '1', 'CCS222', 'Data Structure', NULL, 'A'),
(2, '1', 'CCS110', 'Fundamentals', NULL, 'A'),
(1, '1', 'CCS222', 'Data Structure', NULL, 'A'),
(2, '1', 'CCS110', 'Fundamentals', NULL, 'A'),
(1, '1', 'CCS222', 'Data Structure', NULL, 'A'),
(2, '1', 'CCS110', 'Fundamentals', NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `eventId` int(11) NOT NULL,
  `createdBy` varchar(30) DEFAULT NULL,
  `fileId` int(11) DEFAULT NULL,
  `event_title` text,
  `description` varchar(250) DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventId`, `createdBy`, `fileId`, `event_title`, `description`, `created_date`, `event_date`, `status`) VALUES
(1, '121-122', NULL, 'Foam Parteeee', 'PARTYYYYYY', NULL, '2016-02-09', NULL),
(2, '121-122', NULL, 'EARTH HOUR', 'pawng suga', NULL, '2016-02-09', NULL),
(3, '121-122', NULL, 'Way klase', 'asdasdasdasdasd', NULL, '2016-02-09', NULL),
(4, '121-122', NULL, 'Earth Wind and Fire', 'Concert sa CITU!!!!', NULL, '2016-02-07', NULL),
(5, '121-122', NULL, 'xcxcvbxcvxcv', 'xcvxcvxcvxcv', NULL, '2016-02-10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `fileId` int(11) NOT NULL,
  `fileUrl` varchar(1000) DEFAULT NULL,
  `ownerId` varchar(30) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `messageId` int(11) NOT NULL,
  `to_id` varchar(30) DEFAULT NULL,
  `from_id` varchar(30) DEFAULT NULL,
  `content` varchar(160) DEFAULT NULL,
  `sent_date_time` datetime DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `fileId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notificationId` int(11) NOT NULL,
  `to_userId` varchar(30) DEFAULT NULL COMMENT 'comment or post id',
  `reference` varchar(45) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL,
  `referenceId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `postId` int(11) NOT NULL,
  `fileId` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `type` varchar(45) DEFAULT 'notes' COMMENT 'notes,problem,event\n',
  `ownerId` varchar(30) NOT NULL,
  `isPrivate` tinyint(1) DEFAULT '0',
  `status` varchar(45) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL COMMENT 'or subjects or topics'
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `fileId`, `description`, `type`, `ownerId`, `isPrivate`, `status`, `CreatedDate`, `tags`) VALUES
(26, NULL, '1st', 'Post', '121-122', 0, NULL, '2016-02-08 01:08:54', ''),
(27, NULL, '2nd', 'Post', '121-122', 0, NULL, '2016-02-08 01:09:41', ''),
(28, NULL, '3rd', 'Post', '121-122', 0, NULL, '2016-02-08 01:22:13', 'hhxjg'),
(29, NULL, 'adada', 'aadada', '123', 0, NULL, '2016-02-08 03:31:02', 'adadada');

-- --------------------------------------------------------

--
-- Table structure for table `program`
--

CREATE TABLE IF NOT EXISTS `program` (
  `programId` int(11) NOT NULL,
  `departmentId` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `CollegeCode` varchar(15) NOT NULL,
  `created_date` date DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `program`
--

INSERT INTO `program` (`programId`, `departmentId`, `name`, `CollegeCode`, `created_date`, `status`) VALUES
(1, 1, 'BS - Information Technology', 'CCS', '2016-06-01', 'A'),
(2, 1, 'BS - Computer Science', 'CCS', '2016-06-01', 'A'),
(3, 3, 'BS - Civil Engineering', 'CCS', NULL, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `schoolId` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `registered_date` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `pic_url` varchar(255) NOT NULL,
  `bio` varchar(140) DEFAULT NULL,
  `status` char(1) DEFAULT 'A',
  `followers` varchar(1000) DEFAULT NULL,
  `following_ids` varchar(1000) DEFAULT NULL,
  `updated_date` date DEFAULT NULL,
  `programId` int(11) DEFAULT NULL,
  `role` varchar(45) DEFAULT NULL,
  `full_name` varchar(45) NOT NULL,
  `request_for` varchar(45) DEFAULT NULL,
  `sequence` int(11) DEFAULT NULL,
  `UserType` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`schoolId`, `username`, `password`, `birthdate`, `registered_date`, `email`, `pic_url`, `bio`, `status`, `followers`, `following_ids`, `updated_date`, `programId`, `role`, `full_name`, `request_for`, `sequence`, `UserType`) VALUES
('12-1987-804', 'admin1', 'dagollie', NULL, NULL, 'a', '', NULL, 'A', '123,121-122,', '121-122,', NULL, 1, NULL, 'Chienih Bunao', NULL, NULL, 'A'),
('121-122', 'carlo', 'jacalan', '2015-06-13', NULL, 'a', '', NULL, 'A', '123,12-1987-804,', '123,12-1987-804,', NULL, 1, NULL, 'Carlo Jacalan', NULL, NULL, 'T'),
('123', 'ddr', 'qwr', '2016-01-10', '2016-01-10', 'asd', 'default/pictures/ppic.jpg', NULL, 'A', '121-122,', '12-1987-804,121-122,', NULL, 1, NULL, 'ddr', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`activityId`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentId`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventId`),
  ADD KEY `FK_event_createdBy_idx` (`createdBy`),
  ADD KEY `fk_event_fileId_idx` (`fileId`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileId`),
  ADD KEY `fk_file_ownerId_idx` (`ownerId`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`messageId`),
  ADD KEY `fk_tablename_from_id_idx` (`from_id`),
  ADD KEY `fk_message_fileId_idx` (`fileId`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`notificationId`),
  ADD KEY `fk_notification_referenceId_idx` (`referenceId`),
  ADD KEY `fk_notification_to_userId` (`to_userId`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`postId`),
  ADD UNIQUE KEY `description_UNIQUE` (`description`),
  ADD KEY `fk_tablename_ownerId_idx` (`ownerId`),
  ADD KEY `fk_tablename_fileId_idx` (`fileId`);

--
-- Indexes for table `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`programId`),
  ADD KEY `fk_tablename_departmentId_idx` (`departmentId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`schoolId`),
  ADD KEY `FK_user_programId_idx` (`programId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `activityId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `programId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_event_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_event_fileId` FOREIGN KEY (`fileId`) REFERENCES `file` (`fileId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `fk_file_ownerId` FOREIGN KEY (`ownerId`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `fk_message_fileId` FOREIGN KEY (`fileId`) REFERENCES `file` (`fileId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_tablename_from_id` FOREIGN KEY (`from_id`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `fk_notification_referenceId` FOREIGN KEY (`referenceId`) REFERENCES `post` (`postId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notification_to_userId` FOREIGN KEY (`to_userId`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_fileId` FOREIGN KEY (`fileId`) REFERENCES `file` (`fileId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_post_ownerId` FOREIGN KEY (`ownerId`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
