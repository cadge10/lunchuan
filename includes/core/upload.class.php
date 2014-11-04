<?php
/**
 * 文件上传类
 * 可以使用的有两个方法，一个是构造方法，另一个则是start()方法
 */
class upload {
	var $path;
	var $type = ".jpg,.png,.gif,.rar,.zip,.swf";

	/**
	 * 构造函数
	 *
	 * @param string $path 文件存放的路径，格式：attachments/，注意，后面必须加“/”
	 * @param string $type 文件允许的类型
	 */
	function __construct($path,$type="png,jpg,gif,rar,zip,swf")
	{
		$this->path = $path;
		//更新文件类型
		$this->type = $this->set_type($type);
	}

	function set_type($type="png,jpg,gif,rar,zip,gz,swf")
	{
		if(!$type)
		{
			$type = "png,jpg,gif,rar,zip,gz,swf";
		}
		$type_array = explode(",",$type);
		$array = array();
		foreach($type_array as $key=>$value)
		{
			$value = trim($value);
			if(strlen($value)>1)
			{
				if((substr($value,0,1) != "."))
				{
					$value = ".".$value;
				}
				$array[$key] = $value;
			}
		}
		$this->type = implode(",",$array);
		$mytype = $this->type;
		return $mytype;
	}

	/**
	 * 开始上传
	 *
	 * @param string $var 文件域的名称
	 * @param string $file 文件的名称（没有扩展名），如果不填，则使用当前时间作为该文件名
	 * @return 如果上传成功，返回上传的文件名，否则返回 false
	 */
	function start($var,$file="")
	{
		if(empty($var))
		{
			return false;
		}
		$this->_make_dir($this->path);#[更新附件路径]
		$file_name = $this->_check($file);
		if(!$file_name) $file_name = $this->DateStr();//如果文件名为空，刚使用时间作为文件名称
		//检查文件名称是否含有后缀，有则去掉
		$file_name = strtolower($file_name);//将所有大写改为小写
		//-----
		$file_type = $this->_file_type($var);
		if($file_type)
		{
			if(strrpos($file_name,".") === false)
			{
				$filename = $file_name.$file_type;//新的文件名
			}
			else
			{
				$filename = $file_name;
			}
			#[由于PHP不支持客户端检查文件大小，固这里没有对文件大小进行限制]
			$up = move_uploaded_file($_FILES[$var]["tmp_name"],$this->path.$filename);
			if($up)
			{
				return $filename;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function Name($var)
	{
		return $_FILES[$var]["name"];
	}

	function _file_type($var)
	{
		if($_FILES[$var]["name"])
		{
			$name = explode(".",$_FILES[$var]["name"]);
			$count = count($name);
			$type = ".".strtolower($name[$count-1]);
			if(strpos($this->type,$type) === false)
			{
				return false;
			}
			return $type;
		}
		else
		{
			return false;
		}
	}

	function _check($file="")
	{
		if(!$file)
		{
			return false;
		}
		$file_name = basename($file);
		if($file_name == $file)
		{
			return $file;
		}
		$array = explode("/",$file);
		$path = "";
		$count = count($array);
		if($count > 1)
		{
			for($i = 0;$i < ($count-1); $i++)
			{
				$path .= $array[$i]."/";
			}
		}
		$this->_make_dir($this->path.$path);
		$this->path = $this->path.$path;
		return $file_name;
	}

	#[创建目录]
	function _make_dir($folder)
	{
		$array = explode("/",$folder);
		$count = count($array);
		$msg = "";
		for($i=0;$i<$count;$i++)
		{
			$msg .= $array[$i];
			if(!file_exists($msg) && ($array[$i]))
			{
				mkdir($msg,0777);
			}
			$msg .= "/";
		}
		return true;
	}

	function GetPath()
	{
		return $this->path;
	}

	function FileType($filename)
	{
		$filename = basename($filename);
		$name = explode(".",$filename);
		$count = count($name);
		$type = strtolower($name[$count-1]);
		return $type;
	}
	
	function DateStr() {
		return date("YmdHis");
	}
}
?>