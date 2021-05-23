<?php

require '../../../boot.php';

if (isset($_REQUEST['id'])) {
    $id = Request::requestId();
    $item = new Salle($id);

    $item->name = Request::checkPostOrDie('name');
    $item->city = Request::checkPostOrDie('city');
    $item->dpt = Request::checkPostOrDie('dpt');
    $item->address = Request::checkPostOrDie('address');
    $item->metro = Request::checkPostOrDie('metro');
    $item->cp = Request::checkPostOrDie('cp');
    $item->region = Request::checkPostOrDie('region');
    $item->country = Request::checkPostOrDie('country');
    $item->ardt = Request::checkPostOrDie('ardt');
    $item->tel = Request::checkPostOrDie('tel');
    $item->tel2 = Request::checkPostOrDie('tel1');
    $item->mail = Request::checkPostOrDie('mail');
    $item->fax = Request::checkPostOrDie('fax');
    $item->type = Request::checkPostOrDie('type');
    $item->places = Request::checkPostOrDie('places');
    $item->contact1 = Request::checkPostOrDie('contact1');
    $item->fonction1 = Request::checkPostOrDie('fonction1');
    $item->tel1 = Request::checkPostOrDie('tel1');
    $item->mail1 = Request::checkPostOrDie('mail1');
    $item->date_festival = Request::checkPostOrDie('date_festival');
    $item->code_fnac = Request::checkPostOrDie('code_fnac');
    $item->lat = Request::checkPostOrDie('lat');
    $item->lng = Request::checkPostOrDie('lng');
    $item->style = Request::checkPostOrDie('style');
    $item->date_festival2 = Request::checkPostOrDie('date_festival2');
    $item->website = Request::checkPostOrDie('website');

    $item->active = Request::checkPostOrDie('active');

    if (empty($item->name)) die("Erreur : Nom vide");

    $exec = $item->save();

    if ($exec) echo $lang->l('save_ok') . ' #' . $exec; else echo $lang->l('save_ko');
}