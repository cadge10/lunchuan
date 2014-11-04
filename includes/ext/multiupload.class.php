<?php
// 多附件上传类库
class multiupload {
	public static function add_pic($mulit_pic = '',$input_name = 'pic',$upload_file = 'upload.php',$params = array()) { // 多图片上传
		// $mulit_pic 多个用半角逗号分隔
		$mulit_pic = trim((string)$mulit_pic);
		$input_name != '' ? $input_name : 'pic'; // 输入框的名字
		$upload_file != '' ? $upload_file : 'upload.php'; // 附件处理文件
		$content = '<div style="clear:both;">'; // 开始标签
		$pub_name = '图片'; // 标注
		$web_dir = WEB_DIR;
		
		$thumb  = @$params['thumb'];
		$cut    = @$params['cut'];
		$width  = @$params['width'];
		$height = @$params['height'];
		
		$content .= <<<javascript
<script type="text/javascript">
var ROOT = "$web_dir";
!window.jQuery && document.write('<script type="text/javascript" src="'+ROOT+'js/jquery.js"><\/script>')</script>		
<script type="text/javascript">
function addPic_{$input_name}(input_name) {
	var UPFILE = "$upload_file";
	if ($.trim(input_name) == '') {
		input_name = 'pic';
	} else {
		input_name = $.trim(input_name);
	}
	i = $("input[name='"+input_name+"[]']").size();
	$('#multiPic_'+input_name).append('<div style="float:left;"><input type="text" name="'+input_name+'[]" id="'+input_name+i+'" title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="255"></div><div style="float:left; padding-left:7px;"><iframe src="'+ROOT+'includes/'+UPFILE+'?name='+input_name+i+'&thumb=$thumb&cut=$cut&width=$width&height=$height" scrolling="no" width="400" height="25" frameborder="0"></iframe></div><div style="clear:both;"></div>');
}
</script>
		
javascript;
		
		if ($mulit_pic != '') { // 存在附件
			$arr = explode(",",$mulit_pic);				
			for ($i = 0; $i < count($arr); $i++) {
				$content .= '<div style="float:left;"><input type="text" name="'.$input_name.'[]" id="'.$input_name.$i.'" size="30" maxlength="255" title="双击查看图片" onDblClick="veiwPic(this);" value="'.trim($arr[$i]).'"></div><div style="float:left; padding-left:7px;"><iframe src="'.$web_dir.'includes/'.$upload_file.'?name='.$input_name.$i.'&thumb='.$thumb.'&cut='.$cut.'&width='.$width.'&height='.$height.'" scrolling="no" width="400" height="25" frameborder="0"></iframe></div><div style="clear:both;"></div>';
			}
		} else { // 不存在附件
			$content .= '<div style="float:left;"><input name="'.$input_name.'[]" type="text" class="input" id="'.$input_name.'0" title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="255"></div><div style="float:left; padding-left:7px;"><iframe src="'.$web_dir.'includes/'.$upload_file.'?name='.$input_name.'0&thumb='.$thumb.'&cut='.$cut.'&width='.$width.'&height='.$height.'" width="400" height="25" frameborder="0" scrolling="no"></iframe></div>';
		}
		// 连接添加多附件按钮
		$content .= '<div style="clear:both;"><span id="multiPic_'.$input_name.'"></span><input type="button" name="button" id="button" value="再加一份'.$pub_name.'" onClick="addPic_'.$input_name.'(\''.$input_name.'\');"> * 注：如果不想上传多份'.$pub_name.'，不上传即可。</div>';
        $content .= '</div>'; // 结尾标签
		return $content;
	}
    public static function add_files($mulit_pic = '',$input_name = 'files',$upload_file = 'upload_files.php') { // 多附件上传
		// $mulit_pic 多个用半角逗号分隔
		$mulit_pic = trim((string)$mulit_pic);
		$input_name != '' ? $input_name : 'files'; // 输入框的名字
		$upload_file != '' ? $upload_file : 'upload_files.php'; // 附件处理文件
		$content = '<div style="clear:both;">'; // 开始标签
		$pub_name = '附件'; // 标注
		$web_dir = WEB_DIR;
		$content .= <<<javascript
<script type="text/javascript">
var ROOT = "$web_dir";
!window.jQuery && document.write('<script type="text/javascript" src="'+ROOT+'js/jquery.js"><\/script>')</script>		
<script type="text/javascript">
function addPic_{$input_name}(input_name) {
	var UPFILE = "$upload_file";
	if ($.trim(input_name) == '') {
		input_name = 'pic';
	} else {
		input_name = $.trim(input_name);
	}
	i = $("input[name='"+input_name+"[]']").size();
	$('#multiPic_'+input_name).append('<div style="float:left;"><input type="text" name="'+input_name+'[]" id="'+input_name+i+'" size="30" maxlength="255"></div><div style="float:left; padding-left:7px;"><iframe src="'+ROOT+'includes/'+UPFILE+'?name='+input_name+i+'" scrolling="no" width="400" height="25" frameborder="0"></iframe></div><div style="clear:both;"></div>');
}
</script>
		
javascript;
		
		if ($mulit_pic != '') { // 存在附件
			$arr = explode(",",$mulit_pic);				
			for ($i = 0; $i < count($arr); $i++) {
				$content .= '<div style="float:left;"><input type="text" name="'.$input_name.'[]" id="'.$input_name.$i.'" size="30" maxlength="255" value="'.trim($arr[$i]).'"></div><div style="float:left; padding-left:7px;"><iframe src="'.$web_dir.'includes/'.$upload_file.'?name='.$input_name.$i.'" scrolling="no" width="400" height="25" frameborder="0"></iframe></div><div style="clear:both;"></div>';
			}
		} else { // 不存在附件
			$content .= '<div style="float:left;"><input name="'.$input_name.'[]" type="text" class="input" id="'.$input_name.'0" size="30" maxlength="255"></div><div style="float:left; padding-left:7px;"><iframe src="'.$web_dir.'includes/'.$upload_file.'?name='.$input_name.'0" width="400" height="25" frameborder="0" scrolling="no"></iframe></div>';
		}
		// 连接添加多附件按钮
		$content .= '<div style="clear:both;"><span id="multiPic_'.$input_name.'"></span><input type="button" name="button" id="button" value="再加一份'.$pub_name.'" onClick="addPic_'.$input_name.'(\''.$input_name.'\');"> * 注：如果不想上传多份'.$pub_name.'，不上传即可。</div>';
        $content .= '</div>'; // 结尾标签
		return $content;
	}
}
?>