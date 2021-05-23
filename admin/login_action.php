<?php
include_once '../boot.php';

if(!isset($_POST['login']) || !isset($_POST['pass'])){
    header("location: ".URL_ADM."login.php", 303);
    die();
}

$login = $_POST['login'];
$pass = $_POST['pass'];

$connection = UserAdmin::connection($login, $pass);
if($connection){
    header("location: ".URL_ADM, 303);
} else {
    header("location: ".URL_ADM.'login.php', 303);
}
