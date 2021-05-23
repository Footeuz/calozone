<?php

/**
 *    ____                       _ 
 *   |  _ \                     | |
 *   | |_) | ___  _ __ ___  __ _| |
 *   |  _ < / _ \| '__/ _ \/ _` | |
 *   | |_) | (_) | | |  __/ (_| | |
 *   |____/ \___/|_|  \___|\__,_|_|
 *
 *
 * Short Description
 *
 * Long Description
 *
 * @package      Signalert-new 
 * @copyright    Copyright(c) 2016 Boreal Business, All Rights Reserved.
 * @author       Aurelien Munoz <aurelien@boreal-business.net>
 */


require '../../conf.inc.php';

$trad = $_GET['trad'];
header("Access-Control-Allow-Origin: *");

$res = SQL::query("SELECT id FROM trad WHERE text='".SQL::escp($trad)."'");
if($res->num_rows == 0){
    SQL::insert("trad", array(
        "text" => $trad,
        "type" => "api"
    ));
}