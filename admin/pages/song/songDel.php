<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Song($id);
$item->active = 0;

$item->save();