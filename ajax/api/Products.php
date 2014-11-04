<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
/**
 * 产品类
 * @author zhengkejian@sina.com
 * @copyright 郑克剑
 * @category  PHP
 * @version v1.0
 */
Class Products{
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
     * 产品列表
     * @url http://api请求地址/api.php?mod=Products&fun=getProductsList&page=xxx&size=xxx&time=xxxx&token=xxxx
     * @example products1.html How to use this function
     * @param int $page 页
     * @param int $size 每页数
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getProductsList($page=0,$size=0){
		$page	=	isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : $page;
		$size	=	isset($_REQUEST['size']) ? (int)$_REQUEST['size'] : $size;
		$sql	=	"SELECT count(id) FROM ###_".$this->table." WHERE 1";
		$count	=	$this->db->get_count($sql);
		$limit  =	($page > 0 && $size > 0) ? ' LIMIT '.($page-1) * $size.','.$size : '';
		$sql	=	"SELECT id,title,pic FROM ###_".$this->table." WHERE 1 ORDER BY id DESC $limit";
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
     * 产品信息详情
     * @throws 40001->参数ID错误40002->此帐号已被删除
     * @url http://api请求地址/api.php?mod=Prodcts&fun=getProductsInfo&id=xxx&time=xxxx&token=xxxx
     * @example products2.html How to use this function
     * @param Int $id 用户ID
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getProductsInfo($id=0){
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
			$data['content'] = strip_tags($data['content'],"");
			$response = array(
				'code'	=>	'40000',
				'msg'	=>	'success',
				'data'	=>	$data
			);
		}else{
			$response = array(
				'code'	=>	'40002',
				'msg'	=>	'此条信息已被删除'
			);
		}
		exit(json_encode($response));
	}
}

?>