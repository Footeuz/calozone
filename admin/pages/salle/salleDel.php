<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Salle($id);
$item->active = 0;

$exec = $item->save();

if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');