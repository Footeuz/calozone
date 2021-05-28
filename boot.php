<?php

date_default_timezone_set('Europe/Paris');
error_reporting(E_ALL);

define("ROOT",dirname(__FILE__).'/');
require ROOT.'includes/defines.php';

session_start();

spl_autoload_register(function($class){
    $std = ROOT.'class/'.$class.'.php';
    if(file_exists($std)) require $std;
    else die("ERROR : class not found $class");
});

register_shutdown_function(function(){
   DBG::logswrite();
});

set_error_handler(function($errno, $errstr, $errfile, $errline){
    DBG::errorHandler($errno, $errstr, $errfile, $errline);
});

SQL::connect();

$lang = Cache::getLang(Lang::LL_FR);

function sat($array) {
    echo '<pre>'; var_dump($array); echo '</pre>';
}

$css = [];
$js = [];

$mainartist = Artist::getName(ARTISTID_MAIN);
$mainartistslug = strtolower($mainartist);

$menu_header = MenuItem::getStackMenu(1);