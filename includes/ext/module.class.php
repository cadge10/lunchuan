<?php
// 模型处理类库
class module {
	private $db = NULL;
	public function __construct() {
		$this->db = DB_ENGINE_NAME == 'mysqli'?new mysqli_db() : new mysql();
	}
	public function create_module($moduleid,$table,$type = 'emptytable') {
		if ($table == '') return false;
		if (!defined('DB_PREFIX')) return false;
		$moduleid = (int)$moduleid;
		if ($moduleid <= 0) return false;
		
		if ($type == 'emptytable') {
			$bool = $this->db->query("CREATE TABLE `###_".$table."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `userid` int(11) NOT NULL DEFAULT '0',
			  `sortid` int(11) NOT NULL DEFAULT '0',
			  `title` varchar(255) NOT NULL DEFAULT '',
			  `title_style` varchar(255) NOT NULL DEFAULT '',
			  `thumb` varchar(255) NOT NULL DEFAULT '',
			  `addtime` int(10) NOT NULL DEFAULT '0',
			  `isshow` tinyint(1) NOT NULL DEFAULT '0',
			  `lang` tinyint(3) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8",false);
			if ($bool != true) return false;
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','title','标题','1','1','255',
			  '','','请填写标题','title','array (\n  \'style\' => \'1\',\n  \'size\' => \'50\',\n)','0','1','1'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','isshow','审核','0','','',
			  '','','','radio','array (\n  \'options\' => \'是|1\r\n否|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'default\' => \'1\',\n)','1','1','0')",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','addtime','创建时间','0','','',
			  '','','','datetime','','2','1','0'
			)",false);
		} else {
			$bool = $this->db->query("CREATE TABLE `###_".$table."` (
			  `id` int(11) NOT NULL AUTO_INCREMENT,
			  `typeid` int(11) NOT NULL DEFAULT '0',
			  `userid` int(11) NOT NULL DEFAULT '0',
			  `sortid` int(11) NOT NULL DEFAULT '0',
			  `title` varchar(255) NOT NULL DEFAULT '',
			  `title_style` varchar(255) NOT NULL DEFAULT '',
			  `thumb` varchar(255) NOT NULL DEFAULT '',
			  `keyword` varchar(255) NOT NULL DEFAULT '',
			  `description` mediumtext NOT NULL,
			  `content` text NOT NULL,
			  `isshow` tinyint(1) NOT NULL DEFAULT '0',
			  `hits` int(11) NOT NULL DEFAULT '0',
			  `addtime` int(11) NOT NULL DEFAULT '0',
			  `lang` int(3) NOT NULL DEFAULT '0',
			  PRIMARY KEY (`id`)
			) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8",false);
			if ($bool != true) return false;
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','typeid','栏目名称','1','1','11',
			  '','','请选择栏目','typeid','','0','1','1'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','title','标题','1','1','255',
			  '','','请填写标题','title','array (\n  \'style\' => \'1\',\n  \'size\' => \'50\',\n)','1','1','1'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','keyword','关键字','0','1','255',
			  '','','','text','array (\n  \'size\' => \'55\',\n  \'default\' => \'\',\n  \'ispassword\' => \'0\',\n  \'fieldtype\' => \'varchar\',\n)','3','1','0'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','description','描述','0','1','255',
			  '','','','textarea','array (\n  \'fieldtype\' => \'mediumtext\',\n  \'rows\' => \'4\',\n  \'cols\' => \'55\',\n  \'default\' => \'\',\n)','4','1','0'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','content','内容','0','','',
			  '','','','editor','array (\n  \'toolbar\' => \'full\',\n  \'default\' => \'\',\n  \'height\' => \'\',\n  \'showpage\' => \'1\',\n)','5','1','0'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','isshow','审核','0','','',
			  '','','','radio','array (\n  \'options\' => \'是|1\r\n否|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'default\' => \'1\',\n)','6','1','1'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','hits','点击次数','0','','',
			  '','','','number','array (\n  \'size\' => \'10\',\n  \'decimaldigits\' => \'0\',\n  \'default\' => \'0\',\n)','7','1','0'
			)",false);
			$this->db->query("INSERT INTO `###_field`(
			  `moduleid`,`title`,`name`,`required`,`minlength`,`maxlength`,
			  `pattern`,`defaultmsg`,`errormsg`,`type`,`setup`,`sortid`,`status`,`issystem`
			) VALUES (
			  '$moduleid','addtime','创建时间','0','','',
			  '','','','datetime','','8','1','0'
			)",false);
		}
	}
	public function delete_module($moduleid) {
		$moduleid = (int)$moduleid;
		if ($moduleid <= 0) return false;
		// 获取模型的表名
		$data = $this->db->get_one("SELECT * FROM ###_module WHERE id='$moduleid'");
		if (empty($data)) return false;
		$table = trim($data['name']);
		if ($table == '') return false;
		$this->db->query("DROP TABLE IF EXISTS `###_".$table."`"); // 删除表
		$this->db->query("DELETE FROM ###_field WHERE moduleid='$moduleid'"); // 删除表字段
	}
	
	public static function get_tablesql($info,$do){
		error_reporting(0);
		$fieldtype = $info['type'];
		$_fieldtype = isset($info['setup']['fieldtype'])?$info['setup']['fieldtype']:'';
		if($_fieldtype){
			$fieldtype = $info['setup']['fieldtype'];
		}
		$moduleid = $info['moduleid'];
		$_tablename = @$GLOBALS['db']->get_count("SELECT `name` FROM ###_module WHERE id='$moduleid'");
		if (!$_tablename) return '';
		$default=@$info['setup']['default'];
		$field = @$info['title'];
		$tablename='###_'.strtolower($_tablename);
		$maxlength = intval($info['maxlength']);
		$minlength = intval($info['minlength']);
		$numbertype = @$info['setup']['numbertype'];
		$oldfield = @$info['oldfield'];
		if($do=='add'){ $do = ' ADD ';}else{$do =  " CHANGE `$oldfield` ";}
		
		switch($fieldtype) {
			case 'varchar':
				if(!$maxlength) $maxlength = 255;
				$maxlength = min($maxlength, 255);
				$sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( $maxlength ) NOT NULL DEFAULT '$default'";
			break;

			case 'title':
				if(!$maxlength) $maxlength = 255;
				$maxlength = min($maxlength, 255);
				$sql = array();
				$sql = "ALTER TABLE `$tablename` $do `title` VARCHAR( $maxlength ) NOT NULL DEFAULT '$default'";
			break;

			case 'typeid':
				$sql = "ALTER TABLE `$tablename` $do `$field` INT(11) UNSIGNED NOT NULL DEFAULT '0'";
			break;

			case 'number':
				$decimaldigits = @(int)$info['setup']['decimaldigits'];
				$default = $decimaldigits == 0 ? intval($default) : floatval($default);
				$sql = "ALTER TABLE `$tablename` $do `$field` ".($decimaldigits == 0 ? 'INT' : 'decimal( 10,'.$decimaldigits.' )')."  NOT NULL DEFAULT '$default'";
			break;

			case 'tinyint':
				if(!$maxlength) $maxlength = 3;
				$maxlength = min($maxlength,3);
				$default = intval($default);
				$sql = "ALTER TABLE `$tablename` $do `$field` TINYINT( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default'";
			break;


			case 'smallint':
				$default = intval($default);
				if(!$maxlength) $maxlength = 8;
				$maxlength = min($maxlength,8);
				$sql = "ALTER TABLE `$tablename` $do `$field` SMALLINT( $maxlength ) ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default'";
			break;

			case 'int':
				$default = intval($default);
				$sql = "ALTER TABLE `$tablename` $do `$field` INT ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default'";
			break;

			case 'mediumint':
				$default = intval($default);
				$sql = "ALTER TABLE `$tablename` $do `$field` INT ".($numbertype ==1 ? 'UNSIGNED' : '')." NOT NULL DEFAULT '$default'";
			break;

			case 'mediumtext':
				$sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL";
			break;
			
			case 'text':
				$sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
			break;

			case 'datetime':
				$sql = "ALTER TABLE `$tablename` $do `$field` INT(11) UNSIGNED NOT NULL DEFAULT '0'";
			break;
			
			case 'editor':
				$sql = "ALTER TABLE `$tablename` $do `$field` TEXT NOT NULL";
			break;
			
			case 'image':
				$sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 255 ) NOT NULL DEFAULT ''";
			break;

			case 'images':
				$sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL";
			break;

			case 'file':
				$sql = "ALTER TABLE `$tablename` $do `$field` VARCHAR( 255 ) NOT NULL DEFAULT ''";
			break;

			case 'files':
				$sql = "ALTER TABLE `$tablename` $do `$field` MEDIUMTEXT NOT NULL";
			break;
			
			case 'relationid':
				$sql = "ALTER TABLE `$tablename` $do `$field` INT(11) NOT NULL DEFAULT '0'";
			break;
		}
		return $sql;
	}
	
	public static function getFields($tableName) {
		$result =   $GLOBALS['db']->get_all('SHOW COLUMNS FROM ###_'.$tableName);
		$info   =   array();
		if($result) {
			foreach ($result as $key => $val) {
				$info[$val['Field']] = array(
					'name'    => $val['Field'],
					'type'    => $val['Type'],
					'notnull' => (bool) ($val['Null'] === ''), // not null is empty, null is yes
					'default' => $val['Default'],
					'primary' => (strtolower($val['Key']) == 'pri'),
					'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
				);
			}
		}
		return $info;
	}
    public static function getTables() {
        $sql    = 'SHOW TABLES ';
        $result =   $GLOBALS['db']->get_all($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
    
    
	public static function gettypearray($typeid=0,$moduleid = 0) { // 获取数据库中的栏目类型，并且格式化树状结构数组返回
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		if (!is_numeric($moduleid) || $moduleid<0) {
			$moduleid = 0;
		}
		if ($moduleid>0) {
			$module_sql = " and moduleid='$moduleid'";
		} else {
			$module_sql = '';
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where 1{$module_sql} order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_tree($typeid);
		return $formatdata;
	}
	public static function getartcol($select_id = 0, $top_title = '请选择栏目',$moduleid = 0) { // 获取文章栏目，返回下拉列表
		if (!is_numeric($select_id)) $select_id = (int)$select_id;
		$str = '<select name="typeid" id="typeid"><option value="0">'.$top_title.'</option>';
		$get_tree = self::gettypearray(0,$moduleid);
		$len = count($get_tree);
		if ($len) {
			for ($i = 0; $i< $len; $i++) {
				$str .= '<option value="'.$get_tree[$i]['id'].'"'.($select_id == $get_tree[$i]['id'] ?' selected':'').'>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$get_tree[$i]['stack']).$get_tree[$i]['title'].'</option>';
			}
		}
		$str .= '</select>';
		return $str;
	}
	public static function gettreechildall($typeid=0,$moduleid=0) { // 获取数据库中的栏目类型，取得该栏目下的所有自己栏目，并以逗号分隔
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		if (!is_numeric($moduleid) || $moduleid<0) {
			$moduleid = 0;
		}
		if ($moduleid>0) {
			$module_sql = " and moduleid='$moduleid'";
		} else {
			$module_sql = '';
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where 1{$module_sql} order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_child_all_id($typeid);
		if ($formatdata) return implode(',',$formatdata);
		return '';
	}
	
	public static function table_field_stauts($moduleid,$field) {
		$table_status = @$GLOBALS['db']->get_count("SELECT status FROM ###_field WHERE moduleid='$moduleid' AND title='".$field."'");
		return $table_status;
	}
	
	public static function get_catetory_module($id,$field='title') {
		$id = (int)$id;
		if ($id<=0) return '未知模型';
		$title = @$GLOBALS['db']->get_count("SELECT b.{$field} FROM ###_category AS a LEFT JOIN ###_module AS b ON(b.id=a.moduleid) WHERE a.id='$id'");
		if ($title != '') {
			return $title;
		} else {
			return '模型不存在';
		}
	}
	
	public static function string2array($info) {
		return base::string2array($info);
	}
	
	
	public static function array2string($info) {
		return base::array2string($info);
	}
}

?>