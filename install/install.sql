SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
DROP TABLE IF EXISTS `###pre###cms_admin`;
CREATE TABLE `###pre###cms_admin` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `roleid` int(4) NOT NULL default '0',
  `sys` smallint(1) NOT NULL default '0',
  `addtime` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  `lasttime` int(10) NOT NULL default '0',
  `isshow` smallint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_admincolumn`;
CREATE TABLE `###pre###cms_admincolumn` (
  `id` int(11) NOT NULL auto_increment,
  `parentid` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `sortid` int(5) NOT NULL default '0',
  `isshow` smallint(1) NOT NULL default '0',
  `topshow` smallint(1) NOT NULL default '0',
  `quick` smallint(1) NOT NULL default '0',
  `hidden` smallint(1) NOT NULL default '0',
  `close` smallint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `###pre###cms_admincolumn` (`id`, `parentid`, `title`, `url`, `sortid`, `isshow`, `topshow`, `quick`, `hidden`, `close`) VALUES
(1, 0, '后台栏目管理', 'column', 999, 1, 0, 0, 0, 0),
(2, 1, '后台栏目列表', 'admin_column', 1, 1, 0, 0, 0, 0),
(3, 1, '添加后台栏目', 'admin_column_add', 2, 1, 0, 0, 0, 0),
(4, 1, '修改后台栏目', 'admin_column_edit', 3, 0, 0, 0, 0, 0),
(5, 1, '删除后台栏目', 'admin_column_del', 4, 0, 0, 0, 0, 0),
(6, 0, '文章管理', 'news', 2, 0, 0, 0, 0, 0),
(7, 6, '文章列表', 'admin_news', 1, 1, 0, 0, 0, 0),
(8, 6, '添加文章', 'admin_news_add', 2, 1, 0, 0, 0, 0),
(9, 6, '修改文章', 'admin_news_edit', 3, 0, 0, 0, 0, 0),
(10, 6, '删除文章', 'admin_news_del', 4, 0, 0, 0, 0, 0),
(11, 6, '文章栏目列表', 'admin_news_type', 5, 1, 0, 0, 0, 0),
(12, 6, '添加文章栏目', 'admin_news_type_add', 6, 1, 0, 0, 0, 0),
(13, 6, '修改文章栏目', 'admin_news_type_edit', 7, 0, 0, 0, 0, 0),
(14, 6, '删除文章栏目', 'admin_news_type_del', 8, 0, 0, 0, 0, 0),
(15, 0, '基本操作', 'info', 1, 1, 1, 0, 0, 0),
(16, 15, '网站基本配置', 'admin_config', -999, 1, 1, 0, 0, 0),
(17, 0, '管理员管理', 'admin', 3, 1, 1, 0, 0, 0),
(18, 17, '管理员列表', 'admin_admin', 1, 1, 0, 1, 0, 0),
(19, 17, '添加管理员', 'admin_admin_add', 2, 1, 0, 1, 0, 0),
(20, 17, '修改管理员', 'admin_admin_edit', 3, 0, 0, 0, 0, 0),
(21, 17, '删除管理员', 'admin_admin_del', 4, 0, 0, 0, 0, 0),
(22, 17, '管理员角色', 'admin_admin_role', 5, 1, 0, 0, 0, 0),
(23, 17, '添加角色', 'admin_admin_role_add', 6, 1, 0, 0, 0, 0),
(24, 17, '修改角色', 'admin_admin_role_edit', 7, 0, 0, 0, 0, 0),
(25, 17, '删除角色', 'admin_admin_role_del', 8, 0, 0, 0, 0, 0),
(32, 15, '数据库管理', 'admin_database', 3, 1, 0, 0, 0, 0),
(33, 6, '唯一页面', 'admin_news&onlypage=1', 0, 1, 0, 0, 0, 0),
(34, 0, '友情链接管理', 'links', 4, 1, 1, 0, 0, 0),
(35, 34, '友情链接列表', 'admin_links', 1, 1, 0, 0, 0, 0),
(36, 34, '添加友情链接', 'admin_links_add', 2, 1, 0, 0, 0, 0),
(37, 34, '修改友情链接', 'admin_links_edit', 3, 0, 0, 0, 0, 0),
(38, 34, '删除友情链接', 'admin_links_del', 4, 0, 0, 0, 0, 0),
(39, 0, '留言管理', 'guest', 5, 1, 1, 0, 0, 0),
(40, 39, '留言列表', 'admin_guest', 1, 1, 0, 0, 0, 0),
(41, 39, '修改留言', 'admin_guest_edit', 2, 0, 0, 0, 0, 0),
(42, 39, '删除留言', 'admin_guest_del', 3, 0, 0, 0, 0, 0),
(43, 15, '新增配置字段', 'admin_config_add', 2, 1, 0, 0, 0, 0),
(44, 0, '产品管理', 'product', 2, 0, 0, 0, 0, 0),
(45, 44, '产品列表', 'admin_product', 1, 1, 0, 0, 0, 0),
(46, 44, '添加产品', 'admin_product_add', 2, 1, 0, 0, 0, 0),
(47, 44, '修改产品', 'admin_product_edit', 3, 0, 0, 0, 0, 0),
(48, 44, '删除产品', 'admin_product_del', 4, 0, 0, 0, 0, 0),
(49, 44, '产品分类列表', 'admin_product_type', 5, 1, 0, 0, 0, 0),
(50, 44, '添加产品分类', 'admin_product_type_add', 6, 1, 0, 0, 0, 0),
(51, 44, '修改产品分类', 'admin_product_type_edit', 7, 0, 0, 0, 0, 0),
(52, 44, '删除产品分类', 'admin_product_type_del', 8, 0, 0, 0, 0, 0),
(53, 44, '产品类型列表', 'admin_product_ptype', 9, 1, 0, 0, 0, 0),
(54, 44, '添加产品类型', 'admin_product_ptype_add', 10, 1, 0, 0, 0, 0),
(55, 44, '修改产品类型', 'admin_product_ptype_edit', 11, 0, 0, 0, 0, 0),
(56, 44, '删除产品类型', 'admin_product_ptype_del', 12, 0, 0, 0, 0, 0),
(57, 44, '产品类型属性列表', 'admin_product_attribute', 13, 0, 0, 0, 0, 0),
(58, 44, '添加产品类型属性', 'admin_product_attribute_add', 14, 0, 0, 0, 0, 0),
(59, 44, '修改产品类型属性', 'admin_product_attribute_edit', 15, 0, 0, 0, 0, 0),
(60, 44, '删除产品类型属性', 'admin_product_attribute_del', 16, 0, 0, 0, 0, 0),
(61, 34, '链接类别管理', 'admin_links_type', 5, 1, 0, 0, 0, 0),
(62, 34, '链接类别添加', 'admin_links_type_add', 6, 1, 0, 0, 0, 0),
(63, 34, '链接类别修改', 'admin_links_type_edit', 7, 0, 0, 0, 0, 0),
(64, 34, '链接类别删除', 'admin_links_type_del', 8, 0, 0, 0, 0, 0),
(65, 0, '招聘管理', 'jobs', 9, 1, 0, 0, 0, 0),
(66, 65, '招聘信息列表', 'admin_jobs', 1, 1, 0, 0, 0, 0),
(67, 65, '添加招聘信息', 'admin_jobs_add', 2, 1, 0, 0, 0, 0),
(68, 65, '修改招聘信息', 'admin_jobs_edit', 3, 0, 0, 0, 0, 0),
(69, 65, '删除招聘信息', 'admin_jobs_del', 4, 0, 0, 0, 0, 0),
(70, 65, '应聘信息列表', 'admin_careers', 5, 1, 0, 0, 0, 0),
(71, 65, '查看应聘信息', 'admin_careers_edit', 6, 0, 0, 0, 0, 0),
(72, 65, '删除应聘信息', 'admin_careers_del', 7, 0, 0, 0, 0, 0),
(73, 0, 'banner管理', 'banner', 10, 1, 0, 0, 0, 0),
(74, 73, 'banner列表', 'admin_banner', 1, 1, 0, 0, 0, 0),
(75, 73, '添加banner', 'admin_banner_add', 2, 1, 0, 0, 0, 0),
(76, 73, '修改banner', 'admin_banner_edit', 3, 0, 0, 0, 0, 0),
(77, 73, '删除banner', 'admin_banner_del', 4, 0, 0, 0, 0, 0),
(78, 0, '内容管理', 'category', 2, 1, 1, 0, 0, 0),
(79, 78, '栏目管理', 'admin_category', 1, 1, 0, 0, 0, 0),
(80, 78, '添加栏目', 'admin_category_add', 2, 0, 0, 0, 0, 0),
(81, 78, '修改栏目', 'admin_category_edit', 3, 0, 0, 0, 0, 0),
(82, 78, '删除栏目', 'admin_category_del', 4, 0, 0, 0, 0, 0),
(83, 78, '模型管理', 'admin_module', 5, 1, 0, 0, 0, 0),
(84, 78, '添加模型', 'admin_module_add', 6, 0, 0, 0, 0, 0),
(85, 78, '修改模型', 'admin_module_edit', 7, 0, 0, 0, 0, 0),
(86, 78, '删除模型', 'admin_module_del', 8, 0, 0, 0, 0, 0),
(87, 78, '字段管理', 'admin_module_field', 9, 0, 0, 0, 0, 0),
(88, 78, '添加字段', 'admin_module_field_add', 10, 0, 0, 0, 0, 0),
(89, 78, '修改字段', 'admin_module_field_edit', 11, 0, 0, 0, 0, 0),
(90, 78, '删除字段', 'admin_module_field_del', 12, 0, 0, 0, 0, 0),
(91, 15, '选择模板', 'admin_template', 4, 1, 0, 0, 0, 0),
(92, 15, '管理模板', 'admin_template_manage', 5, 0, 0, 0, 0, 0);

