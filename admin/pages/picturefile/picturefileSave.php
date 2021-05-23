<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new PictureFile($id);

$item->page_id = Request::checkPostOrDie('page_id');
$item->name = Request::checkPostOrDie('name');
$item->level = Request::checkPostOrDie('level');
$item->position = Request::checkPostOrDie('position');
$item->alt = Request::checkPostOrDie('alt');
$item->url = Request::checkPostOrDie('url');

if($item->page_id==0) die("Erreur : Page photo non renseignee");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');