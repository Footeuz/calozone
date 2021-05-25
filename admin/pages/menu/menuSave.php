<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new Menu($id);

$item->name = Request::checkPostOrDie('name');

if(empty($item->name)) die("Erreur : Nom vide");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');