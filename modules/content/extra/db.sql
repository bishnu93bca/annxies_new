-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 23, 2012 at 04:44 PM
-- Server version: 5.5.17
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `purple`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content`
--

CREATE TABLE IF NOT EXISTS `tbl_content` (
  `contentID` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL DEFAULT '0',
  `siteId` int(11) NOT NULL DEFAULT '0',
  `contentType` varchar(100) DEFAULT 'general',
  `menucategoryId` int(11) NOT NULL DEFAULT '0',
  `contentHeading` varchar(100) NOT NULL DEFAULT '',
  `displayHeading` enum('Y','N') NOT NULL DEFAULT 'Y',
  `contentDescription` longtext,
  `contentShortDescription` text NOT NULL,
  `permalink` varchar(250) DEFAULT NULL,
  `contentSwapNo` int(11) DEFAULT '0',
  `contentStatus` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`contentID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_content_premade`
--

CREATE TABLE IF NOT EXISTS `tbl_content_premade` (
  `premadeId` int(11) NOT NULL AUTO_INCREMENT,
  `menucategoryId` int(11) NOT NULL DEFAULT '0',
  `premadeHeading` text NOT NULL,
  `premadeDescription` text NOT NULL,
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`premadeId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_gallery`
--

CREATE TABLE IF NOT EXISTS `tbl_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL DEFAULT '0',
  `menucategoryId` int(11) NOT NULL DEFAULT '0',
  `bannername` varchar(100) NOT NULL DEFAULT '',
  `bannerdescription` text NOT NULL,
  `imagepath` varchar(250) DEFAULT NULL,
  `thumbpath` varchar(200) NOT NULL DEFAULT '',
  `galleryCategoryId` int(11) NOT NULL DEFAULT '0',
  `redirecturl` varchar(250) DEFAULT NULL,
  `galleryType` enum('P','V','D') NOT NULL DEFAULT 'P',
  `swapno` int(11) NOT NULL DEFAULT '0',
  `status` enum('Y','N') DEFAULT 'Y',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=162 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_temp_gallery`
--

CREATE TABLE IF NOT EXISTS `tbl_temp_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sessionId` varchar(200) NOT NULL DEFAULT '',
  `imageName` varchar(200) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=806 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
