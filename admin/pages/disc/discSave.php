<?php

require '../../../boot.php';

$id = Request::requestId();
$item = new Disc($id);

$item->description = Request::checkPostOrDie('description');
$item->name = Request::checkPostOrDie('name');
$item->isrc = Request::checkPostOrDie('isrc');
$item->lnk_difymusic = Request::checkPostOrDie('lnk_difymusic');
$item->lnk_itunes = Request::checkPostOrDie('lnk_itunes');
$item->lnk_deezer = Request::checkPostOrDie('lnk_deezer');
$item->lnk_spotify = Request::checkPostOrDie('lnk_spotify');
$item->lnk_amazon = Request::checkPostOrDie('lnk_amazon');
$item->lnk_fnac = Request::checkPostOrDie('lnk_fnac');
$item->slug = Request::checkPostOrDie('slug');
$item->producer = Request::checkPostOrDie('producer');
$item->artist = Request::checkPostOrDie('artist');
$item->type = Request::checkPostOrDie('type');
$item->is_main = Request::checkPostOrDie('is_main');
$item->role1 = Request::checkPostOrDie('role1');
$item->role2 = Request::checkPostOrDie('role2');
$item->role3 = Request::checkPostOrDie('role3');
$item->role4 = Request::checkPostOrDie('role4');
$item->support = Request::checkPostOrDie('support');

$item->date_parution = Request::checkPostOrDie('date_parution');
$d = new DateTime(substr($item->date_parution,6,4).'-'.substr($item->date_parution,3,2).'-'.substr($item->date_parution, 0,2).' 00:00:00', new DateTimeZone('Europe/Rome'));
$item->date_parution = $d->getTimestamp(); // transform a date dd-mm-yyyy to timestamp

$item->active = Request::checkPostOrDie('active');

if(empty($item->name)) die("Erreur : Nom vide");

// Delete thumb image if necessary
if (isset($_REQUEST['thumbs_to_delete']) && $_REQUEST['thumbs_to_delete'] == 1) $item->thumb = '';

if(isset($_FILES['thumb0'])){
    // Save image
    $files = $_FILES['thumb0'];
    if($files['error'] == 0){
        if(in_array($files['type'], array('image/jpeg', 'image/png'))){
            // add new image
            $item->thumb = file_get_contents($files['tmp_name']);
        }
    }
}

// Delete cover image if necessary
if (isset($_REQUEST['imgs_to_delete']) && $_REQUEST['imgs_to_delete'] == 1) $item->cover = '';

if(isset($_FILES['cover0'])){
    // Save image
    $files2 = $_FILES['cover0'];
    if($files2['error'] == 0){
        if(in_array($files2['type'], array('image/jpeg', 'image/png'))){
            // add new image
            $item->cover = file_get_contents($files2['tmp_name']);
        }
    }
}

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');