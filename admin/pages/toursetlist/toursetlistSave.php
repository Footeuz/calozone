<?php

require '../../../boot.php';

if (isset($_REQUEST['id'])) {
    $id = Request::requestId();
    $item = new TourSetlist($id);

    $item->name = Request::checkPostOrDie('name');
    $item->tour_id = Request::checkPostOrDie('tour_id');
    $item->active = Request::checkPostOrDie('active');

    if (empty($item->name)) die("Erreur : Nom vide");

    // Delete cover image if necessary
    if (isset($_REQUEST['imgs_to_delete']) && $_REQUEST['imgs_to_delete'] == 1) $item->img = '';

    if(isset($_FILES['img0'])){
        // Save image
        $files = $_FILES['img0'];
        if($files['error'] == 0){
            if(in_array($files['type'], array('image/jpeg', 'image/png'))){
                // add new image
                $item->img = file_get_contents($files['tmp_name']);
            }
        }
    }

    $exec = $item->save();

    if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');
}