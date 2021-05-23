<?php
include '../boot.php';

if(isset($_FILES["upload"]) && $_FILES["upload"]["error"] == UPLOAD_ERR_OK){

    $name = $_FILES["upload"]["name"];
    $tab = explode('.', $name);


    $ext = '';
    if(count($tab) >= 2){ 
        $ext = $tab[count($tab)-1];
    }

    if(!in_array($ext, array('jpg', 'jpeg', 'png'))){//TODO , 'png'
        die();
    }

    $f = sha1($name.uniqid());
    $path = 'upload/img/'.$f.'.'.$ext;
    move_uploaded_file($_FILES["upload"]["tmp_name"], ROOT.'/'.$path);
    $url = URL.'/'.$path;
}

header('location: images_gallery.php', 303);
 