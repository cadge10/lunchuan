<?php !defined('APP_VERSION')?exit('Undefine WEBDES!'):'';?>
<?php
$my_place = base::g('path');//文件路径
$my_file = base::g('file'); // 文件名（包括后缀）

if ($my_place == '' || $my_file == '') die(base::msg('错误的参数传递！'));
 
$my_path = $my_place.$my_file;//文件路径
 
header("Pragma: public");
header("Expires: 0");
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
header('Last-Modified: '.gmdate('D, d M Y H:i:s') . ' GMT');
$browser = $_SERVER['HTTP_USER_AGENT'];
 
if(preg_match('/MSIE 5.5/', $browser) || preg_match('/MSIE 6.0/', $browser))
{
  header('Pragma: private');
  // the c in control is lowercase, didnt work for me with uppercase
  header('Cache-control: private, must-revalidate');
  // MUST be a number for IE
  header("Content-Length: ".filesize($my_path));
  header('Content-Type: application/x-download');
  header('Content-Disposition: attachment; filename="'.$my_file.'"');
}
else
{
  header("Content-Length: ".(string)(filesize($my_path)));
  header('Content-Type: application/x-download');
  header('Content-Disposition: attachment; filename="'.$my_file.'"');
}
 
header('Content-Transfer-Encoding: binary');
 
if ($file = fopen($my_path, 'rb'))
{
  while(!feof($file) && (connection_status()==0))
  {
     print(fread($file, filesize($my_path)));
     flush();
  }
  fclose($file);
}

exit();
?>