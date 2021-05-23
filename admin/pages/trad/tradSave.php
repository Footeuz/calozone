<?php

require '../../../boot.php';

if (isset($_REQUEST['id'])) {
    $id = Request::requestId();

    $text = Request::checkPostOrDie('text');
    $fr = Request::checkPostOrDie('fr');
    $en = Request::checkPostOrDie('en');

    if (empty($text)) die("Erreur : Nom vide");

    if ($id>0) {
        $exec = SQL::query("UPDATE ".Lang::STORAGE." SET text = '".$text."', fr = '".$fr."', en = '".$en."' WHERE id = ".$id);
    } else {
        $exec = SQL::query("INSERT INTO ".Lang::STORAGE." SET text = '".$text."', fr = '".$fr."', en = '".$en."'");
    }

    if ($exec) {
        $lang->resetCache();
        echo $lang->l('save_ok') . ' #' . $exec;
    } else {
        echo $lang->l('save_ko');
    }
}