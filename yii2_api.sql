-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2017-07-17 18:51:58
-- 服务器版本： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii2_api`
--

-- --------------------------------------------------------

--
-- 表的结构 `ad`
--

DROP TABLE IF EXISTS `ad`;
CREATE TABLE IF NOT EXISTS `ad` (
`id` int(11) unsigned NOT NULL,
  `cid` int(10) NOT NULL,
  `tag` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ad`
--

INSERT INTO `ad` (`id`, `cid`, `tag`, `name`, `path`, `link`) VALUES
(1, 1, 'top_banner', '图一', '/images/slide1.png', ''),
(2, 1, 'top_banner', '图二', '/images/slide2.png', ''),
(3, 1, 'top_banner', '图三', '/images/slide3.png', ''),
(4, 1, 'top_banner', '图四', '/images/slide2.png', '');

-- --------------------------------------------------------

--
-- 表的结构 `ad_type`
--

DROP TABLE IF EXISTS `ad_type`;
CREATE TABLE IF NOT EXISTS `ad_type` (
`id` int(10) unsigned NOT NULL,
  `cname` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `ad_type`
--

INSERT INTO `ad_type` (`id`, `cname`) VALUES
(1, '首页顶部banner');

-- --------------------------------------------------------

--
-- 表的结构 `baoyang`
--

DROP TABLE IF EXISTS `baoyang`;
CREATE TABLE IF NOT EXISTS `baoyang` (
  `id` int(10) NOT NULL COMMENT '自增',
  `uid` int(10) NOT NULL COMMENT '用户ID',
  `car_id` int(10) NOT NULL COMMENT '车辆ID',
  `type` int(10) NOT NULL COMMENT '保养类别',
  `last_licheng` int(10) NOT NULL COMMENT '上次保养里程',
  `zhouqi` int(10) NOT NULL COMMENT '保养周期',
  `last_date` date NOT NULL COMMENT '上次保养日期',
  `content` text NOT NULL COMMENT '备注'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='保养项目';

-- --------------------------------------------------------

--
-- 表的结构 `baoyang_type`
--

DROP TABLE IF EXISTS `baoyang_type`;
CREATE TABLE IF NOT EXISTS `baoyang_type` (
`id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='保养类型';

--
-- 转存表中的数据 `baoyang_type`
--

INSERT INTO `baoyang_type` (`id`, `name`) VALUES
(1, '机油'),
(2, '机油滤芯'),
(3, '空气滤清器'),
(4, '汽油滤清器'),
(5, '变速箱油'),
(6, '转向助力油'),
(7, '火花塞'),
(8, '刹车油'),
(9, '防冻液'),
(10, '检查刹车片'),
(11, '轮胎换位'),
(12, '四轮定位'),
(13, '清洗喷油嘴'),
(14, '清洗油路'),
(15, '清洗进气道');

-- --------------------------------------------------------

--
-- 表的结构 `car`
--

DROP TABLE IF EXISTS `car`;
CREATE TABLE IF NOT EXISTS `car` (
`id` int(10) unsigned NOT NULL,
  `uid` int(10) NOT NULL COMMENT '会员ID',
  `plate_number` varchar(255) NOT NULL COMMENT '车牌号',
  `brand` varchar(255) NOT NULL COMMENT '品牌',
  `licheng` varchar(255) NOT NULL COMMENT '里程',
  `chejian_date` date NOT NULL COMMENT '车检日期',
  `chexian_date` date NOT NULL COMMENT '车险日期',
  `ctime` datetime NOT NULL COMMENT '创建时间'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='车辆管理';

--
-- 转存表中的数据 `car`
--

INSERT INTO `car` (`id`, `uid`, `plate_number`, `brand`, `licheng`, `chejian_date`, `chexian_date`, `ctime`) VALUES
(1, 1, '晋BNH571', '大众宝来', '110000', '2016-04-30', '2016-04-30', '2017-01-12 22:34:03');

-- --------------------------------------------------------

--
-- 表的结构 `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1449594860),
('m130524_201442_init', 1449594866);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL COMMENT '自增ID',
  `nickname` varchar(255) DEFAULT NULL COMMENT '昵称',
  `phone` bigint(20) NOT NULL COMMENT '手机号',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '1' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '1' COMMENT '状态',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户表';

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `nickname`, `phone`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
(6, NULL, 15212345678, 'xMRT8g-gZuc2HE6Wda_RSeaelSQVInHJ', '$2y$13$T/LLdKtIEl7U4bJmTe.aH.BbKBGcQlY3Q/UGeLAwC8xGGkacMSmLu', NULL, NULL, 1, 10, 1498126360, 1498126360);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad`
--
ALTER TABLE `ad`
 ADD PRIMARY KEY (`id`), ADD KEY `cid` (`cid`);

--
-- Indexes for table `ad_type`
--
ALTER TABLE `ad_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `baoyang_type`
--
ALTER TABLE `baoyang_type`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad`
--
ALTER TABLE `ad`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `ad_type`
--
ALTER TABLE `ad_type`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `baoyang_type`
--
ALTER TABLE `baoyang_type`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
