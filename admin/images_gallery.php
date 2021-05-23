<?php
include '../boot.php';

$files = scandir(ROOT.'/upload/img/');

?>
<style type="text/css">
#upload_gallery img{
    width: 200px;
    max-height: 200px;
    cursor: pointer;
}    
</style>


<div id="upload_form_div" >
    <form id="upload_form" action="upload.php" method="post" enctype="multipart/form-data" onsubmit="this.style.display='none';">
        <input type="file" name="upload" />
        <input type="submit" />
    </form>
</div> 

<?php
echo '<div id="upload_gallery">';
foreach($files as $file){
    if(substr($file, 0, 1) != '.')
        echo '<img src="'.URL.'/upload/img/'.$file.'" onclick="parent.setPicFromGallery(this.src);" />';
}
echo '</div>';

