<?php
require_once '../boot.php';

$id = Request::requestId();
if ($id) {
    $item = new Podcast($id);

    $item->nb_download = $item->nb_download + 1;
    $exec = $item->save();

    header("location: " . URL . $item->path, 303);
} else {
    die();
}
?>