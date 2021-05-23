<?php

require '../../../boot.php';

if (isset($_REQUEST['id'])) {
    $id = Request::requestId();
    $item = new Gig($id);

    $item->artist_id = Request::checkPostOrDie('artist_id');
    $item->tour_id = Request::checkPostOrDie('tour_id');
    $item->salle_id = Request::checkPostOrDie('salle_id');
    $item->more_infos = Request::checkPostOrDie('more_infos');
    $item->is_cp = Request::checkPostOrDie('is_cp');
    $item->radio = Request::checkPostOrDie('radio');
    $item->media_id = Request::checkPostOrDie('media_id');
    $item->canceled = Request::checkPostOrDie('canceled');

    $item->date_start = Request::checkPostOrDie('date_start');
    $d = new DateTime(substr($item->date_start,6,4).'-'.substr($item->date_start,3,2).'-'.substr($item->date_start, 0,2).' 00:00:00', new DateTimeZone('Europe/Rome'));
    $item->date_start = $d->getTimestamp(); // transform a date dd-mm-yyyy to timestamp

    $item->active = Request::checkPostOrDie('active');

    if (empty($item->date_start)) die("Erreur : Nom vide");

    $exec = $item->save();

    if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');
}