<?php
require '../../../boot.php';

$id = Request::requestId();

$item = new User($id);
$code = $item->code;

$item->delete();

echo 'Betatesteur '.$id.'-'.$code.' supprimé';
