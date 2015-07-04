/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50538
Source Host           : localhost:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50538
File Encoding         : 65001

Date: 2015-07-02 01:20:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `min_account`
-- ----------------------------
DROP TABLE IF EXISTS `min_account`;
CREATE TABLE `min_account` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(255) NOT NULL COMMENT '账号',
  `password` varchar(60) NOT NULL COMMENT '密码口令',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态，默认 1 为正常，2 为隐士',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_account
-- ----------------------------
INSERT INTO `min_account` VALUES ('1', 'cyq', '9UklK9vps3Bv3JHguCaFp7jXhUcrlZeCaMjWGcXj69M=', '1', '2015-06-30 23:41:52');
INSERT INTO `min_account` VALUES ('2', 'admin', '9UklK9vps3Bv3JHguCaFp7jXhUcrlZeCaMjWGcXj69M=', '2', '2015-06-30 23:42:04');

-- ----------------------------
-- Table structure for `min_category`
-- ----------------------------
DROP TABLE IF EXISTS `min_category`;
CREATE TABLE `min_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '未定义' COMMENT '分类名称',
  `detail` varchar(255) NOT NULL COMMENT '分类描述',
  `create_uid` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '创建者 ID',
  `auth_uid` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '拥有权限修改的用户集合，以英文逗号“,”分隔',
  `rank` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '排序，数值越大越靠前',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态，默认 1 为显示，2 为隐藏',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_category
-- ----------------------------
INSERT INTO `min_category` VALUES ('1', '基础支持', '返回码说明', '1', '0', '100', '1', '2015-07-02 00:24:47');
INSERT INTO `min_category` VALUES ('2', '登陆相关', '包含注册、登陆、忘记密码及修改密码', '1', '0', '99', '1', '2015-07-02 00:38:41');

-- ----------------------------
-- Table structure for `min_interface`
-- ----------------------------
DROP TABLE IF EXISTS `min_interface`;
CREATE TABLE `min_interface` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL COMMENT '所属分类 ID',
  `interface_name` varchar(255) NOT NULL COMMENT '接口名称',
  `interface_detail` varchar(255) NOT NULL COMMENT '接口描述',
  `interface_url` varchar(255) NOT NULL COMMENT '接口 URL 地址',
  `return_value` tinytext NOT NULL COMMENT '返回值',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_interface
-- ----------------------------

-- ----------------------------
-- Table structure for `min_parameter`
-- ----------------------------
DROP TABLE IF EXISTS `min_parameter`;
CREATE TABLE `min_parameter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(11) unsigned NOT NULL COMMENT '所属接口 ID',
  `param_name` tinytext NOT NULL COMMENT '参数名称',
  `param_detail` tinytext NOT NULL COMMENT '参数描述',
  `param_needs` varchar(255) NOT NULL COMMENT '参数是否必须，默认 1 为是，2 为否',
  `param_type` varchar(255) NOT NULL COMMENT '参数类型，默认 0 代表所有，1 代表post,2 代表get',
  `param_rank` varchar(255) NOT NULL COMMENT '参数排序, 越大越靠前',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_parameter
-- ----------------------------

-- ----------------------------
-- Table structure for `min_return`
-- ----------------------------
DROP TABLE IF EXISTS `min_return`;
CREATE TABLE `min_return` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `return_name` tinytext NOT NULL COMMENT '返回值名称',
  `return_detail` tinytext NOT NULL COMMENT '返回值说明',
  `return_rank` varchar(255) NOT NULL COMMENT '返回值排序，越大越靠前',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_return
-- ----------------------------
