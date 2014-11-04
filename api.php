<?php
include('inc.php');

// 检查网站是否关闭
if (pub::get_config('web_close')=='1') exit(pub::get_config('web_close_description'));

base::router(); // 路由设置

$app_file = 'api'; //api目录
//echo time()."<br>";
//echo md5(md5('apikey'.time()));
$api_time = base::gp('time');//1个小时有效时间
if((time() - $api_time) > 3600){
	$response = array(
		'code'	=>	'40100',
		'msg'	=>	'非法访问，拒绝'
	);
	exit(json_encode($response));
}

$token = base::gp('token');//密钥 apikey
if(md5(md5('apikey'.$api_time)) != $token){
	$response = array(
		'code'	=>	'40101',
		'msg'	=>	'密钥错误，拒绝访问'
	);
	exit(json_encode($response));
}

$view = base::gp('mod','index');
if($view == ''){
	$response = array(
		'code'	=>	'40100',
		'msg'	=>	'非法访问，拒绝'
	);
	exit(json_encode($response));
}
$fun  = base::gp('fun');
if($fun == ''){
	$response = array(
		'code'	=>	'40100',
		'msg'	=>	'非法访问，拒绝'
	);
	exit(json_encode($response));
}
if (!file_exists(__ROOT__.'/ajax/'.$app_file.'/'.$view.'.php')){
	$response = array(
		'code'	=>	'40100',
		'msg'	=>	'非法访问，拒绝'
	);
	exit(json_encode($response));
}
include(__ROOT__.'/ajax/'.$app_file.'/'.$view.'.php');

$obj = new $view($db);
if(!method_exists($obj,$fun)){
	$response = array(
		'code'	=>	'40100',
		'msg'	=>	'非法访问，拒绝'
	);
	exit(json_encode($response));
}
$obj->$fun();
exit();

?>