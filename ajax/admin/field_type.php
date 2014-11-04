<?php
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
error_reporting(0);
// 字段类型显示
@extract($_POST);
@extract($_GET);
?>
	<?php if ($type == 'title'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">是否使用标题图片</td>
			  <td><input type="radio" name="setup[thumb]" value="1"<?php if ($thumb==1){echo ' checked';}?>> 是 <input type="radio" name="setup[thumb]" value="0"<?php if ($thumb==0){echo ' checked';}?>> 否</td>
			</tr>
			<tr>
			  <td>是否使用标题样式</td>
			  <td><input type="radio" name="setup[style]" value="1"<?php if ($style==1){echo ' checked';}?>> 是 <input type="radio" name="setup[style]" value="0"<?php if ($style==0){echo ' checked';}?>> 否</td>
			</tr>
			<tr>
			  <td>文本框长度</td>
			  <td><input type="text" class="input-text" size="5" name="setup[size]" value="<?php echo $size;?>" /></td>
			</tr>
		</table>
	<?php }?>
    <?php if ($type == 'typeid'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">SQL查询语句</td>
			  <td><input type="text" class="input-text" size="50"  name="setup[module_sql]" value="<?php echo $module_sql;?>" /></td>
			</tr>
			</tr>
		</table>
        <div style="line-height:160%;"><strong style="color:red;">提示信息：</strong><br />留空则使用默认栏目，且字段名必须是typid，不留空根据SQL语句调用栏目。<br />请正确编写SQL查询语法，并谨慎执行SQL语句，千万不要执行更新或删除语句，否则数据更改或删除则无法恢复。<br />栏目只调用2个字段，分别是主键[自动编号]和栏目名称，一般是id,title。<br />例如：SELECT id,title FROM <?php echo DB_PREFIX?>newstype WHERE isshow=1 ORDER BY sortid ASC,id DESC</div>
	<?php }?>
    <?php if ($type == 'text'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">文本框长度</td>
			  <td><input type="text" class="input-text" size="5" name="setup[size]" value="<?php echo $size;?>" /></td>
			</tr>
			<tr>
			  <td>默认值</td>
			  <td> <input type="text" class="input-text" size="50"  name="setup[default]" value="<?php echo $default;?>" /></td>
			</tr>
			</tr><input type="hidden" id="varchar" name="setup[fieldtype]" value="varchar"/>
		</table>
	<?php }?>
    <?php if ($type == 'textarea'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
				  <td>字段类型</td>
				  <td>
				  <select name="setup[fieldtype]">
				  <option value="mediumtext" <?php if($fieldtype=='mediumtext') echo 'selected';?>>MEDIUMTEXT</option>
				  <option value="text" <?php if($fieldtype=='text') echo 'selected';?>>TEXT</option>
				  </select>
                  </td>
			</tr>
			<tr>
			  <td width="120">文本域行数</td>
			  <td><input type="text"  class="input-text" size="5" name="setup[rows]" value="<?php echo $rows;?>" /></td>
			</tr>
			<tr>
			  <td>文本域列数</td>
			  <td><input type="text"  class="input-text" size="5" name="setup[cols]" value="<?php echo $cols;?>" /></td>
			</tr>
			<tr>
			  <td>默认值</td>
			  <td><textarea  name="setup[default]" rows="3" cols="40"><?php echo $default;?></textarea></td>
			</tr>
		</table>
	<?php }?>
    <?php if ($type == 'select'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">选项列表:<br>例: <font color="red">选项名称|值</font></td>
			  <td><textarea  name="setup[options]" rows="5" cols="40"><?php echo $options;?></textarea></td>
			</tr>
			<tr>
			  <td>选项类型</td>
			  <td><input type="radio" name="setup[multiple]" value="0"<?php if ($multiple==0){echo ' checked';}?>> 下拉框 <input type="radio" name="setup[multiple]" value="1"<?php if ($multiple==1){echo ' checked';}?>> 多选列表框</td>
			</tr>
			<tr>
				  <td>字段类型</td>
				  <td>
				  <select name="setup[fieldtype]">
				  <option value="varchar" <?php if($fieldtype=='varchar') echo 'selected';?>>字符 VARCHAR</option>
				  <option value="tinyint" <?php if($fieldtype=='tinyint') echo 'selected';?>>整数 TINYINT(3)</option>
				  <option value="smallint" <?php if($fieldtype=='smallint') echo 'selected';?>>整数 SMALLINT(5)</option>
				  <option value="mediumint" <?php if($fieldtype=='mediumint') echo 'selected';?>>整数 MEDIUMINT(8)</option>
				  <option value="int" <?php if($fieldtype=='int') echo 'selected';?>>整数 INT(10)</option>
				  </select>
                  </td>
			</tr>
			<tr>
			  <td>可见选项的数目</td>
			  <td><input type="text" class="input-text" size="5" name="setup[size]" value="<?php echo $size;?>" /></td>
			</tr>
			<tr>
			  <td>默认值</td>
			  <td> <input type="text" class="input-text" size="5"  name="setup[default]" value="<?php echo $default;?>" /> 多个被选中请使用半角逗号分隔。</td>
			</tr>
		</table>
		
	<?php }?>
    <?php if ($type == 'editor'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
		<tr>
		  <td width="140">编辑器样式：</td>
		  <td><input type="radio" name="setup[toolbar]" value="basic"<?php if ($toolbar=='basic'){echo ' checked';}?>> 简洁型  <input type="radio" name="setup[toolbar]" value="full"<?php if ($toolbar!='basic'){echo ' checked';}?>> 标准型 </td>
		</tr>
		<tr>
		  <td>默认值：</td>
		  <td><textarea name="setup[default]" rows="3" cols="40" id="default"  ><?php echo $default;?></textarea></td>
		</tr>
		<tr>
		  <td>编辑器默认高度：</td>
		  <td><input type="text" name="setup[height]" value="<?php echo $height;?>" size="4" class="input-text" ></td>
		</tr>

		<tr>
		  <td>内容是否分页：</td>
		  <td><input type="radio" name="setup[showpage]" value="1"<?php if ($showpage==1){echo ' checked';}?>> 是 <input type="radio" name="setup[showpage]" value="0"<?php if ($showpage==0){echo ' checked';}?>> 否</td>
		</tr>
	<?php }?>
    
    <?php if ($type == 'radio'){?>
        <table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">选项列表:<br>例: <font color="red">选项名称|值</font></td>
			  <td><textarea  name="setup[options]" rows="5" cols="40"><?php echo $options;?></textarea></td>
			</tr>
			<tr>
				  <td>字段类型</td>
				  <td>
				  <select name="setup[fieldtype]">
				  <option value="varchar" <?php if($fieldtype=='varchar') echo 'selected';?>>字符 VARCHAR</option>
				  <option value="tinyint" <?php if($fieldtype=='tinyint') echo 'selected';?>>整数 TINYINT(3)</option>
				  <option value="smallint" <?php if($fieldtype=='smallint') echo 'selected';?>>整数 SMALLINT(5)</option>
				  <option value="mediumint" <?php if($fieldtype=='mediumint') echo 'selected';?>>整数 MEDIUMINT(8)</option>
				  <option value="int" <?php if($fieldtype=='int') echo 'selected';?>>整数 INT(10)</option>
				  </select>
                  </td>
			</tr>
            <tr>
			  <td>宽度</td>
			  <td> <input type="text" class="input-text" size="10"  name="setup[labelwidth]" value="<?php echo $labelwidth;?>" /></td>
			</tr>
			<tr>
			  <td>默认值</td>
			  <td> <input type="text" class="input-text" size="5"  name="setup[default]" value="<?php echo $default;?>" /></td>
			</tr>
		</table>
		
    <?php }?>
    <?php if ($type == 'checkbox'){?>
        <table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">选项列表:<br>例: <font color="red">选项名称|值</font></td>
			  <td><textarea  name="setup[options]" rows="5" cols="40"><?php echo $options;?></textarea></td>
			</tr>
			<tr>
				  <td>字段类型</td>
				  <td>
				  <select name="setup[fieldtype]">
				  <option value="varchar" <?php if($fieldtype=='varchar') echo 'selected';?>>字符 VARCHAR</option>
				  <option value="tinyint" <?php if($fieldtype=='tinyint') echo 'selected';?>>整数 TINYINT(3)</option>
				  <option value="smallint" <?php if($fieldtype=='smallint') echo 'selected';?>>整数 SMALLINT(5)</option>
				  <option value="mediumint" <?php if($fieldtype=='mediumint') echo 'selected';?>>整数 MEDIUMINT(8)</option>
				  <option value="int" <?php if($fieldtype=='int') echo 'selected';?>>整数 INT(10)</option>
				  </select>
                  </td>
			</tr>
            <tr>
			  <td>宽度</td>
			  <td> <input type="text" class="input-text" size="10"  name="setup[labelwidth]" value="<?php echo $labelwidth;?>" /></td>
			</tr>
			<tr>
			  <td>默认值</td>
			  <td> <input type="text" class="input-text" size="5"  name="setup[default]" value="<?php echo $default;?>" /> 多个被选中请使用半角逗号分隔。</td>
			</tr>
		</table>
		
    <?php }?>
    <?php if ($type == 'number'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">文本框长度</td>
			  <td><input type="text" class="input-text" size="5" name="setup[size]" value="<?php echo $size;?>" /></td>
			</tr>
			<tr> 
			  <td>小数位数：</td>
			  <td>
			  <select name="setup[decimaldigits]">
			  <option value="0"<?php if($decimaldigits==0) echo ' selected';?>>0</option>
			  <option value="1"<?php if($decimaldigits==1) echo ' selected';?>>1</option>
			  <option value="2"<?php if($decimaldigits==2) echo ' selected';?>>2</option>
			  <option value="3"<?php if($decimaldigits==3) echo ' selected';?>>3</option>
			  <option value="4"<?php if($decimaldigits==4) echo ' selected';?>>4</option>
			  <option value="5"<?php if($decimaldigits==5) echo ' selected';?>>5</option>
			  </select>
			</td>
			</tr>
			<tr> 
			  <td>默认值</td>
			  <td><input type="text" name="setup[default]" value="<?php echo $default;?>" size="40" class="input-text"></td>
			</tr>
		</table>
	<?php }?>
	<?php if ($type == 'image' || $type == 'images'){?>
		<table cellpadding="2" cellspacing="1" width="100%">
			<tr>
			  <td width="120">启用缩略图</td>
			  <td><input type="radio" name="setup[thumb]" value="1"<?php if ($thumb==1){echo ' checked';}?>> 是 <input type="radio" name="setup[thumb]" value="0"<?php if ($thumb==0){echo ' checked';}?>> 否</td>
			</tr>
			<tr>
			  <td width="120">缩放方式</td>
			  <td><input type="radio" name="setup[cut]" value="0"<?php if ($cut==0){echo ' checked';}?>> 等比列裁剪 <input type="radio" name="setup[cut]" value="1"<?php if ($cut==1){echo ' checked';}?>> 居中裁剪 <input type="radio" name="setup[cut]" value="2"<?php if ($cut==2){echo ' checked';}?>> 左上角裁剪</td>
			</tr>
			<tr> 
			  <td>缩略图大小</td>
			  <td>宽度：<input type="text" name="setup[width]" value="<?php echo $width;?>" size="10" validate="digits:true" title="请输入有效的宽度" class="input-text">px 高度：<input type="text" name="setup[height]" value="<?php echo $height;?>" size="10" validate="digits:true" title="请输入有效的高度" class="input-text">px</td>
			</tr>
		</table>
	<?php }?>