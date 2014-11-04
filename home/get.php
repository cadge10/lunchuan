<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '求购信息发布-供求信息';
$here = "<a href='?mod=information'>供求信息</a> > <a href=''>求购信息发布</a>";
if(base::s('login_id',0) <= 0 || base::s('login_utype') == 1){//未登录
    exit(base::msg('必须是采购商才可发布求购信息'));
}
if($_POST){
    $changjia = base::p('changjia','');
    if($changjia == '')exit(base::msg('请输入厂家'));
    $province = base::p('province','');
    $city = base::p('city','');
    $mingcheng = base::p('mingcheng','');
    $price = base::p('price','');
    $yunshu = base::p('yunshu','');
    $baozhuang = base::p('baozhuang',0);
    $didian = base::p('didian',0);
    $xinghao = base::p('xinghao','');
    if($xinghao == '')exit(base::msg('请输入规格型号'));
    $guanzhu = base::p('guanzhu','');
    $num = base::p('num','');
    if($num == '')exit(base::msg('请输入供应数量'));
    $fukuai = base::p('fukuai','');
    $min = base::p('min','');
    $youxiao = base::p('youxiao','');
    $pic = base::p('pic','');
    $content = base::p('content','');
    if($content == '')exit(base::msg('请输入产品描述'));
    $userid = base::p('userid','');
    $sql    =   "INSERT INTO ###_information (`changjia`,`ttype`,`mingcheng`,`province`,`city`,`price`,`yunshu`,`baozhuang`,`didian`,`xinghao`,`guanzhu`,`num`,`fukuai`,`min`,`youxiao`,`pic`,`content`,`addtime`,`userid`) VALUES ('".$changjia."','2','".$mingcheng."','".$province."','".$city."','".$price."','".$yunshu."','".$baozhuang."','".$didian."','".$xinghao."','".$guanzhu."','".$num."','".$fukuai."','".$min."','".$youxiao."','".$pic."','".$content."','".time()."','".$userid."')";
    if($db->query($sql)){
        exit(base::msg('发布成功','?mod=information'));
    }else{
        exit(base::msg('发布失败','?mod=get'));
    }
}
$sql =  "SELECT * FROM ###_users WHERE id = ".base::s('login_id');
$info = $db->get_one($sql);
$tpl->assign('file_title',$file_title);
$tpl->assign('here',$here);
$tpl->assign('info',$info);
?>