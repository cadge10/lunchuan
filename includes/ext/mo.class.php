<?php
// 前台模型调用类库
class mo {
	public static function get_info($table = '',$id,$field = '') { // 根据ID获取文字的内容，如果field为空，则以数组方式返回所有数据
		$db = $GLOBALS['db'];
		if (!is_numeric($id)) return false;
		if (trim($table)=='') $table = trim(base::gp('table'));
		
		$moduleid = self::get_moduleid($table);
		
		if ($field!='') {
			if (self::field_exists('typeid', $table)) {
				$sql = "select a.$field,b.title as type_name from ###_{$table} as a left join ###_category as b on(a.typeid=b.id) where a.id='$id' and b.moduleid='$moduleid' and a.isshow='1'";
			} else {
				$sql = "select a.$field from ###_{$table} as a where a.id='$id' and a.isshow='1'";
			}
			$one = $db->get_one($sql);
			if (empty($one)) return false;
			$data = $one[0];
		} else {
			if (self::field_exists('typeid', $table)) {
				$sql = "select a.*,b.title as type_name from ###_{$table} as a left join ###_category as b on(a.typeid=b.id) where a.id='$id' and b.moduleid='$moduleid' and a.isshow='1'";
			} else {
				$sql = "select a.* from ###_{$table} as a where a.id='$id' and a.isshow='1'";
			}
			$data = $db->get_one($sql);
			if (empty($data)) return false;
		}
		
		return $data;
	}
	public static function get_self_col_title($table='',$typeid=0,$mod = '') { // 获得本栏目标题和链接		
		$db = $GLOBALS["db"];
		$typeid = (int)$typeid;
		if ($typeid == 0) return array();
		if (trim($table)=='') $table = trim(base::gp('table'));
		if (trim($mod) == '') $mod = $GLOBALS['view'];
		
		$moduleid = self::get_moduleid($table);
		
		if (!self::field_exists('typeid', $table)) return array();
		
		$sql = "select id,title,url from ###_category where id='$typeid' and moduleid='$moduleid' and isshow=1 limit 1";
		$one = $db->get_one($sql);
		if (empty($one)) return array();
		if ($one[2]=="") {
			$url = base::url(array('mod'=>$mod,'table'=>$table,'typeid'=>$one[0]));
		} else {
			$url = $one[2];
		}
		$self_newstype = array("title"=>$one[1],"url"=>$url);
		return $self_newstype;
	}
	public static function get_all_child_col_list($table='',$typeid=0,$mod = "",$spe = "&nbsp;&nbsp;") { // 获得该栏目下的所有子栏目
		$left_newstype_list = array();
		if (trim($table)=='') $table = trim(base::gp('table'));
		if (trim($mod) == '') $mod = $GLOBALS['view'];
		
		if (!self::field_exists('typeid', $table)) return array();
		
		$left_arr = self::gettypearray($table,$typeid);
		foreach ($left_arr as $key=>$val) {
			if ($val["isshow"]!=1) continue;
			if ($val["url"]=="") {
				//$url = "index.php?mod=$mod&typeid=".$val["id"];
				$url = base::url(array('mod'=>$mod,'table'=>$table,'typeid'=>$val["id"]));
			} else {
				$url = $val["url"];
			}
			if ((int)base::gp("typeid") == $val["id"]) {
				$active = ' class="active"';
			} else {
				$active = '';
			}
			$left_newstype_list[] = array("id"=>$val['id'],"title"=>$val['title'],"url"=>$url,"active"=>$active,"repeat"=>str_repeat($spe,$val['stack']));
		}
		return $left_newstype_list;
	}
	public static function get_parent_type($table='',$typeid=0) { // 获取父类所有ID，并以数组方式返回
		if (!is_numeric($typeid)) $typeid = 0;
		if (trim($table)=='') $table = trim(base::gp('table'));
		
		$moduleid = self::get_moduleid($table);
		
		if (!self::field_exists('typeid', $table)) return array();
		
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where isshow=1 and moduleid='$moduleid' order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_parent_all_id($typeid);
		return $formatdata;
	}
	public static function get_child_type($table='',$typeid=0) { // 获取数据库中的栏目类型，取得该栏目下的所有自己栏目ID，并以数组方式返回
		if (!is_numeric($typeid)) $typeid = 0;
		if (trim($table)=='') $table = trim(base::gp('table'));
		
		$moduleid = self::get_moduleid($table);
		
		if (!self::field_exists('typeid', $table)) return array();
		
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where isshow=1 and moduleid='$moduleid' order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_child_all_id($typeid);
		return $formatdata;
	}
	public static function location_str($table='',$typeid=0,$mod='',$spe = '&gt;&gt;') { // 获得栏目当前位置
		if (!is_numeric($typeid)) return '栏目参数错误';
		
		if (trim($table)=='') $table = trim(base::gp('table'));
		if (trim($mod) == '') $mod = $GLOBALS['view'];
		
		$moduleid = self::get_moduleid($table);
		
		if (!self::field_exists('typeid', $table)) return '';
		
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$split_str = "0";
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where isshow=1 and moduleid='$moduleid' order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_parent_all_id($typeid);
		if ($formatdata) $split_str = implode(',',$formatdata);
		//$url = "index.php";
		$locationstr = '<a href="'.WEB_DIR.'">首页</a>';
		// 获取所有栏目及链接
		$sql = "select id,title,url from ###_category where id in($split_str) and isshow=1 and moduleid='$moduleid'";
		
		$re = $db->query($sql,false);
		while ($rs = $db->fetch_row($re)) {
			//$url2 = $url.'?mod='.$mod.'&typeid='.$rs[0];
			$url2 = base::url(array('mod'=>$mod,'table'=>$table,'typeid'=>$rs[0]));
			$locationstr .= ' '.$spe.' <a href="'.$url2.'">'.$rs[1].'</a>';
		}
		return $locationstr;
	}
	public static function prev_next($table='',$id,$type='prev',$mod='',$query_array = array()) { // 获得上一篇或下一篇文章，$type=prev 上一篇,next或其他 下一篇
		if (!is_numeric($id)) return '栏目参数错误';
		$db = $GLOBALS["db"];
		if (trim($table)=='') $table = trim(base::gp('table'));
		if (trim($mod) == '') $mod = $GLOBALS['view'];
		
		if (self::field_exists('typeid', $table)) {
		
			// 获得文章类型id
			$one = $db->get_one("SELECT typeid FROM ###_{$table} WHERE id='$id'");
			if (empty($one)) return '当前文章不存在';
			$typeid = $one[0];
			if ($type == 'prev') { // 上一篇
				$sql = "SELECT id,title FROM ###_{$table} WHERE typeid='$typeid' AND isshow=1 AND id<$id ORDER BY id DESC";
			} else { // 下一篇
				$sql = "SELECT id,title FROM ###_{$table} WHERE typeid='$typeid' AND isshow=1 AND id>$id ORDER BY id ASC";
			}
		} else {
			if ($type == 'prev') { // 上一篇
				$sql = "SELECT id,title FROM ###_{$table} WHERE isshow=1 AND id<$id ORDER BY id DESC";
			} else { // 下一篇
				$sql = "SELECT id,title FROM ###_{$table} WHERE isshow=1 AND id>$id ORDER BY id ASC";
			}
		}
		$info = $db->get_one($sql);
		if (empty($info)) return '<span style="color:red;">没有了</span>';
		$qstr = array("mod"=>trim($mod),"id"=>$info[0]);
		if (is_array($query_array) && !empty($query_array)) {
			$qstr = array_merge($qstr,$query_array);
		}
		$url = base::url($qstr);
		return '<a href="'.$url.'">'.$info[1].'</a>';
	}
	
