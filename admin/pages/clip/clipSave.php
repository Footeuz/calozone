<?php

require '../../../boot.php';

$id = Request::requestId();
$item = new Clip($id);

$item->description = Request::checkPostOrDie('description');
$item->name = Request::checkPostOrDie('name');
$item->path = Request::checkPostOrDie('path');
$item->realisateur = Request::checkPostOrDie('realisateur');
$item->artist_id = Request::checkPostOrDie('artist_id');
$item->disc_id = Request::checkPostOrDie('disc_id');
$item->song_id = Request::checkPostOrDie('song_id');
$item->complement_type = Request::checkPostOrDie('complement_type');
$item->type = Request::checkPostOrDie('type');

$item->date_parution = Request::checkPostOrDie('date_parution');
$d = new DateTime(substr($item->date_parution,6,4).'-'.substr($item->date_parution,3,2).'-'.substr($item->date_parution, 0,2).' 00:00:00', new DateTimeZone('Europe/Rome'));
$item->date_parution = $d->getTimestamp(); // transform a date dd-mm-yyyy to timestamp

$item->admin_id = Request::checkPostOrDie('admin_id');
$item->active = Request::checkPostOrDie('active');

if(empty($item->name)) die("Erreur : Nom vide");

// Delete image if necessary
if (isset($_REQUEST['imgs_to_delete']) && $_REQUEST['imgs_to_delete'] == 1) $item->thumb = '';

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
$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');