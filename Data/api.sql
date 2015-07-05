/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : api

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2015-07-05 13:03:48
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_category
-- ----------------------------
INSERT INTO `min_category` VALUES ('2', '登陆相关', '包含注册、登陆、忘记密码及修改密码', '1', '0', '99', '1', '2015-07-02 00:38:41');
INSERT INTO `min_category` VALUES ('3', '主页面', '产品列表', '2', '0', '96', '1', '2015-07-04 13:28:44');
INSERT INTO `min_category` VALUES ('4', '购物车', '用户的购物车产品列表', '2', '0', '95', '1', '2015-07-04 13:30:07');

-- ----------------------------
-- Table structure for `min_interface`
-- ----------------------------
DROP TABLE IF EXISTS `min_interface`;
CREATE TABLE `min_interface` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL COMMENT '所属分类 ID',
  `interface_code` char(5) DEFAULT NULL COMMENT '接口编号',
  `interface_name` varchar(255) NOT NULL COMMENT '接口名称',
  `interface_detail` varchar(255) NOT NULL COMMENT '接口描述',
  `interface_url` varchar(255) NOT NULL COMMENT '接口 URL 地址',
  `return_value` text NOT NULL COMMENT '返回值',
  `ext` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态，默认 1 为正常，2 为删除',
  `version` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '版本号',
  `lastupdate_time` datetime DEFAULT NULL COMMENT '最后更新时间',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_interface
-- ----------------------------
INSERT INTO `min_interface` VALUES ('1', '2', '00002', '用户登录', '主要用于用户登录系统', 'http://www.xxx.com/User/loginAction', '&lt;pre&gt;{\r\n    &quot;errcode&quot;: &quot;00001&quot;,\r\n    &quot;errinfo&quot;: &quot;添加购物车成功&quot;\r\n}&lt;/pre&gt;', '测试用户登录', '1', '1', null, '2015-07-02 21:01:27');
INSERT INTO `min_interface` VALUES ('2', '2', '00003', '用户密码修改', '用户登录密码修改', 'http://www.xxx.com/User/updatePwd', '&lt;pre&gt;{\r\n    &quot;errcode&quot;: &quot;00001&quot;,\r\n    &quot;errinfo&quot;: &quot;添加购物车成功&quot;\r\n}&lt;/pre&gt;', '用户登录密码的修改基于用户已经登录', '1', '1', null, '2015-07-02 21:18:14');
INSERT INTO `min_interface` VALUES ('3', '3', '00004', '主界面', '产品的热度排列', 'http://www.xxx.com/Index/productList', '&lt;pre&gt;&lt;code class=&quot;lang-json&quot;&gt;{\r\n    &quot;productsData&quot;: [\r\n        {\r\n            &quot;id&quot;: &quot;50&quot;,\r\n            &quot;product_code&quot;: &quot;sfqz2fnmed&quot;,\r\n            &quot;thumb&quot;: &quot;http://www.xxx.com/Upload/Products/thumb/7fc534097cd420cb502d8811beed8160.png&quot;,\r\n            &quot;isPraise&quot;: false,\r\n            &quot;link&quot;: &quot;http://www.xxx.com/wap.php/Product/productDetail/productId/50&quot;\r\n        },\r\n        {\r\n            &quot;id&quot;: &quot;49&quot;,\r\n            &quot;product_code&quot;: &quot;ufadyb67ud&quot;,\r\n            &quot;thumb&quot;: &quot;http://www.xxx.com/Upload/Products/thumb/feab7e2dbd1c603201170f974d144369.png&quot;,\r\n            &quot;isPraise&quot;: true,\r\n            &quot;link&quot;: &quot;http://www.xxx.com/index.php/Product/productDetail/productId/49&quot;\r\n        },\r\n        {\r\n            &quot;id&quot;: &quot;48&quot;,\r\n            &quot;product_code&quot;: &quot;7kr4hkbq5u&quot;,\r\n            &quot;thumb&quot;: &quot;http://www.xxx.com/Upload/Products/thumb/3039c356595f6245daadabae4f380ea8.png&quot;,\r\n            &quot;isPraise&quot;: false,\r\n            &quot;link&quot;: &quot;http://www.xxx.com/index.php/Product/productDetail/productId/48&quot;\r\n        }\r\n    ],\r\n}&lt;/code&gt;&lt;/pre&gt;', '对现有产品的展示  ', '1', '2', '2015-07-04 13:35:30', '2015-07-04 13:34:04');