DROP TABLE IF EXISTS `###pre###cms_adminlog`;
CREATE TABLE `###pre###cms_adminlog` (
  `id` int(11) NOT NULL auto_increment,
  `content` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `addtime` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_config`;
CREATE TABLE `###pre###cms_config` (
  `id` int(11) NOT NULL auto_increment,
  `sortid` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `width` int(5) NOT NULL,
  `value` text NOT NULL,
  `groupname` varchar(255) NOT NULL default '基本设置',
  `typeid` smallint(1) NOT NULL,
  `items` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `hidden` smallint(1) NOT NULL,
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

insert into `###pre###cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`typeid`,`items`,`description`,`hidden`,`groupname`) values 
('1','1','网站名字','web_title','200','通用网站管理系统','1','','网站名称，长度最好不要超过255个字符。','0','基本设置'),
('2','2','网站地址','web_site','200','http://www.openkee.com/','1','','请正确填写网站地址，网址前请加http://。','0','基本设置'),
('3','3','网站关键字','web_keyword','200','通用网站管理系统','1','','多个关键字请以半角逗号“,”隔开。','0','基本设置'),
('4','4','网站描述','web_description','200','通用网站管理系统','1','','最多不要超过255个字符。','0','基本设置'),
('5','5','网站关闭','web_close','0','0','3','是#####1|否#####0','','0','基本设置'),
('6','6','关闭描述','web_close_description','300','网站维护中，请稍候访问。。。','2','','如果网站关闭，此处填写关闭原因，允许出现HTML代码。','0','基本设置'),
('7','0','其他信息','web_other_info','0','0','1','','其他信息，再加字段可往下添加。','1','基本设置'),
('8','1','启用图片水印','web_water','0','0','3','是#####1|否#####0','','0','网站设置'),
('9','2','水印位置','web_water_pos','0','9','3','随机#####0|顶端居左#####1|顶端居中#####2|顶端居右#####3|中部居左#####4|中部居中#####5|中部居右#####6|底端居左#####7|底端居中#####8|底端居右#####9','','0','网站设置'),
('10','3','水印图片','web_water_pic','200','','4','','','0','网站设置'),
('11','4','水印透明度','web_water_pct','200','80','1','','请正确填写水印图片透明度百分比，数值在1-100之间。','0','网站设置'),
('12','0','模板目录','web_template_url','200','default','1','','模板存放的目录，在模板选择出设置','1','基本设置');

DROP TABLE IF EXISTS `###pre###cms_news`;
CREATE TABLE `###pre###cms_news` (
  `id` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `pic` text NOT NULL,
  `isshow` smallint(1) NOT NULL default '1',
  `userid` int(11) NOT NULL,
  `recommend` smallint(1) NOT NULL default '0',
  `content` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `onlypage` smallint(1) NOT NULL default '0',
  `addtime` int(10) NOT NULL,
  `sortid` int(11) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_newstype`;
CREATE TABLE `###pre###cms_newstype` (
  `id` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL,
  `isshow` smallint(1) NOT NULL default '1',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_product`;
CREATE TABLE IF NOT EXISTS `###pre###cms_product` (
  `id` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `short_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `pic` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `hot` tinyint(1) NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '0',
  `recommend` tinyint(1) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `addtime` int(10) NOT NULL default '0',
  `hits` int(11) NOT NULL default '0',
  `product_attribute_id` int(11) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_productattribute`;
CREATE TABLE IF NOT EXISTS `###pre###cms_productattribute` (
  `id` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `attrtype` tinyint(1) NOT NULL default '0',
  `attrinputtype` tinyint(1) NOT NULL default '0',
  `attrvalue` text NOT NULL,
  `sortid` int(11) NOT NULL default '0',
  `attr_group` int(11) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_productinfoattr`;
CREATE TABLE IF NOT EXISTS `###pre###cms_productinfoattr` (
  `id` int(11) NOT NULL auto_increment,
  `productid` int(11) NOT NULL default '0',
  `attrid` int(11) NOT NULL default '0',
  `attrvalue` text NOT NULL,
  `attrprice` decimal(10,2) NOT NULL default '0.00',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_productptype`;
CREATE TABLE IF NOT EXISTS `###pre###cms_productptype` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '0',
  `attr_group` text NOT NULL,
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_producttype`;
CREATE TABLE IF NOT EXISTS `###pre###cms_producttype` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `typeid` int(11) NOT NULL default '0',
  `sortid` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL default '1',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_careers`;
CREATE TABLE `###pre###cms_careers` (
  `id` int(11) NOT NULL auto_increment,
  `jobs_id` int(11) NOT NULL default '0',
  `realname` varchar(20) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `xueli` varchar(50) NOT NULL,
  `yuanxiao` varchar(50) NOT NULL,
  `zhuanye` varchar(50) NOT NULL,
  `jobs_title` varchar(255) NOT NULL,
  `xinzi` varchar(50) NOT NULL,
  `jingyan` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `addtime` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_jobs`;
CREATE TABLE `###pre###cms_jobs` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `sortid` int(5) NOT NULL default '0',
  `xinzi` varchar(255) NOT NULL,
  `xueli` varchar(255) NOT NULL,
  `renshu` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `youxiao` int(5) NOT NULL default '0',
  `starttime` int(10) NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '1',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_banner`;
CREATE TABLE `###pre###cms_banner` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL default '1',
  `sortid` int(11) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_role`;
CREATE TABLE `###pre###cms_role` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL,
  `content` varchar(50) NOT NULL,
  `role` text NOT NULL,
  `module_role` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_links`;
CREATE TABLE IF NOT EXISTS `###pre###cms_links` (
  `id` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL default '0',
  `sortid` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `pic` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_linkstype`;
CREATE TABLE IF NOT EXISTS `###pre###cms_linkstype` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_guest`;
CREATE TABLE IF NOT EXISTS `###pre###cms_guest` (
  `id` int(11) NOT NULL auto_increment,
  `realname` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addtime` int(10) NOT NULL default '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_module`;
CREATE TABLE IF NOT EXISTS `###pre###cms_module` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` TEXT NOT NULL,
  `issystem` tinyint(1) NOT NULL default '0',
  `issearch` tinyint(1) NOT NULL default '0',
  `listfields` text NOT NULL,
  `isdel` tinyint(1) NOT NULL default '0',
  `isadd` tinyint(1) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `sortid` int(11) NOT NULL default '0',
  `relation_url` text NOT NULL default '',
  `relation_name` text NOT NULL default '',
  `relation_table` text NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_category`;
CREATE TABLE IF NOT EXISTS `###pre###cms_category` (
  `id` int(11) NOT NULL auto_increment,
  `typeid` int(11) NOT NULL default '0',
  `title` varchar(50) NOT NULL,
  `moduleid` int(11) NOT NULL default '0',
  `url` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL default '0',
  `sortid` int(11) NOT NULL default '0',
  `lang` int(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `###pre###cms_field`;
CREATE TABLE IF NOT EXISTS `###pre###cms_field` (
  `id` int(11) NOT NULL auto_increment,
  `moduleid` int(11) NOT NULL default '0',
  `title` varchar(50) NOT NULL default '',
  `name` varchar(50) NOT NULL default '', 
  `required` int(11) NOT NULL default '0',
  `minlength` int(11) NOT NULL default '0',
  `maxlength` int(11) NOT NULL default '0',
  `pattern` varchar(255) NOT NULL default '',
  `defaultmsg` varchar(255) NOT NULL default '',
  `errormsg` varchar(255) NOT NULL default '',
  `type` varchar(50) NOT NULL default '',
  `setup` text NOT NULL,
  `sortid` int(11) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '0',
  `issystem` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;