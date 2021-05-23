<?php

require '../../../boot.php';

if (isset($_REQUEST['id'])) {
    $id = Request::requestId();
    $item = new Contributor($id);

    $item->name = Request::checkPostOrDie('name');
    $item->slug = Request::checkPostOrDie('slug');
    $item->active = Request::checkPostOrDie('active');

    if (empty($item->name)) die("Erreur : Nom vide");

    $exec = $item->save();

    if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');
}