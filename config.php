<?php
// 配置信息，一般不需要手动修改
define('APP_SAFECODE','fvw85w6hgX');
define('DB_HOST','rdsmzn7bzuzrfnj.mysql.rds.aliyuncs.com');
define('DB_PORT','3306');
define('DB_NAME','lc');//数据库名
define('DB_USER','lc');//数据库用户名
define('DB_PASSWORD','lc123456');//数据库用户密码
define('DB_PREFIX','cms_');//数据表前缀
define('DB_ENGINE_NAME','mysql');
define('WEB_DIR','/');
// 路由配置
define('URL_ROUTER_ON',true);// 开启路由
define('URL_MODE',0); // 定义路由类型，选择值：0，原生字符串 1，伪静态字符串
define('URL_PATHINFO',0); // 说明：0 /，1 index.php/
define('URL_SEPAPARATOR','-'); // 伪静态时，字符串分隔符
define('URL_EXT','.html'); // 伪静态时结尾的扩展名
?>
