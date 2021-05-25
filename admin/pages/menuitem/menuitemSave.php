<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new MenuItem($id);

$item->name = Request::checkPostOrDie('name');
$item->blank = Request::checkPostOrDie('blank');
$item->menu_id = Request::checkPostOrDie('menu_id');
$item->position = Request::checkPostOrDie('position');
$item->parent_id = Request::checkPostOrDie('parent_id');
$item->link_url = Request::checkPostOrDie('link_url');

if(empty($item->name)) die("Erreur : Nom vide");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');