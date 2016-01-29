# SQL Manager 2010 Lite for MySQL 4.6.0.5
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : db_pelco5


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES latin1 */;

SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `db_pelco5`
    CHARACTER SET 'latin1'
    COLLATE 'latin1_swedish_ci';

USE `db_pelco5`;

#
# Structure for the `bill_account_info` table : 
#

CREATE TABLE `bill_account_info` (
  `bill_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `reference_no` varchar(50) DEFAULT NULL,
  `account_no` varchar(50) NOT NULL,
  `consumer_id` int(11) DEFAULT '0',
  `narration` varchar(100) DEFAULT '',
  `user_id` int(11) DEFAULT '0' COMMENT 'user who created the transaction',
  `total_back_bill_amount` decimal(15,2) DEFAULT '0.00',
  `down_payment` decimal(15,2) DEFAULT '0.00',
  `no_of_days` int(11) DEFAULT '0',
  `payment_start_date` date DEFAULT '0000-00-00',
  `duration` int(11) DEFAULT '0',
  `payment_schedule_remarks` varchar(100) NOT NULL,
  `amount_kwh` decimal(15,2) DEFAULT '0.00',
  `account_total_kwh` decimal(11,0) DEFAULT '0',
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  `is_deleted` bit(1) DEFAULT b'0',
  PRIMARY KEY (`bill_account_id`),
  UNIQUE KEY `account_no` (`account_no`),
  UNIQUE KEY `reference_no` (`reference_no`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

#
# Structure for the `bill_payment_schedule` table : 
#

CREATE TABLE `bill_payment_schedule` (
  `schedule_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bill_item_account_id` varchar(20) DEFAULT NULL COMMENT 'CONCAT bill account id and position id',
  `bill_account_id` int(11) DEFAULT NULL,
  `item_id` varchar(5) DEFAULT NULL,
  `sched_payment_date` date DEFAULT NULL,
  `bill_description` varchar(155) DEFAULT NULL,
  `due_amount` decimal(11,2) DEFAULT '0.00',
  `is_paid` bit(1) DEFAULT b'0',
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  UNIQUE KEY `bill_item_account_id` (`bill_item_account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=499 DEFAULT CHARSET=latin1;

#
# Structure for the `bill_unit_list` table : 
#

CREATE TABLE `bill_unit_list` (
  `bill_unit_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_account_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `unit_qty` int(11) DEFAULT NULL,
  `hours` int(11) DEFAULT NULL,
  `line_kwh` int(11) DEFAULT '0',
  `line_total` int(11) DEFAULT '0',
  PRIMARY KEY (`bill_unit_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=latin1;

#
# Structure for the `customer_info` table : 
#

CREATE TABLE `customer_info` (
  `consumer_id` int(11) NOT NULL AUTO_INCREMENT,
  `consumer_name` varchar(100) DEFAULT '',
  `house_no` varchar(20) DEFAULT '',
  `street_no` varchar(30) DEFAULT '',
  `barangay` varchar(100) DEFAULT '',
  `municipality` varchar(100) DEFAULT '',
  `zip_code` varchar(10) DEFAULT '',
  `province` varchar(100) DEFAULT '',
  `contact_no` varchar(55) DEFAULT '',
  `email` varchar(55) DEFAULT '',
  `second_address` varchar(155) DEFAULT '',
  `meter_no` varchar(55) DEFAULT '',
  `is_deleted` bit(1) DEFAULT b'0',
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`consumer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;

#
# Structure for the `payment_info` table : 
#

CREATE TABLE `payment_info` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_account_id` int(11) DEFAULT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `payment_amount` decimal(15,2) DEFAULT '0.00',
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Structure for the `payment_item_list` table : 
#

CREATE TABLE `payment_item_list` (
  `payment_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) DEFAULT '0',
  `item_id` varchar(5) DEFAULT '0',
  `payment_amount` decimal(11,2) DEFAULT '0.00',
  `receipt_no` varchar(55) DEFAULT '',
  `date_paid` date DEFAULT '0000-00-00',
  PRIMARY KEY (`payment_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

#
# Structure for the `unit_info` table : 
#

CREATE TABLE `unit_info` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

#
# Data for the `bill_account_info` table  (LIMIT 0,500)
#

INSERT INTO `bill_account_info` (`bill_account_id`, `reference_no`, `account_no`, `consumer_id`, `narration`, `user_id`, `total_back_bill_amount`, `down_payment`, `no_of_days`, `payment_start_date`, `duration`, `payment_schedule_remarks`, `amount_kwh`, `account_total_kwh`, `date_created`, `date_modified`, `is_active`, `is_deleted`) VALUES 
  (40,'10001','ACO12111',40,'',0,20000.00,1600.00,10,'2016-01-28',10,'',9.00,240,'2016-01-28 18:53:36','0000-00-00 00:00:00',1,0),
  (41,'1222','AC2344',41,'',0,21600.00,0.00,10,'2016-01-28',10,'',9.00,240,'2016-01-28 18:55:17','2016-01-29 14:41:51',1,0),
  (42,'12233','455555',42,'',0,17000.00,1000.00,10,'2016-01-28',10,'',9.00,200,'2016-01-28 20:00:33','0000-00-00 00:00:00',1,0);
COMMIT;

#
# Data for the `bill_payment_schedule` table  (LIMIT 0,500)
#

INSERT INTO `bill_payment_schedule` (`schedule_id`, `bill_item_account_id`, `bill_account_id`, `item_id`, `sched_payment_date`, `bill_description`, `due_amount`, `is_paid`, `remarks`) VALUES 
  (459,'400',40,'0','2016-01-28','',2000.00,0,NULL),
  (460,'401',40,'1','2016-02-28','',2000.00,0,NULL),
  (461,'402',40,'2','2016-03-28','',2000.00,0,NULL),
  (462,'403',40,'3','2016-04-28','',2000.00,0,NULL),
  (463,'404',40,'4','2016-05-28','',2000.00,0,NULL),
  (464,'405',40,'5','2016-06-28','',2000.00,0,NULL),
  (465,'406',40,'6','2016-07-28','',2000.00,0,NULL),
  (466,'407',40,'7','2016-08-28','',2000.00,0,NULL),
  (467,'408',40,'8','2016-09-28','',2000.00,0,NULL),
  (468,'409',40,'9','2016-10-28','',2000.00,0,NULL),
  (479,'420',42,'0','2016-01-28','',1700.00,0,NULL),
  (480,'421',42,'1','2016-02-28','',1700.00,0,NULL),
  (481,'422',42,'2','2016-03-28','',1700.00,0,NULL),
  (482,'423',42,'3','2016-04-28','',1700.00,0,NULL),
  (483,'424',42,'4','2016-05-28','',1700.00,0,NULL),
  (484,'425',42,'5','2016-06-28','',1700.00,0,NULL),
  (485,'426',42,'6','2016-07-28','',1700.00,0,NULL),
  (486,'427',42,'7','2016-08-28','',1700.00,0,NULL),
  (487,'428',42,'8','2016-09-28','',1700.00,0,NULL),
  (488,'429',42,'9','2016-10-28','',1700.00,0,NULL),
  (489,'410',41,'0','2016-01-28','',2160.00,0,NULL),
  (490,'411',41,'1','2016-02-28','',2160.00,0,NULL),
  (491,'412',41,'2','2016-03-28','',2160.00,0,NULL),
  (492,'413',41,'3','2016-04-28','',2160.00,0,NULL),
  (493,'414',41,'4','2016-05-28','',2160.00,0,NULL),
  (494,'415',41,'5','2016-06-28','',2160.00,0,NULL),
  (495,'416',41,'6','2016-07-28','',2160.00,0,NULL),
  (496,'417',41,'7','2016-08-28','',2160.00,0,NULL),
  (497,'418',41,'8','2016-09-28','',2160.00,0,NULL),
  (498,'419',41,'9','2016-10-28','',2160.00,0,NULL);
COMMIT;

#
# Data for the `bill_unit_list` table  (LIMIT 0,500)
#

INSERT INTO `bill_unit_list` (`bill_unit_list_id`, `bill_account_id`, `unit_id`, `unit_qty`, `hours`, `line_kwh`, `line_total`) VALUES 
  (166,40,2,1,8,10,80),
  (167,40,1,1,8,20,160),
  (170,42,2,1,8,5,40),
  (171,42,1,1,8,20,160),
  (172,41,2,1,8,10,80),
  (173,41,1,1,8,20,160);
COMMIT;

#
# Data for the `customer_info` table  (LIMIT 0,500)
#

INSERT INTO `customer_info` (`consumer_id`, `consumer_name`, `house_no`, `street_no`, `barangay`, `municipality`, `zip_code`, `province`, `contact_no`, `email`, `second_address`, `meter_no`, `is_deleted`, `date_created`, `date_modified`) VALUES 
  (40,'Paul Christian Rueda','','','','','','','09357467601','','','',0,'2016-01-28 18:53:36',NULL),
  (41,'Irene Rueda','','','','','','','093675666','','','',0,'2016-01-28 18:55:17','2016-01-29 14:41:51'),
  (42,'Joel Santos','','','','','','','','','','',0,'2016-01-28 20:00:33',NULL);
COMMIT;

#
# Data for the `payment_info` table  (LIMIT 0,500)
#

INSERT INTO `payment_info` (`payment_id`, `bill_account_id`, `consumer_id`, `payment_amount`, `date_created`, `is_active`) VALUES 
  (1,1,1,0.00,'0000-00-00 00:00:00',1);
COMMIT;

#
# Data for the `payment_item_list` table  (LIMIT 0,500)
#

INSERT INTO `payment_item_list` (`payment_list_id`, `payment_id`, `item_id`, `payment_amount`, `receipt_no`, `date_paid`) VALUES 
  (1,1,'0',2000.00,NULL,'0000-00-00');
COMMIT;

#
# Data for the `unit_info` table  (LIMIT 0,500)
#

INSERT INTO `unit_info` (`unit_id`, `unit_description`, `brand_name`, `model_name`, `estimated_kwh`, `amount_consumption`, `date_created`, `date_modified`, `is_deleted`) VALUES 
  (1,'Refrigerator','LG','456-901211',20,50.00,'0000-00-00 00:00:00',NULL,1),
  (2,'Television','Samsung','1223345555',10,2.00,'0000-00-00 00:00:00',NULL,1);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;