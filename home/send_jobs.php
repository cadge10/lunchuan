<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
// 处理页面
$file_title = '发布招聘信息-招聘中心';
$here = "<a href='?mod=jobs'>招聘中心</a> > <a href=''>发布招聘信息</a>";
if($_POST){
    $jobs_title = base::p('jobs_title','');
    if($jobs_title == '')exit(base::msg('请输入招聘名称'));
    $xueli = base::p('xueli','');
    $zhuanye = base::p('zhuanye','');
    $jingyan = base::p('jingyan','');
    $xinzi = base::p('xinzi','');
    $youxiao = base::p('youxiao',0);
    $renshu = base::p('renshu',0);
    $zhiweimiaoshu = base::p('zhiweimiaoshu','');
    if($zhiweimiaoshu == '')exit(base::msg('请输入职位描述'));
    $renzhiyaoqiu = base::p('renzhiyaoqiu','');
    if($renzhiyaoqiu == '')exit(base::msg('请输入任职要求'));
    $gongsiyaoqiu = base::p('gongsiyaoqiu','');
    if($gongsiyaoqiu == '')exit(base::msg('请输入公司要求'));
    $gongsiming = base::p('gongsiming','');
    $tel = base::p('tel','');
    $realname = base::p('realname','');
    $address = base::p('address','');
    $code = base::p('code','');
    if ($code!=base::s('vCode')) exit(base::msg('请输入正确的验证码。'));
    $sql    =   "INSERT INTO ###_jobs (`title`,`xueli`,`zhuanye`,`jingyan`,`xinzi`,`youxiao`,`renshu`,`content`,`renzhiyaoqiu`,`gongsiyaoqiu`,`gongsiming`,`tel`,`realname`,`address`,`starttime`) VALUES ('".$jobs_title."','".$xueli."','".$zhuanye."','".$jingyan."','".$xinzi."','".$youxiao."','".$renshu."','".$zhiweimiaoshu."','".$renzhiyaoqiu."','".$gongsiyaoqiu."','".$gongsiming."','".$tel."','".$realname."','".$address."','".time()."')";
    if($db->query($sql)){
        exit(base::msg('发布成功','?mod=jobs'));
    }else{
        exit(base::msg('发布失败','?mod=send_jobs'));
    }
}
$tpl->assign('file_title',$file_title);
$tpl->assign('here',$here);
?>