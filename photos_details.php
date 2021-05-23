<?php
require_once 'boot.php';

$is_home = false;
$id = Request::requestId();
if ($id==0) {
    header('Location: '.URL, 303);
}
$page = new PicturePage($id);

$page_title = $page->meta_title;
$page_metadesc = $page->meta_description;
$photos = PictureFile::getStack($id);

$og_url = 'album-photo-'.$page->slug.'-'.$id;
$og_image = 'public/images/'.$photos[0][0]['url'];

$css[] = 'css/hovermedia.css';
$css[] = 'css/etagere2.css';
$css[] = 'css/lightbox.min.css';
$js[] = 'js/lightbox.min.js';

include("header.php");
?>

<div id="photos-<?= $page->directory ?>" class="tour">
    <div class="content">
        <h2 class="mt-3">Album photo : <?= $page->name ?></h2>

        <div class="wrapper">
            <div class="col-12 col-lg-8 mx-auto mt-3">
                <div id="etageres" translate="no" class="view-top-shelf">
                    <div class="etagere-btn col-8 mx-auto">
                        <ul class="etagerenav">
                            <li class="mt-3 d-block d-lg-none">S&eacute;lectionnez votre &eacute;tag&egrave;re : </li>
                            <?php if (!empty($photos)) { ?>
                                <?php foreach ($photos as $idetag => $tmpphotos) { ?>
                                    <li><a href="/" id="view-etag<?= $idetag ?>-shelf" onclick="moveToShelf('view-etag<?= $idetag ?>-shelf', 'setag<?= $idetag ?>');return false;">&#x1F5A2; <?= $idetag+1 ?> &#x1F5A3;</a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="scene mx-auto hoverwrapper">
                        <!-- camera -->
                        <div class="roll-camera">
                            <div class="move-camera">
                                <div class="wallpaper"></div"
                                <?php if (!empty($photos)) { ?>
                                    <?php foreach ($photos as $idetag => $tmpphotos) { ?>
                                        <!-- shelf -->
                                        <div class="shelf" id="setag<?= $idetag ?>">
                                            <div class="face top"></div>
                                            <div class="face front">
                                                <?php foreach ($tmpphotos as $idpic => $photo) { ?>
                                                    <a href="<?= URL_IMG.'/'.$page->directory.'/'.$photo['url'] ?>" class="photocard hovermedia" data-lightbox="albumphoto" data-title="<?= $photo['alt'] ?>">
                                                        <div class="hoverlayer"><p><?= $photo['alt'] ?></p></div>
                                                        <img src="<?= URL_IMG.'/'.$page->directory.'/'.$photo['url'] ?>" alt="<?= $photo['alt'] ?>" />
                                                    </a>
                                                <?php } ?>
                                            </div>
                                            <div class="face back"></div>
                                            <div class="face left"></div>
                                            <div class="face bottom"></div>
                                        </div>
                                        <!-- /shelf -->
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <!-- /camera -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="text-center mt-5">
    <p>Crédits photos : <?= $page->credits ?></p>
    <p><a href="<?= URL.'photos'; ?>"><button>Toutes les pages photos</button></a></p>
</div>

<script>
    (function() {
        oid = function(el) { return document.getElementById(el); };
        ocd = function(el) { return document.getElementsByClassName(el); };
        centerShelfs = function(){
            let topShelfPosition = oid('etageres').clientHeight/2;
            <?php if (!empty($photos)) { ?>
            <?php foreach ($photos as $idetag => $tmpphotos) { ?>
            levelpx = 150 + 200*<?= $idetag ?>;
            oid('setag<?= $idetag ?>').style.top = levelpx+'px';
            <?php } ?>
            oid('setag0').classList.add('current');
            <?php } ?>
        };
        moveToShelf = function(targetid, currentdiv){
            oid('etageres').setAttribute("class", "");
            oid('etageres').classList.add(targetid);
            <?php if (!empty($photos)) { ?>
            <?php foreach ($photos as $idetag => $tmpphotos) { ?>
            oid('setag<?= $idetag ?>').setAttribute("class", "shelf");
            <?php } ?>
            <?php } ?>
            oid(currentdiv).classList.add('current');
        };
        window.addEventListener('resize', function(event){ centerShelfs(); });
        centerShelfs();
        window.setTimeout(function(){ oid('etageres').classList.add('view-top-shelf'); }, 500);
    })();
</script>

<?php include("footer.php") ?>
