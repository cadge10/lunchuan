<?php
// 调用编辑器
class editor {
	public static function xhEditor($value='',$name='content',$insertpage=false,$height='230',$width="100%") {
		$height = (int)$height; // 只保留整数
		$test='<script type="text/javascript">!window.jQuery && document.write(\'<script type="text/javascript" src="'.WEB_DIR.'js/jquery.js"><\/script>\')</script>'."\n";
		$test.='<script type="text/javascript" src="'.WEB_DIR.'includes/editor/xheditor-zh-cn.min.js"></script>'."\n".'<script type="text/javascript">'."\n".'var '.$name.'_tmp_editor;'."\n".'$(pageInit_'.$name.');'."\n".'function pageInit_'.$name.'(){'."\n";
		$test.=$name.'_tmp_editor = $("#'.$name.'").xheditor({';
		$test.='upLinkUrl:"'.WEB_DIR.'includes/editor_upload.php",upLinkExt:"zip,rar,txt,xls,doc,xlsx,docx",';
		$test.='upImgUrl:"'.WEB_DIR.'includes/editor_upload.php",upImgExt:"jpg,jpeg,gif,png",';
		$test.='upFlashUrl:"'.WEB_DIR.'includes/editor_upload.php",upFlashExt:"swf",';
		$test.='upMediaUrl:"'.WEB_DIR.'includes/editor_upload.php",upMediaExt:"wmv,avi,wma,mp3,mid",';
		$test.='skin:"o2007silver",';
		$test.='tools:"Cut,Copy,Paste,Pastetext,|,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,Flash,Media,Table,|,Source"';
		$test.='});'."\n".'}'."\n".'</script>'."\n".'<textarea id="'.$name.'" name="'.$name.'" rows="12" cols="80" style="width: '.$width.'; height:'.$height.'px;">'.$value.'</textarea>';
		if ($insertpage == true) {
			$test.='<div style="padding-top:5px;"><a href="javascript:;" onmousedown="'.$name.'_tmp_editor.pasteText(\'[web_page]\');" style="background-color:#CCC; display:block; padding:5px 8px; width:80px; text-align:center; text-decoration:none; color:#FFF;" onfocus="this.blur();">插入分页符</a></div>';
		}
		return $test;
	}
	// 没有上传附件的
	public static function xhEditorMini($value='',$name='content',$insertpage=false,$height='230',$width="100%") {
		$height = (int)$height; // 只保留整数
		$test='<script type="text/javascript">!window.jQuery && document.write(\'<script type="text/javascript" src="'.WEB_DIR.'js/jquery.js"><\/script>\')</script>'."\n";
		$test.='<script type="text/javascript" src="'.WEB_DIR.'includes/editor/xheditor-zh-cn.min.js"></script>'."\n".'<script type="text/javascript">'."\n".'var '.$name.'_tmp_editor;'."\n".'$(pageInit_'.$name.');'."\n".'function pageInit_'.$name.'(){'."\n";
		$test.=$name.'_tmp_editor = $("#'.$name.'").xheditor({';
		$test.='skin:"o2007silver",';
		$test.='tools:"Cut,Copy,Paste,Pastetext,|,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,|,Align,List,Outdent,Indent,|,Link,Unlink,Img,Flash,Media,Table,|,Source"';
		$test.='});'."\n".'}'."\n".'</script>'."\n".'<textarea id="'.$name.'" name="'.$name.'" rows="12" cols="80" style="width: '.$width.'; height:'.$height.'px;">'.$value.'</textarea>';
		if ($insertpage == true) {
			$test.='<div style="padding-top:5px;"><a href="javascript:;" onmousedown="'.$name.'_tmp_editor.pasteText(\'[web_page]\');" style="background-color:#CCC; display:block; padding:5px 8px; width:80px; text-align:center; text-decoration:none; color:#FFF;" onfocus="this.blur();">插入分页符</a></div>';
		}
		return $test;
	}
	public static function baiduEditor($value='',$name='content',$insertpage=false,$height='230',$width="100%") {
		if (!defined('BAIDU_EDITOR')) { // 在多编辑器下使用
			define('BAIDU_EDITOR','www.openkee.com');
			echo '<script type="text/javascript" charset="utf-8">window.UEDITOR_HOME_URL = "'.WEB_DIR.'includes/ueditor/";</script><script type="text/javascript" charset="utf-8" src="'.WEB_DIR.'includes/ueditor/editor_config.js"></script>'.
			'<script type="text/javascript" charset="utf-8" src="'.WEB_DIR.'includes/ueditor/editor_all.js"></script>'.
			'<link rel="stylesheet" type="text/css" href="'.WEB_DIR.'includes/ueditor/themes/default/ueditor.css"/>';
		} else {
			//echo '';
		}
		$height = (int)$height; // 只保留整数
		$test = '<textarea name="'.$name.'" id="'.$name.'" style="width:'.$width.'" cols="45" rows="5">'.$value.'</textarea>';
		$test .= '<script type="text/javascript">';
		$test .= 'var editor_'.$name.' = new baidu.editor.ui.Editor({minFrameHeight:'.$height.'});';
		$test .= 'editor_'.$name.'.render(\''.$name.'\');';
		$test .= '</script>';		
		return $test;
	}
}
?>