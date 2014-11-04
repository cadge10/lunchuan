<?php 
class files  {
	/**
	* 转化 \ 为 /
	* 
	* @param	string	$path	路径
	* @return	string	路径
	*/
	public function dir_path($path) {
		$path = str_replace('\\', '/', $path);
		if(substr($path, -1) != '/') $path = $path.'/';
		return $path;
	}
	/**
	* 创建目录
	* 
	* @param	string	$path	路径
	* @param	string	$mode	属性
	* @return	string	如果已经存在则返回true，否则为flase
	*/
	public function dir_create($path, $mode = 0777) {
		if(is_dir($path)) return TRUE;
		$ftp_enable = 0;
		$path = $this->dir_path($path);
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
	* 拷贝目录及下面所有文件
	* 
	* @param	string	$fromdir	原路径
	* @param	string	$todir		目标路径
	* @return	string	如果目标路径不存在则返回false，否则为true
	*/
	public function dir_copy($fromdir, $todir) {
		$fromdir = $this->dir_path($fromdir);
		$todir = $this->dir_path($todir);
		if (!is_dir($fromdir)) return FALSE;
		if (!is_dir($todir)) $this->dir_create($todir);
		$list = glob($fromdir.'*');
		if (!empty($list)) {
			foreach($list as $v) {
				$path = $todir.basename($v);
				if(is_dir($v)) {
					$this->dir_copy($v, $path);
				} else {
					copy($v, $path);
					@chmod($path, 0777);
				}
			}
		}
		return TRUE;
	}
	/**
	* 转换目录下面的所有文件编码格式
	* 
	* @param	string	$in_charset		原字符集
	* @param	string	$out_charset	目标字符集
	* @param	string	$dir			目录地址
	* @param	string	$fileexts		转换的文件格式
	* @return	string	如果原字符集和目标字符集相同则返回false，否则为true
	*/
	public function dir_iconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
		if($in_charset == $out_charset) return false;
		$list = $this->dir_list($dir);
		foreach($list as $v) {
			if (preg_match("/\.($fileexts)/i", $v) && is_file($v)){
				file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
			}
		}
		return true;
	}
	/**
	* 列出目录下所有文件
	* 
	* @param	string	$path		路径
	* @param	string	$exts		扩展名
	* @param	array	$list		增加的文件列表
	* @return	array	所有满足条件的文件
	*/
	public function dir_list($path, $exts = '', $list= array()) {
		$path = $this->dir_path($path);
		$files = glob($path.'*');
		foreach($files as $v) {
			$fileext = $this->fileext($v);
			if (!$exts || preg_match("/\.($exts)/i", $v)) {
				$list[] = $v;
				if (is_dir($v)) {
					$list = $this->dir_list($v, $exts, $list);
				}
			}
		}
		return $list;
	}
	/**
	* 设置目录下面的所有文件的访问和修改时间
	* 
	* @param	string	$path		路径
	* @param	int		$mtime		修改时间
	* @param	int		$atime		访问时间
	* @return	array	不是目录时返回false，否则返回 true
	*/
	public function dir_touch($path, $mtime = 0, $atime = 0) {
		if (!is_dir($path)) return false;
		$path = $this->dir_path($path);
		if (!$mtime) $mtime = time();
		if (!$atime) $atime = time();
		if (!is_dir($path)) touch($path, $mtime, $atime);
		$files = glob($path.'*');
		foreach($files as $v) {
			is_dir($v) ? $this->dir_touch($v, $mtime, $atime) : touch($v, $mtime, $atime);
		}
		return true;
	}
	/**
	* 目录列表
	* 
	* @param	string	$dir		路径
	* @param	int		$parentid	父id
	* @param	array	$dirs		传入的目录
	* @return	array	返回目录列表
	*/
	public function dir_tree($dir, $parentid = 0, $dirs = array()) {
		global $id;
		if ($parentid == 0) $id = 0;
		$list = glob($dir.'*');
		foreach($list as $v) {
			if (is_dir($v)) {
				$id++;
				$dirs[$id] = array('id'=>$id,'parentid'=>$parentid, 'name'=>basename($v), 'dir'=>$v.'/');
				$dirs = $this->dir_tree($v.'/', $id, $dirs);
			}
		}
		return $dirs;
	}
	
	/**
	* 删除目录及目录下面的所有文件
	* 
	* @param	string	$dir		路径
	* @return	bool	如果成功则返回 TRUE，失败则返回 FALSE
	*/
	public function dir_delete($dir) {
		$dir = $this->dir_path($dir);
		if (!is_dir($dir)) return FALSE;
		$list = glob($dir.'*');
		foreach($list as $v) {
			is_dir($v) ? $this->dir_delete($v) : @unlink($v);
		}
		return @rmdir($dir);
	}
	
	/**
	 * 取得文件扩展
	 * 
	 * @param $filename 文件名
	 * @return 扩展名
	 */
	public function fileext($filename) {
		return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
	}
	
	/**
	 * 删除一个文件
	 *
	 * @param string $filename 文件名
	 * @return bool
	 */
	public function file_delete($filename)	{
		return @unlink($filename);
	}
	
	/**
	 * 读取文件的内容
	 *
	 * @param string $filename 文件的名称
	 * @param int $type 如果$type=1，只能读取本地文件，其他值既可以读取本地又可以读取远程文件
	 * @return 如果读取成功返回读取的内容，否则返回false
	 */
	public function read($filename,$type = 1) {
		if ($type==1) { // 只能读取本地的
			if (!is_file($filename)) return false;
		}
		$content = file_get_contents($filename);
		return $content;
	}
	/**
	 * 创建一个文件
	 *
	 * @param string $content 文件内容
	 * @param string $filename 文件名，可以包含目录，如果是目录，不存在则创建。注意，最后一定是文件
	 * @param int $mode 文件打开模式
	 * @return bool
	 */
	public function write($content, $filename, $mode = 0777) {
		$dir = substr($filename,0,strrpos($filename,'/'));
		if (!file_exists($dir) && strlen($dir)) {
			$this->dir_create($dir, $mode);
		}
		$bool = file_put_contents($filename,$content);
		if ($bool) return true;
		return false;
	}
	/**
	 * 下载远程文件到指定的文件夹，该文件夹必须存在，注意：文件名不要出现汉字，否则可能不能下载。
	 *
	 * @param string $url 文件存在的地址
	 * @param string $dir 保存到的目录，如果不存在，自动创建
	 * @param int $mode 文件打开模式
	 * @return bool
	 */
	public function down_dir($url,$dir='./') {
		set_time_limit(3600);
		$content = @file_get_contents($url);
		if ($content) {
			if (!file_exists($dir) && strlen($dir)) {
				$this->dir_create($dir);
			}
			return @file_put_contents($dir.basename($url),$content);
		} else {
			return false;
		}
	}
}
?>