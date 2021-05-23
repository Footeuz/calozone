<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new TourSetlistSong($id);

$item->tour_setlist_id = Request::checkPostOrDie('tour_setlist_id');
$item->song_id = Request::checkPostOrDie('song_id');
$item->track_position = Request::checkPostOrDie('track_position');
$item->more_infos = Request::checkPostOrDie('more_infos');

if($item->tour_setlist_id==0) die("Erreur : Tour setlist vide");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');