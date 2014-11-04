<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
$moduleid = (int)base::gp('moduleid');
if ($moduleid <= 0) exit(base::msg('请正确访问此页面。'));
$module_data = $db->get_one("SELECT * FROM ###_module WHERE status=1 AND id='$moduleid'");
if (empty($module_data)) exit(base::msg('此模型已经禁止使用，请返回。'));
$table = $module_data['name'];

$field_data = module::getFields($table);

$page = (int)base::g('page',1);
$pagesize=100;

$sqlt = '';
$qstr = array('mod'=>'admin_module_table');
$qstr['moduleid'] = $moduleid;

$typeid = isset($_REQUEST['typeid'])?(int)$_REQUEST['typeid']:0;
if ($typeid) {
	$childstr = module::gettreechildall($typeid);
	$sqlt .= " and typeid in($childstr)";
	$qstr['typeid'] = $typeid;
}

$userid = isset($_REQUEST['userid'])?(int)$_REQUEST['userid']:0;
/*if ($userid) {
	$sqlt .= " and a.userid='$userid'";
	$qstr['userid'] = $userid;
}
*/
$relation_id = (int)base::gp('relation_id');
$relation_table = '';
if ($relation_id && array_key_exists('relation_id',$field_data) && module::table_field_stauts($moduleid,'relation_id')) {
	$relation_table = trim(base::gp('relation_table'));
	$sqlt .= " and relation_id='$relation_id'";
	$qstr['relation_id'] = $relation_id;
	$qstr['relation_table'] = $relation_table;
}

$keyword = isset($_REQUEST['keyword'])?trim($_REQUEST['keyword']):'';
if ($keyword) {
	$sqlt .= " and title like '%$keyword%'";
	$qstr['keyword'] = $keyword;
}

$isshow = isset($_REQUEST['isshow'])?trim($_REQUEST['isshow']):'-1';
if ($isshow == 1 || $isshow == 0) {
	$isshow = (int)$isshow;
	$sqlt .= " and isshow='$isshow'";
	$qstr['isshow'] = $isshow;
}

// 如果存在fid字段，则自动调用select类型的值
$fid = isset($_REQUEST['fid'])?trim($_REQUEST['fid']):'0';
if ($fid) {
	$fid = (int)$fid;
	$sqlt .= " and fid='$fid'";
	$qstr['fid'] = $fid;
}


// 排序效果
$table_id_sort          = "";
$table_sortid_sort      = "";
$table_addtime_sort     = "";
$table_hits_sort        = "";
$table_isshow_sort        = "";

$orderby = " sortid ASC,id DESC";

$sort_name = 'sort_'.$moduleid;
$sort = base::s($sort_name);

if ($sort) {
	if (is_array($sort)) {
		if (isset($sort['table_id_sort'])) {
			$table_id_sort = trim($sort['table_id_sort']);
			$orderby = " id $table_id_sort";
		}
		if (isset($sort['table_sortid_sort'])) {
			$table_sortid_sort = trim($sort['table_sortid_sort']);
			$orderby = " sortid $table_sortid_sort";
		}
		if (isset($sort['table_addtime_sort'])) {
			$table_addtime_sort = trim($sort['table_addtime_sort']);
			$orderby = " addtime $table_addtime_sort";
		}
		if (isset($sort['table_hits_sort'])) {
			$table_hits_sort = trim($sort['table_hits_sort']);
			$orderby = " hits $table_hits_sort";
		}
		if (isset($sort['table_isshow_sort'])) {
			$table_isshow_sort = trim($sort['table_isshow_sort']);
			$orderby = " isshow $table_isshow_sort";
		}
	}
}
$table_id_sort = $table_id_sort=="DESC"?"ASC":"DESC";
$table_sortid_sort = $table_sortid_sort=="DESC"?"ASC":"DESC";
$table_addtime_sort = $table_addtime_sort=="DESC"?"ASC":"DESC";
$table_hits_sort = $table_hits_sort=="DESC"?"ASC":"DESC";
$table_isshow_sort = $table_isshow_sort=="DESC"?"ASC":"DESC";

$recordcount = $db->get_count("select count(id) from ###_{$table} where 1{$sqlt}");

if ($recordcount>0) {$pagecount = ceil($recordcount/$pagesize);} else {$pagecount = 0;}
if ($page < 1) $page = 1;
if ($page > $pagecount) $page = $pagecount;
$currentpage = ($page-1)*$pagesize;

$sql = "select id from ###_{$table} where 1{$sqlt} order by {$orderby} limit $currentpage,$pagesize";
$idcond = $db->get_id_split($sql);

$sql = "select * from ###_{$table} where id in($idcond) order by {$orderby}";
$db->query($sql);

$pagestr = base::parse_page($qstr);
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<link rel="stylesheet" href="admin/images/style.css" type="text/css">
<script type="text/javascript" src="admin/images/admin.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>

<script type="text/javascript" src="js/transport.js"></script>
<script type="text/javascript" src="admin/images/liulist.js"></script>

