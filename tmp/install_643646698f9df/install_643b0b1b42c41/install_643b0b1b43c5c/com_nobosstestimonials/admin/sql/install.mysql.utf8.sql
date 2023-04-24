/*
Navicat MySQL Data Transfer

Source Server         : No Boss - Desenv
Source Server Version : 50559

Target Server Type    : MYSQL
Target Server Version : 50559
File Encoding         : 65001

Date: 2018-03-26 11:52:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #__noboss_testimonial
-- ----------------------------
DROP TABLE IF EXISTS `#__noboss_testimonial`;
CREATE TABLE `#__noboss_testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_testimonials_group` int(11) DEFAULT NULL,
  `author_name` varchar(300) DEFAULT NULL,
  `display_type` varchar(20) NOT NULL,
  `text_testimonial` text,
  `video_id` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `profession` varchar(200) DEFAULT NULL,
  `course` varchar(200) DEFAULT NULL,
  `class` varchar(200) DEFAULT NULL,
  `conclusion_year` varchar(200) DEFAULT NULL,
  `company` varchar(200) DEFAULT NULL,
  `language` char(7) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `checked_out` int(11) DEFAULT NULL,
  `checked_out_time` datetime DEFAULT '0000-00-00 00:00:00',
  `state` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=555 DEFAULT CHARSET=utf8;


/*
Navicat MySQL Data Transfer

Source Server         : No Boss - Desenv
Source Server Version : 50559

Target Server Type    : MYSQL
Target Server Version : 50559
File Encoding         : 65001

Date: 2018-03-26 11:52:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #__noboss_testimonial_group
-- ----------------------------
DROP TABLE IF EXISTS `#__noboss_testimonial_group`;
CREATE TABLE `#__noboss_testimonial_group` (
  `id_testimonials_group` int(11) NOT NULL AUTO_INCREMENT,
  `name_testimonials_group` varchar(100) NOT NULL,
  `id_module_testimonials_submission` int(11) NOT NULL,
  `id_module_testimonials_display` int(11) NOT NULL,
  `fields_display` text NOT NULL,
  `config_module_testimonials_display` text NOT NULL,
  `config_module_testimonials_submission` text NOT NULL,
  `config_moderate_testimonials` text NOT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `language` varchar(7) NOT NULL DEFAULT '',
  `created_by` int(10) unsigned NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(10) unsigned NOT NULL DEFAULT '0',
  `ordering` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_testimonials_group`)
) ENGINE=InnoDB AUTO_INCREMENT=439 DEFAULT CHARSET=utf8;


/*
Navicat MySQL Data Transfer

Source Server         : No Boss - Desenv
Source Server Version : 50559

Target Server Type    : MYSQL
Target Server Version : 50559
File Encoding         : 65001

Date: 2018-03-26 11:52:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for #__noboss_testimonial_photo
-- ----------------------------
DROP TABLE IF EXISTS `#__noboss_testimonial_photo`;
CREATE TABLE `#__noboss_testimonial_photo` (
  `id_testimonial` int(11) NOT NULL,
  `content_image` longblob NOT NULL,
  `mime_type` varchar(50) NOT NULL,
  PRIMARY KEY (`id_testimonial`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
