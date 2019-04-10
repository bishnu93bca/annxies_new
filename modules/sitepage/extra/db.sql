-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 24, 2012 at 03:58 PM
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
-- Table structure for table `tbl_menu_category`
--

CREATE TABLE IF NOT EXISTS `tbl_menu_category` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL DEFAULT '0',
  `parentId` int(11) NOT NULL DEFAULT '0',
  `moduleId` int(11) NOT NULL DEFAULT '0',
  `categoryName` varchar(100) NOT NULL DEFAULT '',
  `categoryType` varchar(100) NOT NULL DEFAULT '',
  `isTopMenu` enum('Y','N') NOT NULL DEFAULT 'Y',
  `isFooterMenu` enum('Y','N') NOT NULL DEFAULT 'N',
  `isContent` enum('Y','N') NOT NULL DEFAULT 'Y',
  `isGallery` enum('Y','N') NOT NULL DEFAULT 'Y',
  `isVideo` enum('Y','N') NOT NULL DEFAULT 'N',
  `relatedGallerycategoryId` int(11) NOT NULL DEFAULT '0',
  `categoryUrl` text NOT NULL,
  `categoryImage` varchar(100) NOT NULL DEFAULT '',
  `permalink` varchar(250) DEFAULT NULL,
  `sideBar` varchar(200) NOT NULL DEFAULT '',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `update` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `swapNo` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`categoryId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
