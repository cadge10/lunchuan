<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
/**
 * 供求信息类
 * @author zhengkejian@sina.com
 * @copyright 郑克剑
 * @category  PHP
 * @version v1.0
 */
Class Information{
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
     * 供求信息列表
     * @url http://api请求地址/api.php?mod=Information&fun=getInformationList&page=xxx&size=xxx&time=xxxx&token=xxxx
     * @example price1.html How to use this function
     * @param int $page 页
     * @param int $size 每页数
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getInformationList($page=0,$size=0){
		$page	=	isset($_REQUEST['page']) ? (int)$_REQUEST['page'] : $page;
		$size	=	isset($_REQUEST['size']) ? (int)$_REQUEST['size'] : $size;
		$sql	=	"SELECT count(id) FROM ###_".$this->table." WHERE 1";
		$count	=	$this->db->get_count($sql);
		$limit  =	($page > 0 && $size > 0) ? ' LIMIT '.($page-1) * $size.','.$size : '';
		$sql	=	"SELECT id,mingcheng,pic FROM ###_".$this->table." WHERE 1 ORDER BY id DESC $limit";
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
     * 供求信息详情
     * @throws 40001->参数ID错误40002->此帐号已被删除
     * @url http://api请求地址/api.php?mod=Information&fun=getInformationInfo&id=xxx&time=xxxx&token=xxxx
     * @example products2.html How to use this function
     * @param Int $id 用户ID
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
	public function getInformationInfo($id=0){
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
    /**
     * 发布供求信息
     * @throws 40030->数据错误40031->发布失败
     * @url http://api请求地址/api.php?mod=Information&fun=send&array=xxx&time=xxxx&token=xxxx
     * @example information3.html How to use this function
     * @param array $array 有如下元素
     *               changjia->公司或厂家,mingcheng->产品名称,xinghao->型号,num->数量
     *               province->省,city->市,baozhuang->包装,price->价格,didian->地点
     *               youxiao->有效期,userid->发布人,ttype->类型（1供应,2求购）
     * @param string $table 类型product->产品，users->会员,information->供求信息
     * @return array{code->状态码,msg->提示信息,data->数据数组}
     */
    public function send($array=array()){
        $array	=	isset($_REQUEST['array']) ? $_REQUEST['array'] : $array;
        if(empty($array)){
            $response = array(
                'code'	=>	'40030',
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
                'code'	=>	'40031',
                'msg'	=>	'发布失败'
            );
        }
        exit(json_encode($response));
    }
}

?>