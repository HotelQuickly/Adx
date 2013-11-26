CREATE TABLE `campaign_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `network_code` varchar(35) DEFAULT NULL,
  `campaign_code` varchar(35) DEFAULT NULL,
  `adgroup_code` varchar(35) DEFAULT NULL,
  `iphone_url` varchar(255) DEFAULT NULL,
  `android_url` varchar(255) DEFAULT NULL,
  `blackberry_url` varchar(255) DEFAULT NULL,
  `ipad_url` varchar(255) DEFAULT NULL,
  `used_flag` tinyint(4) NOT NULL DEFAULT '-1',
  `ins_dt` datetime NOT NULL,
  `ins_user_id` int(11) NOT NULL DEFAULT '-1',
  `ins_process_id` varchar(255) DEFAULT NULL,
  `upd_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user_id` int(11) NOT NULL DEFAULT '-1',
  `upd_process_id` varchar(255) DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `network_code` (`network_code`,`campaign_code`,`adgroup_code`),
  KEY `upd_dt` (`upd_dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `device_campaign` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ios_idfa` varchar(50) DEFAULT NULL,
  `ios_idfv` varchar(50) DEFAULT NULL,
  `android_andi` varchar(50) DEFAULT NULL,
  `android_apid` varchar(50) DEFAULT NULL,
  `network_code` varchar(50) DEFAULT NULL,
  `campaign_code` varchar(50) DEFAULT NULL,
  `adgroup_code` varchar(50) DEFAULT NULL,
  `ins_dt` datetime NOT NULL,
  `ins_user_id` int(11) NOT NULL DEFAULT '-1',
  `ins_process_id` varchar(255) DEFAULT NULL,
  `upd_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user_id` int(11) NOT NULL DEFAULT '-1',
  `upd_process_id` varchar(255) DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `upd_dt` (`upd_dt`),
  KEY `ios_idfa` (`ios_idfa`),
  KEY `ios_idfv` (`ios_idfv`),
  KEY `android_andi` (`android_andi`),
  KEY `android_apid` (`android_apid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `daily_stats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `network_code` varchar(35) DEFAULT NULL,
  `campaign_code` varchar(35) DEFAULT NULL,
  `adgroup_code` varchar(35) DEFAULT NULL,
  `app` varchar(35) DEFAULT NULL,
  `clicks_cnt` int(11) DEFAULT NULL,
  `downloads_cnt` int(11) DEFAULT NULL,
  `ins_dt` datetime NOT NULL,
  `ins_user_id` int(11) NOT NULL DEFAULT '-1',
  `ins_process_id` varchar(255) DEFAULT NULL,
  `upd_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_user_id` int(11) NOT NULL DEFAULT '-1',
  `upd_process_id` varchar(255) DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `AK_A003` (`date`,`network_code`,`campaign_code`,`adgroup_code`,`app`),
  KEY `upd_dt` (`upd_dt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;