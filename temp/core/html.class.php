<?php
// 生成或删除一个简单的静态页面类库
class html {
	/**
	 * 
	 * 生成一个静态页面
	 * @param string $page 生成保存的页面，默认index.html
	 * @param string $save_url 保存的地址，默认当前目录
	 */
	public static function add($url = "index.php", $save_page = "index.html") {
		if ($url == "") $url = "index.php";
		if ($save_page == "") $save_page = "index.html";
		$data = self::get_content($url);
		return self::build_html($save_page, $data);
	}
	/**
	 * 删除一个页面
	 *
	 * @param string $filename 文件名
	 * @return bool
	 */
	public static function del($filename)	{
		return @unlink($filename);
	}
	/**
	 * 
	 * 检查文件是否存在，如果存在，返回$filename,不存在返回空
	 * @param string $filename
	 */
	public static function exists($filename) {
		if (file_exists($filename)) {
			return $filename;
		} else {
			return '';
		}
	}
	/**
	 * 
	 * 远程获取内容
	 * @param $url 远程地址，需要带http://
	 */
	public static function get_content($url) {
		if ($url == "") return FALSE;
		$url = self::get_website().$url;
		if (function_exists("curl_init")) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1) ;
			$content = curl_exec($ch);
			curl_close($ch);
		} else {
			$content = @file_get_contents($url);
		}
		return $content;
	}
	/**
	 * 
	 * 获取网站的地址
	 */
	public static function get_website() {
		return 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/';
	}
	/**
	 * 
	 * 生成静态页面
	 * @param string $save_page 生成的页面
	 * @param string $data 生成的数据
	 */
	public static function build_html($save_page, $data) {
		if ($save_page == "" OR $data == "") return FALSE;
		$save_page = rtrim(self::dir_path($save_page),"/");
		$_path = strstr($save_page,"/");
		if ($_path != false) {
			$_save_page = str_replace($_path,"",$save_page);
			self::dir_create($_save_page);
		}
		if (@file_put_contents($save_page, $data)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	/**
	* 创建目录
	* 
	* @param	string	$path	路径
	* @param	string	$mode	属性
	* @return	string	如果已经存在则返回true，否则为flase
	*/
	public static function dir_create($path, $mode = 0777) {
		if(is_dir($path)) return TRUE;
		$ftp_enable = 0;
		$path = self::dir_path($path);
		$temp = explode('/', $path);
		$cur_dir = '';
		$max = count($temp) - 1;
		for($i=0; $i<$max; $i++) {
			$cur_dir .= $temp[$i].'/';
			if (@is_dir($cur_dir)) continue;
			@mkdir($cur_dir, 0777,true);
			@chmod($cur_dir, 0777);
		}
		return is_dir($path);
	}
	/**
	* 转化 \ 为 /
	* 
	* @param	string	$path	路径
	* @return	string	路径
	*/
	public static function dir_path($path) {
		$path = str_replace('\\', '/', $path);
		if(substr($path, -1) != '/') $path = $path.'/';
		return $path;
	}
}
?>