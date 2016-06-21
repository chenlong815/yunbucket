/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50544
Source Host           : 123.57.242.185:3306
Source Database       : end_db

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-06-21 19:48:12
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for end_category
-- ----------------------------
DROP TABLE IF EXISTS `end_category`;
CREATE TABLE `end_category` (
  `category_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `keywords` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_id` int(11) NOT NULL DEFAULT '0',
  `status` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `update_time` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `url` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `target` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'link',
  `page_title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `system` enum('yes','no') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'no',
  `item_count` int(11) NOT NULL,
  `image` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `short_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  UNIQUE KEY `category_id` (`category_id`),
  KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of end_category
-- ----------------------------
INSERT INTO `end_category` VALUES ('8', '0', '我的课表', null, null, '0', 'cources_list', '1430368600', '1430368599', '我的课表', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('9', '0', '新闻管理', null, null, '0', 'news_list', '1430368622', '1430368621', '新闻管理', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('10', '0', '记事管理', null, null, '0', 'notes_list', '1430368637', '1430368635', '记事管理', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('12', '0', '学生管理', null, null, '0', 'students_list', '1430467408', '1430467406', '学生管理', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('13', '0', '班级管理', null, null, '0', 'class_name_list', '1430468071', '1430468069', '班级管理', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('14', '0', '时间管理', null, null, '0', 'nowtime_list', '1430540641', '1430468451', '实践管理', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('15', '0', '老师管理', null, null, '0', 'teachers_list', '1430474695', '1430474694', '老师管理', '', '', '', '', 'no', '0', '', null);
INSERT INTO `end_category` VALUES ('16', '0', '未到名单', null, null, '0', 'notcome_list', '1430565150', '1430565149', '未到名单', '', '', '', '', 'no', '0', '', null);
