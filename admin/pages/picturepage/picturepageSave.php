<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new PicturePage($id);

$item->name = Request::checkPostOrDie('name');
$item->slug = Request::checkPostOrDie('slug');
$item->directory = Request::checkPostOrDie('directory');
$item->credits = Request::checkPostOrDie('credits');
$item->meta_title = Request::checkPostOrDie('meta_title');
$item->meta_description = Request::checkPostOrDie('meta_description');

$item->active = Request::checkPostOrDie('active');

if(empty($item->name)) die("Erreur : Nom vide");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');