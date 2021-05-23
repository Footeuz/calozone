<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new Media($id);
$item->active = 0;

$item->save();