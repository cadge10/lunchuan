<?php
// 自动加载类库
class autoloader {
    public static $loader;
    public static function init() {
        if (self::$loader == NULL)
            self::$loader = new self();
        return self::$loader;
    }
    public function __construct() {
        spl_autoload_register(array($this,'library'));
    }
    public function library($class) {        
        spl_autoload_extensions('.class.php');
        spl_autoload($class);
    }
}
autoloader::init();
?>