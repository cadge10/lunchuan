<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 模板标签

function insert_url($params) { // 自动生成url
	if (isset($params) && is_array($params)) {
		unset($params['name']);
		return base::url($params);
	} else {
		return WEB_DIR;
	}
}
function insert_ftime($params) { // 格式化日期时间
	if (isset($params) && is_array($params)) {
		$time = isset($params['time']) ? (int)$params['time'] : $GLOBALS['time'];
		$format = isset($params['format']) ? $params['format'] : "Y-m-d H:i:s"; // 全角空格替换半角空格
		return @date($format,$time);
	} else {
		return false;
	}
}
function insert_get_pic($params) {
	if (isset($params) && is_array($params)) {
		$pic = isset($params['pic']) ? trim($params['pic']) : 'pic';
		return pub::parse_pic($pic,true);
	} else {
		return '';
	}
}
function insert_get_info($params) { // 获取一篇文章
	if (isset($params) && is_array($params)) {
		$id = isset($params['id']) ? (int)$params['id'] : 0;
		if ($id <= 0) return '';
		$field = isset($params['field']) ? trim($params['field']) : 'content';
		return pub::get_news_info($id,$field);
	} else {
		return '';
	}
}


/*====================================================================================
 * foreach 标签使用的数据
 ====================================================================================*/
// 获取文章数据，并以二维数组返回
function get_news_data($params) {
	if (isset($params) && is_array($params)) {
		if (!empty($params)) {
			$str = '';
			$limit = isset($params['limit']) ? trim($params['limit']) : '1';
			unset($params['limit']);
			foreach ($params as $k=>$v) {
				$str .= "a.$k='$v',";
			}
			$str = trim($str,',');
			$sql = "SELECT a.*,b.title AS typename FROM ###_news AS a LEFT JOIN ###_newstype AS b ON (a.typeid=b.id) WHERE {$str} ORDER BY a.sortid ASC,a.id DESC LIMIT {$limit}";
			return @$GLOBALS['db']->get_all($sql);
		} else {
			$sql = "SELECT a.*,b.title AS typename FROM ###_news AS a LEFT JOIN ###_newstype AS b ON (a.typeid=b.id) WHERE 1 ORDER BY sortid ASC,id DESC LIMIT {$limit}";
			return @$GLOBALS['db']->get_all($sql);
		}
	} else {
		return array();
	}
}

// 根据条件获取数据，并以二维数组返回
function get_data($params) {
	if (isset($params) && is_array($params)) {
		$table = isset($params['table']) ? $params['table'] : '';
		$where = isset($params['where']) ? str_ireplace('WHERE','',$params['where']) : '1';
		$limit = isset($params['limit']) ? 'LIMIT '.str_ireplace('LIMIT','',$params['limit']) : '';
		$field = isset($params['field']) ? $params['field'] : '*';
		
		$sql = "SELECT {$field} FROM ###_{$table} WHERE {$where} {$limit}";		
		return @$GLOBALS['db']->get_all($sql);
	} else {
		return array();
	}
}
?>