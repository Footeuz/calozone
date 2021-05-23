<?php

if(!isset($_REQUEST['campaignid'])) die();
require '../boot.php';

$campaignid = intval($_REQUEST['campaignid']);
$emails = strip_tags($_REQUEST['emails']); // list of emails separated by ;

echo Code::genereateCodeForEmail($emails, $campaignid, true, 0);