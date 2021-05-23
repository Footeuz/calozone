<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Contributor($id);
$exec = $item->delete();

if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');