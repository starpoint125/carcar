-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.7.40 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  12.5.0.6684
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 导出 carcar 的数据库结构
CREATE DATABASE IF NOT EXISTS `carcar` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `carcar`;

-- 导出  表 carcar.car_admin_log 结构
CREATE TABLE IF NOT EXISTS `car_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(11) unsigned NOT NULL COMMENT '管理员用户id',
  `route` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '操作路由',
  `description` text COLLATE utf8_unicode_ci COMMENT '操作描述',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_admin_user 结构
CREATE TABLE IF NOT EXISTS `car_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增管理员用户id',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员用户名',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员cookie验证auth_key',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员加密密码',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '管理员找回密码token',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理员邮箱',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '管理员头像url',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '管理员状态,10正常',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_article 结构
CREATE TABLE IF NOT EXISTS `car_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章自增id',
  `cid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章分类id',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型.0文章,1单页',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '文章标题',
  `sub_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `summary` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章概要',
  `thumb` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '缩略图',
  `seo_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keywords` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'seo关键字',
  `seo_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'seo描述',
  `status` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '状态.0草稿,1发布',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `author_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '发布文章管理员id',
  `author_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '发布文章管理员用户名',
  `scan_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `comment_count` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `can_comment` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '是否可评论.0否,1是',
  `visibility` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '文章可见性.1.公开,2.评论可见,3.加密文章,4.登录可见',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '文章明文密码',
  `flag_headline` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '头条.0否,1.是',
  `flag_recommend` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '推荐.0否,1.是',
  `flag_slide_show` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '幻灯.0否,1.是',
  `flag_special_recommend` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '特别推荐.0否,1.是',
  `flag_roll` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '滚动.0否,1.是',
  `flag_bold` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '加粗.0否,1.是',
  `flag_picture` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '图片.0否,1.是',
  `template` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '文章模板',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `index_title` (`title`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_article_content 结构
CREATE TABLE IF NOT EXISTS `car_article_content` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `aid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '文章详细内容',
  PRIMARY KEY (`id`),
  KEY `fk_aid` (`aid`),
  CONSTRAINT `fk_aid` FOREIGN KEY (`aid`) REFERENCES `car_article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_article_meta 结构
CREATE TABLE IF NOT EXISTS `car_article_meta` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `aid` int(11) unsigned NOT NULL COMMENT '文章id',
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'tag名',
  `value` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'tag值',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `index_aid` (`aid`),
  KEY `index_key` (`key`),
  CONSTRAINT `fk_article_meta_aid` FOREIGN KEY (`aid`) REFERENCES `car_article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_auth_assignment 结构
CREATE TABLE IF NOT EXISTS `car_auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `car_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_auth_item 结构
CREATE TABLE IF NOT EXISTS `car_auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `car_auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_auth_item_child 结构
CREATE TABLE IF NOT EXISTS `car_auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `car_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `car_auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_auth_rule 结构
CREATE TABLE IF NOT EXISTS `car_auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_cartype 结构
CREATE TABLE IF NOT EXISTS `car_cartype` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `type_name` varchar(255) NOT NULL COMMENT '类别名称',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型1品牌2配置',
  `created_at` int(10) NOT NULL DEFAULT '0',
  `updated_at` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='车辆类别';

-- 数据导出被取消选择。

-- 导出  表 carcar.car_category 结构
CREATE TABLE IF NOT EXISTS `car_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` int(11) unsigned NOT NULL DEFAULT '0',
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `template` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类模板',
  `article_template` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '分类模板',
  `created_at` int(11) unsigned NOT NULL,
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_comment 结构
CREATE TABLE IF NOT EXISTS `car_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `aid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '文章id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id,游客为0',
  `admin_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员id,其他人员对其回复为0',
  `reply_to` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '回复的评论id',
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '游客' COMMENT '昵称',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `website_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '个人网址',
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '回复内容',
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '回复ip',
  `status` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '状态,0.未审核,1.已通过',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  KEY `index_aid` (`aid`),
  CONSTRAINT `fk_comment_aid` FOREIGN KEY (`aid`) REFERENCES `car_article` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_friendly_link 结构
