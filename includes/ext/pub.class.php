<?php
// 通用扩展类库
class pub {
	public static function get_config($field = '') { // 获取基本配置，如果为空，则以数组方式返回所有数据
		$db = new mysql();
		if ($field == "") {
			$where = " where `hidden`=0";
		} else {
			$where = "";
		}
		$sql = "select id,field,value from ###_config{$where}";
		$db->query($sql);
		$arr = array();
		while($db->next_record()) {
			$arr[$db->f(1)] = $db->f(2);
		}
		if ($field != '') {
			return $arr[$field];
		} else {
			return $arr;
		}
	}
	public static function get_news_info($id,$field = '') { // 根据ID获取文字的内容，如果field为空，则以数组方式返回所有数据
		$db = $GLOBALS['db'];
		if (!is_numeric($id)) return false;
		if ($field!='') {
			$sql = "select a.$field,b.title as type_name from ###_news as a left join ###_newstype as b on(a.typeid=b.id) where a.id='$id' and a.isshow='1'";
			$one = $db->get_one($sql);
			if (empty($one)) return false;
			$data = $one[0];
		} else {
			$sql = "select a.*,b.title as type_name from ###_news as a left join ###_newstype as b on(a.typeid=b.id) where a.id='$id' and a.isshow='1'";
			$data = $db->get_one($sql);
			if (empty($data)) return false;
		}
		return $data;
	}
	public static function get_self_col_title($typeid=0,$mod = "news") { // 获得本栏目标题和链接		
		$db = $GLOBALS["db"];
		$typeid = (int)$typeid;
		if ($typeid == 0) return array();
		$sql = "select id,title,url from ###_newstype where id='$typeid' and isshow=1 limit 1";
		$one = $db->get_one($sql);
		if (empty($one)) return array();
		if ($one[2]=="") {
			//$url = "index.php?mod=$mod&typeid=".$one[0];
			$url = base::url(array('mod'=>$mod,'typeid'=>$one[0]));
		} else {
			$url = $one[2];
		}
		$self_newstype = array("title"=>$one[1],"url"=>$url);
		return $self_newstype;
	}
	public static function get_all_child_col_list($typeid=0,$mod = "news",$spe = "&nbsp;&nbsp;") { // 获得该栏目下的所有子栏目
		$left_newstype_list = array();		
		$left_arr = adminpub::getnewstypearray($typeid);
		foreach ($left_arr as $key=>$val) {
			if ($val["isshow"]!=1) continue;
			if ($val["url"]=="") {
				//$url = "index.php?mod=$mod&typeid=".$val["id"];
				$url = base::url(array('mod'=>$mod,'typeid'=>$val["id"]));
			} else {
				$url = $val["url"];
			}
			if ((int)base::g("typeid") == $val["id"]) {
				$active = ' class="active"';
			} else {
				$active = '';
			}
			$left_newstype_list[] = array("id"=>$val['id'],"title"=>$val['title'],"url"=>$url,"active"=>$active,"repeat"=>str_repeat($spe,$val['stack']));
		}
		return $left_newstype_list;
	}
	public static function get_parent_newstype($typeid=0) { // 获取父类所有ID，并以数组方式返回
		if (!is_numeric($typeid)) $typeid = 0;
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$sql = "select id,typeid,title,sortid,url,isshow from ###_newstype where isshow=1 order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_parent_all_id($typeid);
		return $formatdata;
	}
	public static function get_child_newstype($typeid=0) { // 获取数据库中的栏目类型，取得该栏目下的所有自己栏目，并以数组方式返回
		if (!is_numeric($typeid)) $typeid = 0;
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$sql = "select id,typeid,title,sortid,url,isshow from ###_newstype where isshow=1 order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_child_all_id($typeid);
		return $formatdata;
	}
	public static function news_location($typeid=0,$mod="news",$spe = "&gt;&gt;") { // 获得栏目当前位置
		if (!is_numeric($typeid)) return '栏目参数错误';
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$split_str = "0";
		$sql = "select id,typeid,title,sortid,url,isshow from ###_newstype where isshow=1 order by sortid asc,id asc";
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
		$sql = "select id,title,url from ###_newstype where id in($split_str) and isshow=1";
		
		$re = $db->query($sql,false);
		while ($rs = $db->fetch_row($re)) {
			//$url2 = $url.'?mod='.$mod.'&typeid='.$rs[0];
			$url2 = base::url(array('mod'=>$mod,'typeid'=>$rs[0]));
			$locationstr .= ' '.$spe.' <a href="'.$url2.'">'.$rs[1].'</a>';
		}
		return $locationstr;
	}
	public static function parse_pic($pic,$one = true,$thumb = 0) { // 返回处理后的图片，默认获取一张
		if ($pic == '') return '';
		$pic_arr = explode(",",$pic);
		if ($one == true) {
			if (substr($pic_arr[0],0,7) != "http://") {
				if ($thumb == 0) {
					$pic = WEB_DIR."uploadfile/upfiles/".$pic_arr[0];
				} else {
					if (@file_exists(__ROOT__."/uploadfile/upfiles/thumb_".$pic_arr[0])) {
						$pic = WEB_DIR."uploadfile/upfiles/thumb_".$pic_arr[0];
					} else {
						$pic = WEB_DIR."uploadfile/upfiles/".$pic_arr[0];
					}
				}
			} else {
				$pic = $pic_arr[0];
			}
			return $pic;
		} else {
			$new_arr = array();
			foreach ($pic_arr as $k=>$v) {
				if (substr($v,0,7) != "http://") {
					if ($thumb == 0) {
						$pic = WEB_DIR."uploadfile/upfiles/".$v;
					} else {
						if (@file_exists(__ROOT__."/uploadfile/upfiles/thumb_".$v)) {
							$pic = WEB_DIR."uploadfile/upfiles/thumb_".$v;
						} else {
							$pic = WEB_DIR."uploadfile/upfiles/".$v;
						}
					}
				} else {
					$pic = $v;
				}
				array_push($new_arr,$pic);
			}
			return $new_arr;
		}
		return $pic;
	}
	public static function prev_next($id,$type="prev",$query_array = array()) { // 获得上一篇或下一篇文章，$type=prev 上一篇,next或其他 下一篇
		if (!is_numeric($id)) return '栏目参数错误';
		$db = $GLOBALS["db"];
		// 获得文章类型id
		$one = $db->get_one("SELECT typeid FROM ###_news WHERE id='$id'");
		if (empty($one)) return '当前文章不存在';
		$typeid = $one[0];
		if ($type == 'prev') { // 上一篇
			$sql = "SELECT id,title FROM ###_news WHERE typeid='$typeid' AND isshow=1 AND id<$id ORDER BY id DESC";
		} else { // 下一篇
			$sql = "SELECT id,title FROM ###_news WHERE typeid='$typeid' AND isshow=1 AND id>$id ORDER BY id ASC";
		}
		$info = $db->get_one($sql);
		if (empty($info)) return '<span style="color:red;">没有了</span>';
		$qstr = array("mod"=>trim($GLOBALS['view']),"id"=>$info[0]);
		if (is_array($query_array) && !empty($query_array)) {
			$qstr = array_merge($qstr,$query_array);
		}
		$url = base::url($qstr);
		return '<a href="'.$url.'">'.$info[1].'</a>';
	}
	public static function go_url() { // 对后台分页截取连接字符串
		$gourl = $_SERVER['QUERY_STRING'];
		$gourlarr = explode('&r=yes',$gourl);
		$gourl = @$gourlarr[1];
		return $gourl;
	}
}
?>