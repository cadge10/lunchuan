<?php
// 基础函数类
$plugin_hooks = array(); // 插件钩子
class base {
	public static $character = "utf-8";
	public function __construct() {
		
	}
	/* 路由设置，可以自己指定解析字符串	
	在网站根目录下新建一个routes.php的文件，填写以下内容：
	return array(
		array('模块','路由配置规则','参数定义，多个逗号隔开'),
		array('blog','/^blogother-(\d+).html$/is','id')
	);
	注意：路由配置规则可以重复，重复时以最后一条为准，如果没有匹配的规则，则mod等于$separator之前的字符串
	*/
	public static function router() {
		$path_info = isset($_SERVER['PATH_INFO'])?trim($_SERVER['PATH_INFO'],'/'):'';
		$separator = defined("URL_SEPAPARATOR")?URL_SEPAPARATOR:'/';
		if ($path_info && URL_ROUTER_ON == true) {
			$var = NULL;
			$path_arr = explode($separator,$path_info);
			$mod_arr = explode('.',$path_arr[0]);
			$mod = $mod_arr[0];
			@self::router_auto(); // 先执行自动路由，如果匹配的某项存在，会自动覆盖某项
			if (!$routes = @include('routes.php')) {
				$_GET['mod'] = $mod;
				return false;
			}
			if (count($path_arr) > 0) {
				foreach ($routes as $key=>$route){
					if (preg_match($route[1],$path_info,$matches) && 
										  (preg_match("/^\/\^".$path_arr[0]."/i",$route[1]) || preg_match("/^\/".$path_arr[0]."/i",$route[1]))) {
						$mod = $route[0];
						$vars = @explode(',',$route[2]);
						for ($i = 0; $i<count($vars); $i++) {
							$var[$vars[$i]] = @$matches[$i+1];
						}							
					}
				}
			}
			if (is_array($var)) $_GET = array_merge($var,$_GET);
			$_GET['mod'] = $mod;
		} else {
			
			return false;
		}
	}
	// 自动路由设置，如：/模块名-id-5.html
	public static function router_auto() {
		$path_info = isset($_SERVER['PATH_INFO'])?trim($_SERVER['PATH_INFO'],'/'):'';
		$separator = defined("URL_SEPAPARATOR")?URL_SEPAPARATOR:'/';
		$ext = defined("URL_EXT")?URL_EXT:'.html';
		if ($path_info && URL_ROUTER_ON == true) {
			$path_arr = explode($separator,str_replace($ext,"",$path_info));
			if (count($path_arr) % 2 != 0) {
				$mod = $path_arr[0];
				$_GET['mod'] = $mod;
			} else {
				array_unshift($path_arr,$default);
				$_GET['mod'] = 'index'; // 默认伪静态首页模块名
			}
			array_shift($path_arr); // 删除数组中第一个元素
			if (!empty($path_arr)) {
				$len = count($path_arr);
				for ($i = 0; $i < $len; $i++) {
					$_GET[$path_arr[$i]] = isset($path_arr[$i+1])?$path_arr[$i+1]:'';
					$i++;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	/**
	 * 根据一个关联数组保存的数据，自动解析连接字符串
	 *
	 * @param array $url_data 关联数组保存的数据，格式：array("mod"=>"show","id"=>1); 如果第一个参数不是数组，默认为mod=此参数
	 * @param string $route 手动配置的路由，如果不为空，自动返回$route传递的字符串
	 * @return 返回解析后的链接字符串，相关配置在config.php文件里
	 */
	public static function url($url_data = "", $route = "") {
		// URL_MODE 0：原生字符串 1：伪静态字符串 $route不为空时，返回$route，前提是URL_MODE为1
		
		// 兼容不是index.php页面
		$_basename = basename($_SERVER['SCRIPT_NAME']);
		if ($_basename != "index.php") {
			$url_mode = 0;
			$basename = $_basename;
		} else {
			if (!defined("URL_MODE")) define("URL_MODE",0);
			$url_mode = URL_MODE;
			$basename = '';
		}
		if (!defined("WEB_PATHINFO")) define("WEB_PATHINFO",WEB_DIR);
		$separator = defined("URL_SEPAPARATOR")?URL_SEPAPARATOR:'/';
		$ext = defined("URL_EXT")?URL_EXT:'.html';
		if (!is_array($url_data)) { // 如果不是数组，把第一个字符串赋给一个键为mod的数组
			if ($url_data == "") $url_data = isset($GLOBALS['view'])?$GLOBALS['view']:'index';
			$url_data_tmp = array("mod"=>$url_data);
			unset($url_data);
			$url_data = $url_data_tmp;
		}
		if (!array_key_exists("mod", $url_data)) exit("module no exists, errno 2.");
		$mod = $url_data["mod"];
		if ($mod == "") exit("module value not null, errno 3.");
		unset($url_data["mod"]);
		
		if ($url_mode === 0) { // 原生字符串
			$url_str = WEB_DIR.$basename."?mod=".$mod;
			if (!empty($url_data)) {
				$_str = "";
				foreach ($url_data as $k=>$v) {
					$_str .= "&".$k."=".$v;
				}
				$url_str .= $_str;
			}
		} elseif ($url_mode === 1) { // 伪静态字符串
			$url_str = WEB_PATHINFO.$mod;
			if (!empty($url_data)) {
				if ($route == "") { // 如果为空，默认使用自动配置的伪静态
					$_str = "";
					foreach ($url_data as $k=>$v) {
						$_str .= $separator.$k.$separator.$v;
					}
					$url_str .= $_str;
				} else {
					$url_str = WEB_PATHINFO.str_replace($ext,"",$route); // 自动替换扩展名，如果存在的话
				}
			}
			$url_str .= $ext;
		} else {
			exit('URL_MODE error.');
		}
		return $url_str;
	}
	/**
	 * 把一个关联数组解析为可查询的字符串
	 *
	 * @param array $url_data 解析的数组
	 * @return 返回解析后的字符串，返回格式：&a=b&c=d
	 */
	public static function parse_array($url_data) {
		if (!empty($url_data) && is_array($url_data)) {
			$_str = "&".http_build_query($url_data);
			return $_str;
		}
		return "";
	}
	/**
	 * 获取当前路径和连接字符串
	 *
	 * 返回获取的连接字符串
	 */
	public static function get_uri() {
		$url  =  $_SERVER['REQUEST_URI'];
		$parse = parse_url($url);
		if(isset($parse['query'])) {
			parse_str($parse['query'],$params);
			$url   =  $parse['path'].'?'.http_build_query($params);
		}
		return $url;
	}
	/**
	 * 禁止外部提交
	 *
	 * 无返回值
	 */
	public static function issubmit() {
		if(!isset($_SERVER["HTTP_REFERER"])) {
			exit(self::msg('禁止外部提交！'));
		}
		$myurl=strpos($_SERVER["HTTP_REFERER"],$_SERVER['SERVER_NAME']);
		if (!$myurl) {
			exit(self::msg('禁止外部提交！'));
		}	
	}
	/**
	 * 自定义显示信息窗口
	 *
	 * @param string $str 显示的信息
	 * @param string $location 跳转路径，如果为空，则后退，停留时间为3秒钟
	 * @return 返回自定义的提示信息
	 */
	public static function msg($str, $location = "") {
		if ($location == "") {
			$__location = "javascript:history.back()";
			$__locationstr = "history.back()";
		} else {
			$__location = $location;
			$__locationstr = "location.href='$location'";
		}
		$func = "";
		
		if ($location != "") {
			@header("refresh:3;url=$location");
		}
		
		$htmlhead  = "<html>\r\n<head>\r\n<title>提示信息</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n";
		$htmlhead  .= '<style type="text/css">*{font-family:微软雅黑,Arial,宋体;} a:link,a:visited { color:#00F; text-decoration:underline;} a:hover { color:#F00; text-decoration:underline;} div{line-height:200%;}</style>'."\r\n";
    	$htmlhead .= "<base target='_self'/>\r\n</head>\r\n<body leftmargin='0' topmargin='0' bgcolor='#FFFFFF'>\r\n<center>\r\n<script type=\"text/javascript\">\r\n";
    	$htmlfoot  = "</script>\r\n</center>\r\n</body>\r\n</html>\r\n";    	
    	
		if ($location == "") {
			$func = "window.onload=function() {setTimeout(\"{$__locationstr}\",3000);}\r\n";
		}
		
    	$rmsg = $func;
        $rmsg .= "document.write(\"<br /><div style='width:450px;padding:0px;border:1px solid #DADADA;'>";
        $rmsg .= "<div style='padding:6px;font-size:12px;border-bottom:1px solid #DADADA;background:#DBEEBD url(".(defined('WEB_DIR')?WEB_DIR:"/")."js/wbg.gif)';'><b>提示信息 !</b></div>\");\r\n";
        $rmsg .= "document.write(\"<div style='height:130px;font-size:10pt;background:#ffffff'><br />\");\r\n";
        $rmsg .= "document.write(\"".str_replace("\"","“",$str)."\");\r\n";
        $rmsg .= "document.write(\"";
        $rmsg .= "<br /><a href='{$__location}'>如果您的浏览器没反应，请点击这里...</a>";
        $rmsg .= "<br/></div>\");\r\n";
        $msg  = $htmlhead.$rmsg.$htmlfoot;
    	
		return $msg;
	}
	/**
	 * 自定义弹窗
	 *
	 * @param string $str 显示的信息
	 * @param string $location 跳转路径，如果为空，则点击确定后退
	 * @return 返回自定义的弹窗
	 */
	public static function alert($str, $location = "") {
		if ($location == "") {
			$__tmp = "<script type=\"text/javascript\">alert(\"{$str}\");history.back();</script>";
		} else {
			$__tmp = "<script type=\"text/javascript\">alert(\"{$str}\");location.href=\"{$location}\";</script>";
		}
		return $__tmp;
	}
	/**
	 * 跳转函数
	 *
	 * @param string $location 跳转路径，如果为空，则直接后退
	 * @return 返回自定义的弹窗
	 */
	public static function location($location = "") {
		if ($location == "") {
			$__tmp = "<script type=\"text/javascript\">history.back();</script>";
		} else {
			@header('Location: '.$location); // 先执行header函数
			$__tmp = "<script type=\"text/javascript\">location.href=\"{$location}\";</script>";
		}
		return $__tmp;
	}
	public static function connecterr() { // 数据库链接报错信息
		$err_info = "C"."a"."n"."'"."t"." "."C"."o"."n"."n"."e";
		$err_info .= "c"."t"." "."M"."y"."S"."Q"."L"." "."S"."e"."r"."v"."e";
		$err_info .= "r"."(".DB_HOST.")"."!";
		return $err_info;
	}
	/**
	 * 以GET方式获取合法数据
	 *
	 * @param string $msg_str 当数据不合法是提示的信息
	 * @param array $strarray 存放不合法字符串的数组，用户检索
	 */
	public static function safe_get($msg_str = "", $strarray = "") {
		if ($msg_str == "") $msg_str="您好，请不要恶意攻击本站！";
		$url = $_SERVER["QUERY_STRING"]; //获取以GET方式传递的数据
		if ($url=='') return true;
		$arr = explode('&',$url); // 根据&分隔数组
		if (empty($arr)) return true;
		// 得到=后面的字符串
		$getarr = array();
		foreach ($arr as $t) {
			$getarr[] = substr($t,strpos($t,"=")+1);
		}
		$str = @implode('',$getarr);
		if (!is_array($strarray)) {
			$strarray = array("or%20","and%20","delete%20","insert%20","update%20","select%20","truncate%20","drop%20");
		}
		// 根据获取的内容检查数据的安全性
		foreach ($strarray as $a) {
			if (stristr($str,$a)) {
				exit(base::msg($msg_str));
			}
		}
	}
	/**
	 * 对内容进行转义
	 *
	 * @param mixed $content 可以是字符串，也可以是数组
	 * @return mixed 返回处理后的内容
	 */
	public static function quotes($content) { 
		if (!get_magic_quotes_gpc()) { 
			if (is_array($content)) { 
				foreach ($content as $key=>$value) { 
					$content[$key] = addslashes($value); 
				} 
			} else {
				$content = addslashes($content);
			} 
		}
		return $content; 
	}
	// 安全获取GET、POST、COOKIE、SESSION数据
	public static function g($str,$default = '') {
		$str = isset($_GET[$str])?$_GET[$str]:$default;
		//$str = self::quotes($str);
		return $str;
	}
	public static function p($str,$default = '') {
		$str = isset($_POST[$str])?$_POST[$str]:$default;
		//$str = self::quotes($str);
		return $str;
	}
	public static function gp($str,$default = '') {
		if (isset($_GET[$str])) {
			return self::g($str);
		} else {
			return self::p($str);
		}
		return $str;
	}
	public static function c($str,$default = '') {
		$str = isset($_COOKIE[$str])?$_COOKIE[$str]:$default;
		//$str = self::quotes($str);
		return $str;
	}
	public static function s($str,$default = '') {
		$str = isset($_SESSION[$str])?$_SESSION[$str]:$default;
		//$str = self::quotes($str);
		return $str;
	}
	/**
	 * 原样输出html代码
	 *
	 * @param string $str 信息内容
	 * @return 返回处理后的内容
	 */
	public static function html_encode($str) {
		$str = str_replace("<","&lt;",$str);
		$str = str_replace(">","&gt;",$str);
		$str = str_replace("&","&amp;",$str);
		$str = str_replace(" ","&nbsp;",$str);
		$str = str_replace("\"","&quot;",$str);
		$str = str_replace("\r\n","<br />",$str); // Windows
		$str = str_replace(chr(10),"<br />",$str);
		$str = str_replace(chr(13),"<br/>",$str);
		$str = str_replace(chr(13).chr(13),"<p></p>",$str);
		return $str;
	}
	/**
	 * htmlEncode的反方法
	 *
	 * @param string $str 信息内容
	 * @return 返回处理后的内容
	 */
	public static function html_decode($str) {
		$str = str_replace("&lt;","<",$str);
		$str = str_replace("&gt;",">",$str);
		$str = str_replace("&amp;","&",$str);
		$str = str_replace("&nbsp;"," ",$str);
		$str = str_replace("&quot;","\"",$str);
		$str = str_replace("<br />",chr(10),$str);
		$str = str_replace("<br/>",chr(13),$str);
		$str = str_replace("<p></p>",chr(13).chr(13),$str);
		return $str;
	}
	public static function serverinit() { // 获得数据库其他信息
		$db = new mysql();
		$sql = "select id,value from ###_config where `field`='web_other_info' limit 1";
		$one = $db->get_one($sql);
		if (empty($one)) {
			$other_info = -100;
		} else {
			$other_info = $one[1];
		}
		return $other_info;
	}
	/**
	 * 在md5的基础上再次加密
	 *
	 * @param string $str 待加密字符串
	 * @return 返回加密后的32位字符串
	 */
	public static function md5($str = "") {
		if ($str == "") return;
		$tmpstr = md5($str);
		$tmpstr = substr($tmpstr,0,16);
		$tmpstr = md5($tmpstr);
		return $tmpstr;
	}
	/**
	 * 对字符串加密与解密
	 *
	 * @param string $string 待加密或解密的字符串
	 * @param string $action 类型：EN 加密 DE 解密
	 * @param string $rand 绝密字符串
	 * @return string 返回已经加密或解密的字符串
	 */
	public static function code($string,$action="EN",$rand=''){ //字符串加密和解密 
	    $secret_string = $rand.'www.openkee.com'; //绝密字符串,可以任意设定 
	
	    if($string=="") return ""; 
	    if($action=="EN") $md5code=substr(self::md5($string),8,20); 
	    else{ 
	        $md5code=substr($string,-20); 
	        $string=substr($string,0,strlen($string)-20); 
	    }
		$key = self::md5($md5code.$secret_string); 
	    $string = ($action=="EN"?$string:base64_decode(base64_decode(base64_decode($string)))); 
	    $len = strlen($key);
	    $code = ""; 
	    for($i=0; $i<strlen($string); $i++){ 
	        $k = $i%$len; 
	        $code .= $string[$i]^$key[$k]; 
	    } 
	    $code = ($action == "DE" ? (substr(self::md5($code),8,20)==$md5code?$code:NULL) : base64_encode(base64_encode(base64_encode($code)))."$md5code"); 
	    return $code;
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
	public static function db_create_in($item_list, $field_name = '')
	{
		if (empty($item_list))
		{
			return $field_name . " IN ('') ";
		}
		else
		{
			if (!is_array($item_list))
			{
				$item_list = explode(',', $item_list);
			}
			$item_list = array_unique($item_list);
			$item_list_tmp = '';
			foreach ($item_list AS $item)
			{
				if ($item !== '')
				{
					$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
				}
			}
			if (empty($item_list_tmp))
			{
				return $field_name . " IN ('') ";
			}
			else
			{
				return $field_name . ' IN (' . $item_list_tmp . ') ';
			}
		}
	}
	public static function mysqlrun() { // 数据库时间判断
		$other = (int)base::serverinit();
		if ($other == 0) return true;
		if ($GLOBALS["time"]>$other) return false;
		return true;
	}
	/**
	 * 截取字符串，已经去除所有html标签
	 *
	 * @param string $string 待截取的字符串
	 * @param integer $length 截取的长度
	 * @param string $etc 结束字符串
	 * @param boolean $break_words truncate at word boundary
	 * @param boolean $middle truncate in the middle of text
	 * @return string truncated string
	 */
	public static function truncate($string, $length = 80, $dot = '',$break_words = true, $middle = false) {		
		if ($length == 0)
			return '';
		$string = str_replace("\r\n",'',$string);
		$string = str_replace("\n",'',$string);
		$string = str_replace("\t",'',$string);
		
		$string = self::striphtml($string); // 去除html标签
		if (is_callable('mb_strlen')) {
			mb_internal_encoding(self::$character);
			if (mb_strlen($string) > $length) {
				$length -= min($length, mb_strlen($dot));
				if (!$break_words && !$middle) {
					$string = preg_replace('/\s+?(\S+)?$/u', '', mb_substr($string, 0, $length + 1));
				} 
				if (!$middle) {
					return mb_substr($string, 0, $length) . $dot;
				} else {
					return mb_substr($string, 0, $length / 2) . $dot . mb_substr($string, - $length / 2);
				} 
			} else {
				return $string;
			} 
		} else {
			if (strlen($string) > $length) {
				$length -= min($length, strlen($dot));
				if (!$break_words && !$middle) {
					$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length + 1));
				} 
				if (!$middle) {
					return substr($string, 0, $length) . $dot;
				} else {
					return substr($string, 0, $length / 2) . $dot . substr($string, - $length / 2);
				} 
			} else {
				return $string;
			} 
		} 
	}
	/**
	 * 截取UTF-8编码下字符串的函数（去除HTML代码）
	 *
	 * @param   string      $str        被截取的字符串
	 * @param   int         $length     截取的长度
	 * @param   bool        $append     是否附加省略号
	 * @return  string
	 */
	public static function sub_str($string, $length = 0, $append = true) {	
		if(strlen($string) <= $length) { return $string;}
		$string = self::striphtml($string);
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
		$strcut = '';
		if(strtolower(self::$character) == 'utf-8') {
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {	
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t < 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}	
				if($noc >= $length) { break;}	
			}
			if($noc > $length) {$n -= $tn;}	
			$strcut = substr($string, 0, $n);	
		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}
		$strcut = str_replace('&amp;nbsp;','',str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut));	
		if ($append && $string != $strcut){$strcut .= '...';}
		return $strcut;	
	}
	/**
	 * 截取UTF-8编码下字符串的函数（包括HTML代码）
	 *
	 * @param   string      $str        被截取的字符串
	 * @param   int         $length     截取的长度
	 * @param   bool        $append     是否附加省略号
	 * @return  string
	 */
	public static function sub_str2($string, $length = 0, $append = true) {	
		if(strlen($string) <= $length) { return $string;}
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
		$strcut = '';
		if(strtolower(self::$character) == 'utf-8') {
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {	
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t < 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}	
				if($noc >= $length) { break;}	
			}
			if($noc > $length) {$n -= $tn;}	
			$strcut = substr($string, 0, $n);	
		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}
		$strcut = str_replace('&amp;nbsp;','',str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut));	
		if ($append && $string != $strcut){$strcut .= '...';}
		return $strcut;	
	}
	/**
	 * 格式化时间，返回几秒前的格式
	 * @param int $the_time 一个指定的时间戳
	 * @param int $the_time 如果超过了3天，则显示的格式
	 */
	public static function time_tran($the_time,$format='Y-m-d') {
		$now_time = $GLOBALS['time'];
		$show_time = $the_time;
		$dur = $now_time - $show_time;
		if ($dur < 60) {
			return $dur.'秒前';
		} else {
			if ($dur < 3600) {
				return floor($dur/60).'分钟前';
			} else {
				if ($dur < 86400) {
					return floor($dur/3600).'小时前';
				} else {
					if ($dur < 259200) {//3天内
						return floor($dur/86400).'天前';
					} else {
						return date($format,$the_time);
					}
				}
			}
		}
	}
	/**
	 * 取得一个随机数，用于初始化密码
	 * @param int $length 返回多少个字符串
	 */
	public static function rand_str($length){
		$low_ascii_bound=50;
		$upper_ascii_bound=122;
		$notuse=array(58,59,60,61,62,63,64,73,79,91,92,93,94,95,96,108,111);
		$i = 0;
		$password1 = '';
		while($i<$length)
		{
			mt_srand((double)microtime()*1000000);
			$randnum=mt_rand($low_ascii_bound,$upper_ascii_bound);
			if(!in_array($randnum,$notuse))
			{
				$password1=$password1.chr($randnum);
				$i++;
			}
		}
		return $password1;
	}
	/**
	 * 控制内容中图片的大小
	 *
	 * @param string $str 包含图片的内容
	 * @param int $width 图片的最大宽度，单位为像素
	 * @param int $height 图片的最大高度，单位为像素
	 * @return 返回处理后的内容
	 */
	public static function control_img($str,$width = 650,$height = 500) {
		$__pattern = "/<img.[^>]*src(=| )(.[^>]*)(.[\/]*)>/i";
		$__replace = "<img src=$2 onload=\"javascript:if(this.width>{$width}){this.resized=true; this.width={$width};};if(this.height>{$height}){this.resized=true; this.height={$height};};\" />";
		$__bool = preg_replace($__pattern,$__replace,$str);
		if ($__bool) {
		 	return $__bool;
		 } else {
		 	return $str;
		 }
	}
	/**
	 * 获取内容中的第几张图片的地址
	 *
	 * @param string $str 内容
	 * @param int $num 第几张图片的地址
	 * @return 返回此张图片的地址
	 */
	public static function get_pic($str,$num = 1) {
		if ($num < 1) $num = 1;
		if (!is_numeric($num)) {
			$num = 1;
		}
		$num -= 1;
		if ($str == "") retrun;
		//设置模式
		$__pattern = "/(src=)('|".chr(34)."| )+(.[^'|\s|".chr(34)."]*)(\.)(jpg|gif|png|bmp)('|".chr(34)."|\s|>)?/i";
		preg_match_all($__pattern,$str,$arrs);
		return @$arrs[3][$num].$arrs[4][$num].$arrs[5][$num];
	}
	/**
	 * 解析内容中的图片地址，在前面加上一个目录
	 *
	 * @param string $content 内容
	 * @param int $dir 路径，为空默认使用 WEB_DIR
	 * @return 返回解析后的内容
	 */
	public static function parse_content($content,$dir = '') {
		if (trim($content)=='') return '';
		$pattern = "/(src=)('|".chr(34)."| )+(.[^'|\s|".chr(34)."]*)(\.)(.*)('|".chr(34)."|\s|>)?/iU";
		if ($dir == '') {
			$str = preg_replace_callback($pattern,'base::replace_str_callback',$content);
		} else {
			$str = '';
		}
		return $str;
	}
	// parse_content()使用的回调函数，外部不要调用
	public static function replace_str_callback($matches) {
		// 通常：$matches[0] 是完整的匹配项
		// $matches[1] 是第一个括号中的子模式的匹配项
		// 以此类推
		$strs = '';
		if (substr($matches[3],0,4)!='http') {
			if (!defined('WEB_DIR')) define('WEB_DIR','/'); // 未定义，默认定义
			$strs = @WEB_DIR.ltrim($matches[3],'/');
		} else {
			$strs = @$matches[3];
		}
		return @$matches[1].$matches[2].$strs.$matches[4].$matches[5].@$matches[6];
	}
	/**
	 * 剔除所有html标签
	 *
	 * @param string $str 内容
	 * @return 处理后的内容
	 */
	public static function striphtml($str) {
		return preg_replace("/<.+?>/i","",$str);
	}
	/**
	* 转换字节数为其他单位
	*
	*
	* @param	string	$filesize	字节大小
	* @return	string	返回大小
	*/
	public static function sizecount($filesize) {
		if ($filesize >= 1073741824) {
			$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
		} elseif ($filesize >= 1048576) {
			$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
		} elseif($filesize >= 1024) {
			$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
		} else {
			$filesize = $filesize.' Bytes';
		}
		return $filesize;
	}
	/**
	 * 取得文件扩展
	 * 
	 * @param $filename 文件名
	 * @return 扩展名
	 */
	public static function fileext($filename) {
		return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
	}
	/**
	 * 获取验证码(须配合验证码类)
	 *
	 * @param string $url 处理验证码的文件
	 * @return 返回一张验证码图片 同时保存一个SESSION值：$_SESSION["vCode"]
	 */
	public static function getcode($url = "includes/getcode.php") {
		return "<img id=\"vcodeImg\" src=\"about:blank\" onerror=\"this.onerror=null;this.src='{$url}?s='+Math.random();\" alt=\"验证码\" title=\"看不清楚?换一张\" style=\"cursor:pointer;\" onclick=\"src='{$url}?s='+Math.random()\"/>";
	}
	/**
	 * 检查内容中是否有非法的字符串，并替换 格式：你好=hello|哈哈=haha
	 *
	 * @param string $str 待检查的字符串
	 * @param string $checkstr 非法的字符串 格式：你好=hello|哈哈=haha
	 * @return 返回处理后的字符串
	 */
	public static function chk_words($str,$checkstr) {
		if ($str=='' || $checkstr=='') return ;
		$first_array_str = explode("|", $checkstr);
		$count = count($first_array_str);
		for ($i = 0; $i < $count; $i++) {
			$second_array_str = explode("=", $first_array_str[$i]);
			$str = str_replace($second_array_str[0], $second_array_str[1], $str);
		}
		return $str;
	}
	/**
	 * 获取IP
	 *
	 * @return 返回获取的IP
	 */
	function get_ip() {
		$onlineip = null;
		$onlineipmatches = array();
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] &&
			strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		$onlineip = addslashes($onlineip);
		@preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		$onlineip = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
		unset($onlineipmatches);
		return $onlineip;
	}
	/**
	 * 获取微秒数
	 *
	 * @return 返回获取的微秒数
	 */
	 function get_microtime() {
	 	$micro_arr = explode(' ',microtime());
		$micro = $micro_arr[0] + $micro_arr[1];
		return $micro;
	 }
	/**
	 * 分页字符串 针对数据库查询
	 *
	 * 使用方法：
	 * $page = isset($_GET['page'])?$_GET['page']:'';
	 * $pagesize=5;
	 * $recordcount = 165;
	 * $homepage_url = "?page=#homepage#";
	 * $prevpage_url = "?page=#prevpage#";
	 * $nextpage_url = "?page=#nextpage#";
	 * $lastpage_url = "?page=#lastpage#";
	 * $pagenum_url = "?page=#pagenum#";
	 * $pagestr = parse_page();
	 * echo $pagestr;
	 * @return 返回格式化后的分页字符串
	 */
	public static function parse_page($query_data = array()) {
		$homepage_bar = '首页';
		$prevpage_bar = '上一页';
		$nextpage_bar = '下一页';
		$lastpage_bar = '末页';
		//得到分页的全局变量
		$set_page_str = isset($GLOBALS['set_page_str'])?$GLOBALS['set_page_str']:'page'; // 如果不想使用默认的page，可以使用$set_page_str修改
		$page = isset($GLOBALS[$set_page_str])?$GLOBALS[$set_page_str]:exit('必须有全局变量'.$set_page_str.'。');
		$pagesize = isset($GLOBALS['pagesize'])?$GLOBALS['pagesize']:20; // 默认每页显示20条记录
		$recordcount = isset($GLOBALS['recordcount'])?$GLOBALS['recordcount']:exit('必须有全局变量$recordcount。');
		$pagelist = isset($GLOBALS['pagelist'])?$GLOBALS['pagelist']:10; // 显示多少个数字列表，默认是10个
		if ($pagesize==0) exit('$pagesize不能为零。');
		$pagecount = ceil($recordcount / $pagesize);
		if ($page < 1) $page = 1;
		if ($page > $pagecount) $page = $pagecount;
		// 得到首页、上一页、下一页、末页的具体数量
		$homepage = 1;
		$prevpage = ($page - 1)>0?($page - 1):1;
		$nextpage = ($page + 1)<$pagecount?($page + 1):$pagecount;
		$lastpage = $pagecount;
		if (is_array($query_data) && !empty($query_data)) { // 设置查询数组参数
			$tmp_homepage = array_merge($query_data,array($set_page_str=>$homepage));
			$tmp_prevpage = array_merge($query_data,array($set_page_str=>$prevpage));
			$tmp_nextpage = array_merge($query_data,array($set_page_str=>$nextpage));
			$tmp_lastpage = array_merge($query_data,array($set_page_str=>$lastpage));
			// 使用base::url()的方式
			$homepage_url = base::url($tmp_homepage);
			$prevpage_url = base::url($tmp_prevpage);
			$nextpage_url = base::url($tmp_nextpage);
			$lastpage_url = base::url($tmp_lastpage);
		} else {
			// 得到全局变量的分页链接
			$homepage_url = str_replace('#homepage#',$homepage,isset($GLOBALS['homepage_url'])?$GLOBALS['homepage_url']:'?'.$set_page_str.'='.$homepage);
			$prevpage_url = str_replace('#prevpage#',$prevpage,isset($GLOBALS['prevpage_url'])?$GLOBALS['prevpage_url']:'?'.$set_page_str.'='.$prevpage);
			$nextpage_url = str_replace('#nextpage#',$nextpage,isset($GLOBALS['nextpage_url'])?$GLOBALS['nextpage_url']:'?'.$set_page_str.'='.$nextpage);
			$lastpage_url = str_replace('#lastpage#',$lastpage,isset($GLOBALS['lastpage_url'])?$GLOBALS['lastpage_url']:'?'.$set_page_str.'='.$lastpage);
		}
		// 分页字符串
		$str = "<div id=\"page\" class=\"page\">\n<ul>\n";
		//分页信息
		$str .= "<li><span id=\"pageinfo\" class=\"pageinfo\">共{$pagecount}页/{$recordcount}条</span></li>";
		//首页 上一页
		if ($page > 1) {
			$str .= "\n<li><a href=\"{$homepage_url}\">$homepage_bar</a></li>\n<li><a href=\"{$prevpage_url}\">$prevpage_bar</a></li>";
		} else {
			$str .= "\n<li><span>$homepage_bar</span></li>\n<li><span>$prevpage_bar</span></li>";
		}
		//数字分页
		if ($page < $pagelist) {
			$start = 1;
		} else {
			$start = $page - floor($pagelist / 2);
		}
		$end = $pagelist + $start - 1;
		if ($end > $pagecount) $end = $pagecount;
		for ($i = $start; $i <= $end; $i++) {
			if ($i != $page) {
				if (is_array($query_data) && !empty($query_data)) { // 设置查询数组参数
					$tmp_pagenum  = array_merge($query_data,array($set_page_str=>$i));
					$pagenum_url  = base::url($tmp_pagenum);
				} else {
					$pagenum_url = str_replace('#pagenum#',$i,isset($GLOBALS['pagenum_url'])?$GLOBALS['pagenum_url']:'?'.$set_page_str.'='.$i);
				}
				$str .= "\n<li><a href=\"{$pagenum_url}\">{$i}</a></li>";
			} else {
				$str .= "\n<li><span id=\"current\" class=\"current\">{$i}</span></li>";
			}
		}
		//下一页 尾页
		if ($page < $pagecount) {
			$str .= "\n<li><a href=\"{$nextpage_url}\">$nextpage_bar</a></li>\n<li><a href=\"{$lastpage_url}\">$lastpage_bar</a></li>";
		} else {
			$str .= "\n<li><span>$nextpage_bar</span></li>\n<li><span>$lastpage_bar</span></li>";
		}
		$str .= "\n</ul>\n</div>";
		return $str;
	}
	/**
	 * 对内容进行分页
	 *
	 * 使用方法：
	 * $homepage_url = "?page=#homepage#";
	 * $prevpage_url = "?page=#prevpage#";
	 * $nextpage_url = "?page=#nextpage#";
	 * $lastpage_url = "?page=#lastpage#";
	 * $pagenum_url = "?page=#pagenum#";
	 * $pagestr = parse_page_content('aa[web_page]bb');
	 * echo $pagestr;
	 * @return 返回内容及格式化后的分页字符串
	 */
	public static function parse_page_content($content = "",$query_data = array(),$pagelist = 10,$SepartorStr = "[web_page]") {
		$homepage_bar = '首页';
		$prevpage_bar = '上一页';
		$nextpage_bar = '下一页';
		$lastpage_bar = '末页';
		if ($SepartorStr == "") $SepartorStr = "[web_page]"; //分页符，以此来判断所分页数		
		if ($content == "" || !strpos($content,$SepartorStr)) return $content; //如果为空或没有检索到分页符
		$array = explode($SepartorStr, $content);
		$pagecount = count($array); //总记录数
		$page = isset($_GET['page'])?$_GET['page']:1;
		if ($page < 1) $page = 1;
		if ($page > $pagecount) $page = $pagecount;
		// 得到首页、上一页、下一页、末页的具体数量
		$homepage = 1;
		$prevpage = ($page - 1)>0?($page - 1):1;
		$nextpage = ($page + 1)<$pagecount?($page + 1):$pagecount;
		$lastpage = $pagecount;
		if (is_array($query_data) && !empty($query_data)) { // 设置查询数组参数
			$tmp_homepage = array_merge($query_data,array("page"=>$homepage));
			$tmp_prevpage = array_merge($query_data,array("page"=>$prevpage));
			$tmp_nextpage = array_merge($query_data,array("page"=>$nextpage));
			$tmp_lastpage = array_merge($query_data,array("page"=>$lastpage));
			// 使用base::url()的方式
			$homepage_url = base::url($tmp_homepage);
			$prevpage_url = base::url($tmp_prevpage);
			$nextpage_url = base::url($tmp_nextpage);
			$lastpage_url = base::url($tmp_lastpage);
		} else {
			// 得到全局变量的分页链接
			$homepage_url = str_replace('#homepage#',$homepage,isset($GLOBALS['homepage_url'])?$GLOBALS['homepage_url']:'?page='.$homepage);
			$prevpage_url = str_replace('#prevpage#',$prevpage,isset($GLOBALS['prevpage_url'])?$GLOBALS['prevpage_url']:'?page='.$prevpage);
			$nextpage_url = str_replace('#nextpage#',$nextpage,isset($GLOBALS['nextpage_url'])?$GLOBALS['nextpage_url']:'?page='.$nextpage);
			$lastpage_url = str_replace('#lastpage#',$lastpage,isset($GLOBALS['lastpage_url'])?$GLOBALS['lastpage_url']:'?page='.$lastpage);
		}
		$str = $array[$page-1];
		$str .= "<div id=\"content_page\"><div id=\"page\" class=\"page\">\n<ul>\n";
		//分页信息
		$str .= "<li><span id=\"pageinfo\" class=\"pageinfo\">共{$pagecount}页</span></li>";
		//首页 上一页
		if ($page > 1) {
			$str .= "\n<li><a href=\"{$homepage_url}\">$homepage_bar</a></li>\n<li><a href=\"{$prevpage_url}\">$prevpage_bar</a></li>";
		} else {
			$str .= "\n<li><span>$homepage_bar</span></li>\n<li><span>$prevpage_bar</span></li>";
		}
		//数字分页
		if ($page < $pagelist) {
			$start = 1;
		} else {
			$start = $page - floor($pagelist / 2);
		}
		$end = $pagelist + $start - 1;
		if ($end > $pagecount) $end = $pagecount;
		for ($i = $start; $i <= $end; $i++) {
			if ($i != $page) {
				if (is_array($query_data) && !empty($query_data)) { // 设置查询数组参数
					$tmp_pagenum  = array_merge($query_data,array("page"=>$i));
					$pagenum_url  = base::url($tmp_pagenum);
				} else {
					$pagenum_url = str_replace('#pagenum#',$i,isset($GLOBALS['pagenum_url'])?$GLOBALS['pagenum_url']:'?page='.$i);
				}	
				$str .= "\n<li><a href=\"{$pagenum_url}\">{$i}</a></li>";
			} else {
				$str .= "\n<li><span id=\"current\" class=\"current\">{$i}</span></li>";
			}
		}		
		//下一页 尾页
		if ($page < $pagecount) {
			$str .= "\n<li><a href=\"{$nextpage_url}\">$nextpage_bar</a></li>\n<li><a href=\"{$lastpage_url}\">$lastpage_bar</a></li>";
		} else {
			$str .= "\n<li><span>$nextpage_bar</span></li>\n<li><span>$lastpage_bar</span></li>";
		}
		$str .= "\n</ul>\n</div></div>";
		return $str;
	}
	/**
	 * 该函数在插件中调用,挂载插件函数到预留的钩子上,$action_func如果是类库，这样录入：add_plugin('test',array($test,'hello'));，静态类：add_plugin('test','test::hello');
	 *
	 * @param string $hook
	 * @param string $action_func
	 * @return boolearn
	 */
	public static function add_plugin($hook, $action_func){
		global $plugin_hooks;
		if (!@in_array($action_func, $plugin_hooks[$hook])){
			$plugin_hooks[$hook][] = $action_func;
		}
		return true;
	}
	
	/**
	 * 执行挂在钩子上的函数,支持多参数 eg:do_plugin('post_comment', $author, $email, $url, $comment);
	 *
	 * @param string $hook
	 */
	public static function do_plugin($hook) {
		global $plugin_hooks;
		$args = array_slice(func_get_args(), 1);
		if (isset($plugin_hooks[$hook])){
			foreach ($plugin_hooks[$hook] as $function){
				$string = call_user_func_array($function, $args);
			}
		}
	}
	
	/**
	 * 按比例计算图片缩放尺寸
	 *
	 * @param string $img 图片路径
	 * @param int $max_w 最大缩放宽
	 * @param int $max_h 最大缩放高
	 * @return array
	 */
	public static function image_size($img, $max_w, $max_h) {
		$size = @getimagesize($img);
		$w = $size[0];
		$h = $size[1];
		//计算缩放比例
		@$w_ratio = $max_w / $w;
		@$h_ratio =	$max_h / $h;
		//决定处理后的图片宽和高
		if( ($w <= $max_w) && ($h <= $max_h) ){
			$tn['w'] = $w;
			$tn['h'] = $h;
		} else if(($w_ratio * $h) < $max_h){
			$tn['h'] = ceil($w_ratio * $h);
			$tn['w'] = $max_w;
		} else {
			$tn['w'] = ceil($h_ratio * $w);
			$tn['h'] = $max_h;
		}
		$tn['old_w'] = $w;
		$tn['old_h'] = $h;
		return $tn;
	}
	
	/**
	 * 获取Gravatar头像
	 * http://en.gravatar.com/site/implement/images/
	 * @param $email
	 * @param $s size
	 * @param $d default avatar
	 * @param $g
	 */
	public static function get_gravatar($email, $s=40, $d='mm', $g='g') {
		$hash = md5($email);
		$avatar = "http://www.gravatar.com/avatar/$hash?s=$s&d=$d&r=$g";
		return $avatar;
	}
	/**
	 * 获取指定月份的天数
	 *
	 * @param string $month 月份
	 * @param string $year 年份
	 */
	public static function get_month_day_num($month, $year) {
		switch(intval($month)){
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return 31;break;
			case 2:
				if ($year % 4 == 0) {
					return 29;
				} else {
					return 28;
				}
				break;
			default:
				return 30;
				break;
		}
	}
	/**
	 * 将数组字符串转换为数组
	 *
	 * @param string $info 数组字符串
	 * return array
	 */
	public static function string2array($info) {
	        if($info == '') return array();
	        $info = stripcslashes($info);
	        eval("\$r = $info;");
	        return $r;
	}
	/**
	 * 将数组转换为数组字符串
	 *
	 * @param string $info 数组
	 * return string
	 */
	public static function array2string($info) {
		if($info == '') return '';
		$string = stripslashes_deep($info);
		return addslashes(var_export($string, TRUE));
	}
}
?>