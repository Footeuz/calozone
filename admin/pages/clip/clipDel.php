<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Clip($id);
$item->active = 0;

$item->save();