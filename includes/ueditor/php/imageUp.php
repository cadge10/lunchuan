<?php
    error_reporting( E_ERROR | E_WARNING );
	include('../../../inc.php');
	// 管理员必须登录后才能使用此功能
	$code = adminpub::getsafecode();
	if (base::s('m_logined')!=$code) {
		$islogined = false;
	} else {
		$islogined = true;
	}
    //上传配置
    $config = array(
        "uploadPath" => "upload/" , //保存路径
        "fileType" => array( ".gif" , ".png" , ".jpg" , ".jpeg" , ".bmp" ) , //文件允许格式
        "fileSize" => 1000 //文件大小限制，单位KB
    );
    //原始文件名，表单名固定，不可配置
    $oriName = htmlspecialchars( $_POST[ 'fileName' ] , ENT_QUOTES );

    //上传图片框中的描述表单名称，
    $title = htmlspecialchars( $_POST[ 'pictitle' ] , ENT_QUOTES );

    //文件句柄
    $file = $_FILES[ "upfile" ];

    //文件上传状态,当成功时返回SUCCESS，其余值将直接返回对应字符窜并显示在图片预览框，同时可以在前端页面通过回调函数获取对应字符窜
    $state = "SUCCESS";

    //重命名后的文件名
    $fileName = "";

    //保存路径
    $path = $config[ 'uploadPath' ];

    if ( !file_exists( $path ) ) {
        mkdir( "$path" , 0777 );
    }
    //格式验证
    $current_type = strtolower( strrchr( $file[ "name" ] , '.' ) );
    if ( !in_array( $current_type , $config[ 'fileType' ] ) || false == getimagesize( $file[ "tmp_name" ] ) ) {
        $state = "不允许的图片格式";
    }
    //大小验证
    $file_size = 1024 * $config[ 'fileSize' ];
    if ( $file[ "size" ] > $file_size ) {
        $state = "图片大小超出限制";
    }
    //保存图片
    if ( $state == "SUCCESS" ) {
        $tmp_file = $file[ "name" ];
        $fileName = $path . rand( 1 , 10000 ) . time() . strrchr( $tmp_file , '.' );
		
		if (!$islogined) {
			$state = "请登录后上传。";
			exit("{'url':'".$fileName."','title':'".$title."','original':'".$oriName."','state':'".$state."'}");
		}
		
        $result = move_uploaded_file( $file[ "tmp_name" ] , $fileName );
		
		// 加水印
		$web_config = pub::get_config();
		$web_water     = @(int)trim($web_config['web_water']);
		$web_water_pos = @(int)trim($web_config['web_water_pos']);
		$web_water_pic = @trim($web_config['web_water_pic']);
		$web_water_pct = @(int)trim($web_config['web_water_pct']);
		if ($web_water && $web_water_pic) {
			$image = new image();
			$web_water_pic = '../../../uploadfile/upfiles/'.$web_water_pic;
			$old_pic = $fileName; // 原始图片
			$return = @$image->param($old_pic)->water($old_pic,$web_water_pic,$web_water_pos,$web_water_pct);
		}
		
        if ( !$result ) {
            $state = "未知错误";
        }
    }
    //向浏览器返回数据json数据
    /**
     * 返回数据格式
     * {
     *   'url'      :'a.jpg',   //保存后的文件路径
     *   'title'    :'hello',   //文件描述，对图片来说在前端会添加到title属性上
     *   'original' :'b.jpg',   //原始文件名
     *   'state'    :'SUCCESS'  //上传状态，成功时返回SUCCESS,其他任何值将原样返回至图片上传框中
     * }
     */
    echo "{'url':'" . $fileName . "','title':'" . $title . "','original':'" . $oriName . "','state':'" . $state . "'}";

?>

