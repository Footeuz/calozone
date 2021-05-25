<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Menu($id);
$item->active = 0;

$item->save();