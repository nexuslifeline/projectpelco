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
  `down_payment_date` date DEFAULT '0000-00-00',
  `down_payment_receipt_no` varchar(55) DEFAULT '',
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
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=708 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=195 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=121 DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

#
# Structure for the `user` table : 
#

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT '',
  `password` varchar(400) DEFAULT '',
  `email` varchar(255) DEFAULT '',
  `firstname` varchar(255) DEFAULT '',
  `middlename` varchar(255) DEFAULT '',
  `lastname` varchar(255) DEFAULT '',
  `address` varchar(255) DEFAULT '',
  `birthdate` date DEFAULT '0000-00-00',
  `mobile` varchar(75) DEFAULT '',
  `landline` varchar(75) DEFAULT '',
  `is_deleted` bit(1) NOT NULL DEFAULT b'0',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

#
# Data for the `bill_account_info` table  (LIMIT 0,500)
#

INSERT INTO `bill_account_info` (`bill_account_id`, `reference_no`, `account_no`, `consumer_id`, `narration`, `user_id`, `total_back_bill_amount`, `down_payment`, `down_payment_date`, `down_payment_receipt_no`, `no_of_days`, `payment_start_date`, `duration`, `payment_schedule_remarks`, `amount_kwh`, `account_total_kwh`, `date_created`, `date_modified`, `is_active`, `is_deleted`) VALUES 
  (57,'12111','111',21,'',0,7200.00,0.00,'2016-02-03','',10,'2016-02-14',12,'',9.00,80,'2016-02-14 20:53:39','0000-00-00 00:00:00',1,0),
  (58,'12222','1211',22,'',0,7200.00,0.00,'1970-01-01','',10,'2016-02-14',12,'',9.00,80,'2016-02-14 20:54:38','0000-00-00 00:00:00',1,0);
COMMIT;

#
# Data for the `bill_payment_schedule` table  (LIMIT 0,500)
#

INSERT INTO `bill_payment_schedule` (`schedule_id`, `bill_item_account_id`, `bill_account_id`, `item_id`, `sched_payment_date`, `bill_description`, `due_amount`, `is_paid`, `remarks`) VALUES 
  (684,'570',57,'0','2016-02-14','',600,0,NULL),
  (685,'571',57,'1','2016-03-14','',600,0,NULL),
  (686,'572',57,'2','2016-04-14','',600,0,NULL),
  (687,'573',57,'3','2016-05-14','',600,0,NULL),
  (688,'574',57,'4','2016-06-14','',600,0,NULL),
  (689,'575',57,'5','2016-07-14','',600,0,NULL),
  (690,'576',57,'6','2016-08-14','',600,0,NULL),
  (691,'577',57,'7','2016-09-14','',600,0,NULL),
  (692,'578',57,'8','2016-10-14','',600,0,NULL),
  (693,'579',57,'9','2016-11-14','',600,0,NULL),
  (694,'5710',57,'10','2016-12-14','',600,0,NULL),
  (695,'5711',57,'11','2017-01-14','',600,0,NULL),
  (696,'580',58,'0','2016-02-14','',600,0,NULL),
  (697,'581',58,'1','2016-03-14','',600,0,NULL),
  (698,'582',58,'2','2016-04-14','',600,0,NULL),
  (699,'583',58,'3','2016-05-14','',600,0,NULL),
  (700,'584',58,'4','2016-06-14','',600,0,NULL),
  (701,'585',58,'5','2016-07-14','',600,0,NULL),
  (702,'586',58,'6','2016-08-14','',600,0,NULL),
  (703,'587',58,'7','2016-09-14','',600,0,NULL),
  (704,'588',58,'8','2016-10-14','',600,0,NULL),
  (705,'589',58,'9','2016-11-14','',600,0,NULL),
  (706,'5810',58,'10','2016-12-14','',600,0,NULL),
  (707,'5811',58,'11','2017-01-14','',600,0,NULL);
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
  (183,44,1,1,8,20,160),
  (185,45,2,1,8,12,96),
  (186,46,3,2,8,12,192),
  (187,47,2,1,8,10,80),
  (188,47,1,2,8,20,320),
  (189,48,3,1,8,12,96),
  (190,49,1,1,8,20,160),
  (191,55,2,1,8,10,80),
  (192,56,2,1,8,10,80),
  (193,57,2,1,8,10,80),
  (194,58,2,1,8,10,80);
