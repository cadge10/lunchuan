<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '发布求职信息-招聘中心';
$here = "<a href='?mod=jobs'>招聘中心</a> > <a href=''>发布求职信息</a>";
if($_POST){
    $jobs_title = base::p('jobs_title','');
    if($jobs_title == '')exit(base::msg('请输入招聘名称'));
    $sex = base::p('sex',1) == 1 ? '男' : '女';
    $birthday = base::p('birthday','');
    $yuanxiao = base::p('xuexiao','');
    $xueli = base::p('xueli','');
    $zhuanye = base::p('zhuanye','');
    $jingyan = base::p('jingyan','');
    $xinzi = base::p('xinzi','');
    $content = base::p('content','');
    if($content == '')exit(base::msg('请输入详细信息'));
    $tel = base::p('tel','');
    if($tel == '')exit(base::msg('请输入固定电话'));
    $realname = base::p('realname','');
    if($realname == '')exit(base::msg('请输入姓名'));
    $phone = base::p('phone','');
    if($phone == '')exit(base::msg('请输入移动电话'));
    $address = base::p('address','');
    if($address == '')exit(base::msg('请输入联系地址'));
    $code = base::p('code','');
    if ($code!=base::s('vCode')) exit(base::msg('请输入正确的验证码。'));
    $sql    =   "INSERT INTO ###_careers (`jobs_title`,`sex`,`birthday`,`yuanxiao`,`xueli`,`zhuanye`,`jingyan`,`xinzi`,`content`,`tel`,`realname`,`address`,`phone`,`addtime`) VALUES ('".$jobs_title."','".$sex."','".$birthday."','".$yuanxiao."','".$xueli."','".$zhuanye."','".$jingyan."','".$xinzi."','".$content."','".$tel."','".$realname."','".$address."','".$phone."','".time()."')";
    if($db->query($sql)){
        exit(base::msg('发布成功','?mod=jobs'));
    }else{
        exit(base::msg('发布失败','?mod=get_jobs'));
    }
}
$tpl->assign('file_title',$file_title);
$tpl->assign('here',$here);
?>