<?php
// 操作数据库类
// SQLITE获取所有表语句：SELECT name FROM sqlite_master WHERE (type = 'table')
class sqlite {
	public $link;
	public $sql;
	public $result;
	public function __construct() {
		$this->connect();
	}
	public function connect() {
		$conn = @sqlite_open(__ROOT__.'/includes/websun.db') or exit("Can't Connect Sqlite Server(".__ROOT__.'/includes/websun.db'.")!");
		$this->link = $conn;
	}
	// 如果使用next_record()方法并且在循环体里使用query()时，$type请设置为flase，目的防止此次操作覆盖循环体外的操作
	public function query($sql,$type = true) {
		$sql = $this->parse_sql($sql);
		$result = sqlite_query($sql,$this->link);
		if ($type) {
			$this->result = $result;
		}
		return $result;
	}
	public function next_record() {
		if (!$this->result) return false;
		$this->record = sqlite_fetch_array($this->result);
		if (is_array($this->record)) {
			return true;
		} else {
			$this->free();
			return false;
		}
	}
	public function f($name) {
		if (isset($this->record[$name])) {
			return $this->record[$name];
		}
	}
	public function fetch_array($result) {
		$fetch = sqlite_fetch_array($result);
		return $fetch;
	}
	public function fetch_assoc($result) {
		$fetch = sqlite_fetch_array($result, SQLITE_ASSOC);
		return $fetch;
	}
	public function fetch_row($result) {
		$fetch = sqlite_fetch_array($result, SQLITE_NUM);
		return $fetch;
	}
	public function num_rows($sql = '') {
		if ($sql != '') {
			$result = $this->query($sql,false);
			$num_rows = sqlite_num_rows($result);
			return $num_rows;
		} else {
			$num_rows = sqlite_num_rows($this->result);
			return $num_rows;
		}
	}
	public function get_count($sql) {
		$arr = @$this->get_one($sql);
		return $arr[0];
	}
	public function get_one($sql) {
		$result = $this->query($sql,false);
		$one = $this->fetch_array($result);
		return $one;
	}
	public function get_one_row($sql) {
		$result = $this->query($sql,false);
		$one = $this->fetch_row($result);
		return $one;
	}
	public function get_all($sql) {
		$result = $this->query($sql,false);
		$arr = sqlite_fetch_all($result);
		return $arr;
	}
	public function insert_id() {
		$insert_id = sqlite_last_insert_rowid($this->link);
		return $insert_id;
	}
	public function affected_rows() {
		$affected_rows = sqlite_changes($this->link);
		return $affected_rows;
	}
	// 根据条件获取id，并以逗号分隔。用于 in(idcond)
	public function get_id_split($sql) {
		$re = $this->query($sql,false);
		$item_list = array();
		while ($rs = @$this->fetch_row($re)) {
			$item_list[] = $rs[0];
		}
		
		if (empty($item_list))
		{
			return "''";
		}
		else
		{
			if (!is_array($item_list))
			{
				$item_list = explode(',', $item_list);
			}
			$item_list = array_unique($item_list);
			$item_list_tmp = '';
			foreach ($item_list as $item)
			{
				if ($item !== '')
				{
					$item_list_tmp .= $item_list_tmp ? ",'$item'" : "'$item'";
				}
			}
			if (empty($item_list_tmp))
			{
				return "''";
			}
			else
			{
				return $item_list_tmp;
			}
		}
	}
	private function parse_sql($sql) {
		if ($sql=='') return '';
		$sql = str_replace('###_',DB_PREFIX,$sql);
		$this->sql=$sql;
		return $sql;
	}
	public function get_sql() {
		if ($this->sql) return $this->sql;
	}
	public function free() {
		@sqlite_close($this->link);
	}
	public function close() {
		//mysql_close($this->link);
	}
	/* public: table locking */
	public function lock($table, $mode = "write") {
		return true;
	}
	/* table unlocking */
	public function unlock() {
		return true;
	}
}
?>