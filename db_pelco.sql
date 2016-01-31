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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

#
# Structure for the `bill_payment_schedule` table : 
#

CREATE TABLE `bill_payment_schedule` (
  `schedule_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `bill_item_account_id` varchar(20) DEFAULT NULL COMMENT 'CONCAT bill account id and position id',
  `bill_account_id` int(11) DEFAULT NULL,
  `item_id` varchar(5) DEFAULT NULL,
  `sched_payment_date` date DEFAULT NULL,
  `bill_description` varchar(155) DEFAULT '',
  `due_amount` decimal(15,0) DEFAULT '0',
  `is_paid` bit(1) DEFAULT b'0',
  `remarks` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`schedule_id`),
  UNIQUE KEY `bill_item_account_id` (`bill_item_account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=604 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

#
# Structure for the `payment_info` table : 
#

CREATE TABLE `payment_info` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_account_id` int(11) DEFAULT NULL,
  `consumer_id` int(11) DEFAULT NULL,
  `date_created` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

#
# Structure for the `payment_item_list` table : 
#

CREATE TABLE `payment_item_list` (
  `payment_list_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) DEFAULT '0',
  `bill_item_account_id` int(17) DEFAULT '0',
  `item_id` varchar(5) DEFAULT '0',
  `item_description` varchar(155) DEFAULT NULL,
  `payment_amount` decimal(11,2) DEFAULT '0.00',
  `receipt_no` varchar(55) DEFAULT '',
  `date_paid` date DEFAULT '0000-00-00',
  `is_active` bit(1) DEFAULT b'1',
  PRIMARY KEY (`payment_list_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;

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
  (44,'1','2',7,'',0,21600.00,0.00,10,'2016-02-04',20,'',9.00,240,'2016-02-04 14:32:29','2016-02-04 15:38:09',1,0);
COMMIT;

#
# Data for the `bill_payment_schedule` table  (LIMIT 0,500)
#

INSERT INTO `bill_payment_schedule` (`schedule_id`, `bill_item_account_id`, `bill_account_id`, `item_id`, `sched_payment_date`, `bill_description`, `due_amount`, `is_paid`, `remarks`) VALUES 
  (584,'440',44,'0','2016-02-04','',1080,0,NULL),
  (585,'441',44,'1','2016-03-04','',1080,0,NULL),
  (586,'442',44,'2','2016-04-04','',1080,0,NULL),
  (587,'443',44,'3','2016-05-04','',1080,0,NULL),
  (588,'444',44,'4','2016-06-04','',1080,0,NULL),
  (589,'445',44,'5','2016-07-04','',1080,0,NULL),
  (590,'446',44,'6','2016-08-04','',1080,0,NULL),
  (591,'447',44,'7','2016-09-04','',1080,0,NULL),
  (592,'448',44,'8','2016-10-04','',1080,0,NULL),
  (593,'449',44,'9','2016-11-04','',1080,0,NULL),
  (594,'4410',44,'10','2016-12-04','',1080,0,NULL),
  (595,'4411',44,'11','2017-01-04','',1080,0,NULL),
  (596,'4412',44,'12','2017-02-04','',1080,0,NULL),
  (597,'4413',44,'13','2017-03-04','',1080,0,NULL),
  (598,'4414',44,'14','2017-04-04','',1080,0,NULL),
  (599,'4415',44,'15','2017-05-04','',1080,0,NULL),
  (600,'4416',44,'16','2017-06-04','',1080,0,NULL),
  (601,'4417',44,'17','2017-07-04','',1080,0,NULL),
  (602,'4418',44,'18','2017-08-04','',1080,0,NULL),
  (603,'4419',44,'19','2017-09-04','',1080,0,NULL);
COMMIT;

#
# Data for the `bill_unit_list` table  (LIMIT 0,500)
#

INSERT INTO `bill_unit_list` (`bill_unit_list_id`, `bill_account_id`, `unit_id`, `unit_qty`, `hours`, `line_kwh`, `line_total`) VALUES 
  (170,42,2,1,8,5,40),
  (171,42,1,1,8,20,160),
  (172,41,2,1,8,10,80),
  (173,41,1,1,8,20,160),
  (174,40,2,1,8,10,80),
  (175,40,1,1,8,20,160),
  (176,43,2,1,8,10,80),
  (177,43,1,1,8,20,160),
  (182,44,2,1,8,10,80),
  (183,44,1,1,8,20,160);
COMMIT;

#
# Data for the `customer_info` table  (LIMIT 0,500)
#

INSERT INTO `customer_info` (`consumer_id`, `consumer_name`, `house_no`, `street_no`, `barangay`, `municipality`, `zip_code`, `province`, `contact_no`, `email`, `second_address`, `meter_no`, `is_deleted`, `date_created`, `date_modified`) VALUES 
  (1,'Paul Christian Rueda','','','','','','','09357467601','','','',0,'2016-01-28 18:53:36','2016-02-04 09:43:09'),
  (2,'Irene Rueda','','','','','','','093675666','','','',0,'2016-01-28 18:55:17','2016-01-29 14:41:51'),
  (3,'Joel Santos','','','','','','','','','','',0,'2016-01-28 20:00:33',NULL),
  (4,'Paul Christian Rueda','','','','','','','091211','','','',0,'2016-02-04 14:03:02',NULL),
  (7,'Lalaina','','','','','','','095653343','','','',0,'2016-02-04 14:32:29','2016-02-04 15:38:09');
COMMIT;

#
# Data for the `payment_info` table  (LIMIT 0,500)
#

INSERT INTO `payment_info` (`payment_id`, `bill_account_id`, `consumer_id`, `date_created`, `is_active`) VALUES 
  (51,44,7,'2016-02-04 16:25:04',1);
COMMIT;

#
# Data for the `payment_item_list` table  (LIMIT 0,500)
#

INSERT INTO `payment_item_list` (`payment_list_id`, `payment_id`, `bill_item_account_id`, `item_id`, `item_description`, `payment_amount`, `receipt_no`, `date_paid`, `is_active`) VALUES 
  (98,51,440,'0','Billed @ February 04, 2016',100.00,'1','0000-00-00',1),
  (99,51,441,'1','Billed @ March 04, 2016',1080.00,'1','0000-00-00',1);
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