<script type="text/javascript">
$(function(){
	$('.darkrow').hover(function(){$(this).addClass('darkrow_out');},function(){$(this).removeClass('darkrow_out');});
});
</script>
</head>
<body id="main">
<table id="pagehead" cellpadding="0" cellspacing="0" border="0" width="100%">
  <tr>
    <td><h1><?php echo $module_data['title']?></h1></td>
    <td class="actions">
      <table summary="" cellpadding="0" cellspacing="0" border="0" align="right">
        <tr>
          <?php
          if ($module_data['isadd']==1 && !$relation_id) {
		  ?><td<?php if (strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_table_add&moduleid=<?php echo $moduleid?>" class="view">添加数据</a></td><?php
		  }
		  ?>
          <td<?php if (!strpos($view,'_add')){echo " class=\"active\"";}?>><a href="?mod=admin_module_table&moduleid=<?php echo $moduleid.($relation_id?'&relation_id='.$relation_id:'').($relation_table?'&relation_table='.$relation_table:'')?>" class="view">数据列表</a></td>
        </tr>
      </table>
  </tr>
</table>

<form name="form2" method="get" action="?mod=admin_module_table">
  <input name="mod" type="hidden" id="mod" value="admin_module_table">
  <input name="moduleid" type="hidden" id="moduleid" value="<?php echo $moduleid;?>">
  <?php if ($relation_id) {?><input name="relation_id" type="hidden" id="relation_id" value="<?php echo $relation_id;?>">
  <input name="relation_table" type="hidden" id="relation_table" value="<?php echo $relation_table;?>" /><?php }?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td height="25" valign="top">搜索：
<input name="keyword" type="text" id="keyword" size="30" value="<?php echo stripslashes_deep($keyword);?>" maxlength="100">
<?php if (array_key_exists('typeid',$field_data) && module::table_field_stauts($moduleid,'typeid')) {?>快速选择栏目：<?php echo module::getartcol($typeid,'默认所有栏目',$moduleid);?><?php }?>
<?php if (array_key_exists('fid',$field_data) && module::table_field_stauts($moduleid,'fid')) {?>
		<select name="fid" id="fid">
          <option value="0">默认所有栏目</option>
          <?php
          $f_data = $db->get_one("SELECT id,setup FROM ###_field WHERE moduleid='$moduleid' AND type='select' LIMIT 1");
		  if (!empty($f_data)) {
			  $f_options = $f_data['setup'];
			  if ($f_options != '') {
				  $options_data = @base::string2array($f_options);
				  $options_str = @$options_data['options'];
				  if (trim($options_str) != '') {
					  $options = explode("\n",$options_str);
					  $optionsarr = array();
					  foreach($options as $r) {
						  $v = explode("|",$r);
						  $k = @trim($v[1]);
						  $optionsarr[$k] = @$v[0];
					  }
					  foreach ($optionsarr as $k=>$v) {
						  echo '<option value="'.$k.'"'.($fid==$k?' selected':'').'>'.$v.'</option>';
					  }
				  }
			  }
		  }
		  ?>
        </select><?php }?>
<?php if (array_key_exists('isshow',$field_data) && module::table_field_stauts($moduleid,'isshow')) {?>
		<select name="isshow" id="isshow">
          <option value="-1"<?php echo $isshow==-1?' selected':''?>>选择状态</option>
          <option value="1"<?php echo $isshow==1?' selected':''?>>已审核</option>
          <option value="0"<?php echo $isshow==0?' selected':''?>>未审核</option>
        </select><?php }?>
      <input type="submit" name="button" id="button" value=" 搜  索 ">
      <input name="moduleid" type="hidden" id="moduleid" value="<?php echo $moduleid?>">
      <input name="userid" type="hidden" id="userid" value="<?php echo $userid?>"></td>
    </tr>
  </table>
</form>
<form method="post" name="form1" id="form1" action="?mod=delete" onSubmit="return confirm('您确定要删除吗？该操作不可恢复。');">
  <table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
    <tbody> 
      <tr> 
        <?php if ($module_data['isdel']==1){?><th width=60 height=22 align="center">选中</th><?php }?>
        <th width="80"><a href="javascript:;" onClick="showSort('<?php echo $table_sortid_sort;?>','sortid','table','<?php echo $sort_name;?>');"><u>排序</u></a></th>
        <th width="70"><a href="javascript:;" onClick="showSort('<?php echo $table_id_sort;?>','id','table','<?php echo $sort_name;?>');"><u>ID</u></a></th>
        <?php if (array_key_exists('title',$field_data) && module::table_field_stauts($moduleid,'title')) {?><th>标题</th><?php }?>
        <?php if (array_key_exists('isshow',$field_data) && module::table_field_stauts($moduleid,'isshow')) {?><th><a href="javascript:;" onClick="showSort('<?php echo $table_isshow_sort;?>','isshow','table','<?php echo $sort_name;?>');"><u>审核状态</u></a></th><?php }?>
        <?php if (array_key_exists('hits',$field_data) && module::table_field_stauts($moduleid,'hits')) {?><th><a href="javascript:;" onClick="showSort('<?php echo $table_hits_sort;?>','hits','table','<?php echo $sort_name;?>');"><u>点击</u></a></th><?php }?>
        <?php if (array_key_exists('addtime',$field_data) && module::table_field_stauts($moduleid,'addtime')) {?><th><a href="javascript:;" onClick="showSort('<?php echo $table_addtime_sort;?>','addtime','table','<?php echo $sort_name;?>');"><u>添加时间</u></a></th><?php }?>
        <th>操作</th>
      </tr>
<?php
if ($recordcount) {
while ($db->next_record()) {
?>
      <tr class="darkrow"> 
        <?php if ($module_data['isdel']==1){?><td align=center><input name="chk[]" type="checkbox" id="chk[]" value="<?php echo $db->f('id')?>"<?php if ($module_data['isdel']!=1){echo ' disabled';}?>></td><?php }?>
        <td align="center"><span onClick="liuList.edit(this,'<?php echo $table;?>','sortid',<?php echo $db->f('id')?>,'id',<?php echo $moduleid;?>);"><?php echo $db->f('sortid')?></span></td>
        <td align="center"><?php echo $db->f('id')?></td>
        <?php if (array_key_exists('title',$field_data) && module::table_field_stauts($moduleid,'title')) {?><td><?php
        $_tmp = @$db->get_count("SELECT title FROM ###_category WHERE id='".$db->f('typeid')."'");
		if ($_tmp!=''){echo '['.$_tmp.']';}?><?php echo base::sub_str($db->f('title'),40)?></td><?php }?>
        <?php if (array_key_exists('isshow',$field_data) && module::table_field_stauts($moduleid,'isshow')) {?><td align="center"><img onClick="liuList.staToogle(this,'<?php echo $table;?>','isshow',<?php echo $db->f('id')?>,'id',<?php echo $moduleid;?>)" src="<?php echo $app_dir;?>images/<?php echo $db->f('isshow')==1?'yes':'no'?>.gif" /></td><?php }?>
        <?php if (array_key_exists('hits',$field_data) && module::table_field_stauts($moduleid,'hits')) {?><td align="center"><?php echo $db->f('hits')?></td><?php }?>
        <?php if (array_key_exists('addtime',$field_data) && module::table_field_stauts($moduleid,'addtime')) {?><td align="center"><?php echo date("Y-m-d H:i",$db->f('addtime'))?></td><?php }?>
        <td align="center"><?php
        $_relation_url = trim($module_data['relation_url']);
		if ($_relation_url != '') {
			$relation_url = explode(',',$_relation_url);
			$relation_table = @explode(',',trim($module_data['relation_table']));
			$relation_name = @explode(',',trim($module_data['relation_name']));
			foreach ($relation_url as $k=>$v) {
				echo '<a href="?mod='.trim($v).'&relation_id='.$db->f('id').'&relation_table='.@$relation_table[$k].'"><u>'.@$relation_name[$k].'</u></a> | ';
			}
		}
		?><a href="?mod=admin_module_table_edit&id=<?php echo $db->f('id');?>&r=yes<?php echo base::parse_array(array_slice($qstr,1))?>&page=<?php echo $page;?>"><u>修改</u></a></td>
      </tr>
<?php } } else {?>
      <tr>
        <td colspan="8" align="center"><?php echo adminpub::norecord();?></td>
      </tr>
<?php }?>
      <tr>
        <td colspan="8"><div id="list_form_style">&nbsp;<?php if ($module_data['isdel']==1){?><input name="chkall" type="checkbox" id="chkall" onClick="checkAll(this.form)" value="checkbox">
<input name="fld" type="hidden" id="fld" value="id" />
<input name="table" type="hidden" id="table" value="<?php echo $table;?>" />
<?php if ($relation_id) {?>
<input name="relation_id" type="hidden" id="relation_id" value="<?php echo $relation_id;?>" />
<input name="relation_table" type="hidden" id="relation_table" value="<?php echo $relation_table;?>" />
<?php } else {?>
<input name="relation_id" type="hidden" id="relation_id" value="0" />
<input name="relation_table" type="hidden" id="relation_table" value="<?php echo $module_data['relation_table'];?>" />
<?php }?>
<input name="moduleid" type="hidden" id="moduleid" value="<?php echo $moduleid;?>" />
<input type="hidden" name="location" id="location" value="<?php echo $view;?><?php echo base::parse_array(array_slice($qstr,1))?>&page=<?php echo $page;?>" />
<input name="action" type="hidden" id="action" value="<?php echo $view;?>_del" />
<input name="submit" type="submit" value="删 除" class="submit"></div><?php }?>
<?php echo $pagestr;?>
        </td>
      </tr>
    </tbody> 
  </table>
</form>



<?php include('bottom.php');?>
</body>
</html>