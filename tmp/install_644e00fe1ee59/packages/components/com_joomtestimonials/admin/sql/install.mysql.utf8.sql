SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `#__joomtestimonials` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `catid` int(10) NOT NULL DEFAULT '0',
  `name` varchar(250) NOT NULL DEFAULT '',
  `testimonial` text NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL DEFAULT '',
  `position` varchar(255) NOT NULL DEFAULT '',
  `company` varchar(255) NOT NULL DEFAULT '',
  `website` varchar(255) NOT NULL DEFAULT '',
  `vote` tinyint(1) NOT NULL DEFAULT 0,
  `video` varchar(255) NOT NULL DEFAULT '',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `checked_out` int(10) NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(10) NOT NULL DEFAULT '0',
  `access` int(10) NOT NULL DEFAULT '1',
  `language` char(7) NOT NULL DEFAULT '*',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `params` text  NULL ,
  `ip` varchar(20) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`id`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_createdby` (`created_by`),
  KEY `idx_language` (`language`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

