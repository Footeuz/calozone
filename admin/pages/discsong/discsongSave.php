<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new DiscSong($id);

$item->disc_id = Request::checkPostOrDie('disc_id');
$item->song_id = Request::checkPostOrDie('song_id');
$item->disk_number = Request::checkPostOrDie('disk_number');
$item->track_position = Request::checkPostOrDie('track_position');
$item->face = Request::checkPostOrDie('face');
$item->version = Request::checkPostOrDie('version');

if($item->disc_id==0) die("Erreur : Disque vide");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');