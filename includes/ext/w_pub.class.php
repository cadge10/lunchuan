<?php
class w_pub{
/*
   //正则验证email格式是否正确
	 //$email  ---------需要验证的对象
*/	
public static function checkEmail($email)
	{
		if (preg_match("/^[a-z0-9]([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i",$email)){ // echo '格式正确';
return true;}
else { //echo '格式错误';
return false; }

	}



/*
   //验证电话号码的格式是否正确
     //$tel  ---------需要验证的对象
*/
public static function righttel($tel) {
//if (preg_match("(13[0-9]{9}) ",$tel))
if(strlen($tel)==8 or strlen($tel)==7 or strlen($tel)==11)
{
if (preg_match("/13[0-9]{9}/",$tel)||preg_match("(^(\d{3,4}-)?\d{7,8})",$tel))
{// echo "号码有效";
return true; }
else { //echo "号码无效";
return false;}
	}
else { //echo "号码无效";
return false;}
	}
}
?>