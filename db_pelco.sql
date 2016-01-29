-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2016 at 11:28 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_pelco`
--

-- --------------------------------------------------------

--
-- Table structure for table `bill_account_info`
--

CREATE TABLE IF NOT EXISTS `bill_account_info` (
  `bill_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) NOT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `narration` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'user who created the transaction',
  `total_back_bill_amount` decimal(15,2) DEFAULT '0.00',
  `down_payment` decimal(15,2) DEFAULT '0.00',
  `no_of_days` int(11) DEFAULT NULL,
  `payment_start_date` date DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `payment_schedule_remarks` varchar(100) DEFAULT NULL,
  `amount_kwh` decimal(15,2) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT NULL,
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`bill_account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bill_account_info`
--

INSERT INTO `bill_account_info` (`bill_account_id`, `reference_no`, `account_no`, `consumer_id`, `narration`, `user_id`, `total_back_bill_amount`, `down_payment`, `no_of_days`, `payment_start_date`, `duration`, `payment_schedule_remarks`, `amount_kwh`, `date_created`, `date_modified`, `is_active`, `is_deleted`) VALUES
(1, '123', '123', 1, 'sample', 1, 1200.00, 14.00, 1, '2016-01-06', 1, '0hghgh', 9.00, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '1', '0');

-- --------------------------------------------------------

--
-- Table structure for table `bill_payment_schedule`
--

CREATE TABLE IF NOT EXISTS `bill_payment_schedule` (
  `bill_item_account_id` varchar(20) DEFAULT NULL COMMENT 'CONCAT bill account id and position id',
  `bill_account_id` int(11) DEFAULT NULL,
  `item_id` varchar(5) DEFAULT NULL,
  `sched_payment_date` date DEFAULT NULL,
  `bill_description` varchar(155) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT '0.00',
  `is_paid` bit(1) DEFAULT b'0',
  `remarks` varchar(255) DEFAULT NULL,
  UNIQUE KEY `bill_item_account_id` (`bill_item_account_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bill_payment_schedule`
--

INSERT INTO `bill_payment_schedule` (`bill_item_account_id`, `bill_account_id`, `item_id`, `sched_payment_date`, `bill_description`, `due_amount`, `is_paid`, `remarks`) VALUES
('11', 1, '1', '2016-01-27', 'sample', 250.00, '0', 'sample');

-- --------------------------------------------------------

--
-- Table structure for table `bill_unit_list`
--

CREATE TABLE IF NOT EXISTS `bill_unit_list` (
  `bill_unit_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_account_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `unit_qty` int(11) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  PRIMARY KEY (`bill_unit_list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `bill_unit_list`
--

INSERT INTO `bill_unit_list` (`bill_unit_list_id`, `bill_account_id`, `unit_id`, `unit_qty`, `hours`) VALUES
(1, 1, 2, 21, 8),
(2, 1, 1, 5, 8);

-- --------------------------------------------------------

--
-- Table structure for table `customer_info`
--

CREATE TABLE IF NOT EXISTS `customer_info` (
  `consumer_id` int(11) NOT NULL AUTO_INCREMENT,
  `consumer_name` varchar(100) DEFAULT NULL,
  `house_no` varchar(20) DEFAULT NULL,
  `street_no` varchar(30) DEFAULT NULL,
  `barangay` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `zip_code` varchar(10) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `contact_no` varchar(55) DEFAULT NULL,
  `email` varchar(55) DEFAULT NULL,
  `second_address` varchar(155) DEFAULT NULL,
  `meter_no` varchar(55) DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`consumer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `customer_info`
--

INSERT INTO `customer_info` (`consumer_id`, `consumer_name`, `house_no`, `street_no`, `barangay`, `municipality`, `zip_code`, `province`, `contact_no`, `email`, `second_address`, `meter_no`, `is_deleted`, `date_created`, `date_modified`) VALUES
(1, 'Paul Christian', '1000', '10', 'asd', '2000', '2000', '10', '1234', 'sample@gmail.com', 'sample@gmail.com', '123', '0', '0000-00-00 00:00:00', '2016-01-27 18:02:13');

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE IF NOT EXISTS `payment_info` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `receipt_no` varchar(30) DEFAULT NULL,
  `bill_account_id` int(11) DEFAULT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `payment_date` date DEFAULT NULL,
  `payment_amount` decimal(15,2) DEFAULT '0.00',
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment_info`
--

INSERT INTO `payment_info` (`payment_id`, `receipt_no`, `bill_account_id`, `consumer_id`, `payment_date`, `payment_amount`, `date_created`, `is_active`) VALUES
(1, '100001', 1, 1, '2015-11-20', 0.00, '0000-00-00 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `payment_item_list`
--

CREATE TABLE IF NOT EXISTS `payment_item_list` (
  `payment_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) DEFAULT NULL,
  `item_id` varchar(5) DEFAULT NULL,
  `payment_amount` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`payment_list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment_item_list`
--

INSERT INTO `payment_item_list` (`payment_list_id`, `payment_id`, `item_id`, `payment_amount`) VALUES
(1, 1, '0', 2000.00);

-- --------------------------------------------------------

--
-- Table structure for table `unit_info`
--

CREATE TABLE IF NOT EXISTS `unit_info` (
  `unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_description` varchar(100) DEFAULT NULL,
  `brand_name` varchar(100) DEFAULT NULL,
  `model_name` varchar(75) DEFAULT NULL,
  `estimated_kwh` int(11) DEFAULT NULL,
  `amount_consumption` decimal(11,2) DEFAULT '0.00',
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT NULL,
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `unit_info`
--

INSERT INTO `unit_info` (`unit_id`, `unit_description`, `brand_name`, `model_name`, `estimated_kwh`, `amount_consumption`, `date_created`, `date_modified`, `is_deleted`) VALUES
(1, 'Refrigerator', 'LG', '456-901211', 20, 50.00, '0000-00-00 00:00:00', NULL, '0'),
(2, 'Television', 'Samsung', '1223345555', 10, 2.00, '0000-00-00 00:00:00', NULL, '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
