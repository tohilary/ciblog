-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 10 月 24 日 15:53
-- 服务器版本: 5.5.16
-- PHP 版本: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ciblog`
--

-- --------------------------------------------------------

--
-- 表的结构 `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `cid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'comment表主键',
  `pid` int(10) unsigned DEFAULT '0' COMMENT 'post表主键,关联字段',
  `created` int(10) unsigned DEFAULT '0' COMMENT '评论生成时的GMT unix时间戳',
  `author` varchar(200) DEFAULT NULL COMMENT '评论作者',
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '评论所属用户id',
  `ownerId` int(10) unsigned DEFAULT '0' COMMENT '评论所属内容作者id',
  `mail` varchar(200) DEFAULT NULL COMMENT '评论者邮件',
  `url` varchar(200) DEFAULT NULL COMMENT '评论者网址',
  `ip` varchar(64) DEFAULT NULL COMMENT '评论者ip地址',
  `agent` varchar(200) DEFAULT NULL COMMENT '评论者客户端',
  `text` text COMMENT '评论文字',
  `type` varchar(16) DEFAULT 'comment' COMMENT '评论类型',
  `status` varchar(16) DEFAULT 'approved' COMMENT '评论状态',
  `parent` int(10) unsigned DEFAULT '0' COMMENT '父级评论',
  PRIMARY KEY (`cid`),
  KEY `cid` (`pid`),
  KEY `created` (`created`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `comments`
--

INSERT INTO `comments` (`cid`, `pid`, `created`, `author`, `authorId`, `ownerId`, `mail`, `url`, `ip`, `agent`, `text`, `type`, `status`, `parent`) VALUES
(1, 1, 1268550856, 'Tester', 0, 1, 'tester@tester.com', 'http://www.tester.com', '0.0.0.0', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; zh-CN; rv:1.9.2) Gecko/20100115 Firefox/3.6', '测试留言～', 'comment', 'approved', 0),
(2, 1, 1351063518, 'zhangxy', 0, 1, 'zhangxy@lemote.com', 'http://www.oyoyos.com', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:15.0) Gecko/20100101 Firefox/15.0.1', '测试留言', 'comment', 'approved', 0);

-- --------------------------------------------------------

--
-- 表的结构 `metas`
--

CREATE TABLE IF NOT EXISTS `metas` (
  `mid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目主键',
  `name` varchar(200) DEFAULT NULL COMMENT '名称',
  `slug` varchar(200) DEFAULT NULL COMMENT '项目缩略名',
  `type` varchar(32) NOT NULL COMMENT '项目类型',
  `description` varchar(200) DEFAULT NULL COMMENT '选项描述',
  `count` int(10) unsigned DEFAULT '0' COMMENT '项目所属内容个数',
  `order` int(10) unsigned DEFAULT '0' COMMENT '项目排序',
  PRIMARY KEY (`mid`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `metas`
--

INSERT INTO `metas` (`mid`, `name`, `slug`, `type`, `description`, `count`, `order`) VALUES
(1, '测试分类', 'test', 'category', '这里是分类描述，其内容会出现在分类查看页的meta标签中，有利于seo', 2, 0);

-- --------------------------------------------------------

--
-- 表的结构 `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `pid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'post表主键',
  `title` varchar(200) DEFAULT NULL COMMENT '内容标题',
  `slug` varchar(200) DEFAULT NULL COMMENT '内容缩略名',
  `created` int(10) unsigned DEFAULT '0' COMMENT '内容生成时的GMT unix时间戳',
  `modified` int(10) unsigned DEFAULT '0' COMMENT '内容更改时的GMT unix时间戳',
  `text` text COMMENT '内容文字',
  `order` int(10) unsigned DEFAULT '0',
  `authorId` int(10) unsigned DEFAULT '0' COMMENT '内容所属用户id',
  `template` varchar(32) DEFAULT NULL COMMENT '内容使用的模板',
  `type` varchar(16) DEFAULT 'post' COMMENT '内容类别',
  `status` varchar(16) DEFAULT 'publish' COMMENT '内容状态',
  `commentsNum` int(10) unsigned DEFAULT '0' COMMENT '内容所属评论数,冗余字段',
  `allowComment` char(1) DEFAULT '0' COMMENT '是否允许评论',
  `allowPing` char(1) DEFAULT '0' COMMENT '是否允许ping',
  `allowFeed` char(1) DEFAULT '0' COMMENT '允许出现在聚合中',
  PRIMARY KEY (`pid`),
  UNIQUE KEY `slug` (`slug`),
  KEY `created` (`created`),
  KEY `authorId` (`authorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `posts`
--

INSERT INTO `posts` (`pid`, `title`, `slug`, `created`, `modified`, `text`, `order`, `authorId`, `template`, `type`, `status`, `commentsNum`, `allowComment`, `allowPing`, `allowFeed`) VALUES
(1, '欢迎使用stblog博客', 'start', 1268550720, 1268550824, '如果你看到这篇文章，说明你的stblog已经安装和配置成功了!\n\n这是一篇测试日志，你可以进入后台删除\n\nStblog的历史从今天开始', 0, 1, NULL, 'post', 'publish', 2, '1', '1', '1'),
(2, '我是测试', '2', 1351068540, 1351068570, '我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈\n我是测试 哈哈哈', 0, 1, NULL, 'post', 'publish', 0, '1', '1', '1');

-- --------------------------------------------------------

--
-- 表的结构 `relationships`
--

CREATE TABLE IF NOT EXISTS `relationships` (
  `pid` int(10) unsigned NOT NULL COMMENT '内容主键',
  `mid` int(10) unsigned NOT NULL COMMENT '项目主键',
  PRIMARY KEY (`pid`,`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `relationships`
--

INSERT INTO `relationships` (`pid`, `mid`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- 表的结构 `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('5b7d1728dce076edd750ad61253c07d0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.4 (KH', 1351070700, 'a:1:{s:4:"user";s:409:"a:11:{s:3:"uid";s:1:"1";s:4:"name";s:5:"admin";s:8:"password";s:49:"e76d8c024a9fcb7df4c92a5be2f7989e4407435e29e2110ad";s:4:"mail";s:20:"huyanggang@gmail.com";s:3:"url";s:24:"http://www.cnsaturn.com/";s:10:"screenName";s:5:"admin";s:7:"created";s:4:"1111";s:9:"activated";s:10:"1351057978";s:6:"logged";i:1351058038;s:5:"group";s:13:"administrator";s:5:"token";s:40:"5766e2df46dbeb2a07e1523d1a535244128362dc";}";}'),
('b4f44b9b77d6d1fe68c0310c15e85a86', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1; rv:15.0) Gecko/201001', 1351068520, 'a:1:{s:4:"user";s:409:"a:11:{s:3:"uid";s:1:"1";s:4:"name";s:5:"admin";s:8:"password";s:49:"e76d8c024a9fcb7df4c92a5be2f7989e4407435e29e2110ad";s:4:"mail";s:20:"huyanggang@gmail.com";s:3:"url";s:24:"http://www.cnsaturn.com/";s:10:"screenName";s:5:"admin";s:7:"created";s:4:"1111";s:9:"activated";s:10:"1351058038";s:6:"logged";i:1351064025;s:5:"group";s:13:"administrator";s:5:"token";s:40:"298b51061ab879810bf66d3dd3af2946cb333a0b";}";}'),
('62b24ae6d5f1e42209377ed37683a755', '127.0.0.1', 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.4 (KH', 1351084501, 'a:1:{s:4:"user";s:409:"a:11:{s:3:"uid";s:1:"1";s:4:"name";s:5:"admin";s:8:"password";s:49:"e76d8c024a9fcb7df4c92a5be2f7989e4407435e29e2110ad";s:4:"mail";s:20:"huyanggang@gmail.com";s:3:"url";s:24:"http://www.cnsaturn.com/";s:10:"screenName";s:5:"admin";s:7:"created";s:4:"1111";s:9:"activated";s:10:"1351064025";s:6:"logged";i:1351084510;s:5:"group";s:13:"administrator";s:5:"token";s:40:"d0bbf12e1f7dc06e687c8e0a0545faec6885b1fc";}";}');

-- --------------------------------------------------------

--
-- 表的结构 `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` tinyint(2) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(40) NOT NULL COMMENT '设置名称',
  `value` text NOT NULL COMMENT '设置值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='设置表' AUTO_INCREMENT=28 ;

--
-- 转存表中的数据 `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'blog_title', 'STBLOG DEMO SITE'),
(2, 'blog_slogan', '基于Codeigniter的开源博客程序Stblog'),
(3, 'blog_description', 'STBlog,codeigniter'),
(4, 'cache_enabled', '0'),
(5, 'current_theme', 'default'),
(6, 'blog_status', 'on'),
(7, 'offline_reason', '稍后公布'),
(8, 'blog_keywords', 'stblog,mvc,php,codeigniter,open souce,开源博客'),
(9, 'upload_dir', 'uploads/'),
(10, 'upload_exts', '*.zip;*.tar.gz;*.rar;*.jpg;*.gif;*.png;*.jpeg;*.bmp;*.tiff'),
(11, 'comments_date_format', 'F j, Y, g:i a'),
(12, 'comments_list_size', '10'),
(13, 'comments_url_no_follow', '1'),
(14, 'comments_require_moderation', '0'),
(15, 'comments_auto_close', '0'),
(16, 'comments_require_mail', '1'),
(17, 'comments_require_url', '0'),
(18, 'comments_allowed_html', ''),
(19, 'post_date_format', 'F j, Y, g:i a'),
(20, 'posts_page_size', '10'),
(21, 'posts_list_size', '10'),
(22, 'feed_full_text', '1'),
(23, 'cache_expire_time', '30'),
(26, 'active_plugins', 'a:6:{i:0;a:8:{s:9:"directory";s:12:"recent_posts";s:4:"name";s:18:"最新日志Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:24:"显示博客最新日志";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:1;a:8:{s:9:"directory";s:10:"navigation";s:4:"name";s:15:"导航拦Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:42:"根据创建的页面自动生成导航栏";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:3;a:8:{s:9:"directory";s:15:"recent_comments";s:4:"name";s:18:"最新评论Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:24:"显示博客最新评论";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:4;a:8:{s:9:"directory";s:10:"categories";s:4:"name";s:18:"分类列表Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:27:"显示博客的分类列表";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:5;a:8:{s:9:"directory";s:7:"archive";s:4:"name";s:24:"日志归档列表Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:30:"显示日志按月归档列表";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}i:6;a:8:{s:9:"directory";s:13:"related_posts";s:4:"name";s:18:"相关日志Widget";s:10:"plugin_uri";s:24:"http://www.cnsaturn.com/";s:11:"description";s:33:"显示某篇日志的相关日志";s:6:"author";s:6:"Saturn";s:12:"author_email";s:20:"huyanggang@gmail.com";s:7:"version";s:3:"0.1";s:12:"configurable";b:0;}}'),
(27, 'cache_file_limit', '200');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户PK',
  `name` varchar(32) NOT NULL COMMENT '用户名称',
  `password` varchar(49) DEFAULT NULL COMMENT '用户密码',
  `mail` varchar(200) NOT NULL COMMENT '用户邮箱',
  `url` varchar(200) DEFAULT NULL COMMENT '用户主页',
  `screenName` varchar(32) DEFAULT NULL COMMENT '用户的显示名称',
  `created` int(10) unsigned NOT NULL COMMENT '用户的注册时间',
  `activated` int(10) unsigned NOT NULL COMMENT '最后活跃时间',
  `logged` int(10) unsigned NOT NULL COMMENT '上次登陆最后活跃时间',
  `group` varchar(16) NOT NULL COMMENT '用户所在组',
  `token` varchar(40) DEFAULT NULL COMMENT '令牌',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `name` (`name`,`mail`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`uid`, `name`, `password`, `mail`, `url`, `screenName`, `created`, `activated`, `logged`, `group`, `token`) VALUES
(1, 'admin', 'e76d8c024a9fcb7df4c92a5be2f7989e4407435e29e2110ad', 'huyanggang@gmail.com', 'http://www.cnsaturn.com/', 'admin', 1111, 1351084513, 1351084510, 'administrator', 'd0bbf12e1f7dc06e687c8e0a0545faec6885b1fc');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
