/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50544
Source Host           : 123.57.242.185:3306
Source Database       : end_db

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-06-21 19:48:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for end_admin
-- ----------------------------
DROP TABLE IF EXISTS `end_admin`;
CREATE TABLE `end_admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rights_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `email` varchar(100) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `status` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `id` (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of end_admin
-- ----------------------------
INSERT INTO `end_admin` VALUES ('1', '1', 'admin', '66be5f1f1b43bdb2e337c6749ac1228c0b9d1e24', '', null);
INSERT INTO `end_admin` VALUES ('42', '4', '123456', 'd647730cc2e94692feb4fedba38de256aaaf125a', '', null);
