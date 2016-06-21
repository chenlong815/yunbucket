/*
Navicat MySQL Data Transfer

Source Server         : aliyun
Source Server Version : 50544
Source Host           : 123.57.242.185:3306
Source Database       : end_db

Target Server Type    : MYSQL
Target Server Version : 50544
File Encoding         : 65001

Date: 2016-06-21 19:46:11
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for email_permission
-- ----------------------------
DROP TABLE IF EXISTS `email_permission`;
CREATE TABLE `email_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_address` char(255) DEFAULT NULL,
  `password` char(255) NOT NULL,
  `deadline` int(11) DEFAULT NULL,
  `docname` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of email_permission
-- ----------------------------
INSERT INTO `email_permission` VALUES ('55', 'diaoboyu@163.com', '770438', '1453963795', '20151130.zip');
INSERT INTO `email_permission` VALUES ('56', 'diaoboyu@163.com', '306334', '1453967528', '20160125_172917_3.zip');
INSERT INTO `email_permission` VALUES ('57', 'wangfei@ict.ac.cn', '490011', '1453968070', '20151130.zip');
INSERT INTO `email_permission` VALUES ('58', '18810007943@163.com', '771491', '1453969570', '20151130.zip');
INSERT INTO `email_permission` VALUES ('59', ' jhchen@jmu.edu.cn', '419172', '1453970313', '20160125_172917_3.zip');
INSERT INTO `email_permission` VALUES ('60', 'wwy@lreis.ac.cn', '398752', '1453970445', '20151130.zip');
INSERT INTO `email_permission` VALUES ('63', '18810007943@163.com', '845158', '1454034997', '20160125_172917_3.zip');
INSERT INTO `email_permission` VALUES ('65', '18810007943@163.com', '488504', '1455508330', 'NPO邮件内容.docx');
INSERT INTO `email_permission` VALUES ('66', '18810007943@163.com', '134442', '1455516693', 'NPO邮件内容.docx');
INSERT INTO `email_permission` VALUES ('67', '18810007943@163.com', '225106', '1455517523', '20160125_172917_3.zip');
INSERT INTO `email_permission` VALUES ('68', '1158387748@qq.com', '558404', '1455518322', 'bootstrap-3.3.5-dist.zip');
INSERT INTO `email_permission` VALUES ('69', '18810007943@163.com', '143890', '1455519350', 'bootstrap-3.3.5-dist.zip');
INSERT INTO `email_permission` VALUES ('70', '18810007943@163.com', '129333', '1455519437', '20151130.zip');
INSERT INTO `email_permission` VALUES ('71', '18810007943@163.com', '977030', '1455524952', '20150827_005349_2.csv.tar.gz');
INSERT INTO `email_permission` VALUES ('72', '18810007943@163.com', '493658', '1456193324', '20150827_005349_2.csv.tar.gz');
INSERT INTO `email_permission` VALUES ('73', '18810007943@163.com', '393188', '1460111475', '20151130.zip');
INSERT INTO `email_permission` VALUES ('74', '281910885@qq.com', '346464', '1466060889', '20150827_005349_2.csv.tar.gz');
INSERT INTO `email_permission` VALUES ('75', 'wangfei@ict.ac.cn', '964469', '1466060999', '下载信息.txt');
INSERT INTO `email_permission` VALUES ('76', '281910885@qq.com', '763634', '1466061134', '下载信息.txt');
