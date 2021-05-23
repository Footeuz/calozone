<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new UserAdmin($id);
$item->active = 0;

$item->save();