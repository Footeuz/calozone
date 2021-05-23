<?php
require '../../../boot.php';

$id = Request::requestId();

$req = "DELETE FROM ".DiscSong::TBNAME." WHERE id = ".intval($id);
$result = SQL::query($req);