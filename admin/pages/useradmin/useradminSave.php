<?php

require '../../../boot.php';

$id = Request::requestId();
$item = new UserAdmin($id);

$item->status = Request::checkPostOrDie('status');
$item->login = Request::checkPostOrDie('login');
$item->email = Request::checkPostOrDie('email');
$item->status = Request::checkPostOrDie('status');
$item->name = Request::checkPostOrDie('name');
$item->url = Request::checkPostOrDie('url');

$item->subscription_stamp_start = Request::checkPostOrDie('subscription_stamp_start');
$d = new DateTime(substr($item->subscription_stamp_start,6,4).'-'.substr($item->subscription_stamp_start,3,2).'-'.substr($item->subscription_stamp_start, 0,2).' 00:00:00', new DateTimeZone('Europe/Rome'));
$item->subscription_stamp_start = $d->getTimestamp(); // transform a date dd-mm-yyyy to timestamp

$item->subscription_stamp_end = Request::checkPostOrDie('subscription_stamp_end');
$d = new DateTime(substr($item->subscription_stamp_end,6,4).'-'.substr($item->subscription_stamp_end,3,2).'-'.substr($item->subscription_stamp_end, 0,2).' 00:00:00', new DateTimeZone('Europe/Rome'));
$item->subscription_stamp_end = $d->getTimestamp(); // transform a date dd-mm-yyyy to timestamp

$item->client_theme_id = Request::checkPostOrDie('client_theme_id');

$pass = Request::checkPostOrDie('password');
if(!empty($pass)) {
    $item->setPass($pass);
} else if($item->id == 0) {
    die("Erreur : mot de passe vide");
}

if(empty($item->login)) die("Erreur : login vide");

// Delete image if necessary
if (isset($_REQUEST['imgs_to_delete']) && $_REQUEST['imgs_to_delete'] == 1) $item->client_logo = '';

if(isset($_FILES['client_logo0'])){
    // Save image
    $files = $_FILES['client_logo0'];
    if($files['error'] == 0){
        if(in_array($files['type'], array('image/jpeg', 'image/png'))){
            // add new image
            $item->client_logo = file_get_contents($files['tmp_name']);
        }
    }
}

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');