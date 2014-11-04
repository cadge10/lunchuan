<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
// 执行语句
if (base::p('action') == 'add') {
	base::issubmit();
	$id = (int)base::p('id');
	if ($id==0) exit(base::alert('参数传递错误！'));
	$userid = (int)base::p('userid');
	$title = trim(base::p('title'));
	$short_title = trim(base::p('short_title'));
	$typeid = (int)base::p('typeid');
	
	$count = $db->get_count("select id from `###_producttype` where `typeid`='$typeid'");
	if ($count) {
		exit(base::alert('必须是最终栏目才能添加产品！')); // 不是最终栏目
	}
	
	$content = base::p('content');
	$author = trim(base::p('author'));
	$gourl = trim(base::p('gourl'));
	$isshow = (int)base::p('isshow');
	$recommend = (int)base::p('recommend');
	$hot = (int)base::p('hot');
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
	$video_url = trim(base::p('video_url'));
	
	// 属性
	$product_attribute_id = (int)base::p('attributeid');
	
	$addtime = @strtotime(trim(base::p('addtime')));
	
	// 进行判断
	if ($title == '') exit(base::alert('请填写产品标题！'));
	if ($typeid == 0) exit(base::alert('请选择产品栏目！'));
	
	// 入库
	$sql = "update ###_product set userid='$userid',title='$title',short_title='$short_title',typeid='$typeid',content='$content',
	isshow='$isshow',recommend='$recommend',hot='$hot',pic='$pic',url='$url',video_url='$video_url',addtime='$addtime',product_attribute_id='$product_attribute_id' where id='$id'";
	$db->query($sql);
	
	
	// 处理属性
	$productid = $id;

    /* 处理属性 */
    if ((isset($_POST['attr_id_list']) && isset($_POST['attr_value_list'])) || (empty($_POST['attr_id_list']) && empty($_POST['attr_value_list'])))
    {
        // 取得原有的属性值
        $goods_attr_list = array();

        $sql = "SELECT g.*, a.attrtype
                FROM ###_productinfoattr AS g
                    LEFT JOIN ###_productattribute AS a
                        ON a.id = g.attrid
                WHERE g.productid = '$productid'";

        $res = $db->query($sql,false);

        while ($row = $db->fetch_array($res))
        {
            $goods_attr_list[$row['attrid']][$row['attrvalue']] = array('sign' => 'delete', 'id' => @$row['id']);
        }
        // 循环现有的，根据原有的做相应处理
        if(isset($_POST['attr_id_list']))
        {
            foreach ($_POST['attr_id_list'] AS $key => $attr_id)
            {
                $attr_value = $_POST['attr_value_list'][$key];
                $attr_price = $_POST['attr_price_list'][$key];
                if (!empty($attr_value))
                {
                    if (isset($goods_attr_list[$attr_id][$attr_value]))
                    {
                        // 如果原来有，标记为更新
                        $goods_attr_list[$attr_id][$attr_value]['sign'] = 'update';
                        $goods_attr_list[$attr_id][$attr_value]['attrprice'] = $attr_price;
                    }
                    else
                    {
                        // 如果原来没有，标记为新增
                        $goods_attr_list[$attr_id][$attr_value]['sign'] = 'insert';
                        $goods_attr_list[$attr_id][$attr_value]['attrprice'] = $attr_price;
                    }
                }
            }
        }

        /* 插入、更新、删除数据 */
        foreach ($goods_attr_list as $attr_id => $attr_value_list)
        {
            foreach ($attr_value_list as $attr_value => $info)
            {
                if ($info['sign'] == 'insert')
                {
                    $sql = "INSERT INTO ###_productinfoattr (attrid, productid, attrvalue, attrprice)".
                            "VALUES ('$attr_id', '$productid', '$attr_value', '$info[attrprice]')";
                }
                elseif ($info['sign'] == 'update')
                {
                    $sql = "UPDATE ###_productinfoattr SET attrprice = '$info[attrprice]' WHERE id = '$info[id]' LIMIT 1";
                }
                else
                {
                    $sql = "DELETE FROM ###_productinfoattr WHERE id = '$info[id]' LIMIT 1";
                }
                $db->query($sql);
            }
        }
    }
	
	exit(base::alert('产品修改成功，请返回。','?mod=admin_product'.$gourl));
}

