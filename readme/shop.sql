/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : shop_shicai

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-10-21 11:57:00
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for weitair_address
-- ----------------------------
DROP TABLE IF EXISTS `weitair_address`;
CREATE TABLE `weitair_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '电话号码',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(64) NOT NULL DEFAULT '' COMMENT '行政区',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `num` varchar(32) NOT NULL DEFAULT '' COMMENT '门牌号',
  `is_default` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否默认地址(10：否、20：是)',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10033 DEFAULT CHARSET=utf8mb4 COMMENT='用户地址';

-- ----------------------------
-- Records of weitair_address
-- ----------------------------
INSERT INTO `weitair_address` VALUES ('10000', '0', ' ', '', '', '', '', '', '', '0', '0.0000000', '0.0000000', '2019-10-25 13:39:56', '2019-10-25 13:40:01', '2019-10-25 13:39:59');

-- ----------------------------
-- Table structure for weitair_admin
-- ----------------------------
DROP TABLE IF EXISTS `weitair_admin`;
CREATE TABLE `weitair_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '登录用户名',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '登录密码',
  `realname` varchar(32) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别(0：未知、1：男、2：女 )',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `last_login_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `lock_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '锁定时间',
  `disable` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '禁用(10：否、20：是)',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT 'Token',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10022 DEFAULT CHARSET=utf8mb4 COMMENT='后台管理员';

-- ----------------------------
-- Records of weitair_admin
-- ----------------------------
INSERT INTO `weitair_admin` VALUES ('10000', '10000', 'admin', '$2y$10$XnL7vxPbgBZAawZZU65O8O32BJ.ovZNGic.l/anoeFtInTEMLtqLW', '微态尔', '1', 'https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/console/avatar/20200819141255dc61b6360.png', '', '', '1603251010', '127.0.0.1', '0', '10', '系统管理员，不可删除', 'cfb5afc8c641d3d55f0b1ddb8ecf7c2b', '2019-10-02 22:10:24', '2020-10-21 11:32:08', null);

-- ----------------------------
-- Table structure for weitair_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `weitair_admin_log`;
CREATE TABLE `weitair_admin_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关联账号ID',
  `user_agent` text NOT NULL COMMENT '用户代理',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '客户端IP地址',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态（10：失败、20：成功）',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10150 DEFAULT CHARSET=utf8mb4 COMMENT='后台管理员日志';

-- ----------------------------
-- Records of weitair_admin_log
-- ----------------------------
INSERT INTO `weitair_admin_log` VALUES ('10065', '10000', '', '2130706433', '1590482641', '10', '2020-05-26 16:44:01', '2020-06-22 03:15:55', '2020-05-26 16:45:35');

-- ----------------------------
-- Table structure for weitair_article
-- ----------------------------
DROP TABLE IF EXISTS `weitair_article`;
CREATE TABLE `weitair_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '文章标题',
  `subtitle` varchar(255) NOT NULL DEFAULT '' COMMENT '副标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '封面图片',
  `style` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '列表类型(10：大图、20:左图、30：右图)',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '查看量',
  `is_best` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否推荐(10：否、20：是)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `content` text NOT NULL COMMENT '内容',
  `release_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4 COMMENT='文章';

-- ----------------------------
-- Records of weitair_article
-- ----------------------------
INSERT INTO `weitair_article` VALUES ('10000', '0', '', '', '', '0', '0', '0', '0', ' ', '0', '2020-06-08 00:39:09', '2020-06-08 00:39:20', '2020-06-08 00:39:19');

-- ----------------------------
-- Table structure for weitair_article_banner
-- ----------------------------
DROP TABLE IF EXISTS `weitair_article_banner`;
CREATE TABLE `weitair_article_banner` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '标题',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `redirect_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '是否跳转(10：不跳转、20：跳转)',
  `redirect_site` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(10：下线、20：上线)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=utf8mb4 COMMENT='文章横幅';

-- ----------------------------
-- Records of weitair_article_banner
-- ----------------------------
INSERT INTO `weitair_article_banner` VALUES ('10000', ' ', '', '0', '', '0', '0', '2020-08-28 01:40:18', '2020-08-28 02:10:42', '2020-08-28 02:10:41');

-- ----------------------------
-- Table structure for weitair_article_category
-- ----------------------------
DROP TABLE IF EXISTS `weitair_article_category`;
CREATE TABLE `weitair_article_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `category_name` varchar(255) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '层级',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10003 DEFAULT CHARSET=utf8mb4 COMMENT='文章分类';

-- ----------------------------
-- Records of weitair_article_category
-- ----------------------------
INSERT INTO `weitair_article_category` VALUES ('10000', '', '0', '0', '0', '0', '2020-06-08 00:39:44', '2020-06-08 00:39:52', '2020-06-08 00:39:46');

-- ----------------------------
-- Table structure for weitair_cart
-- ----------------------------
DROP TABLE IF EXISTS `weitair_cart`;
CREATE TABLE `weitair_cart` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品SKU',
  `goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sku_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品SKU名称',
  `image` varchar(512) NOT NULL DEFAULT '' COMMENT '封面图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品价格',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `goods_sku_id` (`goods_sku_id`) USING BTREE,
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10049 DEFAULT CHARSET=utf8mb4 COMMENT='购物车';

-- ----------------------------
-- Records of weitair_cart
-- ----------------------------
INSERT INTO `weitair_cart` VALUES ('10000', '0', '0', '0', ' ', '', '', '0', '0', '2019-10-27 14:31:25', '2019-10-27 14:32:12', '2019-10-27 14:32:09');

-- ----------------------------
-- Table structure for weitair_category
-- ----------------------------
DROP TABLE IF EXISTS `weitair_category`;
CREATE TABLE `weitair_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `category_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序(越小越靠前)',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '层级',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=utf8mb4 COMMENT='商品分类';

-- ----------------------------
-- Records of weitair_category
-- ----------------------------
INSERT INTO `weitair_category` VALUES ('10001', '0', '', '', '100', '0', '20', '2019-10-16 00:13:49', '2020-08-15 02:01:52', '2019-12-29 17:14:40');

-- ----------------------------
-- Table structure for weitair_checkin
-- ----------------------------
DROP TABLE IF EXISTS `weitair_checkin`;
CREATE TABLE `weitair_checkin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(32) NOT NULL DEFAULT '' COMMENT '用户ID',
  `days` tinyint(4) NOT NULL DEFAULT '0' COMMENT '连续天数',
  `checkin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '签到时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `sign_time` (`checkin_time`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10108 DEFAULT CHARSET=utf8mb4 COMMENT='用户签到';

-- ----------------------------
-- Records of weitair_checkin
-- ----------------------------
INSERT INTO `weitair_checkin` VALUES ('10085', '0', '0', '0', '2019-11-06 05:06:28', '2020-06-07 04:03:49', '2020-06-07 04:03:47');

-- ----------------------------
-- Table structure for weitair_coupon
-- ----------------------------
DROP TABLE IF EXISTS `weitair_coupon`;
CREATE TABLE `weitair_coupon` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `coupon_name` varchar(32) NOT NULL DEFAULT '' COMMENT '优惠卷名称',
  `coupon_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '优惠卷类型(10：满减卷、20：折扣券)',
  `coupon_visible` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '优惠卷公开性(10：不公开、20：公开)',
  `discount` float unsigned NOT NULL DEFAULT '0' COMMENT '折扣率范围(0-10，9.5代表9.5折)',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '额度(单位：分)',
  `condition` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用条件(单位：分)',
  `total` int(11) NOT NULL DEFAULT '0' COMMENT '发行数量(限制领取的优惠券数量，0为不限制)',
  `received` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取数量',
  `used` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已使用数量',
  `expire_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '到期类型(10：领取后生效、20：固定时间)',
  `begin_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结束时间',
  `expire_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '失效时间(用于领取后生效：如30天后)',
  `receive_limit` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '限领(每人最多能领取数)',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10019 DEFAULT CHARSET=utf8mb4 COMMENT='优惠卷';

