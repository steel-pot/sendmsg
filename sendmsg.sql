# Host: localhost  (Version: 5.5.53)
# Date: 2018-07-25 15:56:52
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "admin_login_log"
#

DROP TABLE IF EXISTS `admin_login_log`;
CREATE TABLE `admin_login_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(20) DEFAULT NULL,
  `result` varchar(50) DEFAULT '0',
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(20) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "admin_login_log"
#

INSERT INTO `admin_login_log` VALUES (1,'','验证失败','2018-07-25 11:46:50','admin',2,'123qwe'),(2,'','验证失败','2018-07-25 11:46:56','admin',2,'qwe123'),(3,'','验证失败','2018-07-25 11:46:59','admin',2,'qwe123'),(4,'','验证失败','2018-07-25 11:47:01','admin',2,'qwe123'),(5,'','验证失败','2018-07-25 11:47:02','admin',2,'qwe123'),(6,'','验证失败','2018-07-25 11:47:06','admin',2,'123qwe'),(7,'','登陆成功','2018-07-25 11:47:27','admin',2,'');

#
# Structure for table "admin_user"
#

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `name` varchar(20) DEFAULT NULL,
  `lastip` varchar(20) DEFAULT NULL,
  `lasttime` datetime DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `state` int(11) DEFAULT '0' COMMENT '0正常 1禁用',
  `err` int(11) DEFAULT '0' COMMENT '错误次数',
  `token` varchar(32) DEFAULT NULL,
  `tokenexpire` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

#
# Data for table "admin_user"
#

INSERT INTO `admin_user` VALUES (2,'admin','14e1b600b1fd579f47433b88e8d85291','admin',NULL,NULL,'2018-07-17 16:31:54',0,6,'1ad4e490f1eef90cdf2de8fe86c198bb','2018-08-01 11:47:27');

#
# Structure for table "sm_history"
#

DROP TABLE IF EXISTS `sm_history`;
CREATE TABLE `sm_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p1` varchar(20) DEFAULT NULL,
  `p2` varchar(20) DEFAULT NULL,
  `p3` varchar(20) DEFAULT NULL,
  `rs` varchar(512) DEFAULT NULL,
  `created` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `p3` (`p3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

#
# Data for table "sm_history"
#


#
# Structure for table "sm_tmp"
#

DROP TABLE IF EXISTS `sm_tmp`;
CREATE TABLE `sm_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p1` varchar(20) DEFAULT NULL,
  `p2` varchar(20) DEFAULT NULL,
  `p3` varchar(20) DEFAULT NULL,
  `state` int(11) DEFAULT '0' COMMENT '0正常 1已存在 2号码错误',
  PRIMARY KEY (`id`),
  KEY `p3` (`p3`)
) ENGINE=InnoDB AUTO_INCREMENT=1131 DEFAULT CHARSET=utf8mb4;

#
# Data for table "sm_tmp"
#


#
# Structure for table "web_config"
#

DROP TABLE IF EXISTS `web_config`;
CREATE TABLE `web_config` (
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '配置名',
  `value` varchar(2048) DEFAULT NULL COMMENT '内容',
  `title` varchar(255) DEFAULT NULL COMMENT '描述',
  `type` int(11) DEFAULT '0' COMMENT '0短  1长',
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='聊天服务器配置';

#
# Data for table "web_config"
#

INSERT INTO `web_config` VALUES ('msg_intid','3','消息接口ID 当前只支持3',0),('msg_key3',' ','消息接口3的key',0),('msg_secret3',' ','消息接口3的secret',0),('msg_tpl',' ','支持字段$p1目标客户名  $p2来源客户名    $vcode验证码',0);
