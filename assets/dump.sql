DROP TABLE IF EXISTS `wp_exportsreports_groups`;
CREATE TABLE `wp_exportsreports_groups` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `disabled` int(1) NOT NULL,
  `role_access` mediumtext NOT NULL,
  `weight` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wp_exportsreports_reports`;
CREATE TABLE `wp_exportsreports_reports` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group` int(10) NOT NULL,
  `disabled` int(1) NOT NULL,
  `disable_export` int(1) NOT NULL,
  `default_none` int(1) NOT NULL,
  `role_access` mediumtext NOT NULL,
  `sql_query` longtext NOT NULL,
  `sql_query_count` longtext NOT NULL,
  `field_data` longtext NOT NULL,
  `weight` int(10) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `wp_exportsreports_log`;
CREATE TABLE `wp_exportsreports_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `report_id` int(10) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  PRIMARY KEY (`id`)
) DEFAULT CHARSET=utf8;

INSERT INTO `wp_exportsreports_groups` VALUES ('1', 'WordPress', '0', '', '0', NOW(), NOW());

INSERT INTO `wp_exportsreports_reports` (`id`, `name`, `group`, `disabled`, `disable_export`, `default_none`, `role_access`, `sql_query`, `sql_query_count`, `field_data`, `weight`, `created`, `updated`) VALUES (NULL, 'Stocks', '1', '0', '0', '0', '', 'Select * From wp_nepse_stocks', '', '[]', '0', NOW(), NOW());