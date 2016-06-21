/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50544
Source Host           : 123.57.242.185:3306
Source Database       : end_db

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-06-21 19:48:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for end_log
-- ----------------------------
DROP TABLE IF EXISTS `end_log`;
CREATE TABLE `end_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL,
  `controller` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu` tinyint(4) NOT NULL,
  `time` int(11) NOT NULL DEFAULT '0',
  `info` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4801 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of end_log
-- ----------------------------
INSERT INTO `end_log` VALUES ('4799', '0', 'login', '/end_cms/admin.php?p=login&module=admin&backurl=index.php%3F', '0', '1448957151', '');
INSERT INTO `end_log` VALUES ('4800', '0', 'login', '/end_cms/admin.php?p=login&module=admin&backurl=index.php%3F', '0', '1449028015', '');
