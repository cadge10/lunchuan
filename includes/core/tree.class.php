<?php
/**
 * 获取目录树
 * 以二维数组存放数据
 *
 */
class tree {
	/**
	 * 设置树结构最多可以有多少级
	 *
	 * @var int
	 */
	public $level = 100;
	
	private $Data = NULL;
	/**
	 * 构造函数
	 *
	 * @param array $Data 数组数据
	 */
	public function __construct($Data) {
		if (!is_array($Data)) {
			$Data = array();
		}
		$this->Data = $Data;
	}
	
	/**
	 * 获取子树
	 *
	 * @param array $Data 数据
	 * @param int $Id 父类标示符
	 * @return 返回一个存放子树的二维数组
	 */
	private function get_children($Data, $Id) {
		$Counter = 0;
		$tmpChildNode = NULL;
		for ($i = 0; $i < count($Data); $i++) {
			if ($Data[$i]["parentid"] == $Id) {
				$tmpChildNode[$Counter]["id"] = $Data[$i]["id"];
				$tmpChildNode[$Counter]["parentid"] = $Data[$i]["parentid"];
				$tmpChildNode[$Counter]["title"] = isset($Data[$i]["title"])?$Data[$i]["title"]:'';
				$tmpChildNode[$Counter]["sortid"] = isset($Data[$i]["sortid"])?$Data[$i]["sortid"]:0;
				$tmpChildNode[$Counter]["isshow"] = isset($Data[$i]["isshow"])?$Data[$i]["isshow"]:0;
				$tmpChildNode[$Counter]["url"] = isset($Data[$i]["url"])?$Data[$i]["url"]:'';
				$Counter++;
			}
		}
		return $tmpChildNode;
	}
	
	/**
	 * 检测该树下面是否有子树
	 *
	 * @param array $Data 数组数据
	 * @param int $Id 父类标示符
	 * @return bool 如果有子树，返回true，否则false
	 */
	private function check_tree($Data, $Id) {
		if ($this->get_children($Data, $Id)) return true;
		return false;
	}
	
	/**
	 * 获取树状结构
	 *
	 * @param int $Id 编号
	 * @param int $Stack 每个栏目下有多少子类
	 * @param array $Result 读取数据并存放在$Result的二维数组中
	 * @return array 返回处理后的树状结构
	 */
	public function get_tree($Id = 0, $Stack = 0, $Result = array()) {
		if ($Stack == 0) $Result = array();
		//获取ParentId = $Id的所有数据
		$StartData = $this->get_children($this->Data, $Id);
		for ($i = 0; $i < count($StartData); $i++) {
			$Node = $this->check_tree($this->Data, $StartData[$i]["id"]);
			$Result[] = array(
						"id"=>$StartData[$i]["id"],
						"parentid"=>$StartData[$i]["parentid"],
						"title"=>$StartData[$i]["title"],
						"sortid"=>$StartData[$i]["sortid"],
						"isshow"=>$StartData[$i]["isshow"],
						"url"=>$StartData[$i]["url"],
						"type"=>$Node,
						"stack"=>$Stack
			);
			if ($Node == true && $Stack < $this->level - 1) {
				$Result = $this->get_tree($StartData[$i]["id"], $Stack + 1, $Result);
			}
		}
		return $Result;
	}
	
	/**
	 * 
	 * 获取所有子类ID，并保存在一个一维数组中
	 * @param int $Id 编号
	 * @return array 返回一个一维数组
	 */
	public function get_child_all_id($Id = 0) {
		$Result = $this->_get_child_all_id($Id);
		array_unshift($Result,$Id);
		return $Result;
	}
	private function _get_child_all_id($Id = 0, $Stack = 0, $Result = array()) {
		if ($Stack == 0) $Result = array();
		$StartData = $this->get_children($this->Data, $Id);
		for ($i = 0; $i < count($StartData); $i++) {
			$Node = $this->check_tree($this->Data, $StartData[$i]["id"]);
			$Result[] = $StartData[$i]["id"];
			if ($Node == true && $Stack < $this->level - 1) {
				$Result = $this->_get_child_all_id($StartData[$i]["id"], $Stack + 1, $Result);
			}
		}
		return $Result;
	}
	
	/**
	 * 
	 * 获取所有父类类ID，并保存在一个一维数组中，该数组从最顶级开始，依次类推，针对栏目导航使用
	 * @param int $Id 编号
	 * @return array 返回一个一维数组
	 */
	public function get_parent_all_id($Id = 0) {
		$Result = $this->_get_parent_all_id($Id);
		if (is_array($Result)) {
			$Result =  array_reverse($Result);
			$Result[] = $Id;
		} else {
			$Result = array();
		}
		return $Result;
	}
	private function _get_parent_all_id($Id = 0, $Result = array()) {
		$StartData = $this->Data;
		$tmpArr = NULL;
		for ($i = 0; $i < count($StartData); $i++) {
			if ($StartData[$i]["id"]==$Id) {
				$tmpArr = $StartData[$i];
			}
		}
		if ($tmpArr["id"]!=$Id) return false;
		if ($tmpArr["parentid"]!=0) {
			$Result[] = $tmpArr["parentid"];
			$Result = $this->_get_parent_all_id($tmpArr["parentid"], $Result);
		}
		return $Result;
	}
	/**
	 * 
	 * 获取父类类ID
	 * @param int $Id 当前ID编号中
	 * @return int 当前ID的父类ID
	 */
	 public function get_parent_id($Id = 0) {
		$StartData = $this->Data;
		for ($i = 0; $i < count($StartData); $i++) {
			if ($StartData[$i]["id"]==$Id) {
				return $StartData[$i]["parentid"];
			}
		}
		return 0;
	}
}
?>