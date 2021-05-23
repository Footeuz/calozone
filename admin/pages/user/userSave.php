<?php
require '../../../boot.php';

$id = Request::requestId();
$item = new User($id);

$item->code = Request::checkPostOrDie('code');
$item->mailing_id = Request::checkPostOrDie('mailing_id');
$item->firstname = Request::checkPostOrDie('firstname');
$item->lastname = Request::checkPostOrDie('lastname');
$item->email = Request::checkPostOrDie('email');
$item->genre = Request::checkPostOrDie('genre');
$item->age = Request::checkPostOrDie('age');
$item->dep = Request::checkPostOrDie('dep');

$exec = $item->save();
if($exec) echo $lang->l('save_ok').' #'.$exec; else echo $lang->l('save_ko');
