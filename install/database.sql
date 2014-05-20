/* database.sql  */

DROP TABLE IF EXISTS `installation_callback`;

CREATE TABLE `installation_callback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app` varchar(50) DEFAULT NULL,
  `idfa` varchar(50) DEFAULT NULL,
  `andi` varchar(50) DEFAULT NULL,
  `apid` varchar(50) DEFAULT NULL,
  `network_name` varchar(50) DEFAULT NULL,
  `campaign_name` varchar(50) DEFAULT NULL,
  `synchronized_flag` tinyint DEFAULT 0,
  `ins_dt` datetime NOT NULL,
  `ins_process_id` varchar(255) DEFAULT NULL,
  `upd_dt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upd_process_id` varchar(255) DEFAULT NULL,
  `del_flag` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
