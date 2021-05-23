<?php

require '../../../boot.php';

$id = Request::requestId();
$item = new Song($id);

$item->lyrics = Request::checkPostOrDie('lyrics');
$item->name = Request::checkPostOrDie('name');
$item->slug = Request::checkPostOrDie('slug');
//$item->auteur = Request::checkPostOrDie('auteur');
//$item->compositeur = Request::checkPostOrDie('compositeur');
$item->cover_artist_id = Request::checkPostOrDie('cover_artist_id');
$item->artist_id = Request::checkPostOrDie('artist_id');
$item->is_cover = Request::checkPostOrDie('is_cover');
$item->details = Request::checkPostOrDie('details');
$item->active = Request::checkPostOrDie('active');

if(empty($item->name)) die("Erreur : Nom vide");
$exec = $item->save();

if ($exec>0) {
    $sql = 'DELETE FROM '.SongContributor::TBNAME.' WHERE song_id = '.$exec;
    SQL::query($sql);

    if (isset($_REQUEST['author_id'])) {
        $authors = $_REQUEST['author_id'];
        for ($idx = 1; $idx <= 3; $idx++) {
            if ($authors[$idx] > 0) {
                $obj = new SongContributor();
                $obj->contributor_id = $authors[$idx];
                $obj->role = SongContributor::R_AUTHOR;
                $obj->song_id = $exec;
                $obj->save();
            }
        }
    }
    if (isset($_REQUEST['composer_id'])) {
        $composers = $_REQUEST['composer_id'];
        for ($idx = 1; $idx <= 3; $idx++) {
            if ($composers[$idx] > 0) {
                $obj = new SongContributor();
                $obj->contributor_id = $composers[$idx];
                $obj->role = SongContributor::R_COMPOSER;
                $obj->song_id = $exec;
                $obj->save();
            }
        }
    }
}

if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');