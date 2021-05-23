<?php
if(!isset($_REQUEST['id'])) die();
require '../boot.php';

$item = new Question(intval($_REQUEST['id']));

header('Content-type:audio/mp3');
echo $item->mp3;