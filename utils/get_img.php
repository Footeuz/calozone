<?php

if(!isset($_REQUEST['id'])) die();
require '../boot.php';

if(isset($_REQUEST['type'])) {
    if ($_REQUEST['type'] == 'podcast' || $_REQUEST['type'] == 'socialpodcast') $item = new Podcast(intval($_REQUEST['id']));
    else if ($_REQUEST['type'] == 'clip') $item = new Clip(intval($_REQUEST['id']));
    else if ($_REQUEST['type'] == 'disc') $item = new Disc(intval($_REQUEST['id']));
    else if ($_REQUEST['type'] == 'toursetlist') $item = new TourSetlist(intval($_REQUEST['id']));
    else if ($_REQUEST['type'] == 'tour') $item = new Tour(intval($_REQUEST['id']));
}

header('Content-type:image/jpg');
if ($_REQUEST['type'] == 'podcast' || $_REQUEST['type'] == 'clip')
    echo $item->thumb;
else if ($_REQUEST['type'] == 'socialpodcast')
    echo $item->socialimg;
else if ($_REQUEST['type'] == 'disc')
    echo $item->cover;
else if ($_REQUEST['type'] == 'toursetlist' || $_REQUEST['type'] == 'tour')
    echo $item->img;
else
    echo $item->img;