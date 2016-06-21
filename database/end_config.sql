/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50544
Source Host           : 123.57.242.185:3306
Source Database       : end_db

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-06-21 19:48:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for end_config
-- ----------------------------
DROP TABLE IF EXISTS `end_config`;
CREATE TABLE `end_config` (
  `config_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `type` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='admin settings';

-- ----------------------------
-- Records of end_config
-- ----------------------------
INSERT INTO `end_config` VALUES ('1', '0', 'site_name', '管理系统', '2015-04-23 16:19:07', 'text', '站点名字', '0');
INSERT INTO `end_config` VALUES ('18', '0', 'upload_file_types', '*.hex;*.jpg;*.jpeg;*.gif;*.png;', '2015-01-23 16:00:54', 'text', '', '0');