CREATE TABLE IF NOT EXISTS `car_friendly_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '网站名称',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图片url',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '_blank' COMMENT '打开方式._blank新窗口,_self本窗口',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '状态.0禁用,1启用',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_management 结构
CREATE TABLE IF NOT EXISTS `car_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0' COMMENT '车辆名称',
  `avatar` varchar(255) NOT NULL DEFAULT '0' COMMENT '车辆主图',
  `cartype_id` int(10) NOT NULL DEFAULT '0' COMMENT '品牌id',
  `type` tinyint(10) NOT NULL DEFAULT '0' COMMENT '类型(1=>''经济型'',2=>''MPV'',3=>''轿车'',4=>''SUV'')',
  `seat_num` int(10) NOT NULL DEFAULT '0' COMMENT '座位数',
  `door_num` int(10) NOT NULL DEFAULT '0' COMMENT '门数',
  `gear_position` tinyint(1) NOT NULL DEFAULT '0' COMMENT '档位 0自动档1手动档',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态 0开启1禁用',
  `recommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐0无1推荐',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '租金',
  `deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '押金',
  `created_at` int(11) NOT NULL DEFAULT '0',
  `updated_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='车辆管理';

-- 数据导出被取消选择。

-- 导出  表 carcar.car_menu 结构
CREATE TABLE IF NOT EXISTS `car_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '菜单类型.0后台,1前台',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上级菜单id',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '名称',
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'url地址',
  `icon` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '图标',
  `sort` float unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '_blank' COMMENT '打开方式._blank新窗口,_self本窗口',
  `is_absolute_url` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '是否绝对地址',
  `is_display` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '是否显示.0否,1是',
  `created_at` int(11) unsigned NOT NULL COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '最后修改时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_migration 结构
CREATE TABLE IF NOT EXISTS `car_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_options 结构
CREATE TABLE IF NOT EXISTS `car_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型.0系统,1自定义,2banner,3广告',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '标识符',
  `value` text COLLATE utf8_unicode_ci NOT NULL COMMENT '值',
  `input_type` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '输入框类型',
  `autoload` smallint(6) unsigned NOT NULL DEFAULT '1' COMMENT '自动加载.0否,1是',
  `tips` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '提示备注信息',
  `sort` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_order 结构
CREATE TABLE IF NOT EXISTS `car_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `order_number` char(17) DEFAULT NULL COMMENT '订单号',
  `uid` int(10) NOT NULL COMMENT '用户表主键id',
  `car_id` int(10) NOT NULL COMMENT '车辆表id',
  `reservation_time` timestamp NULL DEFAULT NULL COMMENT '预约时间',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `car_rental_fee` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '租车费用',
  `deposit` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '押金',
  `insurance_expenses` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '保险费用',
  `total_cost` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总费用',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单状态 1用车中2已完成3已取消',
  `deposit_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '押金状态 1无押金2待退还',
  `extraction_method` tinyint(1) NOT NULL DEFAULT '1' COMMENT '取车方式 1到店自取2送车上门',
  `created_at` tinyint(10) NOT NULL DEFAULT '0' COMMENT '下单时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单管理';

-- 数据导出被取消选择。

-- 导出  表 carcar.car_user 结构
CREATE TABLE IF NOT EXISTS `car_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增用户id',
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL COMMENT 'cookie验证auth_key',
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '加密后密码',
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '找回密码token',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户邮箱',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT '用户头像url',
  `idcard` varchar(255) COLLATE utf8_unicode_ci DEFAULT '' COMMENT 'idcard',
  `bdcar` int(10) NOT NULL DEFAULT '0' COMMENT '绑定车辆',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '用户状态,10为正常',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '最后修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 数据导出被取消选择。

-- 导出  表 carcar.car_user_details 结构
CREATE TABLE IF NOT EXISTS `car_user_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `car_management_id` int(10) NOT NULL DEFAULT '0' COMMENT '车辆id',
  `date` datetime DEFAULT NULL COMMENT '日期',
  `income` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '收入',
  `expenses` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '支出',
  `remark` text COMMENT '备注',
  `created_at` int(10) NOT NULL DEFAULT '0',
  `updated_at` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='用户消费明细';

-- 数据导出被取消选择。

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
