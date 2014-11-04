<?php
// 操作数据库类
class mysql {
	public $link;
	public $version;
	public $sql;
	public $result;
	public $record;
	
	// 数据库缓存
	var $max_cache_time = 300; // 最大的缓存时间，以秒为单位
	var $cache_data_dir = 'data/query_caches/';
    var $root_path      = '';
	var $dbhash         = '';
	var $platform       = '';
	var $timeline       = 0;
    var $timezone       = 0;
	var $mysql_disable_cache_tables = array(); // 不允许被缓存的表，遇到将不会进行缓存
	
	public function __construct($charset = 'utf8') {
		$this->connect($charset);
	}
	public function connect($charset = '') {
		if ($charset == '') $charset = 'utf8';
		$db_part = DB_PORT != '3306'?':'.DB_PORT:'';
		$conn = @mysql_connect(DB_HOST.$db_part,DB_USER,DB_PASSWORD) or exit("Can't Connect MySQL Server(".DB_HOST.")!");
		$this->version = mysql_get_server_info($conn);
		$this->link = $conn;
		$db = @mysql_select_db(DB_NAME,$conn) or exit("Can't select MySQL database(".DB_NAME.")!");
		/* 如果mysql 版本是 4.1+ 以上，需要对字符集进行初始化 */
        if ($this->version > '4.1') {
            if ($charset != 'latin1') {
                mysql_query("SET character_set_connection=$charset, character_set_results=$charset, character_set_client=binary", $this->link);
            }
            if ($this->version > '5.0.1') {
                mysql_query("SET sql_mode=''", $this->link);
            }
        }
	}
	public function select_db($database) {
		$db = @mysql_select_db($database,$this->link) or exit("Can't select MySQL database($database)!");
		return $db;
	}
	// 如果使用next_record()方法并且在循环体里使用query()时，$type请设置为flase，目的防止此次操作覆盖循环体外的操作
	public function query($sql,$type = true) {
		$sql = $this->parse_sql($sql);
		$result = mysql_query($sql,$this->link);
		if ($type) {
			$this->result = $result;
		}
		return $result;
	}
	public function next_record() {
		if (!$this->result) return false;
		$this->record = mysql_fetch_array($this->result);
		if (is_array($this->record)) {
			return true;
		} else {
			$this->free($this->result);
			return false;
		}
	}
	public function f($name) {
		if (isset($this->record[$name])) {
			return $this->record[$name];
		}
	}
	public function fetch_array($result) {
		$fetch = mysql_fetch_array($result);
		return $fetch;
	}
	public function fetch_assoc($result) {
		$fetch = mysql_fetch_assoc($result);
		return $fetch;
	}
	public function fetch_row($result) {
		$fetch = mysql_fetch_row($result);
		return $fetch;
	}
	public function num_rows($sql = '') {
		if ($sql != '') {
			$result = $this->query($sql,false);
			$num_rows = mysql_num_rows($result);
			return $num_rows;
		} else {
			$num_rows = mysql_num_rows($this->result);
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
		$arr = array();
		while ($one = $this->fetch_array($result)) {
			$arr[] = $one;
		}
		return $arr;
	}
	public function insert_id() {
		$insert_id = mysql_insert_id($this->link);
		return $insert_id;
	}
	public function affected_rows() {
		$affected_rows = mysql_affected_rows($this->link);
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
	public function free($result) {
		@mysql_free_result($result);
	}
	public function close() {
		@mysql_close($this->link);
	}
	/* public: table locking */
	public function lock($table, $mode = "write") {
		$query = "lock tables ";
		if(is_array($table)) {
			while(list($key,$value) = each($table)) {
				// text keys are "read", "read local", "write", "low priority write"
				if(is_int($key)) $key = $mode;
				if(strpos($value, ",")) {
					$query .= str_replace(",", " $key, ", $value) . " $key, ";
				} else {
					$query .= "$value $key, ";
				}
			}
			$query = substr($query, 0, -2);
			} elseif(strpos($table, ",")) {
			$query .= str_replace(",", " $mode, ", $table) . " $mode";
		} else {
			$query .= "$table $mode";
		}
		if(!$this->query($query,false)) {
			echo "lock() failed.";
			return false;
		}
		return true;
	}
	/* table unlocking */
	public function unlock() {	
		// set before unlock to avoid potential loop	
		if(!$this->query("unlock tables",false)) {
			echo "unlock() failed.";
			return false;
		}
		return true;
	}
	
	// 操作数据库，新增或更新数据，如果是更新$data里需要有where数组，即$data['where'] = 'id=5';
	public function do_data($table,$data = array()) {
		if (trim($table) == '') return false;
		if (empty($data)) $data = isset($_POST)?$_POST:array();
		if (empty($data)) return false;
		$fields = $this->get_fields($table);
		if (empty($fields)) return false;
		
		$new_data_k = array();
		$new_data_v = array();
		$new_data_u = array();
		$_tmp_data = array();
		foreach ($fields as $k=>$v) { // 去除主键
			if ($v['primary'] == 1 && $v['autoinc'] == 1) continue;
			$_tmp_data[$k] = $v;
		}
		$fields = $_tmp_data;
		
		foreach ($data as $k=>$v) {
			if (!array_key_exists($k,$fields)) continue;
			
			$new_data_k[] = "`$k`";
			$new_data_v[] = "'".$v."'";
			$new_data_u[] = "`$k`='".$v."'";
		}
		
		if (isset($data['where'])) {
			$where = trim($data['where']);
			if ($where == '') return false;
			$sql = "UPDATE ###_{$table} SET ".implode(',',$new_data_u)." WHERE $where";
		} else {
			$sql = "INSERT INTO ###_{$table} (".implode(',',$new_data_k).") VALUES (".implode(',',$new_data_v).")";
		}
		if (@$this->query($sql,false)) {
			return true;
		} else {
			return false;
		}

	}
	public function get_fields($table_name) {
		$result =   $this->get_all('SHOW COLUMNS FROM ###_'.$table_name);
		$info   =   array();
		if($result) {
			foreach ($result as $key => $val) {
				$info[$val['Field']] = array(
					'name'    => $val['Field'],
					'type'    => $val['Type'],
					'notnull' => (bool) ($val['Null'] === ''), // not null is empty, null is yes
					'default' => $val['Default'],
					'primary' => (strtolower($val['Key']) == 'pri'),
					'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
				);
			}
		}
		return $info;
	}
    public function get_tables() {
        $sql    = 'SHOW TABLES';
        $result =   $this->get_all($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
	
	// 缓存读取方法
	function get_one_cached($sql, $cached = 'FILEFIRST')
    {
        $sql = trim($sql . ' LIMIT 1');

        $cachefirst = ($cached == 'FILEFIRST' || ($cached == 'MYSQLFIRST' && $this->platform != 'WINDOWS')) && $this->max_cache_time;
        if (!$cachefirst)
        {
            return $this->get_one($sql);
        }
        else
        {
            $result = $this->getSqlCacheData($sql, $cached);
            if (empty($result['storecache']) == true)
            {
                return $result['data'];
            }
        }

        $arr = $this->get_one($sql);

        if ($arr !== false && $cachefirst)
        {
            $this->setSqlCacheData($result, $arr);
        }

        return $arr;
    }
	
	function get_all_cached($sql, $cached = 'FILEFIRST')
    {
        $cachefirst = ($cached == 'FILEFIRST' || ($cached == 'MYSQLFIRST' && $this->platform != 'WINDOWS')) && $this->max_cache_time;
        if (!$cachefirst)
        {
            return $this->get_all($sql);
        }
        else
        {
            $result = $this->getSqlCacheData($sql, $cached);
            if (empty($result['storecache']) == true)
            {
                return $result['data'];
            }
        }

        $arr = $this->get_all($sql);

        if ($arr !== false && $cachefirst)
        {
            $this->setSqlCacheData($result, $arr);
        }

        return $arr;
    }
	
	// 数据库缓存
    function setMaxCacheTime($second)
    {
        $this->max_cache_time = $second;
    }

    function getMaxCacheTime()
    {
        return $this->max_cache_time;
    }

    function getSqlCacheData($sql, $cached = '')
    {
        $sql = trim($sql);

        $result = array();
        $result['filename'] = $this->root_path . $this->cache_data_dir . 'sqlcache_' . abs(crc32($this->dbhash . $sql)) . '_' . md5($this->dbhash . $sql) . '.php';

        $data = @file_get_contents($result['filename']);
        if (isset($data{23}))
        {
            $filetime = substr($data, 13, 10);
            $data     = substr($data, 23);

            if (($cached == 'FILEFIRST' && time() > $filetime + $this->max_cache_time) || ($cached == 'MYSQLFIRST' && $this->table_lastupdate($this->get_table_name($sql)) > $filetime))
            {
                $result['storecache'] = true;
            }
            else
            {
                $result['data'] = @unserialize($data);
                if ($result['data'] === false)
                {
                    $result['storecache'] = true;
                }
                else
                {
                    $result['storecache'] = false;
                }
            }
        }
        else
        {
            $result['storecache'] = true;
        }

        return $result;
    }

    function setSqlCacheData($result, $data)
    {
        if ($result['storecache'] === true && $result['filename'])
        {
            @file_put_contents($result['filename'], '<?php exit;?>' . time() . serialize($data));
            clearstatcache();
        }
    }
	
	/* 获取 SQL 语句中最后更新的表的时间，有多个表的情况下，返回最新的表的时间 */
    function table_lastupdate($tables)
    {
        if ($this->link_id === NULL)
        {
            $this->connect($this->settings['dbhost'], $this->settings['dbuser'], $this->settings['dbpw'], $this->settings['dbname'], $this->settings['charset'], $this->settings['pconnect']);
            $this->settings = array();
        }

        $lastupdatetime = '0000-00-00 00:00:00';

        $tables = str_replace('`', '', $tables);
        $this->mysql_disable_cache_tables = str_replace('`', '', $this->mysql_disable_cache_tables);

        foreach ($tables AS $table)
        {
            if (in_array($table, $this->mysql_disable_cache_tables) == true)
            {
                $lastupdatetime = '2037-12-31 23:59:59';

                break;
            }

            if (strstr($table, '.') != NULL)
            {
                $tmp = explode('.', $table);
                $sql = 'SHOW TABLE STATUS FROM `' . trim($tmp[0]) . "` LIKE '" . trim($tmp[1]) . "'";
            }
            else
            {
                $sql = "SHOW TABLE STATUS LIKE '" . trim($table) . "'";
            }
            $result = mysqli_query($sql, $this->link_id);

            $row = mysqli_fetch_assoc($result);
            if ($row['Update_time'] > $lastupdatetime)
            {
                $lastupdatetime = $row['Update_time'];
            }
        }
        $lastupdatetime = strtotime($lastupdatetime) - $this->timezone + $this->timeline;

        return $lastupdatetime;
    }

    function get_table_name($query_item)
    {
        $query_item = trim($query_item);
        $table_names = array();

        /* 判断语句中是不是含有 JOIN */
        if (stristr($query_item, ' JOIN ') == '')
        {
            /* 解析一般的 SELECT FROM 语句 */
            if (preg_match('/^SELECT.*?FROM\s*((?:`?\w+`?\s*\.\s*)?`?\w+`?(?:(?:\s*AS)?\s*`?\w+`?)?(?:\s*,\s*(?:`?\w+`?\s*\.\s*)?`?\w+`?(?:(?:\s*AS)?\s*`?\w+`?)?)*)/is', $query_item, $table_names))
            {
                $table_names = preg_replace('/((?:`?\w+`?\s*\.\s*)?`?\w+`?)[^,]*/', '\1', $table_names[1]);

                return preg_split('/\s*,\s*/', $table_names);
            }
        }
        else
        {
            /* 对含有 JOIN 的语句进行解析 */
            if (preg_match('/^SELECT.*?FROM\s*((?:`?\w+`?\s*\.\s*)?`?\w+`?)(?:(?:\s*AS)?\s*`?\w+`?)?.*?JOIN.*$/is', $query_item, $table_names))
            {
                $other_table_names = array();
                preg_match_all('/JOIN\s*((?:`?\w+`?\s*\.\s*)?`?\w+`?)\s*/i', $query_item, $other_table_names);

                return array_merge(array($table_names[1]), $other_table_names[1]);
            }
        }

        return $table_names;
    }
	
	/* 设置不允许进行缓存的表 */
    function set_disable_cache_tables($tables)
    {
        if (!is_array($tables))
        {
            $tables = explode(',', $tables);
        }

        foreach ($tables AS $table)
        {
            $this->mysql_disable_cache_tables[] = $table;
        }

        array_unique($this->mysql_disable_cache_tables);
    }
}
?>