$id = (int)base::g('id');
if ($id==0) exit(base::alert('参数传递错误！'));
$one = $db->get_one("select * from ###_product where id='$id'");
if (!$one) exit(base::alert('没有您要的数据！'));
$gourl = $_SERVER['QUERY_STRING'];
$gourlarr = explode('&r=yes',$gourl);
$gourl = @$gourlarr[1];
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
<script type="text/javascript" src="js/rowspec.js"></script>
<script type="text/javascript">
function checkForm(frm) {
	if (frm.title.value=='') {
		alert('请填写产品标题！');
		frm.title.focus();
		return false;
	}
	if (frm.typeid.value==0) {
		alert('请选择产品栏目！');
		frm.typeid.focus();
		return false;
	}
	if (frm.checktype.value == 'no') {
		alert('您只能在最后一级栏目下添加产品！');
		frm.typeid.focus();
		return false;
	}
}
function checkTypeId(str) {
	$.get('admincp.php',{r:Math.random(),a:'ajax',mod:'admin_product_checktype',typeid:str},function(data){
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

function getAttrList(typeid,productid) {
	if (typeid==0) return $('#getAttributeInfoAjax').empty();
	$.get("admincp.php",{r:Math.random(),a:'ajax',mod:'getproductattrlist','typeid':typeid,'productid':productid},function(data){
		if ($.trim(data)!='') {
			$('#getAttributeInfoAjax').html(data);
		} else {
			$('#getAttributeInfoAjax').empty();
		}
	});
}
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="tabstyle">
    <div class="current" id="tab_btn_0" onClick="tabit(this,2);">基本信息</div>
    <div class="tabmenu" id="tab_btn_1" onClick="tabit(this,2);">产品属性</div>
    </td>
  </tr>
</table>
<div id="tab_div_0">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left">产品标题：</th>
      <td width="552"><input type="text" id="title" name="title" size="50" value="<?php echo $one['title']?>" /></td>
    </tr>
    <tr>
      <th align="left">产品短名称：</th>
      <td><input type="text" id="short_title" name="short_title" size="50" value="<?php echo $one['short_title']?>" /> 
        *产品列表时显示的名称。</td>
    </tr>
    <tr>
      <th align="left">产品栏目：</th>
      <td><?php echo product::getartcol_p($one['typeid'],'请选择栏目……');?><span id="typemsg"></span></td>
      </tr>
    
      <th align="left">产品内容：</th>
      <td><?php echo editor::xhEditor($one['content']);?></td>
    </tr>
    <tr>
      <th align="left">产品属性：</th>
      <td><input name="isshow" type="checkbox" id="isshow" value="1"<?php if ($one['isshow']==1){echo ' checked';}?>>
        <label for="isshow">产品显示</label>　
          <input name="recommend" type="checkbox" id="recommend" value="1"<?php if ($one['recommend']==1){echo ' checked';}?>>
        <label for="recommend">产品推荐</label>　
          <input name="hot" type="checkbox" id="hot" value="1"<?php if ($one['hot']==1){echo ' checked';}?>>
      <label for="hot">热销</label></td>
      </tr>
    <tr>
    <tr>
        <th align="left">添加时间：</th>
        <td><input name="addtime" type="text" id="addtime" size="30" maxlength="30" onClick="return showCalendar('addtime', '%Y-%m-%d %H:%M:%S', false, false, 'addtime');" value="<?php echo date("Y-m-d H:i:s",$one['addtime']);?>" />
</td>
    </tr>
    <tr>
      <th align="left">外部链接：</th>
      <td><input name="url" type="text" id="url" size="50" value="<?php echo $one['url']?>"> 
      *如果是外部链接地址，网址前面请加http://。</td>
    </tr>
    <tr>
      <th align="left">视频链接：</th>
      <td><input name="video_url" type="text" id="video_url" size="50" value="<?php echo $one['video_url']?>"> 
        *如果有视频，请填写视频的URL。</td>
    </tr>
    <tr>
      <th align="left">产品图片：</th>
      <td>
		<?php echo multiupload::add_pic($one["pic"]);?>
      </td>
      </tr>
  </tbody> 
</table>
</div>
<div id="tab_div_1" class="none">
<table cellspacing=0 cellpadding=0 width="100%" border=0 class="listtable">
  <tbody> 
    <tr>
	  <th width="107" align="left" valign="top" style="padding-top:12px;">产品类型：</th>
      <td><select name="attributeid" id="attributeid" onChange="getAttrList(this.value,<?php echo $id;?>)">
        <option value="0">请选择产品类型...</option>
        <?php
        $re = $db->query("select id,title from ###_productptype order by sortid asc,id asc",false);
		while ($rs = $db->fetch_array($re)) {
		?>
        <option value="<?php echo $rs[0]?>"<?php if ($rs[0]==$one['product_attribute_id']) { echo ' selected';}?>><?php echo $rs[1]?></option>
        <?php }?>
      </select>
        * 请选择产品的所属类型，进而完善此产品的属性。
        <div class="noborder" id="getAttributeInfoAjax"><?php echo product::build_attr_html($one['product_attribute_id'],$id);?></div>
        </td>
    </tr>
  </tbody> 
</table>
</div>

<div class="buttons">
  <input type="submit" name="Submit" value="提　交" class="submit">
  <input type="reset" name="Submit2" value="重　置">
</div>
</form>

<?php include('bottom.php');?>
</body>
</html>