-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2016 at 06:13 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stdbv2`
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
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`activityId`, `ownerId`, `act_description`, `from_id`, `date`, `status`) VALUES
(20, '121-122', 'followed', '12-1987-804', '2016-02-08 05:58:35', 'A'),
(21, '123', 'followed', '121-122', '2016-02-08 05:59:08', 'A'),
(24, '121-122', 'followed', '12-1987-804', '2016-02-08 07:27:13', 'A'),
(25, '121-122', 'followed', '123', '2016-02-08 07:27:20', 'A'),
(26, '121-122', 'followed', '123', '2016-02-08 04:28:46', 'A'),
(27, '121-122', 'followed', '12-1987-804', '2016-02-09 12:56:58', 'A'),
(28, '12-1987-804', 'followed', '121-122', '2016-02-09 12:57:59', 'A'),
(42, '121-122', 'followed', '123', '2016-02-12 05:51:24', 'A'),
(43, '12-0841-453', 'followed', '121-122', '2016-02-13 11:25:49', 'A'),
(44, '12-0841-453', 'followed', '12-2340-471', '2016-02-13 17:19:00', 'A'),
(45, '12-0841-453', 'followed', '123', '2016-02-13 05:04:07', 'A'),
(46, '12-0841-453', 'followed', '121-122', '2016-02-13 05:04:08', 'A'),
(47, '121-122', 'followed', '12-0841-453', '2016-02-13 17:19:00', 'A'),
(48, '12-0841-453', 'commented', '38', '2016-02-13 18:45:00', 'A'),
(49, '121-122', 'commented', '75', '2016-02-15 08:10:00', 'A'),
(50, '121-122', 'commented', '75', '2016-02-15 08:41:00', 'A'),
(51, '121-122', 'followed', '12-0841-454', '2016-02-15 09:14:00', 'A'),
(52, '121-122', 'followed', '12-2340-471', '2016-02-15 09:14:00', 'A'),
(53, '12-0841-453', 'commented', '75', '2016-02-15 09:48:00', 'A'),
(54, '12-0841-453', 'commented', '75', '2016-02-15 09:52:00', 'A'),
(55, '12-0841-453', 'commented', '84', '2016-02-15 10:09:00', 'A'),
(56, '12-0841-453', 'tagged', '98', '2016-02-16 17:37:00', 'A'),
(57, '12-0841-453', 'tagged', '98', '2016-02-16 17:37:00', 'A'),
(58, '12-0841-453', 'tagged', '100', '2016-02-16 17:40:00', 'A'),
(59, '12-0841-453', 'tagged', '100', '2016-02-16 17:40:00', 'A'),
(60, '12-0841-453', 'tagged', '101', '2016-02-16 17:40:00', 'A'),
(61, '12-0841-453', 'tagged', '101', '2016-02-16 17:40:00', 'A'),
(62, '12-0841-453', 'tagged', '102', '2016-02-16 17:41:00', 'A'),
(63, '12-0841-453', 'tagged', '102', '2016-02-16 17:41:00', 'A'),
(64, '12-0841-453', 'tagged', '103', '2016-02-16 17:42:00', 'A'),
(65, '12-0841-453', 'tagged', '104', '2016-02-16 17:42:00', 'A'),
(66, '12-0841-453', 'tagged', '104', '2016-02-16 17:42:00', 'A');

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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`commentId`, `postId`, `userId`, `comment`, `isApproved`, `status`) VALUES
(39, 38, '12-0841-453', 'bcoz ', 0, 'A'),
(40, 75, '121-122', 'hvfhhdgbgdch', 0, 'A'),
(41, 75, '121-122', 'test cooment', 0, 'A'),
(42, 75, '12-0841-453', 'tesssssst', 0, 'A'),
(43, 75, '12-0841-453', 'fgxgg', 0, 'A'),
(44, 84, '12-0841-453', 'wew', 0, 'A');

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventId`, `createdBy`, `fileId`, `event_title`, `description`, `created_date`, `event_date`, `status`) VALUES
(1, '121-122', NULL, 'Foam Parteeee', 'PARTYYYYYY', NULL, '2016-02-09', NULL),
(2, '121-122', NULL, 'EARTH HOUR', 'pawng suga', NULL, '2016-02-09', NULL),
(3, '121-122', NULL, 'Way klase', 'asdasdasdasdasd', NULL, '2016-02-09', NULL),
(4, '121-122', NULL, 'Earth Wind and Fire', 'Concert sa CITU!!!!', NULL, '2016-02-07', NULL),
(5, '121-122', NULL, 'xcxcvbxcvxcv', 'xcvxcvxcvxcv', NULL, '2016-02-10', NULL),
(6, '121-122', NULL, 'Birthday ni Carlo', 'Way klase', NULL, '2016-03-07', NULL),
(7, '121-122', NULL, 'Graduation na!!!', 'Mayta makagraduate mi', NULL, '2016-03-19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE IF NOT EXISTS `file` (
  `fileId` int(11) NOT NULL,
  `fileUrl` varchar(1000) DEFAULT NULL,
  `ownerId` varchar(30) DEFAULT NULL,
  `type` varchar(45) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`fileId`, `fileUrl`, `ownerId`, `type`, `description`, `status`) VALUES
