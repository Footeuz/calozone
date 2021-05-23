<?php
require '../../../boot.php';

$id = Request::requestId();

$exec = SQL::query("DELETE FROM ".Lang::STORAGE." WHERE id = ".$id);

if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');