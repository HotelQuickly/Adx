-- Adminer 3.7.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+07:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `log_daily_stats`;
CREATE TABLE `log_daily_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `records_count` int(11) NOT NULL,
  `email_subject` varchar(70) NOT NULL,
  `email_filename` varchar(50) NOT NULL,
  `email_message` varchar(150) NOT NULL,
  `email_code` varchar(120) NOT NULL,
  `ins_dt` datetime NOT NULL,
  `ins_process_id` varchar(255) DEFAULT NULL,
  `upd_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_process_id` varchar(255) DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_code`),
  KEY `upd_dt` (`upd_dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2013-11-26 17:30:25