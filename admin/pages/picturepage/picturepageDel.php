<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new PicturePage($id);
$item->active = 0;

$item->save();