-- ----------------------------
-- Table structure for `min_parameter`
-- ----------------------------
DROP TABLE IF EXISTS `min_parameter`;
CREATE TABLE `min_parameter` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(11) unsigned NOT NULL COMMENT '所属接口 ID',
  `param_name` tinytext NOT NULL COMMENT '参数名称',
  `param_detail` tinytext NOT NULL COMMENT '参数描述',
  `param_needs` varchar(255) NOT NULL DEFAULT '1' COMMENT '参数是否必须，默认 1 为是，2 为否',
  `param_type` varchar(255) NOT NULL DEFAULT '0' COMMENT '参数类型，默认 0 代表所有，1 代表post,2 代表get',
  `param_rank` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '参数排序, 越大越靠前',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_parameter
-- ----------------------------
INSERT INTO `min_parameter` VALUES ('1', '1', 'userName', '登录名', '1', '1', '2', '2015-07-02 21:01:27');
INSERT INTO `min_parameter` VALUES ('2', '1', 'passWord', '登录口令', '1', '1', '1', '2015-07-02 21:01:27');
INSERT INTO `min_parameter` VALUES ('3', '2', 'oldPwd', '原始密码', '1', '1', '3', '2015-07-02 21:18:14');
INSERT INTO `min_parameter` VALUES ('4', '2', 'newPwd', '新密码', '1', '1', '2', '2015-07-02 21:18:14');
INSERT INTO `min_parameter` VALUES ('5', '2', 'confirmPwd', '确认密码', '1', '1', '1', '2015-07-02 21:18:14');
INSERT INTO `min_parameter` VALUES ('7', '3', 'p', '当前页码，默认为 1', '2', '2', '0', '2015-07-04 13:35:30');

-- ----------------------------
-- Table structure for `min_return`
-- ----------------------------
DROP TABLE IF EXISTS `min_return`;
CREATE TABLE `min_return` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iid` int(11) unsigned NOT NULL COMMENT '相关接口ID,0 代表全局',
  `return_name` tinytext NOT NULL COMMENT '返回值名称',
  `return_detail` tinytext NOT NULL COMMENT '返回值说明',
  `return_rank` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '返回值排序，越大越靠前',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of min_return
-- ----------------------------
INSERT INTO `min_return` VALUES ('1', '0', 'errcode', '返回码，“00001”代表成功，“00002”代表失败', '0', '2015-07-02 21:01:27');
INSERT INTO `min_return` VALUES ('2', '0', 'errinfo', '返回信息说明', '0', '2015-07-02 21:01:27');
INSERT INTO `min_return` VALUES ('11', '3', 'isPraise', '登录用户是否已对其点赞，true 代表已赞，false 代表未赞', '6', '2015-07-04 13:35:30');
INSERT INTO `min_return` VALUES ('10', '3', 'thumb', '产品图片 url', '7', '2015-07-04 13:35:30');
INSERT INTO `min_return` VALUES ('8', '3', 'id', '产品 ID', '9', '2015-07-04 13:35:30');
INSERT INTO `min_return` VALUES ('9', '3', 'product_code', '产品编号', '8', '2015-07-04 13:35:30');
INSERT INTO `min_return` VALUES ('12', '3', 'productsData', '产品数据', '10', '2015-07-04 13:35:30');
