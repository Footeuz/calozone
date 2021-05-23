<?php
require '../../../boot.php';

$id = Request::requestId();

$req = "DELETE FROM ".TourSetlistSong::TBNAME." WHERE id = ".intval($id);
$result = SQL::query($req);