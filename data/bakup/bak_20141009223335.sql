SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
DROP TABLE IF EXISTS `cms_admin`;
CREATE TABLE `cms_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `roleid` int(4) NOT NULL DEFAULT '0',
  `sys` smallint(1) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  `lasttime` int(10) NOT NULL DEFAULT '0',
  `isshow` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

insert into `cms_admin`(`id`,`username`,`password`,`roleid`,`sys`,`addtime`,`ip`,`lasttime`,`isshow`) values('1','admins','cdd7e692858094371afa6affc351d710','0','1','1398437695','127.0.0.1','1412857114','1');
insert into `cms_admin`(`id`,`username`,`password`,`roleid`,`sys`,`addtime`,`ip`,`lasttime`,`isshow`) values('2','admin','88b1175faf2a449bedf7e9139575184f','0','1','1398695985','112.94.196.122','1409796250','1');

DROP TABLE IF EXISTS `cms_admincolumn`;
CREATE TABLE `cms_admincolumn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentid` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `url` varchar(50) NOT NULL,
  `sortid` int(5) NOT NULL DEFAULT '0',
  `isshow` smallint(1) NOT NULL DEFAULT '0',
  `topshow` smallint(1) NOT NULL DEFAULT '0',
  `quick` smallint(1) NOT NULL DEFAULT '0',
  `hidden` smallint(1) NOT NULL DEFAULT '0',
  `close` smallint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;

insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('1','0','后台栏目管理','column','999','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('2','1','后台栏目列表','admin_column','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('3','1','添加后台栏目','admin_column_add','2','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('4','1','修改后台栏目','admin_column_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('5','1','删除后台栏目','admin_column_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('6','0','文章管理','news','2','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('7','6','文章列表','admin_news','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('8','6','添加文章','admin_news_add','2','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('9','6','修改文章','admin_news_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('10','6','删除文章','admin_news_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('11','6','文章栏目列表','admin_news_type','5','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('12','6','添加文章栏目','admin_news_type_add','6','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('13','6','修改文章栏目','admin_news_type_edit','7','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('14','6','删除文章栏目','admin_news_type_del','8','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('15','0','基本操作','info','1','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('16','15','网站基本配置','admin_config','-999','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('17','0','管理员管理','admin','3','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('18','17','管理员列表','admin_admin','1','1','0','1','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('19','17','添加管理员','admin_admin_add','2','1','0','1','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('20','17','修改管理员','admin_admin_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('21','17','删除管理员','admin_admin_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('22','17','管理员角色','admin_admin_role','5','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('23','17','添加角色','admin_admin_role_add','6','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('24','17','修改角色','admin_admin_role_edit','7','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('25','17','删除角色','admin_admin_role_del','8','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('32','15','数据库管理','admin_database','3','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('33','6','唯一页面','admin_news&onlypage=1','0','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('34','0','友情链接管理','links','4','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('35','34','友情链接列表','admin_links','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('36','34','添加友情链接','admin_links_add','2','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('37','34','修改友情链接','admin_links_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('38','34','删除友情链接','admin_links_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('39','0','投诉建议','guest','5','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('40','39','投诉建议','admin_guest','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('41','39','回复投诉建议','admin_guest_edit','2','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('42','39','删除投诉建议','admin_guest_del','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('43','15','新增配置字段','admin_config_add','2','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('44','0','产品管理','product','2','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('45','44','产品列表','admin_product','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('46','44','添加产品','admin_product_add','2','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('47','44','修改产品','admin_product_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('48','44','删除产品','admin_product_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('49','44','产品分类列表','admin_product_type','5','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('50','44','添加产品分类','admin_product_type_add','6','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('51','44','修改产品分类','admin_product_type_edit','7','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('52','44','删除产品分类','admin_product_type_del','8','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('53','44','产品类型列表','admin_product_ptype','9','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('54','44','添加产品类型','admin_product_ptype_add','10','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('55','44','修改产品类型','admin_product_ptype_edit','11','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('56','44','删除产品类型','admin_product_ptype_del','12','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('57','44','产品类型属性列表','admin_product_attribute','13','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('58','44','添加产品类型属性','admin_product_attribute_add','14','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('59','44','修改产品类型属性','admin_product_attribute_edit','15','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('60','44','删除产品类型属性','admin_product_attribute_del','16','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('61','34','链接类别管理','admin_links_type','5','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('62','34','链接类别添加','admin_links_type_add','6','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('63','34','链接类别修改','admin_links_type_edit','7','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('64','34','链接类别删除','admin_links_type_del','8','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('65','0','招聘管理','jobs','9','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('66','65','招聘信息列表','admin_jobs','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('67','65','添加招聘信息','admin_jobs_add','2','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('68','65','修改招聘信息','admin_jobs_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('69','65','删除招聘信息','admin_jobs_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('70','65','求职信息列表','admin_careers','5','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('71','65','查看应聘信息','admin_careers_edit','6','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('72','65','删除应聘信息','admin_careers_del','7','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('73','0','banner管理','banner','10','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('74','73','banner列表','admin_banner','1','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('75','73','添加banner','admin_banner_add','2','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('76','73','修改banner','admin_banner_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('77','73','删除banner','admin_banner_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('78','0','内容管理','category','2','0','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('79','78','栏目管理','admin_category','1','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('80','78','添加栏目','admin_category_add','2','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('81','78','修改栏目','admin_category_edit','3','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('82','78','删除栏目','admin_category_del','4','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('83','78','模型管理','admin_module','5','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('84','78','添加模型','admin_module_add','6','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('85','78','修改模型','admin_module_edit','7','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('86','78','删除模型','admin_module_del','8','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('87','78','字段管理','admin_module_field','9','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('88','78','添加字段','admin_module_field_add','10','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('89','78','修改字段','admin_module_field_edit','11','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('90','78','删除字段','admin_module_field_del','12','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('91','15','选择模板','admin_template','4','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('92','15','管理模板','admin_template_manage','5','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('93','0','会员管理','users','7','1','1','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('94','93','会员列表','admin_users','0','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('95','93','添加会员','admin_users_add','0','1','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('96','93','编辑会员','admin_users_edit','0','0','0','0','0','0');
insert into `cms_admincolumn`(`id`,`parentid`,`title`,`url`,`sortid`,`isshow`,`topshow`,`quick`,`hidden`,`close`) values('97','93','删除会员','admin_users_del','0','0','0','0','0','0');

DROP TABLE IF EXISTS `cms_adminlog`;
CREATE TABLE `cms_adminlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `addtime` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `userid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_banner`;
CREATE TABLE `cms_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL DEFAULT '1',
  `sortid` int(11) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

insert into `cms_banner`(`id`,`title`,`pic`,`url`,`isshow`,`sortid`,`lang`) values('1','行业资讯分类','new_1.png','','1','0','0');
insert into `cms_banner`(`id`,`title`,`pic`,`url`,`isshow`,`sortid`,`lang`) values('2','行业资讯详情','new_1.png','','1','0','0');
insert into `cms_banner`(`id`,`title`,`pic`,`url`,`isshow`,`sortid`,`lang`) values('3','招聘中心资讯分类','new_1.png','','1','0','0');
insert into `cms_banner`(`id`,`title`,`pic`,`url`,`isshow`,`sortid`,`lang`) values('4','招聘中心资讯详情','new_1.png','','1','0','0');
insert into `cms_banner`(`id`,`title`,`pic`,`url`,`isshow`,`sortid`,`lang`) values('5','招聘中心','jobs.png','','1','0','0');

DROP TABLE IF EXISTS `cms_careers`;
CREATE TABLE `cms_careers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobs_id` int(11) NOT NULL DEFAULT '0',
  `realname` varchar(20) NOT NULL,
  `sex` varchar(2) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `xueli` varchar(50) NOT NULL,
  `yuanxiao` varchar(50) NOT NULL,
  `zhuanye` varchar(50) NOT NULL,
  `jobs_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `xinzi` varchar(50) NOT NULL,
  `jingyan` text NOT NULL,
  `address` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

