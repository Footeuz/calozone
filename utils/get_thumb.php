<?php
require '../boot.php';

$id = Request::requestId('id');
$item = new Disc($id);

header('Content-type:image/jpg');
echo $item->thumb;