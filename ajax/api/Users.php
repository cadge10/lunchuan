<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
/**
 * 会员类 登录，注册，详情 列表
 * @author zhengkejian@sina.com
 * @copyright 郑克剑
 * @category  PHP
 * @version v1.0
 */
Class Users{
    /**
     * @access private
     * @var string 数据表名。
     */
	private $table = 'users';
    /**
     * @access private
     * @var Object 数据库对象。
     */
    private $db;
    /**
     * @access private
     * 初始化数据库操作对象
     */
    public function __construct($db) {
        $this->db = $db;
    }
    /**
     * 会员登录
     * @throws 40010->帐号不能为空40011->帐号或密码错误
     * @url http://api请求地址/api.php?mod=Users&fun=userLogin&username=xxx&password=xxx&time=xxxx&token=xxxx
     * @example users1.html How to use this function
     * @param String $username 用户名
     * @param String $password 密码
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function userLogin($username='',$password=''){
		$username = isset($_REQUEST['username']) ? trim($_REQUEST['username']) : $username;
		$password = isset($_REQUEST['password']) ? trim($_REQUEST['password']) : $password;
		if($username == ''){
			$response = array(
				'code'	=>	'40010',
				'msg'	=>	'帐号不能为空'
			);
			exit(json_encode($response));
		}
		$sql	=	"SELECT * FROM ###_".$this->table." WHERE username = '".$username."' AND password = '".md5($password)."'";
		$data	=	$this->db->get_row($sql);
		if($data){
			$response = array(
				'code'	=>	'40000',
				'msg'	=>	'success',
				'data'	=>	$data
			);
		}else{
			$response = array(
				'code'	=>	'40011',
				'msg'	=>	'帐号或密码错误'
			);
		}
		exit(json_encode($response));
	}
    /**
     * 会员退出
     * @throws 40031->参数ID错误
     * @url http://api请求地址/api.php?mod=Users&fun=userOut&id=xxx&time=xxxx&token=xxxx
     * @example users2.html How to use this function
     * @param Int $id 用户ID
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function userOut($id=0){
		$id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : $id;
		if($id <= 0){
			$response = array(
				'code'	=>	'40031',
				'msg'	=>	'参数ID错误'
			);
			exit(json_encode($response));
		}
		$_SESSION['login_id'] = null;
		$_SESSION['login_user'] = null;
		$_SESSION['login_utype'] = null;
		setcookie('auto_login',null,time()-3600*24);
		setcookie('auto_id',null,time()-3600*24);
		setcookie('auto_user',null,time()-3600*24);
		setcookie('auto_utype',null,time()-3600*24);
		$response = array(
			'code'	=>	'40000',
			'msg'	=>	'success'
		);
		exit(json_encode($response));
	}
    /**
     * 会员信息
     * @throws 40001->参数ID错误40002->此帐号已被删除
     * @url http://api请求地址/api.php?mod=Users&fun=getUsersInfo&id=xxx&time=xxxx&token=xxxx
     * @example users3.html How to use this function
     * @param Int $id 用户ID
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getUsersInfo($id=0){
		$id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : $id;
		if($id <= 0){
			$response = array(
				'code'	=>	'40001',
				'msg'	=>	'参数ID错误'
			);
			exit(json_encode($response));
		}
		$sql	=	"SELECT * FROM ###_".$this->table." WHERE id = '".$id."'";
		$data	=	$this->db->get_row($sql);
		if($data){
			$response = array(
				'code'	=>	'40000',
				'msg'	=>	'success',
				'data'	=>	$data
			);
		}else{
			$response = array(
				'code'	=>	'40002',
				'msg'	=>	'此帐号已被删除'
			);
		}
		exit(json_encode($response));
	}
    /**
     * 会员列表
     * @url http://api请求地址/api.php?mod=Users&fun=getUserList&page=xxx&size=xxx&time=xxxx&token=xxxx
     * @example users4.html How to use this function
     * @param int $page 页
     * @param int $size 每页数
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getUserList($page=0,$size=0){
		$page	=	isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : $page;
		$size	=	isset($_REQUEST['size']) ? (int)$_REQUEST['size'] : $size;
		$sql	=	"SELECT count(id) FROM ###_".$this->table." WHERE 1";
		$count	=	$this->db->get_count($sql);
		$limit  =	($page > 0 && $size > 0) ? ' LIMIT '.($page-1) * $size.','.$size : '';
		$sql	=	"SELECT * FROM ###_".$this->table." WHERE 1 ORDER BY id DESC $limit";
		$data	=	$this->db->get_all_name($sql);
		$response = array(
			'code'	=>	'40000',
			'msg'	=>	'success',
			'total'	=>	$count,
			'page'	=>	$page,
			'data'	=>	$data
		);
		exit(json_encode($response));
	}
    /**
     * 会员收藏
     * @url http://api请求地址/api.php?mod=Users&fun=getMyCollection&page=xxx&size=xxx&userid=xxx&table=xxx&time=xxxx&token=xxxx
     * @example users5.html How to use this function
     * @param int $page 页
     * @param int $size 页数
     * @param int $userid 用户ID
     * @param string $table 类型product->产品，users->会员,information->供求信息
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getMyCollection($userid=0,$page=0,$size=0,$table='product'){
		$page	=	isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : $page;
		$size	=	isset($_REQUEST['size']) ? (int)$_REQUEST['size'] : $size;
		$table	=	isset($_REQUEST['table']) ? trim($_REQUEST['table']) : $table;
		$userid	=	isset($_REQUEST['userid']) ? (int)$_REQUEST['userid'] :$userid;
		$sql	=	"SELECT count(c.id) FROM ###_coll WHERE 1 AND c.uid = ".$userid." AND tid = '".$table."'";
		$count	=	$this->db->get_count($sql);		
		$limit  =	($page > 0 && $size > 0) ? ' LIMIT '.($page-1) * $size.','.$size : '';
		$sql	=	"SELECT o.* FROM ###_coll c LEFT JOIN ###_{$table} o ON (o.id = c.pid) WHERE 1 AND c.uid = ".$userid." AND tid = '".$table."' ORDER BY c.id DESC $limit";
		$data	=	$this->db->get_all_name($sql);
		$response = array(
			'code'	=>	'40000',
			'msg'	=>	'success',
			'total'	=>	$count,
			'page'	=>	$page,
			'data'	=>	$data
		);
		exit(json_encode($response));
	}
    /**
     * 会员注册
     * @throws 40020->数据错误40021->注册失败
     * @url http://api请求地址/api.php?mod=Users&fun=register&array=xxx&time=xxxx&token=xxxx
     * @example users6.html How to use this function
     * @param array $array 有如下元素
     *         username->用户名，password->密码,realname->姓名,company->公司
     *         province->省,city->市,sex->性别,phone->手机,email->邮箱,tel->固定电话
     *         utyoe->会员类型,fax->传真,qq
     * @param string $table 类型product->产品，users->会员,information->供求信息
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
    public function register($array=array()){
        $array	=	isset($_REQUEST['array']) ? $_REQUEST['array'] : $array;
        if(empty($array)){
            $response = array(
                'code'	=>	'40020',
                'msg'	=>	'数据错误',
            );
            exit(json_encode($response));
        }
        $array['password'] = md5($array['password']);
        $insert = $this->db->add($array,$this->table);
        if($insert){
            $sql  = "SELECT * FROM ".$this->table." WHERE id = '".$insert."'";
            $data = $this->db->query($sql);
            $response = array(
                'code'	=>	'40000',
                'msg'	=>	'success',
                'data'	=>	$data
            );
        }else{
            $response = array(
                'code'	=>	'40021',
                'msg'	=>	'注册失败'
            );
        }
        exit(json_encode($response));
    }
}

?>