-- phpMyAdmin SQL Dump
-- version 3.4.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2012 at 09:39 AM
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
-- Table structure for table `tbl_meta`
--

CREATE TABLE IF NOT EXISTS `tbl_meta` (
  `metaId` int(11) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL DEFAULT '0',
  `metaUrl` text NOT NULL,
  `metaTag` text NOT NULL,
  `metaDescription` text NOT NULL,
  `metaType` enum('D','O') NOT NULL DEFAULT 'O',
  `status` enum('N','Y') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`metaId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_title`
--

CREATE TABLE IF NOT EXISTS `tbl_page_title` (
  `pageTitleId` int(11) NOT NULL AUTO_INCREMENT,
  `siteId` int(11) NOT NULL DEFAULT '0',
  `pageTitleUrl` text NOT NULL,
  `pageTitleText` text NOT NULL,
  `pageTitleType` enum('D','O') NOT NULL DEFAULT 'O',
  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
  PRIMARY KEY (`pageTitleId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
