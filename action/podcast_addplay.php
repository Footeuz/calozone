<?php
if(!isset($_REQUEST['id'])) echo json_encode(array('status'=>'ko'));
require_once '../boot.php';

$id = Request::requestId();
if ($id) {
    $item = new Podcast($id);

    $item->nb_listen = $item->nb_listen + 1;
    $exec = $item->save();

    echo json_encode(array('status' => 'ok'));
} else {
    echo json_encode(array('status' => 'ko'));
}
?>