<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Disc($id);
$item->active = 0;

$item->save();