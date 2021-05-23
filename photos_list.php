<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('pagephotos_list_title');
$page_metadesc = $lang->l('pagephotos_list_metadesc');

$css[] = 'css/xSquare_style.css';
$js[] = 'js/photos.js';
$js[] = 'js/xsquare.js';

$og_url = 'photos';
$og_image = 'public/images/clips-'.$mainartistslug.'.jpg';

include("header.php");
$list_pagephotos = PicturePage::getStack('id ASC');
?>
<div id="pagephotos-list" class="pagephotos">
    <div class="content">
        <div class="wrapper">
            <div class="row">
                <div class="col-12 col-lg-3 mt-3">
                    <h2 class="h3">Les pages photos :</h2>
                    <?php if (!empty($list_pagephotos)) { ?>
                        <ul class="mt-3">
                            <?php
                            foreach($list_pagephotos as $item) {
                                echo '<li><a href="'.URL.'album-photo-' . $item['slug'].'-' . $item['id'].'" title="Album photo '.$mainartist.' '.$item['name'].'">'.$item['name'].' ➤</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="xSquare"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
    </div>
</div>

<?php include("footer.php") ?>
