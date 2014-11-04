<?php
// 参考类库
class product {
	// 统计产品类型的属性
	public static function get_attribute_count($id) {
		$id = (int)$id;
		if ($id<=0) return '参数错误';
		$ones = $GLOBALS['db']->get_one("select count(id) from ###_productattribute where typeid='$id'");
		if ($ones[0]<1) return 0;
		return $ones[0];
	}
	// 获取产品类型
	public static function get_product_type($id) {
		$ones = $GLOBALS['db']->get_one("select title from ###_productptype where id='$id'");
		return $ones[0];
	}
	// 获取属性值的录入方式
	public static function get_attr_input_type($id) {
		switch ($id) {
			case 1:
			$type='手工录入';
			break;
			case 2:
			$type='从列表中选择';
			break;
			case 3:
			$type='多行文本框';
			break;
			default:
			$type='未知参数';
		}
		return $type;
	}
	// 把回车或换行替换成,
	public static function replace_crlf($content) {
		$content = preg_replace("/[\n|\r\n]+[\s]*/",",",$content);
		return $content;
	}
	public static function replace_crlf_br($content) {
		$content = preg_replace("/[\n|\r\n]+[\s]*/","<br />",$content);
		return $content;
	}
	
	public static function getnewstypearray_p($typeid=0,$isshow=0) { // 产品：获取数据库中的栏目类型，并且格式化树状结构数组返回
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		$where = "";
		if ($isshow==1) {
			$where .= " and isshow=1";
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_producttype where 1=1{$where} order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_tree($typeid);
		return $formatdata;
	}
	public static function gettreechildall_p($typeid=0,$isshow=0) { // 产品：获取数据库中的栏目类型，取得该栏目下的所有自己栏目，并以逗号分隔
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		$where = "";
		if ($isshow==1) {
			$where .= " and isshow=1";
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_producttype where 1=1{$where} order by sortid";
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
	public static function gettypenewsdall_p($typeid=0,$isshow=0) { // 产品：获取某栏目下的文章总数
		$db = new mysql();
		if (!is_numeric($typeid) || $typeid<0) {
			$typeid = 0;
		}
		$where = "";
		if ($isshow==1) {
			$where .= " and isshow=1";
		}
		$sql = "select id,typeid,title,sortid,url,isshow from ###_producttype where 1=1{$where} order by sortid";
		$db->query($sql);
		$data = array();
		while ($db->next_record()) {
			$data[] = array('id'=>$db->f(0),'parentid'=>$db->f(1),'title'=>$db->f(2),'sortid'=>$db->f(3),'isshow'=>$db->f(5),'url'=>$db->f(4));
		}
		$tree = new tree($data);
		$formatdata = $tree->get_child_all_id($typeid);
		$str = '0';
		if ($formatdata) $str = implode(',',$formatdata);
		$num_rows = $db->get_one("select count(id) from ###_product where typeid in($str){$where}");
		return (int)$num_rows[0];
	}
	public static function getuserarticlecount_p($userid) { // 产品
		if (!is_numeric($userid)) $userid = (int)$userid;
		$db = new mysql();
		$num_rows = $db->get_one("select count(id) from ###_product where userid='$userid'");
		return (int)$num_rows[0];
	}
	public static function getartcol_p($select_id = 0, $top_title = '请选择栏目') { // 产品：获取文章栏目，返回下拉列表
		if (!is_numeric($select_id)) $select_id = (int)$select_id;
		$str = '<select name="typeid" id="typeid"><option value="0">'.$top_title.'</option>';
		
		$get_tree = self::getnewstypearray_p();
		$len = count($get_tree);
		if ($len) {
			for ($i = 0; $i< $len; $i++) {
				$str .= '<option value="'.$get_tree[$i]['id'].'"'.($select_id == $get_tree[$i]['id'] ?' selected':'').'>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$get_tree[$i]['stack']).$get_tree[$i]['title'].'</option>';
			}
		}
		$str .= '</select>';
		return $str;
	}
	public static function getnewstype_p($typeid) { // 产品：根据新闻栏目获取该栏目的名称
		if (!is_numeric($typeid)) $typeid = (int)$typeid;
		$db = new mysql();
		$one = $db->get_one("select id,title from ###_producttype where id='$typeid'");
		if ($one) return $one[1];
		return '未知栏目';
	}
	
	// 产品属性的处理
	
	/**
	 * 根据属性数组创建属性的表单
	 *
	 * @access  public
	 * @param   int     $typeid     分类编号
	 * @param   int     $productid   商品编号
	 * @return  string
	 */
	public static function build_attr_html($typeid, $productid = 0) {
		$attr = self::get_attr_list($typeid, $productid);
		$html = '<table width="100%" id="attrTable">';
		$spec = 0;
	
		foreach ($attr AS $key => $val) {
			$html .= "<tr><td class='label'>";
			if ($val['attrtype'] == 2 || $val['attrtype'] == 3) {
				$html .= ($spec != $val['id']) ?
					"<a href='javascript:;' onclick='addSpec(this)'>[+]</a>" :
					"<a href='javascript:;' onclick='removeSpec(this)'>[-]</a>";
				$spec = $val['id'];
			}
	
			$html .= "$val[title]</td><td><input type='hidden' name='attr_id_list[]' value='$val[id]' />";
	
			if ($val['attrinputtype'] == 1) {
				$html .= '<input name="attr_value_list[]" type="text" value="' .htmlspecialchars($val['attrvalue']). '" size="40" /> ';
			} elseif ($val['attrinputtype'] == 3) {
				$html .= '<textarea name="attr_value_list[]" rows="3" cols="40">' .htmlspecialchars($val['attrvalue']). '</textarea>';
			} else {
				$html .= '<select name="attr_value_list[]">';
				$html .= '<option value="">请选择...</option>';
	
				$attr_values = explode("\n", $val['attrvalues']);
	
				foreach ($attr_values AS $opt)
				{
					$opt    = trim(htmlspecialchars($opt));
	
					$html   .= ($val['attrvalue'] != $opt) ?
						'<option value="' . $opt . '">' . $opt . '</option>' :
						'<option value="' . $opt . '" selected="selected">' . $opt . '</option>';
				}
				$html .= '</select> ';
			}
	
			$html .= ($val['attrtype'] == 2 || $val['attrtype'] == 3) ?
				'加价： <input type="text" name="attr_price_list[]" value="' . $val['attrprice'] . '" size="5" maxlength="10" />' :
				' <input type="hidden" name="attr_price_list[]" value="0" />';
	
			$html .= '</td></tr>';
		}
	
		$html .= '</table>';
	
		return $html;
	}
	
	/**
	 * 取得通用属性和某分类的属性，以及某商品的属性值
	 * @param   int     $typeid     分类编号
	 * @param   int     $productid   商品编号
	 * @return  array   规格与属性列表
	 */
	public static function get_attr_list($typeid, $productid = 0) {
		if (empty($typeid)) {
			return array();
		}
	
		// 查询属性值及商品的属性值
		$sql = "SELECT a.id, a.title, a.attrinputtype, a.attrtype, a.attrvalue as attrvalues, v.attrvalue, v.attrprice ".
				"FROM ###_productattribute AS a ".
				"LEFT JOIN ###_productinfoattr AS v ".
				"ON v.attrid = a.id AND v.productid = '$productid' ".
				"WHERE a.typeid = " . intval($typeid) ." OR a.typeid = 0 ".
				"ORDER BY a.sortid, a.attrtype, a.id, v.attrprice, v.id";
		$row = $GLOBALS['db']->get_all($sql);
	
		return $row;
	}
	
	/**
	 * 获得商品的属性和规格
	 *
	 * @access  public
	 * @param   integer $productid
	 * @return  array
	 */
	public static function get_product_properties($productid)
	{	
		/* 对属性进行重新排序和分组 */
		$sql = "SELECT attr_group ".
				"FROM ###_productptype AS gt, ###_product AS g ".
				"WHERE g.id='$productid' AND gt.id=g.product_attribute_id";
		$grp = $GLOBALS['db']->get_one($sql);
	
		if (!empty($grp))
		{
			$groups = explode("\n", strtr($grp[0], "\r", ''));
		}
		/* 获得商品的规格 */
		$sql = "SELECT a.id AS attr_id, a.title AS attr_name,a.attr_group,a.attrtype AS attr_type, ".
					"g.id AS goods_attr_id, g.attrvalue AS attr_value, g.attrprice AS attr_price " .
				'FROM ###_productinfoattr AS g ' .
				'LEFT JOIN ###_productattribute AS a ON a.id = g.attrid ' .
				"WHERE g.productid = '$productid' " .
				'ORDER BY a.sortid, g.attrprice, g.id';
		$res = $GLOBALS['db']->get_all($sql);
	
		$arr['pro'] = array();     // 属性
		$arr['spe'] = array();     // 规格
	
		foreach ($res AS $row)
		{
			$row['attr_value'] = str_replace("\n", '<br />', $row['attr_value']);
	
			if ($row['attr_type'] == 1)
			{	
				$group = trim((isset($groups[$row['attr_group']]) && $groups[$row['attr_group']]!='') ? $groups[$row['attr_group']] : '产品属性');
				
				$arr['pro'][$group][$row['attr_id']]['name']  = $row['attr_name'];
				$arr['pro'][$group][$row['attr_id']]['value'] = $row['attr_value'];
			}
			else
			{
				$arr['spe'][$row['attr_id']]['attr_type'] = $row['attr_type'];
				$arr['spe'][$row['attr_id']]['name']     = $row['attr_name'];
				$arr['spe'][$row['attr_id']]['values'][] = array(
															'label'        => $row['attr_value'],
															'price'        => $row['attr_price'],
															'format_price' => self::price_format(abs($row['attr_price']), false),
															'id'           => $row['goods_attr_id']);
			}
		}
	
		return $arr;
	}
	
	/**
	 * 获得商品选定的属性的附加总价格
	 *
	 * @param   integer     $productid
	 * @param   array       $attr
	 *
	 * @return  void
	 */
	public static function get_attr_amount($productid, $attr) {
		$sql = "SELECT SUM(attrprice) FROM ###_productinfoattr WHERE productid='$productid' AND " . db_create_in($attr, 'id');	
		return $GLOBALS['db']->get_one($sql);
	}
	
	
	
	/**
	 * 获得指定的商品类型下所有的属性分组
	 *
	 * @param   integer     $cat_id     商品类型ID
	 *
	 * @return  array
	 */
	public static function get_attr_groups($cat_id) {
		$sql = "SELECT attr_group FROM ###_productptype WHERE id='$cat_id'";
		$arr = $GLOBALS['db']->get_one($sql);
		if (empty($arr)) return array();
		$grp = str_replace("\r", '', $arr[0]);
		if ($grp) {
			return explode("\n", $grp);
		} else {
			return array();
		}
	}
	
	/**
	 * 更新属性的分组
	 *
	 * @param   integer     $cat_id     商品类型ID
	 * @param   integer     $old_group
	 * @param   integer     $new_group
	 *
	 * @return  void
	 */
	public static function update_attribute_group($cat_id, $old_group, $new_group)
	{
		$sql = "UPDATE ###_productattribute" .
				" SET attr_group='$new_group' WHERE typeid='$cat_id' AND attr_group='$old_group'";
		$GLOBALS['db']->query($sql,false);
	}
	
		
	
	
	/**
	 * 创建像这样的查询: "IN('a','b')";
	 *
	 * @access   public
	 * @param    mix      $item_list      列表数组或字符串
	 * @param    string   $field_name     字段名称
	 *
	 * @return   void
	 */
	public static function db_create_in($item_list, $field_name = '') {
		if (empty($item_list)) {
			return $field_name . " IN ('') ";
		} else {
			if (!is_array($item_list)) {
				$item_list = explode(',', $item_list);
			}
			$item_list = array_unique($item_list);
			$item_list_tmp = '';
			foreach ($item_list AS $item) {
				if ($item !== '') {
					$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
				}
			}
			if (empty($item_list_tmp)) {
				return $field_name . " IN ('') ";
			} else {
				return $field_name . ' IN (' . $item_list_tmp . ') ';
			}
		}
	}
	
	/**
	 * 格式化商品价格
	 *
	 * @access  public
	 * @param   float   $price  商品价格
	 * @param   float   $price_format  价格格式
	 * @return  string
	 */
	public static function price_format($price, $change_price = true, $price_format = 0)
	{
		if ($change_price)
		{
			switch ($price_format)
			{
				case 0:
					$price = number_format($price, 2, '.', '');
					break;
				case 1: // 保留不为 0 的尾数
					$price = preg_replace('/(.*)(\\.)([0-9]*?)0+$/', '\1\2\3', number_format($price, 2, '.', ''));
	
					if (substr($price, -1) == '.')
					{
						$price = substr($price, 0, -1);
					}
					break;
				case 2: // 不四舍五入，保留1位
					$price = substr(number_format($price, 2, '.', ''), 0, -1);
					break;
				case 3: // 直接取整
					$price = intval($price);
					break;
				case 4: // 四舍五入，保留 1 位
					$price = number_format($price, 1, '.', '');
					break;
				case 5: // 先四舍五入，不保留小数
					$price = round($price);
					break;
			}
		}
		else
		{
			$price = number_format($price, 2, '.', '');
		}
		return sprintf('%s', $price);
		//return sprintf('￥%s元', $price);
	}
	public static function get_self_col_title($typeid=0,$mod = "product") { // 获得本栏目标题和链接		
		$db = $GLOBALS["db"];
		$typeid = (int)$typeid;
		if ($typeid == 0) return array();
		$sql = "select id,title,url from ###_producttype where id='$typeid' and isshow=1 limit 1";
		$one = $db->get_one($sql);
		if (empty($one)) return array();
		if ($one[2]=="") {
			$url = "index.php?mod=$mod&typeid=".$one[0];
		} else {
			$url = $one[2];
		}
		$self_newstype = array("title"=>$one[1],"url"=>$url);
		return $self_newstype;
	}
	public static function get_all_child_col_list($typeid=0,$mod = "product",$spe = "&nbsp;&nbsp;") { // 获得该栏目下的所有子栏目
		$left_newstype_list = array();		
		$left_arr = self::getnewstypearray_p($typeid);
		foreach ($left_arr as $key=>$val) {
			if ($val["isshow"]!=1) continue;
			if ($val["url"]=="") {
				$url = "index.php?mod=$mod&typeid=".$val["id"];
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
	public static function get_parent_producttype($typeid=0) { // 获取父类所有ID，并以数组方式返回
		if (!is_numeric($typeid)) $typeid = 0;
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$sql = "select id,typeid,title,sortid,url,isshow from ###_producttype where isshow=1 order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_parent_all_id($typeid);
		return $formatdata;
	}
	public static function get_child_producttype($typeid=0) { // 获取数据库中的栏目类型，取得该栏目下的所有自己栏目，并以数组方式返回
		if (!is_numeric($typeid)) $typeid = 0;
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$sql = "select id,typeid,title,sortid,url,isshow from ###_producttype where isshow=1 order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_child_all_id($typeid);
		return $formatdata;
	}
	public static function product_location($typeid=0,$mod="product",$spe = "&gt;&gt;") { // 获得栏目当前位置
		if (!is_numeric($typeid)) return '栏目参数错误';
		$db = $GLOBALS["db"];
		// 根据栏目ID，获取其下级所有子栏目
		$split_str = "0";
		$sql = "select id,typeid,title,sortid,url,isshow from ###_producttype where isshow=1 order by sortid asc,id asc";
		$re = $db->query($sql,false);
		$data = array();
		while ($rs = $db->fetch_row($re)) {
			$data[] = array('id'=>$rs[0],'parentid'=>$rs[1],'title'=>$rs[2],'sortid'=>$rs[3],'isshow'=>$rs[5],'url'=>$rs[4]);
		}
		$tree = new tree($data);
		$formatdata = $tree->get_parent_all_id($typeid);
		if ($formatdata) $split_str = implode(',',$formatdata);
		$url = "index.php";
		$locationstr = '<a href="'.$url.'">首页</a>';
		// 获取所有栏目及链接
		$sql = "select id,title,url from ###_producttype where id in($split_str) and isshow=1";
		
		$re = $db->query($sql,false);
		while ($rs = $db->fetch_row($re)) {
			$url2 = $url.'?mod='.$mod.'&typeid='.$rs[0];
			$locationstr .= ' '.$spe.' <a href="'.$url2.'">'.$rs[1].'</a>';
		}
		return $locationstr;
	}
}
?>