COMMIT;

#
# Data for the `customer_info` table  (LIMIT 0,500)
#

INSERT INTO `customer_info` (`consumer_id`, `consumer_name`, `house_no`, `street_no`, `barangay`, `municipality`, `zip_code`, `province`, `contact_no`, `email`, `second_address`, `meter_no`, `is_deleted`, `date_created`, `date_modified`) VALUES 
  (1,'Paul Christian Rueda','','','','','','','09357467601','','','',0,'2016-01-28 18:53:36','2016-02-04 09:43:09'),
  (2,'Irene Rueda','','','','','','','093675666','','','',0,'2016-01-28 18:55:17','2016-01-29 14:41:51'),
  (3,'Joel Santos','','','','','','','','','','',0,'2016-01-28 20:00:33',NULL),
  (4,'Paul Christian Rueda','','','','','','','091211','','','',0,'2016-02-04 14:03:02',NULL),
  (7,'Lalaina','','','','','','','095653343','','','',0,'2016-02-04 14:32:29','2016-02-04 15:38:09'),
  (8,'Paulino Rueda','','','','','','','','','','',0,'2016-02-12 17:36:41','2016-02-12 17:39:19'),
  (9,'Paul Rueda','','','','','','','','','','',0,'2016-02-14 17:33:46',NULL),
  (11,'Denis Guttierez','','','','','','','','','','',0,'2016-02-14 17:50:42',NULL),
  (12,'JOEL SANTOS','','','','','','','121','121','','',0,'2016-02-14 19:42:18',NULL),
  (13,'Irene','','','','','','','','','','',0,'2016-02-14 20:25:33',NULL),
  (19,'1','','','','','','','1','1','','',0,'2016-02-14 20:50:15',NULL),
  (20,'Kevin','','','','','','','','','','',0,'2016-02-14 20:51:26',NULL),
  (21,'Paul Christian 121','','','','','','','','','','',0,'2016-02-14 20:53:39',NULL),
  (22,'Denis','','','','','','','','','','',0,'2016-02-14 20:54:38',NULL);
COMMIT;

#
# Data for the `unit_info` table  (LIMIT 0,500)
#

INSERT INTO `unit_info` (`unit_id`, `unit_description`, `brand_name`, `model_name`, `estimated_kwh`, `amount_consumption`, `date_created`, `date_modified`, `is_deleted`) VALUES 
  (1,'Refrigerator','LG','456-901211',20,50.00,'0000-00-00 00:00:00',NULL,1),
  (2,'Television','Samsung','1223345555',10,2.00,'0000-00-00 00:00:00',NULL,1),
  (3,'Appliances 1','','',12,12.00,'2016-02-14 17:33:02',NULL,0);
COMMIT;

#
# Data for the `user` table  (LIMIT 0,500)
#

INSERT INTO `user` (`user_id`, `username`, `password`, `email`, `firstname`, `middlename`, `lastname`, `address`, `birthdate`, `mobile`, `landline`, `is_deleted`, `date_created`, `date_modified`) VALUES 
  (1,'dhenz','21232f297a57a5a743894a0e4a801fc3','sample@gmail.com','Denis','Baun','Gutierrez','#614 Moras Dela Paz Sto. Tomas, Pampanga','1990-02-03','2147483647','4590909',0,'0000-00-00 00:00:00',NULL),
  (2,'jheniloveyou','21232f297a57a5a743894a0e4a801fc3','sample@gmail.com','Jennifer','Santos','Labuyo','Mexico Pampanga','2000-01-01','999999','999999',0,'2016-02-11 07:30:18',NULL),
  (3,'admin','admin','admin@gmail.com','s','s','s','ssd099','2000-01-01','9999','9999',0,'2016-02-11 07:33:15',NULL);
COMMIT;



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;