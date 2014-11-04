<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action') == 'add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$userid = (int)base::p('userid');
	$title = trim(base::p('title'));
	$typeid = (int)base::p('typeid');
	
	$count = $db->get_count("select id from `###_newstype` where `typeid`='$typeid'");
	if ($count) {
		exit(base::alert('必须是最终栏目才能添加文章！')); // 不是最终栏目
	}
	
	$sortid = (int)base::p('sortid');
	$content = base::p('content');
	$author = trim(base::p('author'));
	$gourl = trim(base::p('gourl'));
	$isshow = (int)base::p('isshow');
	$recommend = (int)base::p('recommend');
	$onlypage = (int)base::p('onlypage');
	$picarr =  base::p('pic');
	if (is_array($picarr)) {
		$picarr2 = array();
		foreach ($picarr as $tmp) {
			if ($tmp=='') continue;
			$picarr2[] = $tmp;
		}
		$pic = implode(',',$picarr2);
	} else {
		$pic = '';
	}
	$url = trim(base::p('url'));
	
	$addtime = @strtotime(trim(base::p('addtime')));
	
	// 进行判断
	if ($title == '') exit(base::alert('请填写文章标题！'));
	if ($typeid == 0) exit(base::alert('请选择文章栏目！'));
	
	// 入库
	$sql = "update ###_news set userid='$userid',title='$title',typeid='$typeid',sortid='$sortid',content='$content',
	author='$author',isshow='$isshow',recommend='$recommend',onlypage='$onlypage',pic='$pic',url='$url',addtime='$addtime' where id='$id'";
	$db->query($sql);
	exit(base::alert('文章修改成功，请返回。','?mod=admin_news'.$gourl));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_news where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));

$gourl = pub::go_url();
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/calendar/calendar.js"></script>
<link href="js/calendar/calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.title.value=='') {
		alert('请填写文章标题！');
		frm.title.focus();
		return false;
	}
	if (frm.typeid.value==0) {
		alert('请选择文章栏目！');
		frm.typeid.focus();
		return false;
	}
	if (frm.checktype.value == 'no') {
		alert('您只能在最后一级栏目下添加文章！');
		frm.typeid.focus();
		return false;
	}
}
function checkTypeId(str) {
	$.get('admincp.php',{r:Math.random(),a:'ajax',mod:'admin_news_checktype',typeid:str},function(data){
		if ($.trim(data) == 'no') {
			$('#checktype').val('no');
			$('#typemsg').html('<font color="red" style="font-family:Arial;" title="请您选择一个有效的栏目，并且只能选择最后一级栏目。"> X</font>');
		} else {
			$('#checktype').val('yes');
			$('#typemsg').html('<font color="green" style="font-family:Arial;"> &radic;</font>');
		}
	});
}
$(function(){
	checkTypeId($('#typeid').val());
	$('#typeid').change(function(){
		checkTypeId($('#typeid').val());
	});
	
	
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo adminpub::detailtitle($view);?></h1></td>
  </tr>
</table>


<form action="" method="post" name="form1" id="form1" onSubmit="return checkForm(this);">
<input name="action" type="hidden" id="action" value="add">
<input name="userid" type="hidden" id="userid" value="<?php echo $one['userid'];?>">
<input name="id" type="hidden" id="id" value="<?php echo $one['id']?>">
<input name="gourl" type="hidden" id="gourl" value="<?php echo $gourl?>">
<input name="checktype" type="hidden" id="checktype" value="no">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">文章标题：</th>
      <td><input type="text" id="title" name="title" size="50" value="<?php echo $one['title']?>" /></td>
    </tr>
    <tr>
      <th align="left">文章栏目：</th>
      <td><?php echo adminpub::getartcol($one['typeid'],'请选择栏目……');?><span id="typemsg"></span>　文章顺序：<input name="sortid" type="text" id="sortid" value="<?php echo $one['sortid']?>" size="10" maxlength="9"> 
        *数字越小越靠前。</td>
      </tr>
    
      <th align="left">文章内容：</th>
      <td><?php echo editor::xhEditor($one['content']);?></td>
    </tr>
    <tr>
        <th align="left">添加时间：</th>
        <td><input name="addtime" type="text" id="addtime" size="30" maxlength="30" onClick="return showCalendar('addtime', '%Y-%m-%d %H:%M:%S', false, false, 'addtime');" value="<?php echo date("Y-m-d H:i:s",$one['addtime']);?>" />
</td>
    </tr>
    <tr>
      <th align="left">文章作者：</th>
      <td><input name="author" type="text" id="author" value="<?php echo $one['author']?>" size="30"></td>
      </tr>
    <tr>
      <th align="left">文章属性：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1"<?php if ($one['isshow']==1){echo ' checked';}?>>
        <label for="isshow">文章显示</label>　
          <input name="recommend" type="checkbox" id="recommend" value="1"<?php if ($one['recommend']==1){echo ' checked';}?>>
        <label for="recommend">文章推荐</label>　
          <input name="onlypage" type="checkbox" id="onlypage" value="1"<?php if ($one['onlypage']==1){echo ' checked';}?>>
         <label for="onlypage"> 唯一页面(通常做频道页面，且唯一页面不能被删除。)</label></td>
      </tr>
    <tr>
    <tr>
      <th align="left">外部链接：</th>
      <td><input name="url" type="text" id="url" size="50" value="<?php echo $one['url']?>"> 
      *如果是外部链接地址，网址前面请加http://。</td>
    </tr>
    <tr>
      <th align="left">文章图片：</th>
      <td>
		<?php echo multiupload::add_pic($one["pic"]);?>
      </td>
      </tr>
  </tbody> 
</table>
<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php include('bottom.php');?>
</body>
</html>