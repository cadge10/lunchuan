<?php
// 显示错误级别
error_reporting(E_ALL); // 测试时使用
//error_reporting(E_ALL || ~E_NOTICE); // 发布时使用

date_default_timezone_set('PRC');//时区
$time = $_SERVER['REQUEST_TIME'];
$nowtime = date('Y-m-d H:i:s',$time);
$tmp_dir = str_replace('includes','',dirname(__FILE__));
define('__ROOT__',str_replace('\\','/',substr($tmp_dir,0,strlen($tmp_dir)-1))); // 源码的绝对路径
// 配置路径
set_include_path(get_include_path().PATH_SEPARATOR.__ROOT__.'/includes/core/');
set_include_path(get_include_path().PATH_SEPARATOR.__ROOT__.'/includes/ext/');
// 包含文件
require(__ROOT__.'/includes/version.php');
require(__ROOT__.'/config.php');
!defined('APP_VERSION')?exit('Undefine WEBDES!'):'';
require(__ROOT__.'/includes/autoloader.php');
// 实例化基础类库
if (!defined('DB_ENGINE_NAME')) define('DB_ENGINE_NAME','mysqli'); // 未定义时处理
if (DB_ENGINE_NAME == 'mysqli') {
	$db = new mysqli_db();
} else {
	$db = new mysql();
}
/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc()) {
    if (!empty($_GET)) {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST)) {
        $_POST = addslashes_deep($_POST);
    }
    $_SESSION   = addslashes_deep($_SESSION);
	$_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}
// 安全控制
base::safe_get();
//--------------------------------------------------------------------------------------------
/**
 * 递归方式的对变量中的特殊字符进行转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function addslashes_deep($value) {
    if (empty($value)) {
        return $value;
    } else {
        return is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
    }
}
/**
 * 将对象成员变量或者数组的特殊字符进行转义
 *
 * @access   public
 * @param    mix        $obj      对象或者数组
 * @author   Xuan Yan
 *
 * @return   mix                  对象或者数组
 */
function addslashes_deep_obj($obj) {
    if (is_object($obj) == true) {
        foreach ($obj AS $key => $val) {
            $obj->$key = addslashes_deep($val);
        }
    } else {
        $obj = addslashes_deep($obj);
    }

    return $obj;
}
/**
 * 递归方式的对变量中的特殊字符去除转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function stripslashes_deep($value) {
    if (empty($value)) {
        return $value;
    } else {
        return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    }
}
?>