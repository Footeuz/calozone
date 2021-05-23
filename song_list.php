<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('song_list_title');
$page_metadesc = $lang->l('song_list_metadesc');
$og_url = 'chansons-'.$mainartistslug;
$og_image = 'public/images/chansons-'.$mainartistslug.'.jpg';

include("header.php");

$class = 'Song';
$songs = Song::getStackCalo('name ASC');
$songscharts = Song::getStackCharts('name ASC');
$songscircus = Song::getStackCircus('name ASC');
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
                            <img src="<?= URL ?>public/images/Calogero-Londres-20190119-FannyLinchet.jpg" alt="Calogero Londres 19 janvier 2019" class="w-100" />
                            <p class="text-center">Cr&eacute;dit photo : Fanny L.</p>
                        </div>
                        <h2>Chansons des Charts</h2>
                        <ul class="songs mt-3">
                            <?php foreach ($songscharts as $song_id => $song) { ?>
                                <?php if (!$song['is_cover']) { ?>
                                    <li><a href="chanson-<?= $song['slug'] ?>-<?= $song['id'] ?>" title="Chanson <?= $song['name'] ?>"><?= $song['name'] ?></a></li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <h2>Chansons de Circus</h2>
                        <ul class="songs mt-3">
                            <?php foreach ($songscircus as $song_id => $song) { ?>
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
        Découvrez et achetez <a href="https://www.facebook.com/Calogero-Songographie-Collectors-Le-livre-760809367343394/" target="_blank"><button>le livre dédié à la Discographie de Calogero</button></a> écrit par Pascal.
    </div>
</div>

<?php include("footer.php") ?>
