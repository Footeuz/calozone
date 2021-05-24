<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('song_list_title');
$page_metadesc = $lang->l('song_list_metadesc');
$og_url = 'chansons-'.$mainartistslug;
$og_image = 'public/images/chansons-'.$mainartistslug.'.jpg';

include("header.php");

$class = 'Song';
$songs = Song::getStackArtist('name ASC', ARTISTID_MAIN);
$songssecond = Song::getStackArtist('name ASC', ARTISTID_SECOND);
$songsthird = Song::getStackArtist('name ASC', ARTISTID_THIRD);
$covers = Song::getStackCover('name ASC');
$collaborations = Song::getStackCollaboration('name ASC');
?>
<div id="song-list">
    <div class="content">
        <div class="wrapper">
            <div class="row">
                <?php if (!empty($songs)) { ?>
                    <div class="col-12 col-lg-4">
                        <h2>Chansons de <?= $mainartist ?></h2>
                        <ul class="songs mt-3">
                            <?php foreach ($songs as $song_id => $song) { ?>
                                <?php if (!$song['is_cover']) { ?>
                                    <li><a href="chanson-<?= $song['slug'] ?>-<?= $song['id'] ?>" title="Chanson <?= $song['name'] ?>"><?= $song['name'] ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4 ps-3">
                        <div class="mt-3">
                            <img src="<?= URL ?>public/images/<?= IMGPAGESONGLIST ?>" alt="<?= $lang->l('alt_picture_songs'); ?>" class="w-100" />
                            <p class="text-center"><?= $lang->l('Crédit photo : Fanny L.'); ?></p>
                        </div>
                        <h2>Chansons de <?= Artist::getName(ARTISTID_SECOND) ?></h2>
                        <ul class="songs mt-3">
                            <?php foreach ($songssecond as $song_id => $song) { ?>
                                <?php if (!$song['is_cover']) { ?>
                                    <li><a href="chanson-<?= $song['slug'] ?>-<?= $song['id'] ?>" title="Chanson <?= $song['name'] ?>"><?= $song['name'] ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <h2>Chansons de <?= Artist::getName(ARTISTID_THIRD) ?></h2>
                        <ul class="songs mt-3">
                            <?php foreach ($songsthird as $song_id => $song) { ?>
                                <?php if (!$song['is_cover']) { ?>
                                    <li><a href="chanson-<?= $song['slug'] ?>-<?= $song['id'] ?>" title="Chanson <?= $song['name'] ?>"><?= $song['name'] ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4 ps-3">
                        <h2>Collaborations de <?= $mainartist ?></h2>
                        <ul class="songs mt-3">
                            <?php foreach ($collaborations as $song_id => $song) { ?>
                                <li><a href="chanson-<?= $song['slug'] ?>-<?= $song['id'] ?>" title="Chanson <?= $song['name'] ?>"><?= $song['name'] ?></a> (<?= Artist::getName($song['artist_id']) ?>)</li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4 os-3">
                        <h2>Chansons reprises par <?= $mainartist ?></h2>
                        <ul class="songs mt-3">
                            <?php foreach ($covers as $song_id => $song) { ?>
                                <?php if ($song['is_cover']) { ?>
                                    <li><a href="chanson-<?= $song['slug'] ?>-<?= $song['id'] ?>" title="Chanson <?= $song['name'] ?>"><?= $song['name'] ?></a> (<?= Artist::getName($song['cover_artist_id']) ?>)</li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <?= $lang->l('txt_promo_book') ?>
    </div>
</div>

<?php include("footer.php") ?>
