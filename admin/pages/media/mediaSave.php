<?php

require '../../../boot.php';

$id = Request::requestId();
$item = new Media($id);

$item->title = Request::checkPostOrDie('title');
$item->media = Request::checkPostOrDie('media');
$item->path = Request::checkPostOrDie('path');
$item->category = Request::checkPostOrDie('category');
$item->type = Request::checkPostOrDie('type');
$item->artist = Request::checkPostOrDie('artist');
$item->albumid = Request::checkPostOrDie('albumid');
$item->lancement = Request::checkPostOrDie('lancement');
$item->vues = Request::checkPostOrDie('vues');
$datediff = Request::checkPostOrDie('datediff');
$item->datediff = substr($datediff,6,4).'-'.substr($datediff,3,2).'-'.substr($datediff,0,2);
$item->heurediff = Request::checkPostOrDie('heurediff');
$item->stampadd = Request::checkPostOrDie('stampadd');
$item->description = Request::checkPostOrDie('description');

$item->active = Request::checkPostOrDie('active');

if(empty($item->title)) die("Erreur : Nom vide");

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');