insert into `cms_careers`(`id`,`jobs_id`,`realname`,`sex`,`birthday`,`xueli`,`yuanxiao`,`zhuanye`,`jobs_title`,`content`,`xinzi`,`jingyan`,`address`,`tel`,`phone`,`email`,`addtime`) values('1','2','董洁','女','1989-02-28','博士','清华','计算机','销售','','20000','','北京','8888888','','dongjie@qq.com','1412728200');
insert into `cms_careers`(`id`,`jobs_id`,`realname`,`sex`,`birthday`,`xueli`,`yuanxiao`,`zhuanye`,`jobs_title`,`content`,`xinzi`,`jingyan`,`address`,`tel`,`phone`,`email`,`addtime`) values('2','0','大海','男','1989-02-28','博士','傻B大学','计算机','c#程序员','我是个大盗贼什么也不怕','','3','中国','0733-12213312','163636363366','','1412859878');

DROP TABLE IF EXISTS `cms_category`;
CREATE TABLE `cms_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL,
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_config`;
CREATE TABLE `cms_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sortid` int(5) NOT NULL,
  `title` varchar(50) NOT NULL,
  `field` varchar(50) NOT NULL,
  `width` int(5) NOT NULL,
  `value` text NOT NULL,
  `groupname` varchar(255) NOT NULL DEFAULT '基本设置',
  `typeid` smallint(1) NOT NULL,
  `items` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `hidden` smallint(1) NOT NULL,
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('1','1','网站名字','web_title','200','轮胎贸易网','基本设置','1','','网站名称，长度最好不要超过255个字符。','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('2','2','网站地址','web_site','200','','基本设置','1','','请正确填写网站地址，网址前请加http://。','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('3','3','网站关键字','web_keyword','200','轮胎贸易','基本设置','1','','多个关键字请以半角逗号“,”隔开。','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('4','4','网站描述','web_description','200','轮胎贸易','基本设置','1','','最多不要超过255个字符。','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('5','5','网站关闭','web_close','0','0','基本设置','3','是#####1|否#####0','','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('6','6','关闭描述','web_close_description','300','网站维护中，请稍候访问。。。','基本设置','2','','如果网站关闭，此处填写关闭原因，允许出现HTML代码。','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('7','0','其他信息','web_other_info','0','0','基本设置','1','','其他信息，再加字段可往下添加。','1','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('8','1','启用图片水印','web_water','0','0','网站设置','3','是#####1|否#####0','','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('9','2','水印位置','web_water_pos','0','9','网站设置','3','随机#####0|顶端居左#####1|顶端居中#####2|顶端居右#####3|中部居左#####4|中部居中#####5|中部居右#####6|底端居左#####7|底端居中#####8|底端居右#####9','','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('10','3','水印图片','web_water_pic','200','','网站设置','4','','','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('11','4','水印透明度','web_water_pct','200','80','网站设置','1','','请正确填写水印图片透明度百分比，数值在1-100之间。','0','0');
insert into `cms_config`(`id`,`sortid`,`title`,`field`,`width`,`value`,`groupname`,`typeid`,`items`,`description`,`hidden`,`lang`) values('12','0','模板目录','web_template_url','200','default','基本设置','1','','模板存放的目录，在模板选择出设置','1','0');

DROP TABLE IF EXISTS `cms_field`;
CREATE TABLE `cms_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moduleid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(50) NOT NULL DEFAULT '',
  `required` int(11) NOT NULL DEFAULT '0',
  `minlength` int(11) NOT NULL DEFAULT '0',
  `maxlength` int(11) NOT NULL DEFAULT '0',
  `pattern` varchar(255) NOT NULL DEFAULT '',
  `defaultmsg` varchar(255) NOT NULL DEFAULT '',
  `errormsg` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(50) NOT NULL DEFAULT '',
  `setup` text NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_guest`;
CREATE TABLE `cms_guest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `realname` varchar(50) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `addtime` int(10) NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_jobs`;
CREATE TABLE `cms_jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sortid` int(5) NOT NULL DEFAULT '0',
  `xinzi` varchar(255) NOT NULL,
  `xueli` varchar(255) NOT NULL,
  `renshu` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `youxiao` int(5) NOT NULL DEFAULT '0',
  `zhuanye` varchar(255) NOT NULL,
  `starttime` int(10) NOT NULL DEFAULT '0',
  `isshow` tinyint(1) NOT NULL DEFAULT '1',
  `lang` int(3) NOT NULL DEFAULT '0',
  `jingyan` int(10) NOT NULL,
  `renzhiyaoqiu` text NOT NULL,
  `gongsiyaoqiu` varchar(255) NOT NULL,
  `gongsiming` varchar(255) NOT NULL,
  `tel` varchar(14) NOT NULL,
  `realname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

insert into `cms_jobs`(`id`,`title`,`sortid`,`xinzi`,`xueli`,`renshu`,`address`,`content`,`youxiao`,`zhuanye`,`starttime`,`isshow`,`lang`,`jingyan`,`renzhiyaoqiu`,`gongsiyaoqiu`,`gongsiming`,`tel`,`realname`) values('1','轮胎装修','0','面议','学历不限','8','天河','轮胎装修','30','','1412611200','1','0','0','','','','','');
insert into `cms_jobs`(`id`,`title`,`sortid`,`xinzi`,`xueli`,`renshu`,`address`,`content`,`youxiao`,`zhuanye`,`starttime`,`isshow`,`lang`,`jingyan`,`renzhiyaoqiu`,`gongsiyaoqiu`,`gongsiming`,`tel`,`realname`) values('2','销售','0','面议','学历不限','6','天河','轮胎销售','30','','1412611200','1','0','0','','','','','');
insert into `cms_jobs`(`id`,`title`,`sortid`,`xinzi`,`xueli`,`renshu`,`address`,`content`,`youxiao`,`zhuanye`,`starttime`,`isshow`,`lang`,`jingyan`,`renzhiyaoqiu`,`gongsiyaoqiu`,`gongsiming`,`tel`,`realname`) values('3','php程序员','0','8000','大专','0','天河北路','web开发','30','计算机','1412858453','1','0','3','php linux html jquery','鑫援助','IT有限公司','0733-31133112','小刀');

DROP TABLE IF EXISTS `cms_links`;
CREATE TABLE `cms_links` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `pic` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

insert into `cms_links`(`id`,`typeid`,`sortid`,`title`,`url`,`pic`,`isshow`,`lang`) values('1','1','1','QQ','http://www.qq.com','','1','0');
insert into `cms_links`(`id`,`typeid`,`sortid`,`title`,`url`,`pic`,`isshow`,`lang`) values('2','1','2','百度','http://www.baidu.com','','1','0');
insert into `cms_links`(`id`,`typeid`,`sortid`,`title`,`url`,`pic`,`isshow`,`lang`) values('3','1','0','阿里巴巴','http://www.1688.com','','1','0');

DROP TABLE IF EXISTS `cms_linkstype`;
CREATE TABLE `cms_linkstype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0',
  `isshow` tinyint(1) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

insert into `cms_linkstype`(`id`,`title`,`sortid`,`isshow`,`lang`) values('1','文字','0','1','0');

DROP TABLE IF EXISTS `cms_module`;
CREATE TABLE `cms_module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `issystem` tinyint(1) NOT NULL DEFAULT '0',
  `issearch` tinyint(1) NOT NULL DEFAULT '0',
  `listfields` text NOT NULL,
  `isdel` tinyint(1) NOT NULL DEFAULT '0',
  `isadd` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL DEFAULT '0',
  `relation_url` text NOT NULL,
  `relation_name` text NOT NULL,
  `relation_table` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_news`;
CREATE TABLE `cms_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL,
  `ugroupid` int(10) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `en_title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `pic` text NOT NULL,
  `isshow` smallint(1) NOT NULL DEFAULT '1',
  `userid` int(11) NOT NULL,
  `recommend` smallint(1) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `en_content` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `onlypage` smallint(1) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('1','2','0','公司简介','','','','1','1','0','<p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">根据第三方市场研究公司艾瑞咨询的数据，京东（JD.com）是中国最大的自营式电商企业，2014第二季度在中国自营式电商市场的占有率为54.3%。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东为消费者提供愉悦的在线购物体验。通过内容丰富、人性化的网站（www.jd.com）和移动客户端，京东以富有竞争力的价格，提供具有丰富品类及卓越品质的商品和服务，以快速可靠的方式送达消费者，并且提供灵活多样的支付方式。另外，京东还为第三方卖家提供在线销售平台和物流等一系列增值服务。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东提供13大类超过4000万SKUs的丰富商品，品类包括：计算机、手机及其它数码产品、家电、汽车配件、服装与鞋类、奢侈品（如：手提包、手表与珠宝）、家居与家庭用品、化妆品与其它个人护理用品、食品与营养品、书籍、电子图书、音乐、电影与其它媒体产品、母婴用品与玩具、体育与健身器材以及虚拟商品（如：国内机票、酒店预订等）。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东拥有中国电商行业最大的仓储设施。截至2014年6月30日，京东建立了7大物流中心，在全国39座城市建立了97个仓库，总面积约为180万平方米。同时，还在全国1,780个行政区县拥有1,808个配送站和715个自提点、自提柜。京东专业的配送队伍能够为消费者提供一系列专业服务，如：211限时达、次日达、夜间配和三小时极速达，GIS包裹实时追踪、售后100分、快速退换货以及家电上门安装等服务，保障用户享受到卓越、全面的物流配送和完整的“端对端”购物体验。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东是一家技术驱动的公司，从成立伊始就投入巨资开发完善可靠、能够不断升级、以电商应用服务为核心的自有技术平台。我们将继续增强公司的技术平台实力，以便更好地提升内部运营效率，同时为合作伙伴提供卓越服务。</p><h3 style=\"margin: 20px 0px 5px; padding: 0px; font-size: 14px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">配送服务说明：</h3><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">211限时达：当日上午11：00前提交的现货订单（部分城市为上午10点前），以订单出库完成拣货时间点开始计算，当日送达；夜里11：00前提交的现货订单（以订单出库后完成拣货时间点开始计算），次日15：00前送达。截至2014年6月30日，“211限时达”已覆盖全国111个区县。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">次日达：在一定时间点之前提交的现货订单（以订单出库后完成拣货的时间点开始计算），将于次日送达。除“211限时达”服务外，京东“次日达”服务还覆盖全国622个区县。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">极速达：京东为消费者提供的一项个性化付费增值服务。消费者通过“在线支付”方式全额成功付款或“货到付款”方式成功提交订单，并勾选“极速达”服务后，京东会在服务时间内，3小时将商品送至消费者所留地址。目前，“极速达”业务在北京、上海、广州、成都、武汉、沈阳六个城市提供服务。</p><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">夜间配：京东为消费者提供更快速、更便利的一项增值服务。消费者下单时在日历中选择“19:00-22:00”时段，属“夜间配”服务范围内的商品，京东会尽可能安排配送员在消费者选定当日晚间19:00-22:00送货上门。目前，“夜间配”业务在北京、上海、广州、成都、武汉、沈阳六个城市提供服务。</p><h3 style=\"margin: 20px 0px 5px; padding: 0px; font-size: 14px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">媒体垂询:</h3><p style=\"margin: 0px; padding: 0px; text-indent: 2em; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">media-contact@jd.com</p>','','管理员','1','1411389610','1','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('2','2','0','企业文化','','','','1','1','0','<img src=\"http://www.jd.com/intro/img/jazhiguan2014.png\" alt=\"京东核心价值观\" width=\"336\" height=\"508\" style=\"text-align: center; margin: 0px; padding: 0px; vertical-align: middle; display: block; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\" />','','管理员','1','1411389738','2','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('3','2','0','成长历程','','','','1','1','0','<dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2014年2月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东推出首个互联网金融信用支付产品：“京东白条”。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2014年1月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东西北大区正式启动运营。<br />京东率先试行新消法。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年12月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东成为中国首批虚拟运营商。<br />京东会员俱乐部上线。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年11月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">发布JDPhone计划，整合产业链为用户打造最佳性价比手机。<br />京东获基金支付牌照。<br />京东正式推出“退换货运费险”，是电商业界首次退换货“双保险”。<br />京东与太原唐久便利店合作上线O2O项目。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年10月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东调整会员体系，推出“京豆”。<br />京东首次面向海外招聘国际管培生。<br />京东在自营家电品类率先推出“30天价保，30天只退不换，180天只换不修”特色服务承诺，远超国家三包法规定。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年9月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东发布首份企业社会责任报告 提出“五为”理念。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年7月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东“亚洲一号”上海物流中心（一期）完成建筑结构封顶。<br />成功举办京东首届开放平台合作伙伴大会。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年6月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东推出电商云的四大解决方案：宙斯、云鼎、云擎、云汇。<br />京东开出中国电子商务领域首张电子发票。<br />京东在北京、沈阳两地成功投放自提柜业务，消费者可24小时随时取货。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年5月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东推出 “夜间配”、“极速达”等配送服务，树立电商物流配送的新标杆。<br />京东超市业务上线。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2013年3月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东完成价值观梳理：客户为先、诚信、团队、创新、激情。新企业价值观的核心是“客户为先”。<br />京东域名正式更换为JD.COM，并推出名为“Joy”的吉祥物形象。<br />京东与中国顶级足球赛事中超联赛牵手，成为中超联赛一级合作伙伴。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2012年11月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东上线供应链金融服务“京保贝”，可以实现三分钟向供应商提供融资服务。<br />京东正式开放物流服务系统平台。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2012年10月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东海外站（英文网站）正式上线公测，迈出国际化重要一步。<br />京东完成了对第三方支付公司网银在线的完全收购，正式布局支付体系。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2012年1月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东在线客服正式上线，在网站访客与京东之间搭建起全新的即时沟通渠道。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2011年11月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东进军奢侈品领域，正式推出奢侈品购物网站360Top.com。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2010年12月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东开放平台正式运营。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2010年11月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东图书产品上架销售，实现从3C网络零售商向综合型网络零售商转型。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2010年6月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东开通全国上门取件服务，解决网购的售后之忧。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2010年3月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东推出“211限时达”极速配送，引领并建立了中国B2C行业的全新标准。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2009年10月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东呼叫中心由分布式管理升级为集中式管理，且由北京总部搬迁至江苏省宿迁市。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2009年2月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东获得国家商务部发放的“家电下乡”零售商牌照，成为首个承担家电下乡任务的电子商务企业。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2008年6月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东上线电视、空调、冰洗等大家电产品线，完成了3C产品的全线搭建。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2007年10月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东在北京、上海、广州三地启用移动POS上门刷卡服务，开创了中国电子商务的先河。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2007年7月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东建成北京、上海、广州三大物流体系。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2007年6月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东正式启动全新域名www.360buy.com，并成功改版，正式更名为京东商城。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2007年5月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东全力开拓华南市场，在广州成立华南分公司。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2006年1月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东宣布进军上海，成立上海全资子公司。</dd><dt style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">2004年1月</dt><dd style=\"margin: 0px 0px 25px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, Verdana, 宋体; line-height: 22px;\">京东涉足电子商务领域，京东多媒体网正式开通，启用域名www.jdlaser.com。</dd>','','管理员','1','1411389794','3','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('4','2','0','联系我们','','','','1','1','0','<ul class=\"contact_list margin_b18\" style=\"margin: 0px 0px 18px; padding: 15px 0px 0px; list-style: none; color: rgb(102, 102, 102); font-family: Arial, Verdana, 宋体; line-height: 24px;\"><li style=\"margin: 0px 0px 26px; padding: 0px; color: rgb(51, 51, 51);\"><span style=\"margin: 0px; padding: 0px;\">采销业务：</span><br />如果您想由京东代理、销售您的商品，请<a href=\"http://www.jd.com/contact/sampling.aspx\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">点此了解»</a></li><li style=\"margin: 0px 0px 26px; padding: 0px; color: rgb(51, 51, 51);\"><span style=\"margin: 0px; padding: 0px;\">开放平台业务：</span><br />如果您想借助京东开放平台销售您的商品，了解京东开放平台政策，请<a href=\"http://www.360buy.com/contact/joinin.aspx\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">点此了解»</a></li><li style=\"margin: 0px 0px 26px; padding: 0px; color: rgb(51, 51, 51);\"><span style=\"margin: 0px; padding: 0px;\">企业采购业务：</span><br />如果您是企业，想集中采购商品、成为京东企业客户，请<a href=\"http://market.360buy.com/giftcard/company/default.aspx\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">点此了解»</a></li><li style=\"margin: 0px 0px 26px; padding: 0px; color: rgb(51, 51, 51);\"><span style=\"margin: 0px; padding: 0px;\">广告服务：</span><br />如果您希望在京东商城投放广告，请<a href=\"http://www.360buy.com/intro/service.aspx\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">点此了解»</a></li><li style=\"margin: 0px 0px 26px; padding: 0px; color: rgb(51, 51, 51);\"><span style=\"margin: 0px; padding: 0px;\">战略合作及其他：</span><br />如果您希望和京东商城进行战略合作或多业务合作（<span style=\"margin: 0px; padding: 0px; color: rgb(228, 57, 60);\">不受理银行、支付等涉及资金业务</span>），请<a href=\"http://www.360buy.com/contact/cooperate.aspx\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">点此了解»</a></li><li style=\"margin: 0px 0px 26px; padding: 0px; color: rgb(51, 51, 51);\"><span style=\"margin: 0px; padding: 0px;\">人才招聘：</span><br />如果您希望加入京东公司，与京东共同成长与发展，欢迎<a href=\"http://zhaopin.360buy.com/\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">查看招聘职位»</a></li><li style=\"margin: 0px 0px 26px; padding: 20px 0px 0px; color: rgb(51, 51, 51); border-top-width: 1px; border-top-style: dotted; border-top-color: rgb(204, 204, 204);\"><span style=\"margin: 0px; padding: 0px;\">京东全国客服中心：</span><br />联系页面：<a href=\"http://help.360buy.com/help/question-62.html\" style=\"margin: 0px; padding: 0px; color: rgb(0, 94, 167); text-decoration: none;\">http://help.360buy.com/help/question-62.html</a></li></ul>','','管理员','1','1411389895','4','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('5','3','0','免责申明','','','','1','1','0','<h4 style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif; line-height: 18px;\">京东用户注册协议</h4><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">本协议是您与京东网站（简称&quot;本站&quot;，网址：www.jd.com）所有者（以下简称为&quot;京东&quot;）之间就京东网站服务等相关事宜所订立的契约，请您仔细阅读本注册协议，您点击&quot;同意并继续&quot;按钮后，本协议即构成对双方有约束力的法律文件。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第1条 本站服务条款的确认和接纳</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">1.1</span>本站的各项电子服务的所有权和运作权归京东所有。用户同意所有注册协议条款并完成注册程序，才能成为本站的正式用户。用户确认：本协议条款是处理双方权利义务的契约，始终有效，法律另有强制性规定或双方另有特别约定的，依其规定。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">1.2</span>用户点击同意本协议的，即视为用户确认自己具有享受本站服务、下单购物等相应的权利能力和行为能力，能够独立承担法律责任。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">1.3</span>如果您在18周岁以下，您只能在父母或监护人的监护参与下才能使用本站。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">1.4</span>京东保留在中华人民共和国大陆地区法施行之法律允许的范围内独自决定拒绝服务、关闭用户账户、清除或编辑内容或取消订单的权利。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第2条 本站服务</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">2.1</span>京东通过互联网依法为用户提供互联网信息等服务，用户在完全同意本协议及本站规定的情况下，方有权使用本站的相关服务。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">2.2</span>用户必须自行准备如下设备和承担如下开支：（1）上网设备，包括并不限于电脑或者其他上网终端、调制解调器及其他必备的上网装置；（2）上网开支，包括并不限于网络接入费、上网设备租用费、手机流量费等。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第3条 用户信息</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">3.1</span>用户应自行诚信向本站提供注册资料，用户同意其提供的注册资料真实、准确、完整、合法有效，用户注册资料如有变动的，应及时更新其注册资料。如果用户提供的注册资料不合法、不真实、不准确、不详尽的，用户需承担因此引起的相应责任及后果，并且京东保留终止用户使用京东各项服务的权利。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">3.2</span>用户在本站进行浏览、下单购物等活动时，涉及用户真实姓名/名称、通信地址、联系电话、电子邮箱等隐私信息的，本站将予以严格保密，除非得到用户的授权或法律另有规定，本站不会向外界披露用户隐私信息。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">3.3</span>用户注册成功后，将产生用户名和密码等账户信息，您可以根据本站规定改变您的密码。用户应谨慎合理的保存、使用其用户名和密码。用户若发现任何非法使用用户账号或存在安全漏洞的情况，请立即通知本站并向公安机关报案。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">3.4</span><span style=\"margin: 0px; padding: 0px;\">用户同意，京东拥有通过邮件、短信电话等形式，向在本站注册、购物用户、收货人发送订单信息、促销活动等告知信息的权利。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">3.5</span><span style=\"margin: 0px; padding: 0px;\">用户不得将在本站注册获得的账户借给他人使用，否则用户应承担由此产生的全部责任，并与实际使用人承担连带责任。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">3.6</span><span style=\"margin: 0px; padding: 0px;\">用户同意，京东有权使用用户的注册信息、用户名、密码等信息，登录进入用户的注册账户，进行证据保全，包括但不限于公证、见证等。</span></p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第4条 用户依法言行义务</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">本协议依据国家相关法律法规规章制定，用户同意严格遵守以下义务：</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（1）</span>不得传输或发表：煽动抗拒、破坏宪法和法律、行政法规实施的言论，煽动颠覆国家政权，推翻社会主义制度的言论，煽动分裂国家、破坏国家统一的的言论，煽动民族仇恨、民族歧视、破坏民族团结的言论；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（2）</span>从中国大陆向境外传输资料信息时必须符合中国有关法规；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（3）</span>不得利用本站从事洗钱、窃取商业秘密、窃取个人信息等违法犯罪活动；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（4）</span>不得干扰本站的正常运转，不得侵入本站及国家计算机信息系统；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（5）</span>不得传输或发表任何违法犯罪的、骚扰性的、中伤他人的、辱骂性的、恐吓性的、伤害性的、庸俗的，淫秽的、不文明的等信息资料；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（6）</span>不得传输或发表损害国家社会公共利益和涉及国家安全的信息资料或言论；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（7）</span>不得教唆他人从事本条所禁止的行为；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（8）</span>不得利用在本站注册的账户进行牟利性经营活动；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（9）</span>不得发布任何侵犯他人著作权、商标权等知识产权或合法权利的内容；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">用户应不时关注并遵守本站不时公布或修改的各类合法规则规定。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">本站保有删除站内各类不符合法律政策或不真实的信息内容而无须通知用户的权利。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">若用户未遵守以上规定的，本站有权作出独立判断并采取暂停或关闭用户帐号等措施。</span>用户须对自己在网上的言论和行为承担法律责任。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第5条 商品信息</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">本站上的商品价格、数量、是否有货等商品信息随时都有可能发生变动，本站不作特别通知。由于网站上商品信息的数量极其庞大，虽然本站会尽最大努力保证您所浏览商品信息的准确性，但由于众所周知的互联网技术因素等客观原因存在，本站网页显示的信息可能会有一定的滞后性或差错，对此情形您知悉并理解；京东欢迎纠错，并会视情况给予纠错者一定的奖励。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">为表述便利，商品和服务简称为&quot;商品&quot;或&quot;货物&quot;。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第6条 订单</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">6.1</span>在您下订单时，请您仔细确认所购商品的名称、价格、数量、型号、规格、尺寸、联系地址、电话、收货人等信息。<span style=\"margin: 0px; padding: 0px;\">收货人与用户本人不一致的，收货人的行为和意思表示视为用户的行为和意思表示，用户应对收货人的行为及意思表示的法律后果承担连带责任。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">6.2</span><span style=\"margin: 0px; padding: 0px;\">除法律另有强制性规定外，双方约定如下：本站上销售方展示的商品和价格等信息仅仅是要约邀请，您下单时须填写您希望购买的商品数量、价款及支付方式、收货人、联系方式、收货地址（合同履行地点）、合同履行方式等内容；系统生成的订单信息是计算机信息系统根据您填写的内容自动生成的数据，仅是您向销售方发出的合同要约；销售方收到您的订单信息后，只有在销售方将您在订单中订购的商品从仓库实际直接向您发出时（ 以商品出库为标志），方视为您与销售方之间就实际直接向您发出的商品建立了合同关系；如果您在一份订单里订购了多种商品并且销售方只给您发出了部分商品时，您与销售方之间仅就实际直接向您发出的商品建立了合同关系；只有在销售方实际直接向您发出了订单中订购的其他商品时，您和销售方之间就订单中该其他已实际直接向您发出的商品才成立合同关系。您可以随时登录您在本站注册的账户，查询您的订单状态。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">6.3</span><span style=\"margin: 0px; padding: 0px;\">由于市场变化及各种以合理商业努力难以控制的因素的影响，本站无法保证您提交的订单信息中希望购买的商品都会有货；如您拟购买的商品，发生缺货，您有权取消订单。</span></p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第7条 配送</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">7.1</span>销售方将会把商品（货物）送到您所指定的收货地址，所有在本站上列出的送货时间为参考时间，参考时间的计算是根据库存状况、正常的处理过程和送货时间、送货地点的基础上估计得出的。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">7.2</span>因如下情况造成订单延迟或无法配送等，销售方不承担延迟配送的责任：</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（1）</span>用户提供的信息错误、地址不详细等原因导致的；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（2）</span>货物送达后无人签收，导致无法配送或延迟配送的；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（3）</span>情势变更因素导致的；</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">（4）</span>不可抗力因素导致的，例如：自然灾害、交通戒严、突发战争等。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第8条 所有权及知识产权条款</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">8.1</span><span style=\"margin: 0px; padding: 0px;\">用户一旦接受本协议，即表明该用户主动将其在任何时间段在本站发表的任何形式的信息内容（包括但不限于客户评价、客户咨询、各类话题文章等信息内容）的财产性权利等任何可转让的权利，如著作权财产权（包括并不限于：复制权、发行权、出租权、展览权、表演权、放映权、广播权、信息网络传播权、摄制权、改编权、翻译权、汇编权以及应当由著作权人享有的其他可转让权利），全部独家且不可撤销地转让给京东所有，用户同意京东有权就任何主体侵权而单独提起诉讼。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">8.2</span><span style=\"margin: 0px; padding: 0px;\">本协议已经构成《中华人民共和国著作权法》第二十五条（条文序号依照2011年版著作权法确定）及相关法律规定的著作财产权等权利转让书面协议，其效力及于用户在京东网站上发布的任何受著作权法保护的作品内容，无论该等内容形成于本协议订立前还是本协议订立后。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">8.3</span><span style=\"margin: 0px; padding: 0px;\">用户同意并已充分了解本协议的条款，承诺不将已发表于本站的信息，以任何形式发布或授权其它主体以任何方式使用（包括但限于在各类网站、媒体上使用）。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">8.4</span><span style=\"margin: 0px; padding: 0px;\">京东是本站的制作者,拥有此网站内容及资源的著作权等合法权利,受国家法律保护,有权不时地对本协议及本站的内容进行修改，并在本站张贴，无须另行通知用户。在法律允许的最大限度范围内，京东对本协议及本站内容拥有解释权。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">8.5</span><span style=\"margin: 0px; padding: 0px;\">除法律另有强制性规定外，未经京东明确的特别书面许可,任何单位或个人不得以任何方式非法地全部或部分复制、转载、引用、链接、抓取或以其他方式使用本站的信息内容，否则，京东有权追究其法律责任。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">8.6</span>本站所刊登的资料信息（诸如文字、图表、标识、按钮图标、图像、声音文件片段、数字下载、数据编辑和软件），均是京东或其内容提供者的财产，受中国和国际版权法的保护。本站上所有内容的汇编是京东的排他财产，受中国和国际版权法的保护。本站上所有软件都是京东或其关联公司或其软件供应商的财产，受中国和国际版权法的保护。</p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第9条 责任限制及不承诺担保</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">除非另有明确的书面说明,本站及其所包含的或以其它方式通过本站提供给您的全部信息、内容、材料、产品（包括软件）和服务，均是在&quot;按现状&quot;和&quot;按现有&quot;的基础上提供的。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">除非另有明确的书面说明,京东不对本站的运营及其包含在本网站上的信息、内容、材料、产品（包括软件）或服务作任何形式的、明示或默示的声明或担保（根据中华人民共和国法律另有规定的以外）。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">京东不担保本站所包含的或以其它方式通过本站提供给您的全部信息、内容、材料、产品（包括软件）和服务、其服务器或从本站发出的电子信件、信息没有病毒或其他有害成分。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">如因不可抗力或其它本站无法控制的原因使本站销售系统崩溃或无法正常使用导致网上交易无法完成或丢失有关的信息、记录等，京东会合理地尽力协助处理善后事宜。</span></p><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第10条 协议更新及用户关注义务</h5><span style=\"color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif; line-height: 18px;\">根据国家法律法规变化及网站运营需要，京东有权对本协议条款不时地进行修改，修改后的协议一旦被张贴在本站上即生效，并代替原来的协议。用户可随时登录查阅最新协议；</span><span style=\"margin: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif; line-height: 18px;\"><span style=\"margin: 0px; padding: 0px;\">用户有义务不时关注并阅读最新版的协议及网站公告。如用户不同意更新后的协议，可以且应立即停止接受京东网站依据本协议提供的服务；如用户继续使用本网站提供的服务的，即视为同意更新后的协议。京东建议您在使用本站之前阅读本协议及本站的公告。</span></span><span style=\"color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif; line-height: 18px;\">&nbsp;如果本协议中任何一条被视为废止、无效或因任何理由不可执行，该条应视为可分的且并不影响任何其余条款的有效性和可执行性。</span><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第11条 法律管辖和适用</h5><span style=\"color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif; line-height: 18px;\">本协议的订立、执行和解释及争议的解决均应适用在中华人民共和国大陆地区适用之有效法律（但不包括其冲突法规则）。 如发生本协议与适用之法律相抵触时，则这些条款将完全按法律规定重新解释，而其它有效条款继续有效。 如缔约方就本协议内容或其执行发生任何争议，双方应尽力友好协商解决；协商不成时，任何一方均可向有管辖权的中华人民共和国大陆地区法院提起诉讼。</span><h5 style=\"margin: 0px; padding: 0px; font-size: 12px; line-height: 30px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\">第12条 其他</h5><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">12.1</span>京东网站所有者是指在政府部门依法许可或备案的京东网站经营主体。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">12.2</span>京东尊重用户和消费者的合法权利，本协议及本网站上发布的各类规则、声明等其他内容，均是为了更好的、更加便利的为用户和消费者提供服务。本站欢迎用户和社会各界提出意见和建议，京东将虚心接受并适时修改本协议及本站上的各类规则。</p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">12.3</span><span style=\"margin: 0px; padding: 0px;\">本协议内容中以黑体、加粗、下划线、斜体等方式显著标识的条款，请用户着重阅读。</span></p><p style=\"margin: 0px; padding: 0px; line-height: 20px; color: rgb(51, 51, 51); font-family: Arial, 宋体, Lucida, Verdana, Helvetica, sans-serif;\"><span style=\"margin: 0px; padding: 0px;\">12.4</span><span style=\"margin: 0px; padding: 0px;\">您点击本协议下方的&quot;同意并继续&quot;按钮即视为您完全接受本协议，在点击之前请您再次确认已知悉并完全理解本协议的全部内容。</span></p>','','管理员','1','1411389980','1','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('6','3','0','版权信息','','','','1','1','0','版权信息','','管理员','1','1411390082','2','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('7','3','0','投诉建议','','?mod=complaint','','1','1','0','','','管理员','1','1411390191','3','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('8','4','0','我们的优势','','','','1','1','0','我们的优势','','管理员','1','1411390336','1','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('9','4','0','我们的理念','','','','1','1','0','我们的理念','','管理员','1','1411390441','2','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('14','20','0','资讯供应商资讯供应商资讯供应商资1','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412667427','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('10','4','0','媒体合作','','','','1','1','0','媒体合作','','管理员','1','1411390530','3','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('11','5','0','新手导航','','','','1','1','0','新手导航','','管理员','1','1411390562','1','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('12','5','0','常见问题','','','','1','1','0','常见问题','','管理员','1','1411390624','2','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('13','5','0','网站地图','','','','1','1','0','网站地图','','管理员','1','1411390650','3','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('15','20','0','资讯供应商资讯供应商资讯供应商资2','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412667450','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('16','20','0','资讯供应商资讯供应商资讯供应商资3','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412667472','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('18','20','0','资讯供应商资讯供应商资讯供应商资5','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412667510','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('17','20','0','资讯供应商资讯供应商资讯供应商资4','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412667486','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('19','20','0','资讯供应商资讯供应商资讯供应商资6','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412667525','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('20','18','0','不犭钢轮胎','','','a1.png','1','1','0','不犭钢轮胎','','管理员','0','1412667754','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('21','18','0','生犭钢轮胎','','','a2.png','1','1','0','生犭钢轮胎','','管理员','0','1412667844','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('22','12','0','资讯供应商资讯供应商资讯供应商资1','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668140','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('23','13','0','资讯供应商资讯供应商资讯供应商资2','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668175','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('24','14','0','资讯供应商资讯供应商资讯供应商资3','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668186','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('25','12','0','资讯供应商资讯供应商资讯供应商资4','','','n1.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668198','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('26','13','0','资讯供应商资讯供应商资讯供应商资5','','','shop.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668210','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('27','19','0','资讯供应商资讯供应商资讯','','','','1','1','0','asfd厅','','管理员','0','1412668568','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('28','19','0','资讯供应商资讯供应商资讯4','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news_show&amp;id=14\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯</a>','','管理员','0','1412668590','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('29','19','0','资讯供应商资讯供应商资讯6','','','','1','1','0','<a href=\"http://lc.z.com/?mod=news_show&amp;id=14\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯</a>','','管理员','0','1412668607','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('30','9','0','新疆鸟撸木齐','','','n1.png','1','1','0','<p><a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 25px;\"><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳<span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，</span></span></a></p><p><a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 25px;\"><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\"><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳</span></span></a></p>','','管理员','0','1412668951','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('31','9','0','zzzzzzzzzzzzzzzzzzzzz','','','','1','1','0','asfdfsasfdfsafdsa','','管理员','0','1412669204','1','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('32','10','0','新疆鸟撸木齐','','','n1.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 25px;\"><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳<span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳</span></span></a>','','管理员','0','1412668951','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('33','10','0','zzzzzzzzzzzzzzzzzzzzz','','','','1','1','0','asfdfsasfdfsafdsa','','管理员','0','1412669204','1','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('34','9','0','新疆鸟撸木齐','','','n1.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 25px;\"><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳<span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳</span></span></a>','','管理员','0','1412668951','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('35','10','0','新疆鸟撸木齐','','','n1.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 25px;\"><span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳<span style=\"color: rgb(34, 34, 34); font-family: Consolas, \'Lucida Console\', monospace; white-space: nowrap;\">路远，心更远，是每个善领人的极致追求。在过去的5年里，善领从不足10平方米的办公室，现已发展成拥有深圳</span></span></a>','','管理员','0','1412668951','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('36','11','0','政策资讯新闻标题','','','','1','1','0','<ul style=\"margin: 0px; padding: 0px; list-style-type: none; font-family: Simsun;\"><li style=\"margin: 0px; padding: 0px 0px 0px 10px; list-style-type: disc; line-height: 25px; list-style-position: inside;\">政策<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">资讯新闻标题</a></li></ul>','','管理员','0','1412669505','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('37','11','0','政策资讯新闻标题','','','','1','1','0','<ul style=\"margin: 0px; padding: 0px; list-style-type: none; font-family: Simsun;\"><li style=\"margin: 0px; padding: 0px 0px 0px 10px; list-style-type: disc; line-height: 25px; list-style-position: inside;\">政策<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">资讯新闻标题</a></li></ul>','','管理员','0','1412669505','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('38','11','0','政策资讯新闻标题','','','','1','1','0','<ul style=\"margin: 0px; padding: 0px; list-style-type: none; font-family: Simsun;\"><li style=\"margin: 0px; padding: 0px 0px 0px 10px; list-style-type: disc; line-height: 25px; list-style-position: inside;\">政策<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">资讯新闻标题</a></li></ul>','','管理员','0','1412669505','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('39','11','0','政策资讯新闻标题','','','','1','1','0','<ul style=\"margin: 0px; padding: 0px; list-style-type: none; font-family: Simsun;\"><li style=\"margin: 0px; padding: 0px 0px 0px 10px; list-style-type: disc; line-height: 25px; list-style-position: inside;\">政策<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">资讯新闻标题</a></li></ul>','','管理员','0','1412669505','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('40','11','0','政策资讯新闻标题','','','shop.png','1','1','0','<ul style=\"margin: 0px; padding: 0px; list-style-type: none; font-family: Simsun;\"><li style=\"margin: 0px; padding: 0px 0px 0px 10px; list-style-type: disc; line-height: 25px; list-style-position: inside;\">政策<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">资讯新闻标题</a></li></ul>','','管理员','0','1412669505','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('41','11','0','政策资讯新闻标题','','','','1','1','0','<ul style=\"margin: 0px; padding: 0px; list-style-type: none; font-family: Simsun;\"><li style=\"margin: 0px; padding: 0px 0px 0px 10px; list-style-type: disc; line-height: 25px; list-style-position: inside;\">政策<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0);\">资讯新闻标题</a></li></ul>','','管理员','0','1412669505','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('42','15','0','资讯供应商资讯供应商资讯供应商资4','','','n1.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668198','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('43','16','0','资讯供应商资讯供应商资讯供应商资5','','','shop.png','1','1','0','<a href=\"http://lc.z.com/?mod=news\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">资讯供应商资讯供应商资讯供应商资</a>','','管理员','0','1412668210','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('44','17','0','成功故事1','','','','1','1','0','sfdsdf','','管理员','0','1412671297','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('45','17','0','成功故事2','','','','1','1','0','sfdsdf','','管理员','0','1412671297','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('46','22','0','名企招聘1','','','','1','1','0','<a href=\"http://lc.z.com/?mod=jobs\" style=\"text-decoration: none; color: rgb(0, 0, 0); font-family: Simsun; line-height: 32px;\">名</a>企招聘','','管理员','0','1412679413','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('47','23','0','教你用人1','','','','1','1','0','教你用人a','','管理员','0','1412679447','0','0','0');
insert into `cms_news`(`id`,`typeid`,`ugroupid`,`title`,`en_title`,`url`,`pic`,`isshow`,`userid`,`recommend`,`content`,`en_content`,`author`,`onlypage`,`addtime`,`sortid`,`hits`,`lang`) values('48','24','0','职场资讯1','','','','1','1','0','职场资讯','','管理员','0','1412679470','0','0','0');

DROP TABLE IF EXISTS `cms_newstype`;
CREATE TABLE `cms_newstype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `en_title` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `isshow` smallint(1) NOT NULL DEFAULT '1',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('1','0','帮助中心','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('2','1','关于我们','','1','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('3','1','供求须知','','2','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('4','1','加入我们','','3','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('5','1','新手上路','','4','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('6','0','行业资讯','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('7','0','企业动态','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('8','0','知识库','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('9','6','行业动态','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('10','6','市场研究','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('11','6','政策法规','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('12','7','企业新闻','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('13','7','业界名人','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('14','7','新品推荐','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('15','8','行业知识','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('16','8','再利用技术','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('17','8','成功故事','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('18','0','专题活动','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('19','0','视频新闻','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('20','0','最新资讯','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('21','0','招聘中心','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('22','21','名企招聘','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('23','21','教你用人','','0','','1','0');
insert into `cms_newstype`(`id`,`typeid`,`title`,`en_title`,`sortid`,`url`,`isshow`,`lang`) values('24','21','职场资讯','','0','','1','0');

DROP TABLE IF EXISTS `cms_product`;
CREATE TABLE `cms_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `en_title` varchar(255) NOT NULL,
  `en_content` text NOT NULL,
  `short_title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `pic` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `video_url` varchar(255) NOT NULL,
  `hot` tinyint(1) NOT NULL DEFAULT '0',
  `isshow` tinyint(1) NOT NULL DEFAULT '0',
  `recommend` tinyint(1) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0',
  `hits` int(11) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL DEFAULT '0',
  `product_attribute_id` int(11) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_productattribute`;
CREATE TABLE `cms_productattribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `attrtype` tinyint(1) NOT NULL DEFAULT '0',
  `attrinputtype` tinyint(1) NOT NULL DEFAULT '0',
  `attrvalue` text NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0',
  `attr_group` int(11) NOT NULL DEFAULT '0',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_productinfoattr`;
CREATE TABLE `cms_productinfoattr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL DEFAULT '0',
  `attrid` int(11) NOT NULL DEFAULT '0',
  `attrvalue` text NOT NULL,
  `attrprice` decimal(10,2) NOT NULL DEFAULT '0.00',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_productptype`;
CREATE TABLE `cms_productptype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `sortid` int(11) NOT NULL DEFAULT '0',
  `isshow` tinyint(1) NOT NULL DEFAULT '0',
  `attr_group` text NOT NULL,
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_producttype`;
CREATE TABLE `cms_producttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `en_title` varchar(255) NOT NULL,
  `typeid` int(11) NOT NULL DEFAULT '0',
  `sortid` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) NOT NULL,
  `isshow` tinyint(1) NOT NULL DEFAULT '1',
  `lang` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `content` varchar(50) NOT NULL,
  `role` text NOT NULL,
  `module_role` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `cms_users`;
CREATE TABLE `cms_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `utype` int(1) NOT NULL DEFAULT '1',
  `realname` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `qq` varchar(64) NOT NULL,
  `email` varchar(50) NOT NULL,
  `last_date` int(10) NOT NULL,
  `reg_date` int(11) NOT NULL,
  `clicks` int(11) NOT NULL,
  `fax` varchar(64) NOT NULL,
  `tel` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('6','zheng','4297f44b13955235245b2497399d7a93','','1','','15355415000','','469228228@qq.com','1402887338','1402887338','0','','');
insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('8','zkj','bb7d3a72748d611cb54c1ef75828a46a','','1','','','','zhengkejian@sina.com','1408629439','1408629439','0','','');
insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('9','kzk','bb7d3a72748d611cb54c1ef75828a46a','','1','','','','zhengkejian@sina.com','1408695433','1408695433','0','','');
insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('10','ff','633de4b0c14ca52ea2432a3c8a5c4c31','','1','','','','f@qq.com','1408699559','1408699559','0','','');
insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('11','aa','74b87337454200d4d33f80c4663dc5e5','','1','','','','2832930231@qq.com','1408699790','1408699790','0','','');
insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('12','sandi8632273','db0fa8b02584ebcedfb3d7f9e35b332d','','1','','','','24254577@QQ.com','1408703933','1408703933','0','','');
insert into `cms_users`(`id`,`username`,`password`,`sex`,`utype`,`realname`,`phone`,`qq`,`email`,`last_date`,`reg_date`,`clicks`,`fax`,`tel`) values('13','zkjzzzzzzzz','4297f44b13955235245b2497399d7a93','1','1','dsaf','213','','132','1412664582','1412664582','0','','132');

