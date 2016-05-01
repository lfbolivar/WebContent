-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Nov 07, 2015 at 06:11 PM
-- Server version: 5.6.27
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `WebContent`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
  `iAdId` int(11) NOT NULL AUTO_INCREMENT,
  `vchAdCaption` varchar(50) DEFAULT NULL,
  `vchAdHeadLine` varchar(100) DEFAULT NULL,
  `vchAdDesc` varchar(500) DEFAULT NULL,
  `vchAdURL` varchar(100) DEFAULT NULL,
  `dtAdDate` datetime DEFAULT NULL,
  `dtAdExpireDate` datetime DEFAULT NULL,
  `iAdPeriod` int(11) DEFAULT NULL,
  `iAdHits` int(11) DEFAULT NULL,
  `dAdVotes` double(16,4) DEFAULT NULL,
  `vchUserEmail` varchar(50) DEFAULT NULL,
  `vchUserId` varchar(50) DEFAULT NULL,
  `vchUserPassword` varchar(32) DEFAULT NULL,
  `vchCust_1` varchar(50) DEFAULT NULL,
  `vchCust_2` varchar(50) DEFAULT NULL,
  `vchCust_3` varchar(50) DEFAULT NULL,
  `vchCust_4` varchar(50) DEFAULT NULL,
  `vchCust_5` varchar(50) DEFAULT NULL,
  `vchCust_6` varchar(50) DEFAULT NULL,
  `vchCust_7` varchar(50) DEFAULT NULL,
  `vchCust_8` varchar(50) DEFAULT NULL,
  `tsAdModifyDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `vchAdUserName` varchar(50) DEFAULT NULL,
  `tiAdValid` tinyint(4) DEFAULT '0',
  `iAdCatId` smallint(6) NOT NULL,
  PRIMARY KEY (`iAdId`),
  KEY `UserId` (`vchUserEmail`,`vchUserPassword`),
  KEY `Category` (`iAdCatId`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='WebContent' AUTO_INCREMENT=172 ;

--
-- Dumping data for table `ad`
--


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CatId` smallint(6) NOT NULL AUTO_INCREMENT,
  `CatDesc` varchar(50) NOT NULL,
  `CatImage` varchar(50) NOT NULL,
  PRIMARY KEY (`CatId`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='Contains Classifieds Categories' AUTO_INCREMENT=18 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CatId`, `CatDesc`, `CatImage`) VALUES
(1, 'Boats & Accessories', 'fishingboat.jpg'),
(2, 'Cottage/House Rentals', 'cottages.jpg'),
(3, 'Hotels', 'hotels.jpg'),
(4, 'Real Estate', 'realestate.jpg'),
(5, 'Restaurants', 'restaurants.jpg'),
(6, 'Shopping', 'shopping.jpg'),
(7, 'Slips & Moorings', 'moorings.jpg'),
(8, 'Travel', 'travel.jpg'),
(9, 'Water Sports', 'watersports.jpg'),
(10, 'Personal', 'personal.jpg'),
(11, 'Night Clubs', 'nightclub.jpg'),
(12, 'Jobs', 'jobs.jpg'),
(13, 'Technology', 'tech.jpg'),
(14, 'Religion', 'religion.jpg'),
(15, 'Automobiles', 'auto.jpg'),
(16, 'Computers', 'computer.jpg'),
(17, 'Spa', 'health.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE IF NOT EXISTS `image` (
  `iFileID` int(11) NOT NULL AUTO_INCREMENT,
  `iFileAdId` int(11) NOT NULL,
  `vchFileName` varchar(30) NOT NULL,
  `vchFileType` varchar(30) NOT NULL,
  `iFileSize` int(11) NOT NULL,
  `bFileContent` blob NOT NULL,
  PRIMARY KEY (`iFileID`),
  KEY `AdId` (`iFileAdId`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='Contains AD images' AUTO_INCREMENT=81 ;

--
-- Dumping data for table `image`
--


-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `vchEmail` varchar(50) NOT NULL,
  `vchPassword` varchar(32) NOT NULL,
  `dtRegistered` char(25) NOT NULL,
  PRIMARY KEY (`vchEmail`)
) ENGINE=MyISAM DEFAULT CHARSET=ascii COMMENT='Contains email and password';

--
-- Dumping data for table `member`
--


-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `iUserId` int(11) NOT NULL AUTO_INCREMENT,
  `vchEmail` varchar(50) NOT NULL,
  `vchFirstName` varchar(100) DEFAULT NULL,
  `vchLastName` varchar(100) DEFAULT NULL,
  `vchAddress1` varchar(100) DEFAULT NULL,
  `vchAddress2` varchar(100) DEFAULT NULL,
  `vchAddress3` varchar(100) DEFAULT NULL,
  `vchCity` varchar(100) DEFAULT NULL,
  `vchState` varchar(100) DEFAULT NULL,
  `vchPhone` varchar(30) DEFAULT NULL,
  `vchPassword` varchar(32) DEFAULT NULL,
  `tsRegModified` char(25) DEFAULT NULL,
  `iNum_ads` int(11) DEFAULT '0',
  `vchCountry` varchar(50) DEFAULT NULL,
  `tiHide_email` tinyint(4) DEFAULT NULL,
  `vchZip` varchar(20) DEFAULT NULL,
  `vchUsr_1` varchar(150) DEFAULT NULL,
  `vchUsr_2` varchar(150) DEFAULT NULL,
  `vchUsr_3` varchar(150) DEFAULT NULL,
  `vchUsr_4` varchar(150) DEFAULT NULL,
  `vchUsr_5` varchar(150) DEFAULT NULL,
  `vchUsr_6` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`iUserId`),
  KEY `Email` (`vchEmail`)
) ENGINE=MyISAM  DEFAULT CHARSET=ascii COMMENT='Details of a member key' AUTO_INCREMENT=15 ;

--
-- Dumping data for table `user`
--

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