	public static function gettypearray($table='',$typeid=0) { // 获取数据库中的栏目类型，并且格式化树状结构数组返回
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) $typeid = 0;
		if (trim($table)=='') $table = trim(base::gp('table'));
		
		$moduleid = self::get_moduleid($table);
		if ($moduleid>0) {
			$module_sql = " and moduleid='$moduleid'";
		} else {
			return array();
		}
		
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where isshow=1{$module_sql} order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_tree($typeid);
		return $formatdata;
	}
	public static function getartcol($table='',$select_id = 0, $top_title = '请选择栏目') { // 获取文章栏目，返回下拉列表
		if (!is_numeric($select_id)) $select_id = (int)$select_id;
		if (trim($table)=='') $table = trim(base::gp('table'));
		
		$str = '<select name="typeid" id="typeid"><option value="0">'.$top_title.'</option>';
		
		$get_tree = self::gettypearray($table);
		$len = count($get_tree);
		if ($len) {
			for ($i = 0; $i< $len; $i++) {
				$str .= '<option value="'.$get_tree[$i]['id'].'"'.($select_id == $get_tree[$i]['id'] ?' selected':'').'>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$get_tree[$i]['stack']).$get_tree[$i]['title'].'</option>';
			}
		}
		$str .= '</select>';
		return $str;
	}
	public static function gettreechildall($table='',$typeid=0) { // 获取数据库中的栏目类型，取得该栏目下的所有自己栏目，并以逗号分隔
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) $typeid = 0;
		if (trim($table)=='') $table = trim(base::gp('table'));
		
		$moduleid = self::get_moduleid($table);
		if ($moduleid>0) {
			$module_sql = " and moduleid='$moduleid'";
		} else {
			return '';
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_category where isshow=1{$module_sql} order by sortid";
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
	
	
	public static function get_search_module() { // 获取所有允许搜索并且可使用的模型，以二维数组方式返回
		$db = $GLOBALS['db'];
		$sql = "SELECT id,title,`name` AS `table` FROM ###_module WHERE issearch=1 AND status=1 ORDER BY sortid ASC,id DESC";
		return @$db->get_all($sql);
	}
	
	
	public static function get_fields($table_name) { // 获取所有字段
		$result =   $GLOBALS['db']->get_all('SHOW COLUMNS FROM ###_'.$table_name);
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
    public static function get_tables() { // 获取所有表
        $sql    = 'SHOW TABLES';
        $result =   $GLOBALS['db']->get_all($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
    public static function table_exists($table) { // 检查表是否在数据库中存在
    	$table = trim($table);
    	if ($table != '') {
    		return in_array(DB_PREFIX.$table, self::get_tables())?true : false;
    	} else {
    		return false;
    	}
    }
	public static function field_exists($field,$table) { // 检查字段是否在表中中存在
    	$table = trim($table);
		$field = trim($field);
    	if ($table != '' && $field != '') {
    		$field_data = self::get_fields($table);
    		return array_key_exists($field, $field_data)?true : false;
    	} else {
    		return false;
    	}
    }
    
    public static function get_moduleid($table) { // 根据表名获取模型ID
    	$table = trim($table);
		if ($table=='') return 0;
		$moduleid = $GLOBALS['db']->get_count("SELECT `id` FROM ###_module WHERE `name`='$table' AND status=1");
		if (!is_numeric($moduleid) || $moduleid<0) $moduleid = 0;
		return $moduleid;
    }
    
	public static function get_module_field($table) { // 根据表名，获取列表页调用字段
    	$table = trim($table);
		if ($table=='') return 0;
		$module_field = $GLOBALS['db']->get_count("SELECT `listfields` FROM ###_module WHERE `name`='$table' AND status=1");
		if (@$module_field) $module_field = '*';
		return $module_field;
    }
}
?>