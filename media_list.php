<?php
require_once 'boot.php';

$is_home = true;
$page_title = $lang->l('media_list_title');
$page_metadesc = $lang->l('media_list_metadesc');
$og_url = 'media-list';
$og_image = 'public/images/clips-'.$mainartistslug.'.jpg';

include("header.php");
?>
<div id="media-list" class="media">
    <div class="text-center mt-5 mb-5">
        <span class="fw-bold">Accédez au site d'archives audios et vidéos sur <?= $mainartist ?>, Archivons.com : </span>
        <p class="mt-3"><a href="<?= URLARCHIVONSVID; ?>" title="Archives vidéos <?= $mainartist ?>" target="_blank"><button>Vidéos <?= $mainartist ?></button></a></p>
        <p class="mt-3"><a href="<?= URLARCHIVONSAUD; ?>" title="Archives audios <?= $mainartist ?>" target="_blank"><button>Audios <?= $mainartist ?></button></a></p>
    </div>
</div>

<?php include("footer.php") ?>
