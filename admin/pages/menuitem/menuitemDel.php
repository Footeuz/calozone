<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new MenuItem($id);
$item->delete();