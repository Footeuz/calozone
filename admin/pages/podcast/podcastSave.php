<?php

require '../../../boot.php';

if (isset($_REQUEST['episode']) && $_REQUEST['episode']>0) {
    $id = Request::requestId();
    $item = new Podcast($id);

    $item->episode = Request::checkPostOrDie('episode');
    $item->description = Request::checkPostOrDie('description');
    $item->name = Request::checkPostOrDie('name');
    $item->participants = Request::checkPostOrDie('participants');
    $item->duration = Request::checkPostOrDie('duration');

    $date_add = Request::checkPostOrDie('date_add');
    $heure_add = Request::checkPostOrDie('heure_add');
    sat($heure_add);
    $d = new DateTime(substr($date_add, 6, 4) . '-' . substr($date_add, 3, 2) . '-' . substr($date_add, 0, 2) . ' '. $heure_add, new DateTimeZone('Europe/Rome'));
    $item->date_add = $d->getTimestamp(); // transform a date dd-mm-yyyy to timestamp

    $item->admin_id = Request::checkPostOrDie('admin_id');
    $item->active = Request::checkPostOrDie('active');

    if (empty($item->name)) die("Erreur : Nom vide");

// Delete image if necessary
    if (isset($_REQUEST['imgs_to_delete']) && $_REQUEST['imgs_to_delete'] == 1) $item->thumb = '';
    if (isset($_REQUEST['imgs_social_to_delete']) && $_REQUEST['imgs_social_to_delete'] == 1) $item->socialimg = '';

    if (isset($_FILES['thumb0'])) {
        $files = $_FILES['thumb0'];
        if ($files['error'] == 0) {
            if (in_array($files['type'], array('image/jpeg', 'image/png'))) {
                $item->thumb = file_get_contents($files['tmp_name']);
            }
        }
    }
    if (isset($_FILES['socialimg0'])) {
        $files = $_FILES['socialimg0'];
        if ($files['error'] == 0) {
            if (in_array($files['type'], array('image/jpeg', 'image/png'))) {
                $item->socialimg = file_get_contents($files['tmp_name']);
            }
        }
    }
    $exec = $item->save();
sat($exec);
    if (isset($_FILES["upload_podcast0"]) && $_FILES["upload_podcast0"]["error"] == UPLOAD_ERR_OK) {
        $name = $_FILES["upload_podcast0"]["name"];
        $tab = explode('.', $name);

        $ext = '';
        if (count($tab) >= 2) {
            $ext = $tab[count($tab) - 1];
        }

        if (!in_array($ext, array('mp3'))) {
            echo 'probleme';
            die();
        }

        $f = 'Calogero-le-podcast-S' . date('Y') . 'E' . str_pad($item->getEpisode(), 2, '0', STR_PAD_LEFT);
        $path = 'upload/podcast/' . date('Y') . '/' . $f . '.' . $ext;
        move_uploaded_file($_FILES["upload_podcast0"]["tmp_name"], ROOT . '/' . $path);
        $url = URL . '/' . $path;

        $item->path = $path;
        $exec = $item->save();
        echo 'sauvegarde fichier ok';
    }
    if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');
}