(2, 'F_cfcd208495d565ef66e7dff9f98764da.pdf', '12-0841-453', 'asd', 'VISA2016.pdf', 'A'),
(3, 'F_c4ca4238a0b923820dcc509a6f75849b.docx', '12-0841-453', 'notes', 'Azuchi.docx', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `mentions`
--

CREATE TABLE IF NOT EXISTS `mentions` (
  `tagId` int(11) NOT NULL,
  `userId` varchar(30) NOT NULL,
  `referenceTable` varchar(10) NOT NULL,
  `referenceId` int(11) NOT NULL,
  `to_userId` varchar(30) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mentions`
--

INSERT INTO `mentions` (`tagId`, `userId`, `referenceTable`, `referenceId`, `to_userId`, `status`) VALUES
(1, '12-0841-453', 'post', 86, '121-122', 'A'),
(2, '12-0841-453', 'post', 87, '121-122', 'A'),
(4, '12-0841-453', 'post', 88, '12-2340-471', 'A'),
(6, '12-0841-453', 'post', 89, '121-122', 'A'),
(8, '12-0841-453', 'post', 91, '121-122', 'A'),
(9, '12-0841-453', 'post', 93, '121-122', 'A'),
(10, '12-0841-453', 'post', 96, '121-122', 'A'),
(11, '12-0841-453', 'post', 96, '12-0841-453', 'A'),
(12, '12-0841-453', 'post', 97, '12-2340-471', 'A'),
(13, '12-0841-453', 'post', 98, '121-122', 'A'),
(15, '12-0841-453', 'post', 100, '121-122', 'A'),
(17, '12-0841-453', 'post', 101, '121-122', 'A'),
(19, '12-0841-453', 'post', 102, '121-122', 'A'),
(21, '12-0841-453', 'post', 103, '121-122', 'A'),
(22, '12-0841-453', 'post', 104, '121-122', 'A'),
(23, '12-0841-453', 'post', 104, '12-2340-471', 'A');

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
  `referenceId` int(11) DEFAULT NULL,
  `fromId` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`notificationId`, `to_userId`, `reference`, `description`, `status`, `referenceId`, `fromId`) VALUES
(3, '121-122', 'post', 'commented', 'N', 38, '12-0841-453'),
(4, '12-0841-453', 'post', 'commented', 'N', 75, '121-122'),
(5, '12-0841-453', 'post', 'commented', 'N', 75, '121-122'),
(6, '12-0841-453', 'post', 'commented', 'N', 75, '12-0841-453'),
(7, '12-0841-453', 'post', 'commented', 'N', 75, '12-0841-453'),
(8, '12-0841-453', 'post', 'commented', 'N', 84, '12-0841-453'),
(9, '121-122', 'post', 'tagged', 'N', 98, '12-0841-453'),
(11, '121-122', 'post', 'tagged', 'N', 100, '12-0841-453'),
(13, '121-122', 'post', 'tagged', 'N', 101, '12-0841-453'),
(15, '121-122', 'post', 'tagged', 'N', 102, '12-0841-453'),
(17, '121-122', 'post', 'tagged', 'N', 103, '12-0841-453'),
(18, '121-122', 'post', 'tagged', 'N', 104, '12-0841-453'),
(19, '12-2340-471', 'post', 'tagged', 'N', 104, '12-0841-453');

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
  `upvotes` text,
  `isPrivate` tinyint(1) DEFAULT '0',
  `status` varchar(45) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL COMMENT 'or subjects or topics'
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`postId`, `fileId`, `description`, `type`, `ownerId`, `upvotes`, `isPrivate`, `status`, `CreatedDate`, `tags`) VALUES
(35, NULL, 'soul searching', 'Post', '12-0841-453', '121-122,12-0841-453,', 0, NULL, '2016-02-13 17:19:00', 'franco'),
(36, NULL, 'Let''s move ', 'notes', '12-0841-453', '12-0841-453,', 0, NULL, '2016-02-13 18:08:00', 'wew'),
(37, NULL, 'Carlo''s ', 'asd', '121-122', '12-0841-453,', 0, NULL, '2016-02-13 18:23:00', 'adad'),
(38, NULL, 'Happy Valentine''s day!', 'Post', '121-122', NULL, 0, NULL, '2016-02-13 18:24:00', ''),
(46, NULL, 'One punch man', 'post', '12-0841-453', NULL, 0, NULL, '2016-02-14 13:28:00', 'anime'),
(47, NULL, 'adasd', 'adasdasd', '121-122', NULL, 0, NULL, '2016-02-14 13:57:00', 'adad'),
(49, NULL, 'aasdasdad', 'adasdasd', '121-122', NULL, 0, NULL, '2016-02-14 13:59:00', 'adadasdasd'),
(51, NULL, 'aaaa', 'aaa', '121-122', NULL, 0, NULL, '2016-02-14 14:01:00', 'aaaa'),
(52, NULL, 'bbb', 'bb', '121-122', NULL, 0, NULL, '2016-02-14 14:07:00', 'bb'),
(54, NULL, 'asdasd', 'asdasd', '121-122', NULL, 0, NULL, '2016-02-14 14:08:00', 'asd'),
(55, NULL, '2323', 'adsasd', '121-122', NULL, 0, NULL, '2016-02-14 14:10:00', 'aasdas'),
(56, NULL, 'sql', 'adsasd', '12-0841-453', NULL, 0, NULL, '2016-02-14 14:54:00', 'aasdas'),
(58, NULL, 'adadas', 'adsasd', '12-0841-453', NULL, 0, NULL, '2016-02-14 14:57:00', 'aasdas'),
(60, NULL, 'adadasda', 'adsasd', '12-0841-453', NULL, 0, NULL, '2016-02-14 14:58:00', 'aasdas'),
(61, NULL, 'adasdadadada', 'dadada', '12-0841-453', NULL, 0, NULL, '2016-02-14 15:00:00', 'adadada'),
(62, NULL, 'test', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 15:51:00', 'asd'),
(63, NULL, 'visa', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 15:54:00', 'asd'),
(64, NULL, 'visa2', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 15:54:00', 'asd'),
(66, NULL, 'visa3', 'asd', '12-0841-453', '12-0841-453,', 0, NULL, '2016-02-14 15:55:00', 'asd'),
(67, NULL, 'visa4', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 15:57:00', 'asd'),
(68, NULL, 'visa5', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 15:57:00', 'asd'),
(69, NULL, 'visa6', 'asd', '12-0841-453', '', 0, NULL, '2016-02-14 15:58:00', 'asd'),
(72, NULL, 'visa7', 'asd', '12-0841-453', '12-0841-453,', 0, NULL, '2016-02-14 15:59:00', 'asd'),
(73, NULL, 'visa8', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 16:00:00', 'asd'),
(74, 2, 'visa9', 'asd', '12-0841-453', NULL, 0, NULL, '2016-02-14 16:01:00', 'asd'),
(75, 3, 'Azuchi', 'notes', '12-0841-453', '12-0841-453,', 0, NULL, '2016-02-14 16:03:00', 'nihonggo'),
(76, NULL, 'ahah', 'Post', '12-0841-453', '', 0, NULL, '2016-02-15 10:00:00', ''),
(84, NULL, 'ahahaha', 'Post', '12-0841-453', '', 0, NULL, '2016-02-15 10:01:00', ''),
(85, NULL, 'testedcgrg', 'Post', '12-0841-453', '12-0841-453,', 0, NULL, '2016-02-15 16:02:00', ''),
(86, NULL, 'hey @carlo', 'asdasdsadasdada', '12-0841-453', NULL, 0, NULL, '2016-02-16 16:34:00', 'asdasdasd'),
(87, NULL, '@carlo, hey', 'Post', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:20:00', ''),
(88, NULL, '@meynard, wfcvvgbvb vvvf', 'Post', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:21:00', ''),
(89, NULL, '@carlo hey', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:22:00', 'asdasd'),
(90, NULL, '@carlo hedadasdasdasdasd', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:23:00', 'asdasd'),
(91, NULL, '@carlo hedadasdasdasdasd @meynard', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:23:00', 'asdasd'),
(93, NULL, '@carlo hey @meynard', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:24:00', 'asdasd'),
(94, NULL, '@carlo hey @meynard @testCarlo', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:25:00', 'asdasd'),
(96, NULL, '@carlo hey @testCarlo', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:25:00', 'asdasd'),
(97, NULL, 'hey @meynard', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:26:00', 'asdasd'),
(98, NULL, '@carlo, waasaaaaap', 'Post', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:37:00', ''),
(100, NULL, '@carlo asdasdadada', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:40:00', 'asdasd'),
(101, NULL, '@carlo adadadada', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:40:00', 'asdasd'),
(102, NULL, '@carlo abuag', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:41:00', 'asdasd'),
(103, NULL, '@carlo adadadads2wd', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:42:00', 'asdasd'),
(104, NULL, '@carlo adadadads2wd @meynard', 'asdasdasd', '12-0841-453', NULL, 0, NULL, '2016-02-16 17:42:00', 'asdasd');

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
-- Table structure for table `report`
--

CREATE TABLE IF NOT EXISTS `report` (
  `reportId` int(11) NOT NULL,
  `ownerId` varchar(30) NOT NULL,
  `referenceTable` varchar(10) NOT NULL,
  `referenceId` int(11) NOT NULL,
  `reportDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`reportId`, `ownerId`, `referenceTable`, `referenceId`, `reportDate`, `status`) VALUES
(1, '12-0841-453', 'post', 35, '2016-02-14 23:46:30', 'P');

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
('12-0841-453', 'testCarlo', '1234', '1996-03-07', NULL, 'test@test.com', 'P_cfcd208495d565ef66e7dff9f98764da.jpg', NULL, 'A', '121-122,', '12-2340-471,123,121-122,', NULL, 1, NULL, 'Carlo Test Ac', NULL, NULL, NULL),
('12-0841-454', 'testCarlo1', '1234', '1996-03-07', '2016-02-13', 'test@test.com', 'P_cfcd208495d565ef66e7dff9f98764da.jpg', NULL, 'A', '121-122,', NULL, NULL, 1, NULL, 'Carlo Test Ac2', NULL, NULL, NULL),
('12-1987-804', 'admin1', 'dagollie', NULL, NULL, 'a', 'default/pictures/ppic.jpg', NULL, 'A', '123,121-122,', '121-122,', NULL, 1, NULL, 'Chienih Bunao', NULL, NULL, 'A'),
('12-2340-471', 'meynard', '123', '0000-00-00', '2016-02-13', 'test', 'P_cfcd208495d565ef66e7dff9f98764da.jpg', NULL, 'A', '12-0841-453,121-122,', NULL, NULL, 1, NULL, '', NULL, NULL, NULL),
('121-122', 'carlo', 'jacalan', '2015-06-13', NULL, 'a', 'default/pictures/ppic.jpg', NULL, 'A', '123,12-1987-804,12-0841-453,', '12-1987-804,123,12-0841-453,12-0841-454,12-2340-471,', NULL, 1, NULL, 'Carlo Jacalan', NULL, NULL, 'T'),
('123', 'ddr', 'qwr', '2016-01-10', '2016-01-10', 'asd', 'default/pictures/ppic.jpg', NULL, 'A', '121-122,12-0841-453,', '12-1987-804,121-122,', NULL, 1, NULL, 'ddr', NULL, NULL, NULL);

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
  ADD KEY `fk_event_fileId_idx` (`fileId`),
  ADD KEY `fileId` (`fileId`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileId`),
  ADD KEY `fk_file_ownerId_idx` (`ownerId`);

--
-- Indexes for table `mentions`
--
ALTER TABLE `mentions`
  ADD PRIMARY KEY (`tagId`);

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
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD UNIQUE KEY `reportId` (`reportId`);

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
  MODIFY `activityId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=45;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `fileId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `mentions`
--
ALTER TABLE `mentions`
  MODIFY `tagId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=105;
--
-- AUTO_INCREMENT for table `program`
--
ALTER TABLE `program`
  MODIFY `programId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `FK_event_createdBy` FOREIGN KEY (`createdBy`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `fk_file_ownerId` FOREIGN KEY (`ownerId`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `message`
--
ALTER TABLE `message`
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
  ADD CONSTRAINT `fk_post_fileId` FOREIGN KEY (`fileId`) REFERENCES `file` (`fileId`),
  ADD CONSTRAINT `fk_post_ownerId` FOREIGN KEY (`ownerId`) REFERENCES `user` (`schoolId`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
