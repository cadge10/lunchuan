<?php
// 后台左边栏目类
class adminpub {
	public static function showleftmenu() { // 显示左边的栏目
		$db = new mysql();
		$re = $db->query("select id,title,url,hidden from ###_admincolumn where parentid=0 and isshow=1 order by sortid asc,id asc",false);
		$str = '';
		while ($arr = $db->fetch_array($re)) {
			if (!adminpub::getuservalidate(base::s('m_userid'),$arr['url'])) continue; // 权限控制
			if ((int)base::s('m_userid')!=1 && $arr['id']==1) continue; // 后台栏目管理非管理员不显示
			$style = 'display:block;';
			if ($arr['hidden']==1) {$style = ' style="display:none;"';} else {$style = ' style="display:block;"';};
			$str .= "<div id=\"".$arr['url']."\" style=\"display:block;\"><h3>".$arr['title']."</h3><ul".$style." id=\"ul_".$arr['url']."\">";
			$re2 = $db->query("select title,url,parentid from ###_admincolumn where parentid='".$arr['id']."' and isshow=1 and parentid<>0 order by sortid asc,id asc",false);
			while ($arr2 = $db->fetch_array($re2)) {
				if (!adminpub::getuservalidate(base::s('m_userid'),$arr2['url'])) continue; // 权限控制
				//if (base::s('m_userid')!=1 && stristr($arr2['url'],'admin_module')) continue; // 不是创始人账号时，不显示模型管理
				$str .= "<li><a href='?mod=".$arr2['url']."'>".$arr2['title']."</a></li>";
			}
			
			if ( $arr['url']=='category') {
				// 显示添加的所有模型
				$all = $db->get_all("SELECT id,title,`name` FROM ###_module WHERE status=1 ORDER BY sortid ASC,id DESC");
				foreach ($all as $k=>$v) {
					
					$userid = (int)base::s('m_userid');
					// 读取数据库权限
					$one = $db->get_one("select id,roleid,sys,isshow from ###_admin where id='$userid'");
					$roleid = $one[1];
					$sys = $one[2];
					// 获取角色模型权限
					$one = $db->get_one("select id,module_role from ###_role where id='".$one[1]."'");
					$module_role = trim($one[1])!=''?unserialize($one[1]):array();

					if (isset($module_role[$v['name']]) || $sys==1 || $userid==1) {
						$str .= "<li><a href='?mod=admin_module_table&moduleid=".$v['id']."'>".$v['title']."</a></li>";
					}
				}
			}
			$str .= "</ul></div>";
		}
		return $str;
	}
	public static function detailtitle($mod = '') { // 后台操作页面显示的标题
		if (!$mod) return '未知栏目操作';
		$db = new mysql();
		$childarr = $db->get_one("select title,parentid from ###_admincolumn where url='$mod'");
		$parentarr = $db->get_one("select title from ###_admincolumn where id='".$childarr[1]."'");
		return $parentarr[0].' =&gt; '.$childarr[0];
	}
	public static function detailtitle_one($mod = '') { // 后台操作页面显示的标题，只显示标题
		if (!$mod) return '未知栏目';
		$db = new mysql();
		$childarr = $db->get_one("select title,parentid from ###_admincolumn where url='$mod'");
		$parentarr = $db->get_one("select title from ###_admincolumn where id='".$childarr[1]."'");
		return $childarr[0];
	}
	public static function norecord() {
		return '暂时没有记录。';
	}
	public static function showadminrole($roleid='') { // 显示管理员具体权限
		$db = new mysql();
		$sql = "select id,title,url from ###_admincolumn where parentid=0 and isshow=1 order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$str = '';
		$g = 0;
		while ($rs = $db->fetch_array($re)) {
			if ($rs['id']==1) continue; // 后台栏目管理不显示
			if (stristr($rs['url'],'module_table')) continue; // 后台栏目管理不显示
			
			$str .= '<div style="font-weight:bold;"><input type="checkbox" name="role[]" id="role_'.$g.'" class="role_'.$g.'" value="'.$rs[0].'" onClick="set_child_checked(this,'.$g.')" />'.$rs[1].'</div>';
			$re2 = $db->query("select id,title from ###_admincolumn where parentid='".$rs[0]."' and `close`=0 order by sortid asc,id asc",false);
			$str .= '<div style="padding-left:20px;">';
			$stc = 0;
			$m = 1;
			while ($rs2 = $db->fetch_array($re2)) {
				if ($rs2['id']>=83 && $rs2['id'] <=90) continue; // 模型管理和字段管理不显示
				
				$stc++;
				$str .= '<input type="checkbox" name="role[]" id="role_child_'.$g.'_'.$m.'" rel="role_child_'.$g.'" class="role_child_'.$g.'" value="'.$rs2[0].'" onClick="set_parent_checked(this,'.$g.')" />'.$rs2[1];
				if ($stc % 4 == 0) $str .= '<br />';
				$m++;
			}
			$str .= '</div>';
			$g++;
		}
		
		return $str;
	}
	public static function getcoltitle($role='') { // 获取栏目名称
		$db = new mysql();
		if (!$role) return '';
		$rolearr = explode(',',$role);
		if (!count($rolearr)) return '';
		$str = '';
		foreach ($rolearr as $id) {
			if (!is_numeric($id)) $id = (int)$id;
			$one = $db->get_one("select title from ###_admincolumn where id='$id'");
			if ($one) {
				$str .= $one[0].'&nbsp;&nbsp;';
			}
		}
		return $str;
	}
	public static function getrolelist($id=0) {
		$db = new mysql();
		if (!is_numeric($id)) $id = (int)$id;
		$str = '<select name="roleid" id="roleid"><option value="0">请选择角色……</option>';
		$db->query("select id,title from ###_role order by id asc");
		while ($db->next_record()) {
			$selected = '';
			if ($id == $db->f(0)) $selected = ' selected';
			$str .= '<option value="'.$db->f(0).'"'.$selected.'>'.$db->f(1).'</option>';
		}
		$str .= '</select>';
		return $str;
	}
	public static function adminuservalidate($username) { // 检测管理员用户是否被注册
		$db = new mysql();
		$one = $db->get_one("select id from ###_admin where username='$username'");
		if ($one[0]) {
			return true; // 已注册
		} else {
			return false;
		}
	}
	public static function getuserrolename($userid) { // 根据用户ID获取所属角色
		$db = new mysql();
		if (!is_numeric($userid)) $userid = (int)$userid;
		if ($userid==0) return '参数错误';
		$one = $db->get_one("select id,roleid,sys from ###_admin where id='$userid'");
		if ($one[0]) {
			if ($one[2]==1) {
				return '系统管理员';
			}
			$roleid = (int)$one[1];
			if ($roleid>0) {
				$role = $db->get_one("select title from ###_role where id='$roleid'");
				if ($role) {
					return $role[0];
				} else {
					return '角色不存在';
				}
			} else {
				return '角色不存在';
			}
		}
		return '角色不存在';
	}
	public static function getuservalidate($userid,$mod) { // 检测用户是否有权限管理某页面
		$db = new mysql();
		if (!is_numeric($userid)) $userid = (int)$userid;
		if ($userid==0||$mod=='') return false;
		if ($userid==1) return true;
		
		$action = base::gp('action');

		if ($mod == 'delete') {
			$mod = $action;
		}
		
		$mod = explode('&',$mod);
		$query = isset($mod[1])?$mod[1]:'';
		$mod = @$mod[0];
		if (substr($mod,0,6) != 'admin_' && stristr($mod,'module_table')) $mod = 'admin_'.$mod;
		// 对模型进行验证
		if ($mod=='admin_module_table'||$mod=='admin_module_table_add'||
			$mod=='admin_module_table_edit'||$mod=='admin_module_table_del'||$action=='admin_module_table_del') {
			$moduleid = (int)base::gp('moduleid');
			$_module_data = array();
			
			if ($query != '') $_module_data = explode('=',$query);
			if (!empty($_module_data)) {
				if ($_module_data[0] == 'moduleid' && isset($_module_data[1]) && $_module_data[1] > 0) {
					$moduleid = (int)$_module_data[1];
				}
			}
			
			if ($moduleid <= 0) return false;
			// 读取数据库权限
			$one = $db->get_one("select id,roleid,sys,isshow from ###_admin where id='$userid'");

			if (!$one[0]) return false;
			if ($one[3]!=1) return false;
			if ($one[2]==1) return true; // 系统管理员
			$roleid = $one[1];
			if (!$roleid) return false;
			// 获取角色模型权限
			$one = $db->get_one("select id,module_role from ###_role where id='".$one[1]."'");
			if (!$one[0]) return false;
			$module_role = trim($one[1])!=''?unserialize($one[1]):array();
			// 获取模型表名
			$module_table = @$db->get_count("SELECT `name` FROM ###_module WHERE id='$moduleid'");
			if (!$module_table) return false;
			if (empty($module_role)) return false;

			if ($mod=='admin_module_table'){
				if (@$module_role[$module_table]['parent'] == $moduleid && isset($module_role[$module_table]['list'])) {
					return true;
				}
			}
			if ($mod=='admin_module_table_add') {
				if (isset($module_role[$module_table]['add'])) {
					return true;
				}
			}
			if ($mod=='admin_module_table_edit') {
				if (isset($module_role[$module_table]['edit'])) {
					return true;
				}
			}
			if (($mod=='admin_module_table_del'||$action=='admin_module_table_del')) {
				if (isset($module_role[$module_table]['del'])) {
					return true;
				}
			}			
			return false;
		}
		
		if ($mod=='index'||$mod=='login'||
			$mod=='top'||$mod=='left'||
			$mod=='right'||
			$mod=='admin_pic'||
			$mod=='down'||
			$mod=='admin_info'||
			$mod=='admin_module_table'||$mod=='admin_module_table_add'||
			$mod=='admin_module_table_edit'||$mod=='admin_module_table_del'||$action=='admin_module_table_del'
		) return true;
		
		if ($userid!=1 && ($mod=='admin_module'||
		$mod=='admin_module_add' || $mod=='admin_module_edit' || $mod=='admin_module_del'||
		$mod=='admin_module_field_add' || $mod=='admin_module_field_edit' || $mod=='admin_module_field_del'|| $action=='admin_module_field_del'||
		$mod=='admin_column'||$mod=='admin_column_add' || $mod=='admin_column_edit' || $mod=='admin_column_del' || $action=='admin_column_del'
		)) return false;
		
		$one = $db->get_one("select id,roleid,sys,isshow from ###_admin where id='$userid'");
		if (!$one[0]) return false;
		if ($one[3]!=1) return false;
		if ($one[2]==1) return true; // 系统管理员
		$roleid = $one[1];
		if (!$roleid) return false;
		// 获取角色id
		$one = $db->get_one("select id,role from ###_role where id='".$one[1]."'");
		if (!$one[0]) return false;
		$rolestr = $one[1];
		if ($rolestr!='') {
			$rolearr = explode(',',$rolestr);
			if ($mod == 'delete') {
				$mod = base::gp('action');
			}
			$one = $db->get_one("select id from ###_admincolumn where url='$mod'");
			if (in_array($one[0],$rolearr)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
		return false;
	}
	public static function get_web_config_info() { // 获得web配置信息
		if (base::mysqlrun()) {
			return ;
		} else {
			exit(base::connecterr());
		}
	}
	public static function getsafecode() { // 获取安全的session编码
		$code = base::code(APP_SAFECODE);
		return $code;
	}
	public static function getnewstypearray($typeid=0) { // 获取数据库中的栏目类型，并且格式化树状结构数组返回
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_newstype order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_tree($typeid);
		return $formatdata;
	}
	public static function gettreechildall($typeid=0) { // 获取数据库中的栏目类型，取得该栏目下的所有自己栏目，并以逗号分隔
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_newstype order by sortid";
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
	public static function gettypenewsdall($typeid=0) { // 获取某栏目下的文章总数
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_newstype order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_child_all_id($typeid);
		$str = '0';
		if ($formatdata) $str = implode(',',$formatdata);
		$num_rows = $db->get_one("select count(id) from ###_news where typeid in($str) and onlypage=0");
		return (int)$num_rows[0];
	}
	public static function getuserarticlecount($userid) {
		if (!is_numeric($userid)) $userid = (int)$userid;
		$db = new mysql();
		$num_rows = $db->get_one("select count(id) from ###_news where userid='$userid' and onlypage=0");
		return (int)$num_rows[0];
	}
	public static function getartcol($select_id = 0, $top_title = '请选择栏目') { // 获取文章栏目，返回下拉列表
		if (!is_numeric($select_id)) $select_id = (int)$select_id;
		$str = '<select name="typeid" id="typeid"><option value="0">'.$top_title.'</option>';
		
		$get_tree = self::getnewstypearray();
		$len = count($get_tree);
		if ($len) {
			for ($i = 0; $i< $len; $i++) {
				$str .= '<option value="'.$get_tree[$i]['id'].'"'.($select_id == $get_tree[$i]['id'] ?' selected':'').'>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$get_tree[$i]['stack']).$get_tree[$i]['title'].'</option>';
			}
		}
		$str .= '</select>';
		return $str;
	}
	public static function getnewstype($typeid) { // 根据新闻栏目获取该栏目的名称
		if (!is_numeric($typeid)) $typeid = (int)$typeid;
		$db = new mysql();
		$one = $db->get_one("select id,title from ###_newstype where id='$typeid'");
		if ($one) return $one[1];
		return '未知栏目';
	}
	public static function getusername($userid) { // 根据新闻栏目获取该栏目的名称
		if (!is_numeric($userid)) $userid = (int)$userid;
		$db = new mysql();
		$one = $db->get_one("select id,username from ###_admin where id='$userid'");
		if ($one) return $one[1];
		return '未知用户';
	}
}

?>