-- ----------------------------
-- Records of weitair_coupon
-- ----------------------------
INSERT INTO `weitair_coupon` VALUES ('10000', ' ', '0', '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '', '0', '2019-10-19 02:01:37', '2020-06-07 04:04:18', '2019-10-19 02:01:38');

-- ----------------------------
-- Table structure for weitair_coupon_receive
-- ----------------------------
DROP TABLE IF EXISTS `weitair_coupon_receive`;
CREATE TABLE `weitair_coupon_receive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `coupon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `coupon_name` varchar(32) NOT NULL DEFAULT '' COMMENT '优惠卷名称',
  `coupon_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '优惠卷类型(10：满减卷、20：折扣券)',
  `discount` float unsigned NOT NULL DEFAULT '0' COMMENT '折扣率范围(0-10，9.5代表9.5折)',
  `amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '额度(单位：分)',
  `condition` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用条件(单位：分)',
  `expire_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '到期时间',
  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `receive_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '领取时间',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '来源(10：主动领取、20：系统发放)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：未使用、20：已使用)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10062 DEFAULT CHARSET=utf8mb4 COMMENT='优惠卷领取';

-- ----------------------------
-- Records of weitair_coupon_receive
-- ----------------------------
INSERT INTO `weitair_coupon_receive` VALUES ('10018', '0', '0', '', '0', '0', '0', '0', '0', '', '', '0', '10', '0', '2019-10-30 00:51:12', '2020-06-02 01:12:45', '2020-05-12 00:37:49');

-- ----------------------------
-- Table structure for weitair_distribution
-- ----------------------------
DROP TABLE IF EXISTS `weitair_distribution`;
CREATE TABLE `weitair_distribution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `phone` varchar(16) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `apply_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '申请状态(10：申请中、20：已完成)',
  `audit_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '审核状态(10：未通过、20：通过)',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '理由',
  `apply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请时间',
  `audit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '审核时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10011 DEFAULT CHARSET=utf8mb4 COMMENT='分销申请';

-- ----------------------------
-- Records of weitair_distribution
-- ----------------------------
INSERT INTO `weitair_distribution` VALUES ('10000', '0', '', '', '10', '10', '', '0', '0', '2020-07-29 01:34:39', '2020-08-20 14:24:14', '2020-08-20 14:24:12');

-- ----------------------------
-- Table structure for weitair_distribution_bonus
-- ----------------------------
DROP TABLE IF EXISTS `weitair_distribution_bonus`;
CREATE TABLE `weitair_distribution_bonus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `from_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '来自哪个用户的订单佣金',
  `amount` int(10) NOT NULL DEFAULT '0' COMMENT '金额(单位：分)',
  `balance` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '余额',
  `record_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10010 DEFAULT CHARSET=utf8mb4 COMMENT='分销订单';

-- ----------------------------
-- Records of weitair_distribution_bonus
-- ----------------------------
INSERT INTO `weitair_distribution_bonus` VALUES ('10000', '0', '0', '0', '0', '0', '0', '2019-12-06 04:08:37', '2019-12-06 04:08:37', '2019-12-06 04:08:34');

-- ----------------------------
-- Table structure for weitair_distribution_cash
-- ----------------------------
DROP TABLE IF EXISTS `weitair_distribution_cash`;
CREATE TABLE `weitair_distribution_cash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `cash_no` varchar(128) NOT NULL DEFAULT '' COMMENT '提现编号',
  `payment_no` varchar(64) NOT NULL DEFAULT '' COMMENT '微信返回支付编号',
  `cash_fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '手续费',
  `cash_apply` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '申请提现金额',
  `cash_amount` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际提现金额',
  `cash_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：申请、20：完成)',
  `cash_channel` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '提现渠道(10：账户余额、20：微信、30：支付宝、40：银行卡)',
  `cash_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '提现时间',
  `finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `audit_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '审核状态(10：未通过、20：通过)',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '理由',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '客户端IP',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4 COMMENT='分销提现';

-- ----------------------------
-- Records of weitair_distribution_cash
-- ----------------------------
INSERT INTO `weitair_distribution_cash` VALUES ('10000', '0', ' ', '', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '2019-12-11 14:23:23', '2020-06-07 04:03:10', '2019-12-11 14:23:22');

-- ----------------------------
-- Table structure for weitair_express
-- ----------------------------
DROP TABLE IF EXISTS `weitair_express`;
CREATE TABLE `weitair_express` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `company` varchar(32) NOT NULL DEFAULT '' COMMENT '物流公司',
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '物流公司代码',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10011 DEFAULT CHARSET=utf8mb4 COMMENT='快递公司';

-- ----------------------------
-- Records of weitair_express
-- ----------------------------
INSERT INTO `weitair_express` VALUES ('10000', '', '', '0', '2020-06-07 04:10:57', '2020-06-07 04:11:01', '2020-06-07 04:10:59');
INSERT INTO `weitair_express` VALUES ('10001', '顺丰速运', 'shunfeng', '101', '2019-11-05 02:52:13', '2019-11-18 00:18:38', null);
INSERT INTO `weitair_express` VALUES ('10002', '邮政国内', 'yzguonei', '102', '2019-11-05 02:52:43', '2019-11-18 00:18:42', null);
INSERT INTO `weitair_express` VALUES ('10003', '圆通速递', 'yuantong', '103', '2019-11-05 02:55:20', '2019-11-18 00:18:46', null);
INSERT INTO `weitair_express` VALUES ('10004', '申通快递', 'shentong', '104', '2019-11-05 02:55:39', '2019-11-18 00:18:50', null);
INSERT INTO `weitair_express` VALUES ('10005', '韵达快递', 'yunda', '105', '2019-11-05 02:55:50', '2019-11-18 00:18:54', null);
INSERT INTO `weitair_express` VALUES ('10006', '百世快递', 'huitongkuaidi', '106', '2019-11-05 02:56:00', '2019-11-18 00:18:57', null);
INSERT INTO `weitair_express` VALUES ('10007', '中通快递', 'zhongtong', '107', '2019-11-05 02:56:13', '2019-11-18 00:19:02', null);
INSERT INTO `weitair_express` VALUES ('10008', '天天快递', 'tiantian', '108', '2019-11-05 02:56:27', '2019-11-18 00:19:05', null);
INSERT INTO `weitair_express` VALUES ('10009', '宅急送', 'zhaijisong', '109', '2019-11-05 02:56:38', '2019-11-18 00:19:09', null);
INSERT INTO `weitair_express` VALUES ('10010', '同城速递', '-', '100', '2019-11-16 03:17:41', '2020-08-03 13:17:28', null);

-- ----------------------------
-- Table structure for weitair_express_template
-- ----------------------------
DROP TABLE IF EXISTS `weitair_express_template`;
CREATE TABLE `weitair_express_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '模板名称',
  `free` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否包邮(10：不包邮、20：包邮)',
  `method` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '计价方式(10：按件数、20：按重量)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10013 DEFAULT CHARSET=utf8mb4 COMMENT='快递模板';

-- ----------------------------
-- Records of weitair_express_template
-- ----------------------------
INSERT INTO `weitair_express_template` VALUES ('10000', '', '10', '10', '0', '2020-08-03 08:31:02', '2020-08-03 13:33:09', '2020-08-03 13:33:08');

-- ----------------------------
-- Table structure for weitair_express_template_item
-- ----------------------------
DROP TABLE IF EXISTS `weitair_express_template_item`;
CREATE TABLE `weitair_express_template_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `express_template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递模板ID',
  `region` text NOT NULL COMMENT '区域',
  `first` double unsigned NOT NULL DEFAULT '0' COMMENT '首件/首重',
  `first_fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首件/首重费用(单位：分)',
  `additional` double unsigned NOT NULL DEFAULT '0' COMMENT '续件/续重',
  `additional_fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '续件/续重费用(单位：分)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10071 DEFAULT CHARSET=utf8mb4 COMMENT='快递模板项目';

-- ----------------------------
-- Records of weitair_express_template_item
-- ----------------------------
INSERT INTO `weitair_express_template_item` VALUES ('10000', '0', '', '0', '0', '0', '0', '2020-08-03 08:32:37', '2020-08-03 08:32:37', null);

-- ----------------------------
-- Table structure for weitair_failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `weitair_failed_jobs`;
CREATE TABLE `weitair_failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of weitair_failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for weitair_feedback
-- ----------------------------
DROP TABLE IF EXISTS `weitair_feedback`;
CREATE TABLE `weitair_feedback` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '反馈分类',
  `contact` varchar(64) NOT NULL DEFAULT '' COMMENT '联系方式',
  `content` varchar(255) NOT NULL COMMENT '反馈内容',
  `feedback_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '反馈时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10004 DEFAULT CHARSET=utf8mb4 COMMENT='用户反馈';

-- ----------------------------
-- Records of weitair_feedback
-- ----------------------------
INSERT INTO `weitair_feedback` VALUES ('10001', '0', ' ', ' ', '0', '2019-11-18 01:36:57', '2019-11-18 01:36:57', '2019-11-18 01:36:50');
INSERT INTO `weitair_feedback` VALUES ('10002', '10000', '18586865559', '测试测试测试测试测试', '1597985223', '2020-08-21 12:47:03', '2020-08-21 15:49:57', '2020-08-21 15:49:57');
INSERT INTO `weitair_feedback` VALUES ('10003', '10002', '13608533690', '海报生成，选择图片勾选确认。', '1598007419', '2020-08-21 18:56:59', '2020-08-21 18:56:59', null);

-- ----------------------------
-- Table structure for weitair_feedback_category
-- ----------------------------
DROP TABLE IF EXISTS `weitair_feedback_category`;
CREATE TABLE `weitair_feedback_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分类名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序(越小越靠前)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8mb4 COMMENT='反馈分类';

-- ----------------------------
-- Records of weitair_feedback_category
-- ----------------------------
INSERT INTO `weitair_feedback_category` VALUES ('10000', '其他问题', '104', '2019-11-16 03:27:13', '2020-06-10 00:04:04', null);
INSERT INTO `weitair_feedback_category` VALUES ('10001', '产品质量问题(功能优化/新的想法)', '100', '2019-11-17 23:46:09', '2019-11-17 23:51:52', null);
INSERT INTO `weitair_feedback_category` VALUES ('10002', '故障反馈(功能不可用)', '101', '2019-11-17 23:51:11', '2019-11-17 23:52:08', null);
INSERT INTO `weitair_feedback_category` VALUES ('10003', '提现失败或延时', '103', '2020-06-09 01:15:10', '2020-06-09 01:15:10', null);

-- ----------------------------
-- Table structure for weitair_goods
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods`;
CREATE TABLE `weitair_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类',
  `goods_no` varchar(128) NOT NULL DEFAULT '' COMMENT '商品编号',
  `goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `subtitle` varchar(128) NOT NULL DEFAULT '' COMMENT '副标题',
  `unit` varchar(32) NOT NULL DEFAULT '' COMMENT '单位',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销售价',
  `line_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '划线价(单位：分)',
  `min_quantity` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '起购数量',
  `quota_quantity` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '限购数量(0：不限购)',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '总库存',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际销量',
  `sales_init` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '虚拟销量',
  `sku_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '规格类型(10：单规格、20：多规格)',
  `distribution_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否开启分销(10:未开启, 20: 开启)',
  `distribution_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '分销佣金类型(10: 百分比, 20: 固定金额)',
  `sales_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上架时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `content` text NOT NULL COMMENT '商品详细',
  `is_express` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否支持快递配送',
  `is_local` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否支持同城配送',
  `is_fetch` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否支持上门自提',
  `express_template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递运费模板ID',
  `local_template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同城运费模板ID',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览量',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `goods_no` (`goods_no`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10039 DEFAULT CHARSET=utf8mb4 COMMENT='商品';

-- ----------------------------
-- Records of weitair_goods
-- ----------------------------
INSERT INTO `weitair_goods` VALUES ('10012', '10005', '2019101852102505', '', '', '', '', '0', '0', '1', '0', '0', '0', '0', '0', '0', '10', '0', '0', '', '10', '10', '10', '0', '0', '0', '0', '2019-10-18 15:47:48', '2020-06-23 06:07:36', '2019-12-29 17:36:27');

-- ----------------------------
-- Table structure for weitair_goods_distribution
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_distribution`;
CREATE TABLE `weitair_goods_distribution` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `distribution_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '分销佣金类型(10: 百分比, 20: 固定金额)',
  `level_one` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分销佣金',
  `level_two` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分销佣金',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10011 DEFAULT CHARSET=utf8mb4 COMMENT='商品分销设置';

-- ----------------------------
-- Records of weitair_goods_distribution
-- ----------------------------
INSERT INTO `weitair_goods_distribution` VALUES ('10000', '0', '0', '0', '0', '2020-06-03 18:25:45', '2020-06-07 04:05:27', '2020-06-07 04:05:25');

-- ----------------------------
-- Table structure for weitair_goods_group
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_group`;
CREATE TABLE `weitair_goods_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分组名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否启用(10：否、20：是)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10014 DEFAULT CHARSET=utf8mb4 COMMENT='商品分组';

-- ----------------------------
-- Records of weitair_goods_group
-- ----------------------------
INSERT INTO `weitair_goods_group` VALUES ('10000', '', '0', '10', '2020-08-08 11:48:52', '2020-08-08 11:49:02', '2020-08-08 11:49:00');

-- ----------------------------
-- Table structure for weitair_goods_group_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_group_pivot`;
CREATE TABLE `weitair_goods_group_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `group_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分组ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4 COMMENT='商品分组中间表';

-- ----------------------------
-- Records of weitair_goods_group_pivot
-- ----------------------------
INSERT INTO `weitair_goods_group_pivot` VALUES ('10000', '0', '0', '2020-08-09 07:33:44', '2020-08-09 07:33:44', '2020-08-09 07:33:43');

-- ----------------------------
-- Table structure for weitair_goods_history
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_history`;
CREATE TABLE `weitair_goods_history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `view_total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
  `view_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10228 DEFAULT CHARSET=utf8mb4 COMMENT='商品浏览历史';

-- ----------------------------
-- Records of weitair_goods_history
-- ----------------------------
INSERT INTO `weitair_goods_history` VALUES ('10004', '0', '0', '0', '0', '2019-10-28 12:57:41', '2019-10-28 12:59:03', '2019-10-28 12:59:01');

-- ----------------------------
-- Table structure for weitair_goods_images
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_images`;
CREATE TABLE `weitair_goods_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10115 DEFAULT CHARSET=utf8mb4 COMMENT='商品图片';

-- ----------------------------
-- Records of weitair_goods_images
-- ----------------------------
INSERT INTO `weitair_goods_images` VALUES ('10000', '0', ' ', '2020-06-07 04:05:55', '2020-06-07 04:05:55', '2020-06-07 04:05:53');

-- ----------------------------
-- Table structure for weitair_goods_like
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_like`;
CREATE TABLE `weitair_goods_like` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `add_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10016 DEFAULT CHARSET=utf8mb4 COMMENT='商品收藏';

-- ----------------------------
-- Records of weitair_goods_like
-- ----------------------------
INSERT INTO `weitair_goods_like` VALUES ('10000', '0', '0', '0', '2019-10-26 11:30:41', '2019-10-28 12:59:18', '2019-10-28 12:59:16');

-- ----------------------------
-- Table structure for weitair_goods_sku
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_sku`;
CREATE TABLE `weitair_goods_sku` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `sku_id` varchar(20) NOT NULL DEFAULT '' COMMENT 'sku_id',
  `sku_no` varchar(255) NOT NULL DEFAULT '' COMMENT 'sku编号',
  `sku_name` varchar(128) NOT NULL DEFAULT '' COMMENT 'sku名称',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '价格(单位：分)',
  `cost_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成本价(单位：分)',
  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '库存',
  `weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '重量(单位：克)',
  `points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分',
  `level_one` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '一级分销佣金',
  `level_two` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '二级分销佣金',
  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku_id` (`sku_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10316 DEFAULT CHARSET=utf8mb4 COMMENT='商品SKU';

-- ----------------------------
-- Records of weitair_goods_sku
-- ----------------------------
INSERT INTO `weitair_goods_sku` VALUES ('10283', '0', '', '', '', '', '0', '0', '0', '0', '0', '0', '0', '0', '2020-08-15 02:05:42', '2020-08-15 02:05:53', '2020-08-15 02:05:51');

-- ----------------------------
-- Table structure for weitair_goods_sku_value
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_sku_value`;
CREATE TABLE `weitair_goods_sku_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(11) NOT NULL DEFAULT '0' COMMENT 'SKU_ID',
  `spec_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规格ID',
  `spec_value_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规格值ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10018 DEFAULT CHARSET=utf8mb4 COMMENT='商品SKU值';

-- ----------------------------
-- Records of weitair_goods_sku_value
-- ----------------------------
INSERT INTO `weitair_goods_sku_value` VALUES ('10000', '0', '0', '0', '0', '2019-10-14 13:18:00', '2020-06-07 04:07:47', '2020-06-07 04:07:46');

-- ----------------------------
-- Table structure for weitair_goods_support
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_support`;
CREATE TABLE `weitair_goods_support` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `support_name` varchar(32) NOT NULL DEFAULT '' COMMENT '支持名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10003 DEFAULT CHARSET=utf8mb4 COMMENT='支持模板';

-- ----------------------------
-- Records of weitair_goods_support
-- ----------------------------
INSERT INTO `weitair_goods_support` VALUES ('10000', ' ', '', '0', '0', '2020-06-24 17:07:12', '2020-06-24 23:56:40', '2020-06-24 17:07:11');

-- ----------------------------
-- Table structure for weitair_goods_support_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_goods_support_pivot`;
CREATE TABLE `weitair_goods_support_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `support_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支持ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10013 DEFAULT CHARSET=utf8mb4 COMMENT='商品支持中间表';

-- ----------------------------
-- Records of weitair_goods_support_pivot
-- ----------------------------
INSERT INTO `weitair_goods_support_pivot` VALUES ('10000', '0', '0', '2020-06-24 17:06:39', '2020-06-24 17:06:43', '2020-06-24 17:06:37');

-- ----------------------------
-- Table structure for weitair_group
-- ----------------------------
DROP TABLE IF EXISTS `weitair_group`;
CREATE TABLE `weitair_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(32) NOT NULL DEFAULT '' COMMENT '分组名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否启用(10：否、20：是)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10011 DEFAULT CHARSET=utf8mb4 COMMENT='商品分组';

-- ----------------------------
-- Records of weitair_group
-- ----------------------------
INSERT INTO `weitair_group` VALUES ('10000', '', '0', '10', '2020-08-08 11:48:52', '2020-08-08 11:49:02', '2020-08-08 11:49:00');

-- ----------------------------
-- Table structure for weitair_invite
-- ----------------------------
DROP TABLE IF EXISTS `weitair_invite`;
CREATE TABLE `weitair_invite` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被邀请人上级用户ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '被邀请用户ID',
  `level` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '被邀请人上级用户分销等级',
  `invite_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '邀请时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40192 DEFAULT CHARSET=utf8mb4 COMMENT='邀请表';

-- ----------------------------
-- Records of weitair_invite
-- ----------------------------
INSERT INTO `weitair_invite` VALUES ('40164', '0', '0', '0', '0', '2019-12-27 02:48:31', '2019-12-27 02:48:31', '2019-12-27 02:48:28');
INSERT INTO `weitair_invite` VALUES ('40165', '10002', '10007', '1', '1597819741', '2020-08-19 14:49:01', '2020-08-19 14:49:01', null);
INSERT INTO `weitair_invite` VALUES ('40166', '10002', '10008', '1', '1597821484', '2020-08-19 15:18:04', '2020-08-19 15:18:04', null);
INSERT INTO `weitair_invite` VALUES ('40167', '10002', '10009', '1', '1597822584', '2020-08-19 15:36:24', '2020-08-19 15:36:24', null);
INSERT INTO `weitair_invite` VALUES ('40168', '10002', '10010', '1', '1597828106', '2020-08-19 17:08:26', '2020-08-19 17:08:26', null);
INSERT INTO `weitair_invite` VALUES ('40169', '10013', '10014', '1', '1597993626', '2020-08-21 15:07:06', '2020-08-21 15:07:06', null);
INSERT INTO `weitair_invite` VALUES ('40170', '10013', '10015', '1', '1597993678', '2020-08-21 15:07:58', '2020-08-21 15:07:58', null);
INSERT INTO `weitair_invite` VALUES ('40171', '10013', '10016', '1', '1597993711', '2020-08-21 15:08:31', '2020-08-21 15:08:31', null);
INSERT INTO `weitair_invite` VALUES ('40172', '10013', '10017', '1', '1597995026', '2020-08-21 15:30:26', '2020-08-21 15:30:26', null);
INSERT INTO `weitair_invite` VALUES ('40173', '10013', '10018', '1', '1597996550', '2020-08-21 15:55:50', '2020-08-21 15:55:50', null);
INSERT INTO `weitair_invite` VALUES ('40174', '10007', '10019', '1', '1598004765', '2020-08-21 18:12:45', '2020-08-21 18:12:45', null);
INSERT INTO `weitair_invite` VALUES ('40175', '10002', '10019', '2', '1598004765', '2020-08-21 18:12:45', '2020-08-21 18:12:45', null);
INSERT INTO `weitair_invite` VALUES ('40176', '10002', '10036', '1', '1599460027', '2020-09-07 14:27:07', '2020-09-07 14:27:07', null);
INSERT INTO `weitair_invite` VALUES ('40177', '10019', '10038', '1', '1599624848', '2020-09-09 12:14:08', '2020-09-09 12:14:08', null);
INSERT INTO `weitair_invite` VALUES ('40178', '10007', '10038', '2', '1599624848', '2020-09-09 12:14:08', '2020-09-09 12:14:08', null);
INSERT INTO `weitair_invite` VALUES ('40179', '10002', '10038', '3', '1599624848', '2020-09-09 12:14:08', '2020-09-09 12:14:08', null);
INSERT INTO `weitair_invite` VALUES ('40180', '10013', '10046', '1', '1600241628', '2020-09-16 15:33:48', '2020-09-16 15:33:48', null);
INSERT INTO `weitair_invite` VALUES ('40181', '10013', '10047', '1', '1600320488', '2020-09-17 13:28:08', '2020-09-17 13:28:08', null);
INSERT INTO `weitair_invite` VALUES ('40182', '10013', '10049', '1', '1600834447', '2020-09-23 12:14:07', '2020-09-23 12:14:07', null);
INSERT INTO `weitair_invite` VALUES ('40183', '10002', '10050', '1', '1600934692', '2020-09-24 16:04:52', '2020-09-24 16:04:52', null);
INSERT INTO `weitair_invite` VALUES ('40184', '10019', '10052', '1', '1601115652', '2020-09-26 18:20:52', '2020-09-26 18:20:52', null);
INSERT INTO `weitair_invite` VALUES ('40185', '10007', '10052', '2', '1601115652', '2020-09-26 18:20:52', '2020-09-26 18:20:52', null);
INSERT INTO `weitair_invite` VALUES ('40186', '10002', '10052', '3', '1601115652', '2020-09-26 18:20:52', '2020-09-26 18:20:52', null);
INSERT INTO `weitair_invite` VALUES ('40187', '10019', '10053', '1', '1601187246', '2020-09-27 14:14:06', '2020-09-27 14:14:06', null);
INSERT INTO `weitair_invite` VALUES ('40188', '10007', '10053', '2', '1601187246', '2020-09-27 14:14:06', '2020-09-27 14:14:06', null);
INSERT INTO `weitair_invite` VALUES ('40189', '10002', '10053', '3', '1601187246', '2020-09-27 14:14:06', '2020-09-27 14:14:06', null);
INSERT INTO `weitair_invite` VALUES ('40190', '10002', '10054', '1', '1601690218', '2020-10-03 09:56:58', '2020-10-03 09:56:58', null);
INSERT INTO `weitair_invite` VALUES ('40191', '10013', '10055', '1', '1601729920', '2020-10-03 20:58:40', '2020-10-03 20:58:40', null);

-- ----------------------------
-- Table structure for weitair_invoice
-- ----------------------------
DROP TABLE IF EXISTS `weitair_invoice`;
CREATE TABLE `weitair_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '发票类型(10：个人、20：单位)',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '发票抬头',
  `tax_no` varchar(64) NOT NULL DEFAULT '' COMMENT '纳税人识别号',
  `bank_name` varchar(64) NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_account` varchar(64) NOT NULL DEFAULT '' COMMENT '银行账号',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10003 DEFAULT CHARSET=utf8mb4 COMMENT='发票';

-- ----------------------------
-- Records of weitair_invoice
-- ----------------------------
INSERT INTO `weitair_invoice` VALUES ('10000', '0', '0', '', '', '', '', '', '', '2019-11-09 01:14:55', '2020-06-07 04:09:30', '2020-06-07 04:09:28');

-- ----------------------------
-- Table structure for weitair_jobs
-- ----------------------------
DROP TABLE IF EXISTS `weitair_jobs`;
CREATE TABLE `weitair_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `weitair_jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of weitair_jobs
-- ----------------------------
INSERT INTO `weitair_jobs` VALUES ('61', 'default', '{\"displayName\":\"App\\\\Jobs\\\\OrderReceive\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":5,\"delay\":null,\"timeout\":30,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderReceive\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\OrderReceive\\\":13:{s:5:\\\"tries\\\";i:5;s:7:\\\"timeout\\\";i:30;s:8:\\\"\\u0000*\\u0000order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:22:\\\"App\\\\Logics\\\\Admin\\\\Order\\\";s:2:\\\"id\\\";i:10097;s:9:\\\"relations\\\";a:6:{i:0;s:5:\\\"goods\\\";i:1;s:7:\\\"invoice\\\";i:2;s:9:\\\"logistics\\\";i:3;s:17:\\\"logistics.express\\\";i:4;s:5:\\\"fetch\\\";i:5;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:10:\\\"\\u0000*\\u0000setting\\\";a:6:{s:5:\\\"stock\\\";i:20;s:5:\\\"close\\\";i:15;s:7:\\\"invoice\\\";i:10;s:11:\\\"sms_receive\\\";s:0:\\\"\\\";s:12:\\\"sms_receiver\\\";s:23:\\\"17585176669,18586865559\\\";s:7:\\\"receive\\\";i:7;}s:10:\\\"\\u0000*\\u0000receive\\\";i:7;s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";i:604800;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', '0', null, '1602916499', '1602311699');
INSERT INTO `weitair_jobs` VALUES ('66', 'default', '{\"displayName\":\"App\\\\Jobs\\\\OrderReceive\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":5,\"delay\":null,\"timeout\":30,\"timeoutAt\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\OrderReceive\",\"command\":\"O:21:\\\"App\\\\Jobs\\\\OrderReceive\\\":13:{s:5:\\\"tries\\\";i:5;s:7:\\\"timeout\\\";i:30;s:8:\\\"\\u0000*\\u0000order\\\";O:45:\\\"Illuminate\\\\Contracts\\\\Database\\\\ModelIdentifier\\\":4:{s:5:\\\"class\\\";s:22:\\\"App\\\\Logics\\\\Admin\\\\Order\\\";s:2:\\\"id\\\";i:10099;s:9:\\\"relations\\\";a:6:{i:0;s:5:\\\"goods\\\";i:1;s:7:\\\"invoice\\\";i:2;s:9:\\\"logistics\\\";i:3;s:17:\\\"logistics.express\\\";i:4;s:5:\\\"fetch\\\";i:5;s:4:\\\"user\\\";}s:10:\\\"connection\\\";s:5:\\\"mysql\\\";}s:10:\\\"\\u0000*\\u0000setting\\\";a:6:{s:5:\\\"stock\\\";i:20;s:5:\\\"close\\\";i:15;s:7:\\\"invoice\\\";i:10;s:11:\\\"sms_receive\\\";s:0:\\\"\\\";s:12:\\\"sms_receiver\\\";s:23:\\\"17585176669,18586865559\\\";s:7:\\\"receive\\\";i:7;}s:10:\\\"\\u0000*\\u0000receive\\\";i:7;s:6:\\\"\\u0000*\\u0000job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:5:\\\"delay\\\";i:604800;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}', '0', null, '1603185171', '1602580371');

-- ----------------------------
-- Table structure for weitair_local_template
-- ----------------------------
DROP TABLE IF EXISTS `weitair_local_template`;
CREATE TABLE `weitair_local_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '模板名称',
  `free` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否包邮(10：不包邮、20：包邮)',
  `method` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '配送方式(10：按距离、20：按重量)',
  `distance` smallint(3) unsigned NOT NULL DEFAULT '10' COMMENT '最大可配送距离(Km)',
  `weight` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '最大可配送重量(Kg)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10011 DEFAULT CHARSET=utf8mb4 COMMENT='同城配送模板';

-- ----------------------------
-- Records of weitair_local_template
-- ----------------------------
INSERT INTO `weitair_local_template` VALUES ('10000', '', '10', '10', '10', '0', '0', '2020-08-03 08:33:52', '2020-08-03 13:38:18', '2020-08-03 13:38:15');
INSERT INTO `weitair_local_template` VALUES ('10010', '默认', '10', '10', '30', '20', '100', '2020-08-15 05:06:12', '2020-10-21 11:40:33', null);

-- ----------------------------
-- Table structure for weitair_local_template_item
-- ----------------------------
DROP TABLE IF EXISTS `weitair_local_template_item`;
CREATE TABLE `weitair_local_template_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `local_template_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '同城配送模板ID',
  `min` double unsigned NOT NULL DEFAULT '0' COMMENT '区间开始',
  `max` double unsigned NOT NULL DEFAULT '0' COMMENT '区间结束',
  `fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '加价费用(元)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '添加时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10067 DEFAULT CHARSET=utf8mb4 COMMENT='同城配送模板距离策略';

-- ----------------------------
-- Records of weitair_local_template_item
-- ----------------------------
INSERT INTO `weitair_local_template_item` VALUES ('10000', '0', '0', '0', '0', '2020-08-03 08:34:54', '2020-08-03 08:34:54', null);
INSERT INTO `weitair_local_template_item` VALUES ('10015', '10010', '0', '3', '1000', '2020-08-15 05:06:12', '2020-08-21 18:12:11', '2020-08-21 18:12:11');
INSERT INTO `weitair_local_template_item` VALUES ('10016', '10010', '3', '5', '2000', '2020-08-15 05:06:12', '2020-08-21 18:12:11', '2020-08-21 18:12:11');
INSERT INTO `weitair_local_template_item` VALUES ('10017', '10010', '5', '10', '3000', '2020-08-15 05:06:12', '2020-08-21 18:12:11', '2020-08-21 18:12:11');
INSERT INTO `weitair_local_template_item` VALUES ('10018', '10010', '10', '20', '5000', '2020-08-15 05:06:12', '2020-08-21 18:12:11', '2020-08-21 18:12:11');
INSERT INTO `weitair_local_template_item` VALUES ('10019', '10010', '20', '30', '10000', '2020-08-15 05:06:12', '2020-08-21 18:12:11', '2020-08-21 18:12:11');
INSERT INTO `weitair_local_template_item` VALUES ('10020', '10010', '0', '3', '0', '2020-08-21 18:12:11', '2020-08-21 18:14:27', '2020-08-21 18:14:27');
INSERT INTO `weitair_local_template_item` VALUES ('10021', '10010', '3', '5', '1000', '2020-08-21 18:12:11', '2020-08-21 18:14:27', '2020-08-21 18:14:27');
INSERT INTO `weitair_local_template_item` VALUES ('10022', '10010', '5', '10', '2000', '2020-08-21 18:12:11', '2020-08-21 18:14:27', '2020-08-21 18:14:27');
INSERT INTO `weitair_local_template_item` VALUES ('10023', '10010', '10', '20', '3000', '2020-08-21 18:12:11', '2020-08-21 18:14:27', '2020-08-21 18:14:27');
INSERT INTO `weitair_local_template_item` VALUES ('10024', '10010', '20', '30', '10000', '2020-08-21 18:12:11', '2020-08-21 18:14:27', '2020-08-21 18:14:27');
INSERT INTO `weitair_local_template_item` VALUES ('10025', '10010', '0', '3', '0', '2020-08-21 18:14:27', '2020-08-24 01:05:31', '2020-08-24 01:05:31');
INSERT INTO `weitair_local_template_item` VALUES ('10026', '10010', '3', '5', '1000', '2020-08-21 18:14:27', '2020-08-24 01:05:31', '2020-08-24 01:05:31');
INSERT INTO `weitair_local_template_item` VALUES ('10027', '10010', '5', '10', '2000', '2020-08-21 18:14:27', '2020-08-24 01:05:31', '2020-08-24 01:05:31');
INSERT INTO `weitair_local_template_item` VALUES ('10028', '10010', '10', '20', '3000', '2020-08-21 18:14:27', '2020-08-24 01:05:31', '2020-08-24 01:05:31');
INSERT INTO `weitair_local_template_item` VALUES ('10029', '10010', '20', '30', '10000', '2020-08-21 18:14:27', '2020-08-24 01:05:31', '2020-08-24 01:05:31');
INSERT INTO `weitair_local_template_item` VALUES ('10030', '10010', '30', '50', '20000', '2020-08-21 18:14:27', '2020-08-24 01:05:31', '2020-08-24 01:05:31');
INSERT INTO `weitair_local_template_item` VALUES ('10031', '10010', '0', '3', '0', '2020-08-24 01:05:31', '2020-08-26 06:01:56', '2020-08-26 06:01:56');
INSERT INTO `weitair_local_template_item` VALUES ('10032', '10010', '3', '5', '1000', '2020-08-24 01:05:31', '2020-08-26 06:01:56', '2020-08-26 06:01:56');
INSERT INTO `weitair_local_template_item` VALUES ('10033', '10010', '5', '10', '2000', '2020-08-24 01:05:31', '2020-08-26 06:01:56', '2020-08-26 06:01:56');
INSERT INTO `weitair_local_template_item` VALUES ('10034', '10010', '10', '20', '3000', '2020-08-24 01:05:31', '2020-08-26 06:01:56', '2020-08-26 06:01:56');
INSERT INTO `weitair_local_template_item` VALUES ('10035', '10010', '20', '30', '10000', '2020-08-24 01:05:31', '2020-08-26 06:01:56', '2020-08-26 06:01:56');
INSERT INTO `weitair_local_template_item` VALUES ('10036', '10010', '30', '50', '20000', '2020-08-24 01:05:31', '2020-08-26 06:01:56', '2020-08-26 06:01:56');
INSERT INTO `weitair_local_template_item` VALUES ('10037', '10010', '0', '3', '0', '2020-08-26 06:01:56', '2020-09-09 01:44:17', '2020-09-09 01:44:17');
INSERT INTO `weitair_local_template_item` VALUES ('10038', '10010', '3', '5', '1000', '2020-08-26 06:01:56', '2020-09-09 01:44:17', '2020-09-09 01:44:17');
INSERT INTO `weitair_local_template_item` VALUES ('10039', '10010', '5', '10', '2000', '2020-08-26 06:01:56', '2020-09-09 01:44:17', '2020-09-09 01:44:17');
INSERT INTO `weitair_local_template_item` VALUES ('10040', '10010', '10', '20', '3000', '2020-08-26 06:01:56', '2020-09-09 01:44:17', '2020-09-09 01:44:17');
INSERT INTO `weitair_local_template_item` VALUES ('10041', '10010', '20', '30', '10000', '2020-08-26 06:01:56', '2020-09-09 01:44:17', '2020-09-09 01:44:17');
INSERT INTO `weitair_local_template_item` VALUES ('10042', '10010', '0', '3', '0', '2020-09-09 01:44:17', '2020-09-09 01:44:50', '2020-09-09 01:44:50');
INSERT INTO `weitair_local_template_item` VALUES ('10043', '10010', '3', '5', '1000', '2020-09-09 01:44:17', '2020-09-09 01:44:50', '2020-09-09 01:44:50');
INSERT INTO `weitair_local_template_item` VALUES ('10044', '10010', '5', '10', '2000', '2020-09-09 01:44:18', '2020-09-09 01:44:50', '2020-09-09 01:44:50');
INSERT INTO `weitair_local_template_item` VALUES ('10045', '10010', '10', '20', '3000', '2020-09-09 01:44:18', '2020-09-09 01:44:50', '2020-09-09 01:44:50');
INSERT INTO `weitair_local_template_item` VALUES ('10046', '10010', '20', '30', '10000', '2020-09-09 01:44:18', '2020-09-09 01:44:50', '2020-09-09 01:44:50');
INSERT INTO `weitair_local_template_item` VALUES ('10047', '10010', '0', '3', '0', '2020-09-09 01:44:50', '2020-09-28 18:13:42', '2020-09-28 18:13:42');
INSERT INTO `weitair_local_template_item` VALUES ('10048', '10010', '3', '5', '0', '2020-09-09 01:44:50', '2020-09-28 18:13:42', '2020-09-28 18:13:42');
INSERT INTO `weitair_local_template_item` VALUES ('10049', '10010', '5', '10', '0', '2020-09-09 01:44:50', '2020-09-28 18:13:42', '2020-09-28 18:13:42');
INSERT INTO `weitair_local_template_item` VALUES ('10050', '10010', '10', '20', '0', '2020-09-09 01:44:50', '2020-09-28 18:13:42', '2020-09-28 18:13:42');
INSERT INTO `weitair_local_template_item` VALUES ('10051', '10010', '20', '30', '0', '2020-09-09 01:44:50', '2020-09-28 18:13:42', '2020-09-28 18:13:42');
INSERT INTO `weitair_local_template_item` VALUES ('10052', '10010', '0', '3', '1000', '2020-09-28 18:13:42', '2020-09-28 18:17:23', '2020-09-28 18:17:23');
INSERT INTO `weitair_local_template_item` VALUES ('10053', '10010', '3', '5', '1500', '2020-09-28 18:13:42', '2020-09-28 18:17:23', '2020-09-28 18:17:23');
INSERT INTO `weitair_local_template_item` VALUES ('10054', '10010', '5', '10', '2000', '2020-09-28 18:13:42', '2020-09-28 18:17:23', '2020-09-28 18:17:23');
INSERT INTO `weitair_local_template_item` VALUES ('10055', '10010', '10', '20', '4000', '2020-09-28 18:13:42', '2020-09-28 18:17:23', '2020-09-28 18:17:23');
INSERT INTO `weitair_local_template_item` VALUES ('10056', '10010', '20', '30', '5000', '2020-09-28 18:13:42', '2020-09-28 18:17:23', '2020-09-28 18:17:23');
INSERT INTO `weitair_local_template_item` VALUES ('10057', '10010', '0', '3', '0', '2020-09-28 18:17:23', '2020-10-21 11:40:33', '2020-10-21 11:40:33');
INSERT INTO `weitair_local_template_item` VALUES ('10058', '10010', '3', '5', '1000', '2020-09-28 18:17:23', '2020-10-21 11:40:33', '2020-10-21 11:40:33');
INSERT INTO `weitair_local_template_item` VALUES ('10059', '10010', '5', '10', '1500', '2020-09-28 18:17:23', '2020-10-21 11:40:33', '2020-10-21 11:40:33');
INSERT INTO `weitair_local_template_item` VALUES ('10060', '10010', '10', '20', '2000', '2020-09-28 18:17:23', '2020-10-21 11:40:33', '2020-10-21 11:40:33');
INSERT INTO `weitair_local_template_item` VALUES ('10061', '10010', '20', '30', '3000', '2020-09-28 18:17:23', '2020-10-21 11:40:33', '2020-10-21 11:40:33');
INSERT INTO `weitair_local_template_item` VALUES ('10062', '10010', '0', '3', '0', '2020-10-21 11:40:33', '2020-10-21 11:40:33', null);
INSERT INTO `weitair_local_template_item` VALUES ('10063', '10010', '3', '5', '1000', '2020-10-21 11:40:33', '2020-10-21 11:40:33', null);
INSERT INTO `weitair_local_template_item` VALUES ('10064', '10010', '5', '10', '1500', '2020-10-21 11:40:33', '2020-10-21 11:40:33', null);
INSERT INTO `weitair_local_template_item` VALUES ('10065', '10010', '10', '20', '2000', '2020-10-21 11:40:33', '2020-10-21 11:40:33', null);
INSERT INTO `weitair_local_template_item` VALUES ('10066', '10010', '20', '30', '3000', '2020-10-21 11:40:33', '2020-10-21 11:40:33', null);

-- ----------------------------
-- Table structure for weitair_migrations
-- ----------------------------
DROP TABLE IF EXISTS `weitair_migrations`;
CREATE TABLE `weitair_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of weitair_migrations
-- ----------------------------
INSERT INTO `weitair_migrations` VALUES ('1', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `weitair_migrations` VALUES ('2', '2020_06_29_172810_create_jobs_table', '1');

-- ----------------------------
-- Table structure for weitair_module
-- ----------------------------
DROP TABLE IF EXISTS `weitair_module`;
CREATE TABLE `weitair_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `module_name` varchar(32) NOT NULL DEFAULT '' COMMENT '模块名称',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级ID',
  `icon` varchar(32) NOT NULL DEFAULT '' COMMENT '图标',
  `client_router` varchar(32) NOT NULL DEFAULT '' COMMENT '前端路由',
  `server_router` varchar(32) NOT NULL DEFAULT '' COMMENT '服务端路由',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '模块类型(10：目录、20：菜单、30：权限)',
  `extend` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否权限继承(10：否、20：是 )',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '模块简介',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10177 DEFAULT CHARSET=utf8mb4 COMMENT='系统模块';

-- ----------------------------
-- Records of weitair_module
-- ----------------------------
INSERT INTO `weitair_module` VALUES ('10000', '系统', '0', 'alibabacloud', '', '', '10', '10', '9', '', '2019-09-26 20:53:21', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10002', '账号', '10000', 'user_fill', '/system/admin', 'admin.index', '20', '10', '0', '', '2019-09-29 14:16:08', '2020-08-05 01:13:09', null);
INSERT INTO `weitair_module` VALUES ('10003', '模块', '10000', 'store', '/system/module', 'module.index', '20', '10', '2', '', '2019-09-29 14:16:08', '2020-06-22 23:04:06', null);
INSERT INTO `weitair_module` VALUES ('10004', '角色', '10000', 'card', '/system/role', 'role.index', '20', '10', '1', '', '2019-09-29 14:16:08', '2020-06-22 23:04:06', null);
INSERT INTO `weitair_module` VALUES ('10015', '首页', '0', 'dashboard', '/dashboard', 'index.index', '10', '20', '0', '', '2019-09-26 20:53:21', '2020-08-30 06:07:57', null);
INSERT INTO `weitair_module` VALUES ('10016', '日志', '10000', 'list', '/system/log', 'log.index', '20', '10', '3', '', '2019-09-29 14:16:08', '2020-06-22 23:04:06', null);
INSERT INTO `weitair_module` VALUES ('10029', '客户', '0', 'user_fill', '', '', '10', '10', '7', '', '2019-09-26 20:53:21', '2020-08-05 01:22:44', null);
INSERT INTO `weitair_module` VALUES ('10030', '资料', '10029', 'card', '/user', 'user.index', '20', '10', '0', '', '2019-09-26 20:25:24', '2020-09-22 08:29:36', null);
INSERT INTO `weitair_module` VALUES ('10031', '商品', '0', 'goods', '', '', '10', '10', '2', '', '2019-10-12 22:54:42', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10032', '商品', '10031', 'goods', '/goods', 'goods.index', '20', '10', '1', '', '2019-10-12 22:57:58', '2020-09-16 18:10:13', null);
INSERT INTO `weitair_module` VALUES ('10033', '分类', '10031', 'store', '/goods/category', 'goods/category.index', '20', '10', '2', '', '2019-10-12 23:03:05', '2020-08-26 05:50:50', null);
INSERT INTO `weitair_module` VALUES ('10034', '规格', '10031', 'detail', '/goods/spec', 'goods/spec.index', '20', '10', '4', '', '2019-10-14 13:49:37', '2020-08-26 05:50:50', null);
INSERT INTO `weitair_module` VALUES ('10035', '提交', '10002', '', '', 'admin.save', '30', '10', '0', '', '2019-10-17 01:45:26', '2020-08-05 01:13:21', null);
INSERT INTO `weitair_module` VALUES ('10037', '删除', '10002', '', '', 'admin.remove', '30', '10', '0', '', '2019-10-17 01:47:24', '2020-08-05 01:13:30', null);
INSERT INTO `weitair_module` VALUES ('10038', '提交', '10004', '', '', 'role.save', '30', '10', '0', '', '2019-10-17 01:48:15', '2020-06-22 22:40:52', null);
INSERT INTO `weitair_module` VALUES ('10040', '删除', '10004', '', '', 'role.remove', '30', '10', '0', '', '2019-10-17 01:49:06', '2020-06-22 22:40:53', null);
INSERT INTO `weitair_module` VALUES ('10041', '提交', '10003', '', '', 'module.save', '30', '10', '0', '', '2019-10-17 01:49:52', '2020-06-22 22:40:55', null);
INSERT INTO `weitair_module` VALUES ('10043', '删除', '10003', '', '', 'module.remove', '30', '10', '0', '', '2019-10-17 01:50:26', '2020-06-22 22:40:56', null);
INSERT INTO `weitair_module` VALUES ('10044', '删除', '10016', '', '', 'log.remove', '30', '10', '0', '', '2019-10-17 01:55:05', '2020-06-22 22:40:58', null);
INSERT INTO `weitair_module` VALUES ('10051', '提交', '10033', '', '', 'goods/category.save', '30', '10', '0', '', '2019-10-17 02:06:17', '2020-06-22 22:40:59', null);
INSERT INTO `weitair_module` VALUES ('10052', '删除', '10033', '', '', 'goods/category.remove', '30', '10', '0', '', '2019-10-17 02:06:31', '2020-06-22 22:41:00', null);
INSERT INTO `weitair_module` VALUES ('10053', '提交', '10034', '', '', 'goods/spec.save', '30', '10', '0', '', '2019-10-17 02:07:49', '2020-06-22 22:41:01', null);
INSERT INTO `weitair_module` VALUES ('10054', '删除', '10034', '', '', 'goods/spec.remove', '30', '10', '0', '', '2019-10-17 02:08:05', '2020-06-22 22:41:02', null);
INSERT INTO `weitair_module` VALUES ('10055', '提交', '10032', '', '', 'goods.save', '30', '10', '0', '', '2019-10-17 02:08:41', '2020-06-22 22:41:03', null);
INSERT INTO `weitair_module` VALUES ('10056', '删除', '10032', '', '', 'goods.remove', '30', '10', '0', '', '2019-10-17 02:08:55', '2020-06-22 22:41:05', null);
INSERT INTO `weitair_module` VALUES ('10057', '营销', '0', 'fund', '', '', '10', '10', '5', '', '2019-10-18 18:13:28', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10058', '优惠卷', '10057', 'coupon', '/market/coupon', 'market/coupon.index', '20', '10', '1', '', '2019-10-18 18:17:56', '2020-09-16 16:45:35', null);
INSERT INTO `weitair_module` VALUES ('10059', '订单', '0', 'cart_fill', '', '', '10', '10', '3', '', '2019-10-18 18:26:34', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10060', '商品', '10059', 'text', '/order', 'order.index', '20', '10', '1', '', '2019-10-18 18:28:17', '2020-09-16 17:47:42', null);
INSERT INTO `weitair_module` VALUES ('10063', '优惠卷领取', '10057', 'coupon', '/market/coupon/receive', 'market/coupon/receive.index', '20', '10', '2', '', '2019-10-19 03:49:32', '2020-09-16 16:45:46', null);
INSERT INTO `weitair_module` VALUES ('10064', '提交', '10058', '', '', 'market/coupon.save', '30', '10', '0', '', '2019-10-19 03:50:11', '2020-09-16 16:46:16', null);
INSERT INTO `weitair_module` VALUES ('10065', '删除', '10058', '', '', 'market/coupon.remove', '30', '10', '0', '', '2019-10-19 03:50:31', '2020-09-16 16:46:24', null);
INSERT INTO `weitair_module` VALUES ('10066', '删除', '10063', '', '', 'market/coupon/receive.remove', '30', '10', '0', '', '2019-10-21 01:53:49', '2020-09-16 16:46:38', null);
INSERT INTO `weitair_module` VALUES ('10070', '设置', '0', 'setting', '', '', '10', '10', '8', '', '2019-11-05 01:50:43', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10071', '系统', '10070', 'control', '/setting/system', 'setting.index', '20', '20', '0', '', '2019-11-05 01:58:54', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10072', '微信', '10070', 'wechat', '/setting/wechat', 'setting.index', '20', '20', '1', '', '2019-11-05 02:06:31', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10074', '应用', '10070', 'store', '/setting/app', 'setting.index', '20', '20', '8', '', '2019-11-05 03:23:49', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10082', '详细', '10030', '', '', 'user.detail', '30', '10', '0', '', '2019-12-08 03:10:52', '2020-06-22 22:41:13', null);
INSERT INTO `weitair_module` VALUES ('10083', '财务', '0', 'rmb', '', '', '10', '10', '4', '', '2019-12-08 03:31:46', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10084', '支付流水', '10083', 'detail', '/finance/payment', 'finance/payment.index', '20', '10', '1', '', '2019-12-08 03:33:48', '2020-09-16 17:27:15', null);
INSERT INTO `weitair_module` VALUES ('10085', '详细', '10084', '', '', 'finance/payment.detail', '30', '10', '0', '', '2019-12-08 03:36:30', '2020-09-16 17:27:23', null);
INSERT INTO `weitair_module` VALUES ('10086', '提现记录', '10083', 'detail', '/finance/cash', 'finance/cash.index', '20', '10', '2', '', '2019-12-18 16:52:25', '2020-09-16 17:27:34', null);
INSERT INTO `weitair_module` VALUES ('10087', '审核', '10086', '', '', 'finance/cash.audit', '30', '10', '0', '', '2019-12-18 16:53:40', '2020-09-16 17:27:52', null);
INSERT INTO `weitair_module` VALUES ('10088', '详细', '10060', '', '', 'order.detail', '30', '10', '0', '', '2019-12-22 01:54:36', '2020-06-22 22:41:19', null);
INSERT INTO `weitair_module` VALUES ('10089', '发货', '10060', '', '', 'order.shipment', '30', '10', '0', '', '2019-12-22 02:41:10', '2020-09-20 04:50:21', null);
INSERT INTO `weitair_module` VALUES ('10090', '评价', '10059', 'message', '/order/comment', 'order/comment.index', '20', '10', '3', '', '2019-12-22 06:02:36', '2020-08-17 17:26:05', null);
INSERT INTO `weitair_module` VALUES ('10091', '回复', '10090', '', '', 'order/comment.reply', '30', '10', '0', '', '2019-12-22 06:04:11', '2020-08-17 17:02:12', null);
INSERT INTO `weitair_module` VALUES ('10092', '删除', '10090', '', '', 'order/comment.remove', '30', '10', '0', '', '2019-12-22 06:04:48', '2020-08-17 17:02:25', null);
INSERT INTO `weitair_module` VALUES ('10097', '文章', '0', 'file', '', '', '10', '10', '6', '', '2020-06-08 04:05:44', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10098', '文章', '10097', 'file', '/article', 'article.index', '20', '10', '0', '', '2020-06-08 04:06:38', '2020-08-28 05:49:01', null);
INSERT INTO `weitair_module` VALUES ('10099', '分类', '10097', 'store', '/article/category', 'article/category.index', '20', '10', '1', '', '2020-06-08 04:07:09', '2020-08-28 05:49:01', null);
INSERT INTO `weitair_module` VALUES ('10100', '提交', '10098', '', '', 'article.save', '30', '10', '0', '', '2020-06-08 04:07:34', '2020-06-22 22:41:26', null);
INSERT INTO `weitair_module` VALUES ('10101', '删除', '10098', '', '', 'article.remove', '30', '10', '0', '', '2020-06-08 04:07:48', '2020-06-22 22:41:27', null);
INSERT INTO `weitair_module` VALUES ('10102', '提交', '10099', '', '', 'article/category.save', '30', '10', '0', '', '2020-06-08 04:08:05', '2020-06-22 22:41:28', null);
INSERT INTO `weitair_module` VALUES ('10103', '删除', '10099', '', '', 'article/category.remove', '30', '10', '0', '', '2020-06-08 04:08:19', '2020-06-22 22:41:29', null);
INSERT INTO `weitair_module` VALUES ('10104', '打印', '10070', 'printer', '/setting/prints', 'setting.index', '20', '20', '3', '', '2020-06-21 02:25:09', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10105', '补打小票', '10060', '', '', 'order.prints', '30', '10', '0', '', '2020-06-21 02:25:59', '2020-06-22 22:41:32', null);
INSERT INTO `weitair_module` VALUES ('10126', '反馈', '10029', 'list', '/user/feedback', 'user/feedback.index', '20', '10', '2', '', '2020-06-23 09:29:56', '2020-09-23 10:59:35', null);
INSERT INTO `weitair_module` VALUES ('10127', '删除', '10126', '', '', 'user/feedback.remove', '30', '10', '100', '', '2020-06-23 09:31:02', '2020-09-23 10:59:48', null);
INSERT INTO `weitair_module` VALUES ('10128', '支持', '10031', 'plus-square', '/goods/support', 'goods/support.index', '20', '10', '5', '', '2020-06-25 03:49:18', '2020-08-26 05:50:50', null);
INSERT INTO `weitair_module` VALUES ('10129', '提交', '10128', '', '', 'goods/support.save', '30', '10', '100', '', '2020-06-25 03:50:14', '2020-06-25 03:50:14', null);
INSERT INTO `weitair_module` VALUES ('10130', '删除', '10128', '', '', 'goods/support.remove', '30', '10', '100', '', '2020-06-25 03:50:30', '2020-06-25 03:50:30', null);
INSERT INTO `weitair_module` VALUES ('10131', '营销', '10070', 'fund', '/setting/market', 'setting.index', '20', '20', '5', '', '2020-07-07 04:27:34', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10132', '财务', '10070', 'rmb', '/setting/finance', 'setting.index', '20', '20', '4', '', '2020-07-11 02:21:43', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10138', '消息', '10070', 'message', '/setting/message', 'setting.index', '20', '20', '2', '', '2020-08-01 03:07:09', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10139', '店铺', '0', 'shop', '', '', '10', '10', '1', '', '2020-08-02 02:09:47', '2020-08-02 02:10:14', null);
INSERT INTO `weitair_module` VALUES ('10141', '门店', '10139', 'shop', '/shop/store', 'shop/store.index', '20', '10', '2', '', '2020-08-02 02:15:23', '2020-10-13 11:10:51', null);
INSERT INTO `weitair_module` VALUES ('10142', '提交', '10141', '', '', 'shop/store.save', '30', '10', '100', '', '2020-08-02 02:15:51', '2020-08-06 10:21:54', null);
INSERT INTO `weitair_module` VALUES ('10143', '删除', '10141', '', '', 'shop/store.remove', '30', '10', '100', '', '2020-08-02 02:16:06', '2020-08-06 10:22:04', null);
INSERT INTO `weitair_module` VALUES ('10147', '物流', '10070', 'deliver', '/setting/logistics', 'setting.index', '20', '20', '6', '', '2020-08-03 12:23:17', '2020-08-18 05:52:53', null);
INSERT INTO `weitair_module` VALUES ('10148', '地址', '10139', 'location', '/shop/address', 'shop/address.index', '20', '10', '3', '', '2020-08-05 05:14:42', '2020-10-13 11:10:51', null);
INSERT INTO `weitair_module` VALUES ('10149', '提交', '10148', '', '', 'shop/address.save', '30', '10', '100', '', '2020-08-05 05:15:11', '2020-08-12 14:46:48', null);
INSERT INTO `weitair_module` VALUES ('10150', '删除', '10148', '', '', 'shop/address.remove', '30', '10', '100', '', '2020-08-05 05:15:26', '2020-08-12 14:46:59', null);
INSERT INTO `weitair_module` VALUES ('10151', '装修', '10139', 'layout', '/shop/design', 'shop/design.index', '20', '10', '0', '', '2020-08-06 10:23:41', '2020-10-13 11:10:51', null);
INSERT INTO `weitair_module` VALUES ('10152', '提交', '10151', '', '', 'shop/design.save', '30', '10', '100', '', '2020-08-06 12:04:42', '2020-10-13 11:11:32', null);
INSERT INTO `weitair_module` VALUES ('10153', '分组', '10031', 'tags', '/goods/group', 'goods/group.index', '20', '10', '3', '', '2020-08-08 12:12:00', '2020-08-26 05:50:50', null);
INSERT INTO `weitair_module` VALUES ('10154', '提交', '10153', '', '', 'goods/group.save', '30', '10', '100', '', '2020-08-08 12:12:42', '2020-08-08 12:12:42', null);
INSERT INTO `weitair_module` VALUES ('10155', '删除', '10153', '', '', 'goods/group.remove', '30', '10', '100', '', '2020-08-08 12:13:06', '2020-08-08 12:13:06', null);
INSERT INTO `weitair_module` VALUES ('10156', '发票', '10059', 'invoice', '/order/invoice', 'order/invoice.index', '20', '10', '2', '', '2020-08-17 17:20:32', '2020-08-17 17:26:05', null);
INSERT INTO `weitair_module` VALUES ('10157', '开票', '10156', '', '', 'order/invoice.issue', '30', '10', '100', '', '2020-08-17 17:24:20', '2020-08-18 02:54:02', null);
INSERT INTO `weitair_module` VALUES ('10158', '分销商', '10057', 'tree', '/market/distribution', 'market/distribution.index', '20', '10', '3', '', '2020-08-21 06:09:06', '2020-09-16 16:45:55', null);
INSERT INTO `weitair_module` VALUES ('10159', '审核', '10158', '', '', 'market/distribution.auth', '30', '10', '100', '', '2020-08-21 06:09:31', '2020-09-16 16:46:57', null);
INSERT INTO `weitair_module` VALUES ('10160', '员工', '10139', 'user_fill', '/shop/employee', 'shop/employee.index', '20', '10', '4', '', '2020-08-21 06:10:21', '2020-10-13 11:10:51', null);
INSERT INTO `weitair_module` VALUES ('10161', '提交', '10160', '', '', 'shop/employee.save', '30', '10', '100', '', '2020-08-21 06:10:48', '2020-08-21 06:10:48', null);
INSERT INTO `weitair_module` VALUES ('10162', '删除', '10160', '', '', 'shop/employee.remove', '30', '10', '100', '', '2020-08-21 06:11:03', '2020-08-21 06:11:03', null);
INSERT INTO `weitair_module` VALUES ('10163', '单位', '10031', 'text_time', '/goods/unit', 'goods/unit.index', '20', '10', '6', '', '2020-08-26 05:50:46', '2020-08-26 05:50:50', null);
INSERT INTO `weitair_module` VALUES ('10164', '提交', '10163', '', '', 'goods/unit.save', '30', '10', '100', '', '2020-08-26 05:51:06', '2020-08-26 05:51:06', null);
INSERT INTO `weitair_module` VALUES ('10165', '删除', '10163', '', '', 'goods/unit.remove', '30', '10', '100', '', '2020-08-26 05:51:21', '2020-08-26 05:51:21', null);
INSERT INTO `weitair_module` VALUES ('10166', '横幅', '10097', 'image', '/article/banner', 'article/banner.index', '20', '10', '2', '', '2020-08-28 05:48:56', '2020-08-28 05:49:01', null);
INSERT INTO `weitair_module` VALUES ('10167', '提交', '10166', '', '', 'article/banner.save', '30', '10', '100', '', '2020-08-28 05:49:14', '2020-08-28 05:49:14', null);
INSERT INTO `weitair_module` VALUES ('10168', '删除', '10166', '', '', 'article/banner.remove', '30', '10', '100', '', '2020-08-28 05:49:26', '2020-08-28 05:49:26', null);
INSERT INTO `weitair_module` VALUES ('10169', '标签', '10029', 'tags', '/user/tag', 'user/tag.index', '20', '10', '1', '', '2020-09-22 08:28:52', '2020-09-22 08:29:36', null);
INSERT INTO `weitair_module` VALUES ('10170', '提交', '10169', '', '', 'user/tag.save', '30', '10', '100', '', '2020-09-22 08:29:11', '2020-09-22 08:29:11', null);
INSERT INTO `weitair_module` VALUES ('10171', '删除', '10169', '', '', 'user/tag.remove', '30', '10', '100', '', '2020-09-22 08:29:30', '2020-09-22 08:29:30', null);
INSERT INTO `weitair_module` VALUES ('10172', '编辑', '10030', '', '', 'user.edit', '30', '10', '100', '', '2020-09-28 14:38:50', '2020-09-28 14:38:50', null);
INSERT INTO `weitair_module` VALUES ('10173', '页面', '10139', 'file', '/shop/page', 'shop/page.index', '20', '10', '1', '', '2020-10-13 11:10:41', '2020-10-13 11:10:51', null);
INSERT INTO `weitair_module` VALUES ('10174', '提交', '10173', '', '', 'shop/page.save', '30', '10', '100', '', '2020-10-13 11:11:48', '2020-10-13 11:36:11', null);
INSERT INTO `weitair_module` VALUES ('10175', '删除', '10173', '', '', 'shop/page.remove', '30', '10', '100', '', '2020-10-13 11:12:07', '2020-10-13 11:12:07', null);

-- ----------------------------
-- Table structure for weitair_order
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order`;
CREATE TABLE `weitair_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `coupon_receive_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户优惠卷ID',
  `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '订单编号',
  `logistics_method` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '配送方式(10：快递发货、20：同城配送、30：上门自提)',
  `logistics_fee` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '运费',
  `goods_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品合计金额',
  `discount_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠金额',
  `payment_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '实际支付金额',
  `payment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `payment_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '支付状态(10：未支付、20：已支付)',
  `payment_channel` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '支付渠道(10：钱包、20：微信)',
  `shipment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `shipment_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '发货状态(10：未发货、20：已发货)',
  `receive_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '签收时间',
  `receive_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '签收状态(10：未签收、20：已签收)',
  `close_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '关闭时间',
  `finish_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单完成时间',
  `order_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `order_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '订单状态(-1：已关闭、0：已完成、1:待支付、2：待发货、3：待收货)',
  `comment_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '评论(10：未评论、20：已评论)',
  `invoice_status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '发票(10：不开票、20：开票)',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '订单来源(10：公众号、20：小程序)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_no` (`order_no`) USING BTREE,
  KEY `receive_status` (`receive_status`) USING BTREE,
  KEY `order_status` (`order_status`) USING BTREE,
  KEY `order_time` (`order_time`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `payment_status` (`payment_status`) USING BTREE,
  KEY `logistics_status` (`shipment_status`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10104 DEFAULT CHARSET=utf8mb4 COMMENT='订单';

-- ----------------------------
-- Records of weitair_order
-- ----------------------------
INSERT INTO `weitair_order` VALUES ('10064', '0', '0', ' ', '10', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '', '0', '2019-11-28 03:16:43', '2020-08-03 12:07:01', '2019-11-28 03:16:41');

-- ----------------------------
-- Table structure for weitair_order_comment
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_comment`;
CREATE TABLE `weitair_order_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '课程ID',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '评论内容',
  `comment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论时间',
  `reply_content` varchar(255) NOT NULL DEFAULT '' COMMENT '回复内容',
  `reply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `rate` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '打分',
  `top` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '置顶(10：否、20：是)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=utf8mb4 COMMENT='商品评论';

-- ----------------------------
-- Records of weitair_order_comment
-- ----------------------------
INSERT INTO `weitair_order_comment` VALUES ('10000', '0', '0', '0', ' ', '0', '', '0', '0', '0', '2019-11-27 14:40:55', '2019-11-27 14:40:55', '2019-11-27 14:40:53');

-- ----------------------------
-- Table structure for weitair_order_comment_images
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_comment_images`;
CREATE TABLE `weitair_order_comment_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_comment_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论ID',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10064 DEFAULT CHARSET=utf8mb4 COMMENT='评论图片';

-- ----------------------------
-- Records of weitair_order_comment_images
-- ----------------------------
INSERT INTO `weitair_order_comment_images` VALUES ('10054', '0', ' ', '2020-06-02 01:15:03', '2020-06-02 01:15:03', '2020-06-02 01:14:59');

-- ----------------------------
-- Table structure for weitair_order_fetch
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_fetch`;
CREATE TABLE `weitair_order_fetch` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `store_address_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自提点ID',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `begin_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自提时间区间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '自提时间区间',
  `address_name` varchar(255) NOT NULL DEFAULT '' COMMENT '自提点名称',
  `address` varchar(255) DEFAULT '' COMMENT '自提点地址',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10010 DEFAULT CHARSET=utf8mb4 COMMENT='订单自提';

-- ----------------------------
-- Records of weitair_order_fetch
-- ----------------------------
INSERT INTO `weitair_order_fetch` VALUES ('10000', '0', '0', '', '', '0', '0', '', '', '2020-08-11 01:23:46', '2020-08-11 01:23:46', '2020-08-11 01:23:44');

-- ----------------------------
-- Table structure for weitair_order_goods
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_goods`;
CREATE TABLE `weitair_order_goods` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',
  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品SKU',
  `goods_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品名称',
  `sku_name` varchar(128) NOT NULL DEFAULT '' COMMENT '商品SKU名称',
  `image` varchar(512) NOT NULL DEFAULT '' COMMENT '封面图片',
  `sales_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品价格',
  `cost_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '成本价',
  `weight` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品重量(单位：克)',
  `quantity` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '购买数量',
  `total` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '小计(sales_price * quantity) ',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `goods_sku_id` (`goods_sku_id`) USING BTREE,
  KEY `goods_id` (`goods_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10124 DEFAULT CHARSET=utf8mb4 COMMENT='订单商品';

-- ----------------------------
-- Records of weitair_order_goods
-- ----------------------------
INSERT INTO `weitair_order_goods` VALUES ('10074', '0', '0', '0', ' ', '', '', '0', '0', '0', '0', '0', '2019-11-28 03:17:23', '2020-06-07 04:11:47', '2020-06-07 04:11:45');

-- ----------------------------
-- Table structure for weitair_order_invoice
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_invoice`;
CREATE TABLE `weitair_order_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `category` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '发票类型(10：个人、20：单位)',
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '抬头内容',
  `tax_no` varchar(64) NOT NULL DEFAULT '' COMMENT '纳税人识别号',
  `bank_name` varchar(64) NOT NULL DEFAULT '' COMMENT '开户行',
  `bank_account` varchar(64) NOT NULL DEFAULT '' COMMENT '银行账号',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(64) NOT NULL DEFAULT '' COMMENT '邮箱',
  `tax` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '税金',
  `code` varchar(32) NOT NULL DEFAULT '' COMMENT '发票代码',
  `issue_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '开票时间',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '处理状态(10：未开票、20：已开票)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10007 DEFAULT CHARSET=utf8mb4 COMMENT='订单发票';

-- ----------------------------
-- Records of weitair_order_invoice
-- ----------------------------
INSERT INTO `weitair_order_invoice` VALUES ('10000', '0', '0', ' ', '', '', '', '', '', '0', '', '0', '10', '2019-11-09 01:16:33', '2020-06-07 04:11:56', '2020-06-07 04:11:55');

-- ----------------------------
-- Table structure for weitair_order_logistics
-- ----------------------------
DROP TABLE IF EXISTS `weitair_order_logistics`;
CREATE TABLE `weitair_order_logistics` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '联系人ID',
  `express_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '快递公司ID',
  `express_no` varchar(255) NOT NULL DEFAULT '' COMMENT '快递单号',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系人电话',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(64) NOT NULL DEFAULT '' COMMENT '区/县',
  `detail` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `num` varchar(32) NOT NULL DEFAULT '' COMMENT '门牌号',
  `lon` decimal(10,7) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` decimal(10,7) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `order_id` (`order_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10031 DEFAULT CHARSET=utf8mb4 COMMENT='订单物流';

-- ----------------------------
-- Records of weitair_order_logistics
-- ----------------------------
INSERT INTO `weitair_order_logistics` VALUES ('10000', '0', '0', '0', '', ' ', '', '', '', '', '', '', '0.0000000', '0.0000000', '2019-10-22 17:06:44', '2020-06-07 04:12:07', '2020-06-07 04:12:05');

-- ----------------------------
-- Table structure for weitair_page
-- ----------------------------
DROP TABLE IF EXISTS `weitair_page`;
CREATE TABLE `weitair_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL DEFAULT '' COMMENT '页面名称',
  `content` text NOT NULL COMMENT '内容',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10006 DEFAULT CHARSET=utf8mb4 COMMENT='主题页面';

-- ----------------------------
-- Records of weitair_page
-- ----------------------------
INSERT INTO `weitair_page` VALUES ('10000', ' ', '', '', '0', '10', '2020-07-15 00:00:10', '2020-07-15 00:00:13', '2020-07-15 00:00:11');

-- ----------------------------
-- Table structure for weitair_payment
-- ----------------------------
DROP TABLE IF EXISTS `weitair_payment`;
CREATE TABLE `weitair_payment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',
  `openid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户OPEN_ID',
  `transaction_id` varchar(64) NOT NULL DEFAULT '' COMMENT '微信支付交易ID',
  `payment_no` varchar(32) NOT NULL DEFAULT '' COMMENT '支付流水号',
  `payment_price` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付金额',
  `payment_channel` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '支付渠道(10：钱包、20：微信、30：提现)',
  `payment_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '支付时间',
  `order_type` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '订单类型(10：普通订单)',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT 'IP',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '支付状态(10：未支付、20：已支付)',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `source` tinyint(3) unsigned NOT NULL DEFAULT '20' COMMENT '订单来源(10：公众号、20：小程序)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `payment_no` (`payment_no`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10055 DEFAULT CHARSET=utf8mb4 COMMENT='支付流水';

-- ----------------------------
-- Records of weitair_payment
-- ----------------------------
INSERT INTO `weitair_payment` VALUES ('10000', '0', '0', '', '', '', '0', '0', '0', '10', '', '0', '', '20', '2019-09-27 17:40:37', '2020-06-22 04:09:30', '2019-10-12 16:50:37');

-- ----------------------------
-- Table structure for weitair_points
-- ----------------------------
DROP TABLE IF EXISTS `weitair_points`;
CREATE TABLE `weitair_points` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `points` smallint(10) NOT NULL DEFAULT '0' COMMENT '积分',
  `intro` varchar(32) NOT NULL DEFAULT '' COMMENT '说明',
  `record_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '记录时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10121 DEFAULT CHARSET=utf8mb4 COMMENT='积分记录';

-- ----------------------------
-- Records of weitair_points
-- ----------------------------
INSERT INTO `weitair_points` VALUES ('10000', '0', '0', '', '0', '2019-11-06 03:08:55', '2019-11-06 03:08:55', null);

-- ----------------------------
-- Table structure for weitair_printer
-- ----------------------------
DROP TABLE IF EXISTS `weitair_printer`;
CREATE TABLE `weitair_printer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '打印机名称',
  `sn` varchar(64) NOT NULL DEFAULT '' COMMENT '打印机编号',
  `key` varchar(64) NOT NULL DEFAULT '' COMMENT '飞蛾云打印机Key',
  `copies` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '打印联数',
  `label` varchar(32) NOT NULL DEFAULT '' COMMENT '标签',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：关闭、20：开启)',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10049 DEFAULT CHARSET=utf8mb4 COMMENT='打印机';

-- ----------------------------
-- Records of weitair_printer
-- ----------------------------
INSERT INTO `weitair_printer` VALUES ('10000', ' ', '', '', '1', '', '0', '100', '2020-06-19 16:31:35', '2020-06-19 16:31:41', '2020-06-19 16:31:39');

-- ----------------------------
-- Table structure for weitair_pv
-- ----------------------------
DROP TABLE IF EXISTS `weitair_pv`;
CREATE TABLE `weitair_pv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `client_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '客户端IP地址',
  `entry_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '进入时间',
  `quit_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '退出时间',
  `user_agent` text NOT NULL COMMENT '客户端',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10494 DEFAULT CHARSET=utf8mb4 COMMENT='访问量';

-- ----------------------------
-- Records of weitair_pv
-- ----------------------------
INSERT INTO `weitair_pv` VALUES ('10000', '0', '0', '0', '', '2020-08-28 15:38:49', '2020-08-28 15:38:53', '2020-08-28 15:38:51');

-- ----------------------------
-- Table structure for weitair_role
-- ----------------------------
DROP TABLE IF EXISTS `weitair_role`;
CREATE TABLE `weitair_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_name` varchar(32) NOT NULL DEFAULT '' COMMENT '角色名称',
  `intro` mediumtext NOT NULL COMMENT '角色简介',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 COMMENT='角色';

-- ----------------------------
-- Records of weitair_role
-- ----------------------------
INSERT INTO `weitair_role` VALUES ('10000', '管理员', '系统管理员角色，不可删除', '2019-09-14 01:03:47', '2019-09-14 01:03:47', null);

-- ----------------------------
-- Table structure for weitair_role_module
-- ----------------------------
DROP TABLE IF EXISTS `weitair_role_module`;
CREATE TABLE `weitair_role_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `module_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '模块ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`) USING BTREE,
  KEY `module_id` (`module_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=13691 DEFAULT CHARSET=utf8mb4 COMMENT='角色权限';

-- ----------------------------
-- Records of weitair_role_module
-- ----------------------------
INSERT INTO `weitair_role_module` VALUES ('13593', '10000', '10015', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13594', '10000', '10139', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13595', '10000', '10151', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13596', '10000', '10152', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13597', '10000', '10173', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13598', '10000', '10174', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13599', '10000', '10175', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13600', '10000', '10141', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13601', '10000', '10142', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13602', '10000', '10143', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13603', '10000', '10148', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13604', '10000', '10149', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13605', '10000', '10150', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13606', '10000', '10160', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13607', '10000', '10161', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13608', '10000', '10162', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13609', '10000', '10031', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13610', '10000', '10032', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13611', '10000', '10055', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13612', '10000', '10056', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13613', '10000', '10033', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13614', '10000', '10051', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13615', '10000', '10052', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13616', '10000', '10153', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13617', '10000', '10154', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13618', '10000', '10155', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13619', '10000', '10034', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13620', '10000', '10053', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13621', '10000', '10054', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13622', '10000', '10128', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13623', '10000', '10129', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13624', '10000', '10130', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13625', '10000', '10163', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13626', '10000', '10164', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13627', '10000', '10165', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13628', '10000', '10059', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13629', '10000', '10060', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13630', '10000', '10088', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13631', '10000', '10089', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13632', '10000', '10105', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13633', '10000', '10156', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13634', '10000', '10157', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13635', '10000', '10090', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13636', '10000', '10091', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13637', '10000', '10092', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13638', '10000', '10083', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13639', '10000', '10084', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13640', '10000', '10085', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13641', '10000', '10086', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13642', '10000', '10087', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13643', '10000', '10057', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13644', '10000', '10058', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13645', '10000', '10064', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13646', '10000', '10065', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13647', '10000', '10063', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13648', '10000', '10066', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13649', '10000', '10158', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13650', '10000', '10159', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13651', '10000', '10097', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13652', '10000', '10098', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13653', '10000', '10100', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13654', '10000', '10101', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13655', '10000', '10099', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13656', '10000', '10102', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13657', '10000', '10103', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13658', '10000', '10166', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13659', '10000', '10167', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13660', '10000', '10168', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13661', '10000', '10029', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13662', '10000', '10030', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13663', '10000', '10082', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13664', '10000', '10172', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13665', '10000', '10169', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13666', '10000', '10170', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13667', '10000', '10171', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13668', '10000', '10126', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13669', '10000', '10127', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13670', '10000', '10070', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13671', '10000', '10071', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13672', '10000', '10072', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13673', '10000', '10138', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13674', '10000', '10104', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13675', '10000', '10132', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13676', '10000', '10131', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13677', '10000', '10147', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13678', '10000', '10074', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13679', '10000', '10000', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13680', '10000', '10002', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13681', '10000', '10035', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13682', '10000', '10037', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13683', '10000', '10004', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13684', '10000', '10038', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13685', '10000', '10040', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13686', '10000', '10003', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13687', '10000', '10041', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13688', '10000', '10043', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13689', '10000', '10016', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);
INSERT INTO `weitair_role_module` VALUES ('13690', '10000', '10044', '2020-10-13 16:28:10', '2020-10-13 16:28:10', null);

-- ----------------------------
-- Table structure for weitair_rule
-- ----------------------------
DROP TABLE IF EXISTS `weitair_rule`;
CREATE TABLE `weitair_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `rule_name` varchar(64) NOT NULL DEFAULT '' COMMENT '名称',
  `content` longtext NOT NULL COMMENT '内容',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10008 DEFAULT CHARSET=utf8mb4 COMMENT='规则协议';

-- ----------------------------
-- Records of weitair_rule
-- ----------------------------
INSERT INTO `weitair_rule` VALUES ('10005', ' ', ' ', '0', '2019-11-18 03:22:32', '2019-11-18 03:22:37', '2019-11-18 03:22:35');

-- ----------------------------
-- Table structure for weitair_search
-- ----------------------------
DROP TABLE IF EXISTS `weitair_search`;
CREATE TABLE `weitair_search` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `keyword` varchar(128) NOT NULL DEFAULT '' COMMENT '关键词',
  `search_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '搜索时间',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4 COMMENT='搜索记录';

-- ----------------------------
-- Records of weitair_search
-- ----------------------------
INSERT INTO `weitair_search` VALUES ('10000', '0', ' ', '0', '2019-11-21 03:11:07', '2019-11-21 03:11:11', '2019-11-21 03:11:09');

-- ----------------------------
-- Table structure for weitair_setting
-- ----------------------------
DROP TABLE IF EXISTS `weitair_setting`;
CREATE TABLE `weitair_setting` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `category` varchar(32) NOT NULL DEFAULT '' COMMENT '分类',
  `key` varchar(32) NOT NULL DEFAULT '' COMMENT 'Key',
  `values` text NOT NULL COMMENT '内容',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_key` (`category`,`key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10851 DEFAULT CHARSET=utf8mb4 COMMENT='系统设置';

-- ----------------------------
-- Records of weitair_setting
-- ----------------------------
INSERT INTO `weitair_setting` VALUES ('10457', 'system', 'security', '{\"lock\":\"20\",\"limited_time_length\":15,\"fail_times\":3,\"lock_time_length\":15}', '2020-07-31 09:51:00', '2020-07-31 09:51:00', null);
INSERT INTO `weitair_setting` VALUES ('10488', 'market', 'invite', '{\"type\":[\"points\"],\"points\":50,\"points_limit\":5000,\"coupon\":[]}', '2020-08-04 12:52:01', '2020-08-04 12:52:01', null);
INSERT INTO `weitair_setting` VALUES ('10562', 'design', 'category', '[{\"id\":1,\"type\":\"navigation\",\"default\":true,\"disabled\":true,\"data\":{\"app_name\":\"应用名称\",\"app_skin\":\"#ffffff\",\"navigation_bar_text_style\":\"#000000\"}},{\"id\":2,\"type\":\"category\",\"default\":true,\"data\":{\"layout\":30}}]', '2020-08-07 13:26:18', '2020-08-07 13:26:18', null);
INSERT INTO `weitair_setting` VALUES ('10691', 'logistics', 'local', '{\"method\":10,\"distance\":10,\"weight\":10,\"item\":[{\"min\":0,\"max\":3,\"fee\":10},{\"min\":3,\"max\":5,\"fee\":20},{\"min\":5,\"max\":10,\"fee\":30}]}', '2020-08-12 17:03:14', '2020-08-12 17:03:14', null);
INSERT INTO `weitair_setting` VALUES ('10756', 'app', 'points', '{\"checkin\":[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"],\"content\":\"\"}', '2020-08-19 03:23:47', '2020-08-19 03:23:47', null);
INSERT INTO `weitair_setting` VALUES ('10757', 'finance', 'cash', '{\"cash_limit\":100,\"cash_fee_type\":10,\"cash_fee\":1,\"cash_lock\":15}', '2020-08-19 03:51:05', '2020-08-19 03:51:05', null);
INSERT INTO `weitair_setting` VALUES ('10777', 'logistics', 'free', '{\"status\":10,\"type\":20,\"limit\":5}', '2020-08-24 01:05:16', '2020-08-24 01:05:16', null);
INSERT INTO `weitair_setting` VALUES ('10780', 'logistics', 'base', '{\"method\":[20,30],\"shipping\":10,\"freight\":30,\"today_fetch\":10}', '2020-08-25 05:09:02', '2020-08-25 05:09:02', null);
INSERT INTO `weitair_setting` VALUES ('10787', 'design', 'mine', '[{\"id\":1,\"type\":\"navigation\",\"default\":true,\"disabled\":true,\"data\":{\"app_name\":\"应用名称\",\"app_skin\":\"#ffffff\",\"navigation_bar_text_style\":\"black\"}},{\"id\":2,\"type\":\"mine\",\"default\":true,\"data\":{\"background_image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/mine/20200807165554fd3592578.png\",\"color\":\"#FFFFFF\"}},{\"id\":3,\"type\":\"grid\",\"data\":{\"padding\":0,\"margin\":10,\"column\":4,\"style\":\"round\",\"background\":\"#fff\",\"color\":\"#353535\",\"images\":[{\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/202008071054389ccf17777.png\",\"link\":\"/pages/mine/points/index/index\",\"text\":\"积分中心\",\"label\":\"\",\"login\":true},{\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/2020080710544182d2c1538.png\",\"link\":\"/pages/mine/coupon/index\",\"text\":\"优惠卷\",\"label\":\"\",\"login\":true},{\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/20200807105447d87057143.png\",\"link\":\"/pages/mine/address/index\",\"text\":\"地址管理\",\"label\":\"\",\"login\":true},{\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/202008071054588b8200655.png\",\"link\":\"/pages/mine/history/index\",\"text\":\"浏览历史\",\"label\":\"\",\"login\":true},{\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/202008071055030b8da0829.png\",\"link\":\"/pages/mine/like/index\",\"text\":\"我的收藏\",\"label\":\"\",\"login\":true},{\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/202008071055145a2100017.png\",\"link\":\"/pages/mine/distribution/index/index\",\"text\":\"分销中心\",\"label\":\"\",\"login\":true},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/2020081707373235b093757.png\",\"link\":\"/pages/mine/invite/index\",\"text\":\"邀请用户\",\"login\":true},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/202008170737430fa979611.png\",\"link\":\"/pages/mine/feedback/index\",\"text\":\"反馈\",\"login\":false}],\"size\":50}},{\"id\":6,\"type\":\"line\",\"data\":{\"padding_top_bottom\":1,\"background\":\"#F6F6F6\",\"style\":\"solid\",\"border_color\":\"#ebedf0\",\"position\":\"center\",\"color\":\"#969799\",\"text\":\"店铺推荐\"}},{\"id\":5,\"type\":\"goods\",\"data\":{\"data\":10,\"category\":null,\"sort\":10,\"limit\":6,\"layout\":2,\"status\":[],\"background\":\"#f6f6f6\",\"field\":[\"goods_name\",\"subtitle\",\"sales_price\",\"line_price\",\"sales\"]}}]', '2020-08-26 06:08:05', '2020-08-26 06:08:05', null);
INSERT INTO `weitair_setting` VALUES ('10806', 'market', 'register', '{\"type\":[\"points\"],\"points\":100,\"coupon\":[]}', '2020-10-09 13:06:16', '2020-10-09 13:06:16', null);
INSERT INTO `weitair_setting` VALUES ('10808', 'design', 'cart', '[{\"id\":1,\"type\":\"navigation\",\"default\":true,\"disabled\":true,\"data\":{\"app_name\":\"应用名称\",\"app_skin\":\"#ffffff\",\"navigation_bar_text_style\":\"#000000\"}},{\"id\":2,\"type\":\"fixd\",\"default\":true,\"disabled\":true,\"data\":{}}]', '2020-10-09 17:04:24', '2020-10-09 17:04:24', null);
INSERT INTO `weitair_setting` VALUES ('10829', 'design', 'index', '[{\"id\":1,\"type\":\"navigation\",\"default\":true,\"data\":{\"app_name\":\"拾材餐舍\",\"app_skin\":\"#990000\",\"navigation_bar_text_style\":\"#ffffff\"}},{\"id\":2,\"type\":\"tabbar\",\"default\":true,\"data\":{\"background\":\"#FFFFFF\",\"color\":\"#646566\",\"color_active\":\"#353535\",\"item\":[{\"text\":\"首页\",\"link\":\"/pages/index/index\",\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/tabbar/202008071132128a0ea4979.png\",\"image_active\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/tabbar/20200807113209e19373656.png\"},{\"text\":\"购物车\",\"link\":\"/pages/cart/index\",\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/tabbar/20200807113325150969305.png\",\"image_active\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/tabbar/20200807113322a4a813594.png\"},{\"text\":\"我的\",\"link\":\"/pages/mine/index/index\",\"image\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/tabbar/202008071133189cb676911.png\",\"image_active\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/design/tabbar/20200807113315d2c1c2605.png\"}]}},{\"id\":4,\"type\":\"swiper\",\"data\":{\"height\":500,\"style\":\"plane\",\"background\":\"#000000\",\"indicatorDots\":true,\"indicatorColor\":\"#ffffff\",\"indicatorActiveColor\":\"#FFFFFF\",\"autoplay\":true,\"interval\":5000,\"images\":[{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/swiper/2020101614122739eb55155.jpg\",\"link\":\"\"},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/swiper/20201016143731db9020087.png\",\"link\":\"\"},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/swiper/20201016144314b1fba7543.jpg\",\"link\":\"\"},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/swiper/202010161443219e92d7863.jpg\",\"link\":\"\"}],\"padding\":0}},{\"id\":14,\"type\":\"notice\",\"data\":{\"padding_top_bottom\":0,\"background\":\"#990000\",\"color\":\"#FFFFFF\",\"content\":\"现在下单，三公里免费配送！超过三公里可减10元！\",\"icon\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/notice/20201016153215f69cf9128.png\"}},{\"id\":23,\"type\":\"grid\",\"data\":{\"margin\":0,\"column\":4,\"style\":\"square\",\"background\":\"#FFFFFF\",\"color\":\"#353535\",\"size\":60,\"images\":[{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/2020101613034818f5a0833.png\",\"link\":\"\",\"text\":\"非遗菜系\",\"login\":false},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/20201016130412ec1cb5853.png\",\"link\":\"\",\"text\":\"热卖推荐\",\"login\":false},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/20201016130420556950285.png\",\"link\":\"\",\"text\":\"福利折扣\",\"login\":false},{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/grid/2020101613042699e563090.png\",\"link\":\"\",\"text\":\"新品尝鲜\",\"login\":false}]}},{\"id\":29,\"type\":\"image\",\"data\":{\"padding_top_bottom\":0,\"padding_left_right\":0,\"background\":\"#fff\",\"images\":[{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/image/20201016151936963173073.png\",\"link\":\"\"}]}},{\"id\":28,\"type\":\"goods\",\"data\":{\"data\":10,\"goods\":[],\"category\":null,\"sort\":10,\"limit\":50,\"layout\":2,\"background\":\"#f6f6f6\",\"field\":[\"goods_name\",\"subtitle\",\"sales_price\",\"line_price\",\"sales\",\"stock\"]}},{\"id\":30,\"type\":\"image\",\"data\":{\"padding_top_bottom\":0,\"padding_left_right\":0,\"background\":\"#fff\",\"images\":[{\"image\":\"https://www-10caihao-com.oss-cn-chengdu.aliyuncs.com/upload/design/image/20201016152044fac320014.png\",\"link\":\"\"}]}}]', '2020-10-16 15:33:36', '2020-10-16 15:33:36', null);
INSERT INTO `weitair_setting` VALUES ('10834', 'storage', 'base', '{\"driver\":\"ali\",\"app_id\":\"LTAI2J8adqY86FEl\",\"app_secret\":\"z48JrYpgFpMGwHBEuP6m0Lb8rjY85W\",\"bucket\":\"demo-weitair-com\",\"endpoint\":\"oss-cn-chengdu.aliyuncs.com\",\"region\":\"-\",\"secret_id\":\"-\",\"secret_key\":\"-\",\"tencent_bucket\":\"-\"}', '2020-10-21 11:35:39', '2020-10-21 11:35:39', null);
INSERT INTO `weitair_setting` VALUES ('10835', 'system', 'base', '{\"system_name\":\"微态尔商城\",\"copyright\":\"©2018-2020 拾材餐舍 版权所有\",\"logo\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/console/logo/20201021113550fb2f38095.png\"}', '2020-10-21 11:35:51', '2020-10-21 11:35:51', null);
INSERT INTO `weitair_setting` VALUES ('10837', 'wechat', 'base', '{\"app_id\":\"-\",\"app_secret\":\"-\",\"qrcode\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/setting/qrcode/20201021113618567791191.jpg\"}', '2020-10-21 11:36:20', '2020-10-21 11:36:20', null);
INSERT INTO `weitair_setting` VALUES ('10838', 'wechat', 'wxapp', '{\"app_id\":\"-\",\"app_secret\":\"-\"}', '2020-10-21 11:36:27', '2020-10-21 11:36:27', null);
INSERT INTO `weitair_setting` VALUES ('10839', 'wechat', 'payment', '{\"mch_id\":\"-\",\"mch_key\":\"-\"}', '2020-10-21 11:36:36', '2020-10-21 11:36:36', null);
INSERT INTO `weitair_setting` VALUES ('10840', 'wechat', 'location', '{\"name\":\"-\",\"key\":\"-\"}', '2020-10-21 11:36:42', '2020-10-21 11:36:42', null);
INSERT INTO `weitair_setting` VALUES ('10843', 'message', 'wxapp', '{\"driver\":\"wxapp\",\"template\":[{\"key\":\"ORDER_SHIPMENT\",\"value\":\"-\",\"title\":\"订单发货通知\",\"detail\":\"订单编号,商品信息,快递公司,快递单号,收货地址\"},{\"key\":\"DISTRIBUTION_AUTH\",\"value\":\"-\",\"title\":\"分销商入驻审核通知\",\"detail\":\"审核状态,申请时间,备注信息\"}]}', '2020-10-21 11:37:14', '2020-10-21 11:37:14', null);
INSERT INTO `weitair_setting` VALUES ('10845', 'prints', 'base', '{\"status\":10,\"driver\":\"xpyun\",\"xpyun_user\":\"-\",\"xpyun_secret\":\"-\",\"feieyun_user\":\"-\",\"feieyun_secret\":\"-\",\"header\":\"-\",\"footer\":\"-%0A\"}', '2020-10-21 11:37:43', '2020-10-21 11:37:43', null);
INSERT INTO `weitair_setting` VALUES ('10846', 'market', 'distribution', '{\"distribution_status\":20,\"distribution_join\":20,\"distribution_type\":10,\"level_one\":15,\"level_two\":0,\"content\":\"\"}', '2020-10-21 11:39:23', '2020-10-21 11:39:23', null);
INSERT INTO `weitair_setting` VALUES ('10847', 'app', 'base', '{\"app_name\":\"微态尔商城\",\"copyright\":\"\"}', '2020-10-21 11:40:51', '2020-10-21 11:40:51', null);
INSERT INTO `weitair_setting` VALUES ('10848', 'app', 'order', '{\"stock\":20,\"close\":15,\"invoice\":10,\"sms_receive\":\"\",\"sms_receiver\":\"\",\"receive\":7}', '2020-10-21 11:40:58', '2020-10-21 11:40:58', null);
INSERT INTO `weitair_setting` VALUES ('10849', 'app', 'invite', '{\"image_list\":[{\"name\":\"https://demo-weitair-com.oss-cn-chengdu.aliyuncs.com/upload/invite/poster/20201021114150c67b31185.jpg\"}],\"title\":\"微态尔商城\",\"subtitle\":\"人人为我，我为人人\",\"content\":\"\"}', '2020-10-21 11:42:07', '2020-10-21 11:42:07', null);
INSERT INTO `weitair_setting` VALUES ('10850', 'message', 'sms', '{\"driver\":\"ali\",\"app_id\":\"-\",\"app_secret\":\"-\",\"sign\":\"-\",\"status\":\"10\",\"template\":[{\"name\":\"新订单通知\",\"key\":\"NEW_ORDER\",\"value\":\"-\",\"status\":20}]}', '2020-10-21 11:47:17', '2020-10-21 11:47:17', null);

-- ----------------------------
-- Table structure for weitair_spec
-- ----------------------------
DROP TABLE IF EXISTS `weitair_spec`;
CREATE TABLE `weitair_spec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '规格名称',
  `search` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否搜索属性(10：否、20：是)',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10004 DEFAULT CHARSET=utf8mb4 COMMENT='规格';

-- ----------------------------
-- Records of weitair_spec
-- ----------------------------
INSERT INTO `weitair_spec` VALUES ('10000', '', '10', '100', '2020-08-02 23:01:06', '2020-08-15 02:09:11', '2020-08-13 02:09:04');

-- ----------------------------
-- Table structure for weitair_spec_value
-- ----------------------------
DROP TABLE IF EXISTS `weitair_spec_value`;
CREATE TABLE `weitair_spec_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `spec_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '规格ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '规格值',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10019 DEFAULT CHARSET=utf8mb4 COMMENT='规格值';

-- ----------------------------
-- Records of weitair_spec_value
-- ----------------------------
INSERT INTO `weitair_spec_value` VALUES ('10000', '0', '', '0', '2020-08-02 23:01:22', '2020-10-21 11:45:15', '2020-08-15 02:09:25');

-- ----------------------------
-- Table structure for weitair_store
-- ----------------------------
DROP TABLE IF EXISTS `weitair_store`;
CREATE TABLE `weitair_store` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `store_name` varchar(128) NOT NULL DEFAULT '' COMMENT '门店名称',
  `contact` varchar(32) NOT NULL DEFAULT '' COMMENT '负责人',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系电话',
  `business` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '营业时间类型(10：全天、20：自定)',
  `business_begin` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '营业时间',
  `business_end` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '打烊时间',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '行政区',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态(10：休息、20：营业)',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '门店介绍',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8mb4 COMMENT='门店';

-- ----------------------------
-- Records of weitair_store
-- ----------------------------
INSERT INTO `weitair_store` VALUES ('10000', ' ', '', '', '10', '0', '0', '', '', '', '0.0000000', '0.0000000', '', '0', '0', '', '2019-12-27 00:04:13', '2019-12-27 00:04:13', '2019-12-27 00:04:11');

-- ----------------------------
-- Table structure for weitair_store_address
-- ----------------------------
DROP TABLE IF EXISTS `weitair_store_address`;
CREATE TABLE `weitair_store_address` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `address_name` varchar(64) NOT NULL DEFAULT '' COMMENT '自提点名称',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '联系电话',
  `business` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '营业时间类型(10：全天、20：自定)',
  `business_begin` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '营业时间',
  `business_end` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '打烊时间',
  `province` varchar(32) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(32) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(32) NOT NULL DEFAULT '' COMMENT '行政区',
  `lon` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '经度',
  `lat` varchar(32) NOT NULL DEFAULT '0.0000000' COMMENT '纬度',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '详细地址',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `is_fetch` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否自提地址(10：否、20：是)',
  `is_shipment` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否发货地址(10：否、20：是)',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '是否启用(10：否、20：是)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 COMMENT='门店地址库';

-- ----------------------------
-- Records of weitair_store_address
-- ----------------------------
INSERT INTO `weitair_store_address` VALUES ('10000', '', '', '10', '0', '0', '', '', '', '0.0000000', '0.0000000', '', '0', '10', '10', '10', '2020-08-05 04:59:18', '2020-08-05 04:59:26', '2020-08-05 04:59:24');

-- ----------------------------
-- Table structure for weitair_store_employee
-- ----------------------------
DROP TABLE IF EXISTS `weitair_store_employee`;
CREATE TABLE `weitair_store_employee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',
  `verify` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '是否核销人员(10：否、20：是)',
  `status` int(10) unsigned NOT NULL DEFAULT '10' COMMENT '是否启用(10：否、20：是)',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10005 DEFAULT CHARSET=utf8mb4 COMMENT='门店员工';

-- ----------------------------
-- Records of weitair_store_employee
-- ----------------------------
INSERT INTO `weitair_store_employee` VALUES ('10000', '0', '', '', '10', '10', '2020-08-21 03:38:04', '2020-08-21 03:38:08', '2020-08-21 03:38:06');

-- ----------------------------
-- Table structure for weitair_support
-- ----------------------------
DROP TABLE IF EXISTS `weitair_support`;
CREATE TABLE `weitair_support` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `support_name` varchar(32) NOT NULL DEFAULT '' COMMENT '支持名称',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '内容',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '10' COMMENT '状态(10：下线、20：上线)',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 COMMENT='支持模板';

-- ----------------------------
-- Records of weitair_support
-- ----------------------------
INSERT INTO `weitair_support` VALUES ('10000', ' ', '', '0', '0', '2020-06-24 17:07:12', '2020-06-24 23:56:40', '2020-06-24 17:07:11');

-- ----------------------------
-- Table structure for weitair_unit
-- ----------------------------
DROP TABLE IF EXISTS `weitair_unit`;
CREATE TABLE `weitair_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `unit` varchar(32) NOT NULL DEFAULT '' COMMENT '单位名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10011 DEFAULT CHARSET=utf8mb4 COMMENT='单位';

-- ----------------------------
-- Records of weitair_unit
-- ----------------------------
INSERT INTO `weitair_unit` VALUES ('10000', ' ', '0', '2020-08-25 01:40:00', '2020-08-25 01:40:00', '2020-08-25 01:39:59');
INSERT INTO `weitair_unit` VALUES ('10001', '只', '100', '2020-08-26 03:42:51', '2020-08-26 03:42:51', null);
INSERT INTO `weitair_unit` VALUES ('10002', '斤', '101', '2020-08-26 03:43:18', '2020-08-26 03:43:18', null);
INSERT INTO `weitair_unit` VALUES ('10003', '个', '102', '2020-08-26 03:43:25', '2020-08-26 03:43:25', null);
INSERT INTO `weitair_unit` VALUES ('10004', '瓶', '103', '2020-08-26 03:43:33', '2020-08-26 03:43:33', null);
INSERT INTO `weitair_unit` VALUES ('10005', '箱', '104', '2020-08-26 03:43:40', '2020-08-26 03:43:40', null);
INSERT INTO `weitair_unit` VALUES ('10006', '份', '105', '2020-08-26 03:43:52', '2020-08-26 03:43:52', null);
INSERT INTO `weitair_unit` VALUES ('10007', '套', '106', '2020-08-26 03:43:58', '2020-08-26 03:58:13', null);
INSERT INTO `weitair_unit` VALUES ('10008', 'test12', '107', '2020-08-26 03:44:46', '2020-08-26 03:44:54', '2020-08-26 03:44:54');
INSERT INTO `weitair_unit` VALUES ('10009', '阿斯蒂芬', '107', '2020-08-26 03:45:45', '2020-08-26 03:45:49', '2020-08-26 03:45:49');
INSERT INTO `weitair_unit` VALUES ('10010', '123', '107', '2020-08-26 03:58:16', '2020-08-26 03:58:19', '2020-08-26 03:58:19');

-- ----------------------------
-- Table structure for weitair_user
-- ----------------------------
DROP TABLE IF EXISTS `weitair_user`;
CREATE TABLE `weitair_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上级用户ID',
  `token` varchar(64) NOT NULL DEFAULT '' COMMENT '用户令牌',
  `session_key` varchar(64) NOT NULL DEFAULT '' COMMENT '小程序Session Key',
  `unionid` varchar(64) NOT NULL DEFAULT '' COMMENT 'unionid',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '昵称',
  `gender` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '性别(0：未知、1：男、2：女 )',
  `province` varchar(64) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(64) NOT NULL DEFAULT '' COMMENT '城市',
  `district` varchar(64) NOT NULL DEFAULT '' COMMENT '区/县',
  `avatar` varchar(512) NOT NULL DEFAULT '' COMMENT '头像',
  `points` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户积分余额',
  `bonus` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分销佣金余额',
  `register_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `last_login_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录的时间',
  `last_login_ip` varchar(64) NOT NULL DEFAULT '' COMMENT '最后登录的IP',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  KEY `token` (`token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10066 DEFAULT CHARSET=utf8mb4 COMMENT='用户';

-- ----------------------------
-- Records of weitair_user
-- ----------------------------
INSERT INTO `weitair_user` VALUES ('10000', '0', '', '', '', '', '0', '', '', '', '', '0', '0', '0', '0', '0', '2019-10-26 11:20:14', '2020-06-07 06:23:11', '2020-06-07 06:23:09');

-- ----------------------------
-- Table structure for weitair_user_tag
-- ----------------------------
DROP TABLE IF EXISTS `weitair_user_tag`;
CREATE TABLE `weitair_user_tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tag_name` varchar(64) NOT NULL DEFAULT '' COMMENT '标签名称',
  `sort` int(10) unsigned NOT NULL DEFAULT '100' COMMENT '排序',
  `intro` varchar(255) NOT NULL DEFAULT '' COMMENT '说明',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10009 DEFAULT CHARSET=utf8mb4 COMMENT='用户标签';

-- ----------------------------
-- Records of weitair_user_tag
-- ----------------------------
INSERT INTO `weitair_user_tag` VALUES ('10000', '', '100', '', '2020-09-22 09:39:58', '2020-09-22 09:40:21', '2020-09-22 09:40:18');

-- ----------------------------
-- Table structure for weitair_user_tag_pivot
-- ----------------------------
DROP TABLE IF EXISTS `weitair_user_tag_pivot`;
CREATE TABLE `weitair_user_tag_pivot` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签ID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10017 DEFAULT CHARSET=utf8mb4 COMMENT='用户标签中间表';

-- ----------------------------
-- Records of weitair_user_tag_pivot
-- ----------------------------
INSERT INTO `weitair_user_tag_pivot` VALUES ('10000', '0', '0', '2020-09-28 14:16:33', '2020-09-28 14:16:36', '2020-09-28 14:16:35');

-- ----------------------------
-- Table structure for weitair_user_wechat
-- ----------------------------
DROP TABLE IF EXISTS `weitair_user_wechat`;
CREATE TABLE `weitair_user_wechat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'OpenID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10002 DEFAULT CHARSET=utf8mb4 COMMENT='微信公众号';

-- ----------------------------
-- Records of weitair_user_wechat
-- ----------------------------
INSERT INTO `weitair_user_wechat` VALUES ('10001', '0', '', '2020-07-29 02:02:32', '2020-07-29 02:02:32', null);

-- ----------------------------
-- Table structure for weitair_user_wechat_app
-- ----------------------------
DROP TABLE IF EXISTS `weitair_user_wechat_app`;
CREATE TABLE `weitair_user_wechat_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT '小程序OpenID',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '删除时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `openid` (`openid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10069 DEFAULT CHARSET=utf8mb4 COMMENT='微信小程序';

-- ----------------------------
-- Records of weitair_user_wechat_app
-- ----------------------------
INSERT INTO `weitair_user_wechat_app` VALUES ('10003', '0', '', '2020-07-29 04:22:53', '2020-08-15 02:10:28', '2020-08-15 02:10:20');
