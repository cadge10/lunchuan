<?php
// 参考类库
error_reporting(0);
class form {
	public $data = array() ,$isadmin=1,$doThumb=1,$doAttach=1,$lang;

    public function __construct($data=array()) {
         $this->data = $data;
    }
 
	public function typeid($info,$value){
		$db = $GLOBALS['db'];
        $validate = $this->getvalidate($info);
		$id = $field = $info['title'];
		$value = $value ? $value : @$this->data[$field];
		$moduleid =$info['moduleid'];
		$module = $db->get_one("SELECT * FROM ###_module WHERE id='$moduleid'");
		if (empty($module)) return '';
		
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$module_sql = @$info['setup']['module_sql'];
		
		if (trim($module_sql) == '') {
			$sql = "SELECT id,typeid AS parentid,title,sortid,url,isshow FROM ###_category WHERE moduleid='$moduleid' ORDER BY sortid ASC,id ASC";
			$data = $db->get_all($sql);
			$tree = new tree($data);
			$get_tree = $tree->get_tree();
			$len = count($get_tree);
			$parseStr = '';
			$parseStr .= '<select  id="'.$id.'" name="'.$field.'" '.$validate.'>';
			$parseStr .= '<option value="">请选择栏目...</option>';
			$select_id = @$value;
			if (base::g('typeid')>0 && $GLOBALS['view'] == 'admin_module_table_add') $select_id = (int)base::g('typeid');
			
			for ($i = 0; $i< $len; $i++) {
				$cou = $db->get_count("select id from ###_category where moduleid='$moduleid' and typeid='".$get_tree[$i]['id']."'");
				if ($cou>0) {
					$disabled = ' disabled';
				} else {
					$disabled = '';
				}
				$parseStr .= '<option value="'.$get_tree[$i]['id'].'"'.($select_id == $get_tree[$i]['id'] ?' selected':'').$disabled.'>'.str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$get_tree[$i]['stack']).$get_tree[$i]['title'].'</option>';;
			}
			$parseStr .= '</select>';
		} else {
			$sql = $module_sql;
			$data = $db->get_all($sql);
			
			$parseStr = '';
			$parseStr .= '<select  id="'.$id.'" name="'.$field.'" '.$validate.'>';
			$parseStr .= '<option value="">请选择栏目...</option>';
			$select_id = @$value;
			
			foreach ($data as $v) {
				$parseStr .= '<option value="'.$v[0].'"'.($select_id == $v[0] ?' selected':'').'>'.$v['title'].'</option>';;
			}
			$parseStr .= '</select>';
		}
		return $parseStr;
	}


	public function title($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$thumb=@$info['setup']['thumb'];
		$style=@$info['setup']['style'];
		$id = $field = @$info['title'];
	    $validate = $this->getvalidate($info);
		$value = $value ? $value : @$this->data[$field];

		$title_style = @explode(';',$this->data['title_style']);
		$style_color = @explode(':',$title_style[0]);
		$style_color = @$style_color[1];
		$style_bold = @explode(':',$title_style[1]);
		$style_bold = @$style_bold[1];
		
		$parseStr   = '<div style="float:left;"><input type="text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" size="'.@$info['setup']['size'].'"  '.$validate.'  /></div> ';
		
		$boldchecked= $style_bold=='bold' ? 'checked' : '';
		$stylestr = '<div id="'.$id.'_colorimg" class="colorimg" style="background-color:'.$style_color.';"><img src="admin/images/admin_color_arrow.gif"></div><input type="hidden" id="'.$id.'_style_color" name="style_color" value="'.$style_color.'" /><input type="checkbox" class="style_bold" id="style_bold" name="style_bold" value="bold" '.$boldchecked.' /><b>加粗</b><script>$.showcolor("'.$id.'_colorimg","'.$id.'_style_color");</script>';
		
		$thumbstr = '<div style="clear:both;">';
		$thumbstr .= '<div style="float:left;"><storng>标题图片：</strong><input name="thumb" type="text" class="input" id="thumb" title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="255" value="'.@$this->data['thumb'].'"></div><div style="float:left; padding-left:7px;"><iframe src="includes/upload.php?name=thumb" width="400" height="25" frameborder="0" scrolling="no"></iframe></div><div style="clear:both;">如果链接外部图片，必须以http://开头。</div>';
		$thumbstr .= '</div>';
		
		if($style) $parseStr = $parseStr.$stylestr;
		
		if($thumb &&  $this->doThumb)$parseStr = $parseStr.$thumbstr;
		
		return $parseStr;
	}

	public function text($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
	    $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : @$this->data[$field];
        }
		$parseStr   = '<input type="text" class="input-text" name="'.$field.'"  id="'.$id.'" value="'.stripcslashes($value).'" size="'.@$info['setup']['size'].'"  '.$validate.'/> ';
		return $parseStr;
	}

	public function number($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
	    $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : $info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
		$parseStr   = '<input type="text"   class="input-text" name="'.$field.'"  id="'.$id.'" value="'.$value.'" size="'.@$info['setup']['size'].'"  '.$validate.'/> ';
		return $parseStr;
	}

	public function textarea($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
        $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : @$this->data[$field];
        }

		$parseStr   = '<textarea name="'.$field.'"  rows="'.@$info['setup']['rows'].'" cols="'.@$info['setup']['cols'].'"  id="'.$id.'"   '.$validate.'/>'.stripcslashes($value).'</textarea>';
		return $parseStr;
	}


	public function select($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
		$validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : $info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
        if($value != '') $value = strpos($value, ',') ? explode(',', $value) : $value;

        if(@is_array($info['options'])){
             if($info['options_key']){
				$options_key=explode(',',$info['options_key']);
				foreach((array)$info['options'] as $key=>$res){
					if($options_key[0]=='key'){
						$optionsarr[$key]=$res[$options_key[1]];
					}else{
						$optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
					}
				}
			}else{
             $optionsarr = $info['options'];
			}
        }else{
            $options    = $info['setup']['options'];
            $options = explode("\n",$info['setup']['options']);
        	foreach($options as $r) {
        		$v = explode("|",$r);
        		$k = trim($v[1]);
        		$optionsarr[$k] = $v[0];
        	}
        }


        if(!empty($info['setup']['multiple'])) {
            $parseStr = '<select id="'.$id.'" name="'.$field.'" '.$validate.' size="'.$info['setup']['size'].'" multiple="multiple" >';
        }else {
        	$parseStr = '<select id="'.$id.'" name="'.$field.'" '.$validate.'>';
        }

        if(is_array($optionsarr)) {
			foreach($optionsarr as $key=>$val) {
				if(!empty($value)){
				    $selected='';
					if($value==$key || @in_array($key,$value)) $selected = ' selected="selected"';
				    $parseStr   .= '<option '.$selected.' value="'.$key.'">'.$val.'</option>';
				}else{
					$parseStr   .= '<option value="'.$key.'">'.$val.'</option>';
				}
			}
		}
        $parseStr   .= '</select>';
        return $parseStr;
	}
	public function checkbox($info,$value){
	    $parseStr = '';
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
		$validate = $this->getvalidate($info);
		if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
        $labelwidth = @$info['setup']['labelwidth'];


        if(@is_array($info['options'])){
			if(@$info['options_key']){
				$options_key=explode(',',$info['options_key']);
				foreach((array)$info['options'] as $key=>$res){
					if($options_key[0]=='key'){
						$optionsarr[$key]=$res[$options_key[1]];
					}else{
						$optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
					}
				}
			}else{
             $optionsarr = @$info['options'];
			}
        }else{
            $options    = @$info['setup']['options'];
            $options = @explode("\n",$info['setup']['options']);
        	foreach($options as $r) {
        		$v = explode("|",$r);
        		$k = trim($v[1]);
        		$optionsarr[$k] = $v[0];
        	}
        }
		if($value != '') $value = (strpos($value, ',') && !is_array($value)) ? explode(',', $value) :  $value ;
		$value = is_array($value) ? $value : array($value);
		$i = 1;

		foreach($optionsarr as $key=>$r) {
			$key = trim($key);
            if($i>1) $validate='';
			$checked = ($value && in_array($key, $value)) ? 'checked' : '';
			if($labelwidth) $parseStr .= '<label style="float:left;width:'.$labelwidth.'px" class="checkbox_'.$id.'" >';
			$parseStr .= '<input type="checkbox" class="input_checkbox" name="'.$field.'[]" id="'.$id.'_'.$i.'" '.$checked.' value="'.htmlspecialchars($key).'"  '.$validate.'> '.htmlspecialchars($r);
			if($labelwidth) $parseStr .= '</label>';
			$i++;
		}
		return $parseStr;

	}
	public function radio($info,$value){

        $parseStr = '';
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
		$validate = $this->getvalidate($info);
		if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
        $labelwidth = @$info['setup']['labelwidth'];
        
        if(@is_array($info['options'])){
             if($info['options_key']){
				$options_key=explode(',',$info['options_key']);
				foreach((array)$info['options'] as $key=>$res){
					if($options_key[0]=='key'){
						$optionsarr[$key]=$res[$options_key[1]];
					}else{
						$optionsarr[$res[$options_key[0]]]=$res[$options_key[1]];
					}
				}
			}else{
             $optionsarr = $info['options'];
			}
        }else{
            $options    = @$info['setup']['options'];
            $options = @explode("\n",$info['setup']['options']);
        	foreach($options as $r) {
        		$v = explode("|",$r);
        		$k = @trim($v[1]);
        		$optionsarr[$k] = $v[0];
        	}
        }
        $i = 1;
        foreach($optionsarr as $key=>$r) {
            if($i>1) $validate ='';
			$checked = trim($value)==trim($key) ? 'checked' : '';
			if(empty($value) && empty($key) ) $checked = 'checked';
			if($labelwidth) $parseStr .= '<label style="float:left;width:'.$labelwidth.'px" class="checkbox_'.$id.'" >';
			$parseStr .= '<input type="radio" class="input_radio" name="'.$field.'" id="'.$id.'_'.$i.'" '.$checked.' value="'.$key.'" '.$validate.'> '.$r;
			if($labelwidth) $parseStr .= '</label>';
            $i++;
		}
		return $parseStr;
	}


	public function editor($info,$value){
 
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
		$validate = $this->getvalidate($info);
		if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : @$this->data[$field];
        }
        
		$textareaid = $field;
		$moduleid = @$info['moduleid'];
		$toolbar = @$info['setup']['toolbar'];
		$height = @$info['setup']['height'] ? $info['setup']['height'] : 300;
		$show_page=@$info['setup']['showpage'];

		$str ='';

		$show_page =  $show_page ?  true :  false;
		
		if($toolbar=='full'){
			$str = editor::baiduEditor($value,$field,$show_page,$height);
		}else{
			$str = editor::xhEditor($value,$field,$show_page,$height);
		}

		return $str;
	}
	public function datetime($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
		$validate = $this->getvalidate($info);
		if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
		$value = $value ?  date("Y-m-d H:i:s",$value) : date("Y-m-d H:i:s",time());

		$parseStr = '<input '.$validate.'  name="'.$field.'" type="text" id="'.$id.'" size="30" onClick="return showCalendar(\''.$field.'\', \'%Y-%m-%d %H:%M:%S\', false, false, \''.$field.'\');" value="'.$value.'" />';
        return $parseStr;
	}
    public function groupid($info,$value){
        $newinfo = $info;
        $info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
        $groups=F('Role');$options=array();
        foreach($groups as $key=>$r) {
            if($r['status']){
                $options[$key]=$r['name'];
            }
		}
        $newinfo['options']=$options;
        $fun=$info['setup']['inputtype'];
        return $this->$fun($newinfo,$value);
    }
    public function posid($info,$value){
        $newinfo = $info;
        $posids=F('Posid');
        $options=array();
        $options[0]= L('please_chose');
        foreach($posids as $key=>$r) {
           $options[$key]=$r['name'];
		}
        $newinfo['options']=$options;
        $fun=$info['setup']['inputtype'];
        return $this->select($newinfo,$value);
    }

    public function template($info,$value){

        $templates= template_file(MODULE_NAME);
        $newinfo = $info;
        $info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
        $options=array();
        $options[0]= L('please_chose');
        foreach($templates as $key=>$r) {
            if(strstr($r['value'],'_show')){
                $options[$r['value']]=$r['filename'];
            }
		}
        $newinfo['options']=$options;
        $fun=$info['setup']['inputtype'];
        return $this->select($newinfo,$value);
    }


	public function image($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
	    $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }

		$parseStr   = ' <div style="float:left;"><input name="'.$field.'" type="text" class="input" id="'.$id.'" title="双击查看图片" onDblClick="veiwPic(this);" size="30" maxlength="255" value="'.$value.'"></div><div style="float:left; padding-left:7px;"><iframe src="includes/upload.php?name='.$field.'&thumb='.@$info['setup']['thumb'].'&cut='.@$info['setup']['cut'].'&width='.@$info['setup']['width'].'&height='.@$info['setup']['height'].'" width="400" height="25" frameborder="0" scrolling="no"></iframe></div><div style="clear:both;">如果链接外部图片，必须以http://开头。</div> ';
		return $parseStr;
	}

	public function images($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
	    $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
		$data='';
		$i=0;
		
		$params = array(
				'thumb'  => @$info['setup']['thumb'],
				'cut'    => @$info['setup']['cut'],
				'width'  => @$info['setup']['width'],
				'height' => @$info['setup']['height'],
		);
		$parseStr = multiupload::add_pic($value,$field,'upload.php',$params);

		return $parseStr;
	}
	public function file($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
	    $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }

		$parseStr   = ' <div style="float:left;"><input name="'.$field.'" type="text" class="input" id="'.$id.'" size="30" maxlength="255" value="'.$value.'"></div><div style="float:left; padding-left:7px;"><iframe src="includes/upload_files.php?name='.$field.'" width="400" height="25" frameborder="0" scrolling="no"></iframe></div><div style="clear:both;">如果链接外部文件，必须以http://开头。</div> ';
		return $parseStr;
	}

	public function files($info,$value){
		$info['setup']=is_array($info['setup']) ? $info['setup'] : module::string2array($info['setup']);
		$id = $field = $info['title'];
	    $validate = $this->getvalidate($info);
        if(stristr($GLOBALS['view'],'_add')){
			$value = $value ? $value : @$info['setup']['default'];
        }else{
			$value = $value ? $value : $this->data[$field];
        }
		$data='';
		$i=0;
		
		$parseStr = multiupload::add_files($value,$field);

		return $parseStr;
	}
	
	public function getvalidate($info){
        $validate_data=array();
        if($info['minlength']) $validate_data['minlength'] = ' minlength:'.$info['minlength'];
		if($info['maxlength']) $validate_data['maxlength'] = ' maxlength:'.$info['maxlength'];
		if($info['required']) $validate_data['required'] = ' required:true';
		if($info['pattern']) $validate_data['pattern'] = ' '.$info['pattern'].':true';
		$errormsg = '';
        if($info['errormsg']) $errormsg = ' title="'.$info['errormsg'].'"';
        $validate= implode(',',$validate_data);
        $validate= $validate ? 'validate="'.$validate.'" ' : '';
        $parseStr = $validate.$errormsg;
        return $parseStr;
	}
	
	public function getform($form,$info,$value=''){
		return $form->$info['type']($info,$value);
	}
}
?>