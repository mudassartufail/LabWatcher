-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 11, 2014 at 01:10 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `labwatcher_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_computers`
--

CREATE TABLE IF NOT EXISTS `tbl_computers` (
  `systemName` varchar(50) NOT NULL,
  `processorInfo` text NOT NULL,
  `processorUsage` text NOT NULL,
  `osInfo` text NOT NULL,
  `hardDiskInfo` int(11) NOT NULL,
  `ramInfo` text NOT NULL,
  `hardDiskUsage` text NOT NULL,
  `ramUsage` text NOT NULL,
  `keyboardStatus` text NOT NULL,
  `keyboardInfo` text NOT NULL,
  `mouseStatus` text NOT NULL,
  `mouseInfo` text NOT NULL,
  `monitorStatus` text NOT NULL,
  `monitorInfo` text NOT NULL,
  `hardDiskStatus` text NOT NULL,
  `processorStatus` text NOT NULL,
  `ramStatus` text NOT NULL,
  `Status` enum('0','1') NOT NULL,
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`systemName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_computers`
--

INSERT INTO `tbl_computers` (`systemName`, `processorInfo`, `processorUsage`, `osInfo`, `hardDiskInfo`, `ramInfo`, `hardDiskUsage`, `ramUsage`, `keyboardStatus`, `keyboardInfo`, `mouseStatus`, `mouseInfo`, `monitorStatus`, `monitorInfo`, `hardDiskStatus`, `processorStatus`, `ramStatus`, `Status`, `dateTime`) VALUES
('NOORALAM-PC', 'Intel(R) Core(TM)2 Duo CPU     T5670  @ 1.80GHz', '60', 'Microsoft Windows 7 Professional ', 450, '2', 'C: 125724258304 57666314240|D: 125829115904 105023504384|E: 248447496192 186552692736|', '800', 'OK', 'Keyboard Id | Keyboard Name | Keyboard Description', 'OK', 'Mouse Id | Mouse Name | Mouse Description', 'OK', 'Monitor Id | Monitor Name | Monitor Description', 'OK', 'OK', 'Device is working properly.', '0', '2014-03-11 16:53:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_errors`
--

CREATE TABLE IF NOT EXISTS `tbl_errors` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `pcName` varchar(50) NOT NULL,
  `errorMessage` text NOT NULL,
  `Type` enum('0','1') NOT NULL,
  `Status` enum('0','1') NOT NULL DEFAULT '0',
  `dateTime` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `pcName` (`pcName`),
  KEY `pcName_2` (`pcName`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `email` text NOT NULL,
  `password` int(11) NOT NULL,
  `type` enum('1','2') NOT NULL DEFAULT '1',
  `dateCreated` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `password`, `type`, `dateCreated`) VALUES
(1, 'Mudassar', 'Malik', 'mudassartufail@live.com', 123456, '1', '0000-00-00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_errors`
--
ALTER TABLE `tbl_errors`
  ADD CONSTRAINT `tbl_errors_ibfk_1` FOREIGN KEY (`pcName`) REFERENCES `tbl_computers` (`systemName`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
