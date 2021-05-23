<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('sitemap_title');
$page_metadesc = $lang->l('sitemap_metadesc');
$og_url = 'plan-du-site';
$og_image = 'public/images/tournees-'.$mainartistslug.'.jpg';
$og_type = '';

$list_podcast = Podcast::getStack('1');
$list_tour = Tour::getStack();
$list_pagephotos = PicturePage::getStack('id ASC');
$list_disc_cd = Disc::getStack(Disc::SUPPORT_CD, 'is_main DESC, name ASC');
$list_disc_single = Disc::getStack(Disc::SUPPORT_SINGLE, 'is_main DESC, name ASC');
$list_disc_vinyle = Disc::getStack(Disc::SUPPORT_VINYLE, 'is_main DESC, name ASC');
$list_disc_video = Disc::getStack(Disc::SUPPORT_DVD, 'is_main DESC, name ASC');
$list_song = Song::getStack('artist_id ASC, name ASC');
$list_contributor = Contributor::getStack();
$list_salles = Salle::getStackArtist();

include("header.php");
?>

<div id="sitemap">
    <div class="content">
        <div class="wrapper">

            <h2><?= $page_title ?> de <?= $mainartist ?></h2>
            <ul>
                <li><a href="<?= URL ?>"><?= TITLE ?></a></li>
                <li><a href="<?= URL ?>podcast-list"><?= $lang->l('podcast_list_title') ?></a>
                    <?php if (!empty($list_podcast)) { ?>
                        <ul>
                            <?php
                            foreach($list_podcast as $item) {
                                echo '<li><a href="'.URL.'podcast-details-' . $item['id'].'" title="Podcast '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>clip-list"><?= $lang->l('clip_list_title') ?></a></li>
                <li><a href="<?= URL ?>media-list"><?= $lang->l('media_list_title') ?></a></li>
                <li><a href="<?= URL ?>recompenses"><?= $lang->l('recompenses_title') ?></a></li>
                <li><a href="<?= URL ?>photos"><?= $lang->l('pagephotos_list_title') ?></a>
                    <?php if (!empty($list_pagephotos)) { ?>
                        <ul>
                            <?php
                            foreach($list_pagephotos as $item) {
                                echo '<li><a href="'.URL.'album-photo-' . $item['slug'].'-' . $item['id'].'" title="Album photo '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>discographie"><?= $lang->l('disc_list_title') ?></a>
                    <?php if (!empty($list_disc_cd)) { ?>
                        <ul>
                            <?php
                            foreach($list_disc_cd as $item) {
                                echo '<li><a href="'.URL.'disc-' . $item['slug'] . '-' . $item['id'].'" title="Disque '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>vinyles"><?= $lang->l('vinyle_list_title') ?></a>
                    <?php if (!empty($list_disc_vinyle)) { ?>
                        <ul>
                            <?php
                            foreach($list_disc_vinyle as $item) {
                                echo '<li><a href="'.URL.'disc-' . $item['slug'] . '-' . $item['id'].'" title="Vinyle '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>singles"><?= $lang->l('single_list_title') ?></a>
                    <?php if (!empty($list_disc_single)) { ?>
                        <ul>
                            <?php
                            foreach($list_disc_single as $item) {
                                echo '<li><a href="'.URL.'disc-' . $item['slug'] . '-' . $item['id'].'" title="Single '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>videographie"><?= $lang->l('video_list_title') ?></a>
                    <?php if (!empty($list_disc_video)) { ?>
                        <ul>
                            <?php
                            foreach($list_disc_video as $item) {
                                echo '<li><a href="'.URL.'disc-' . $item['slug'] . '-' . $item['id'].'" title="Vidéo '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>chansons-<?= $mainartistslug ?>"><?= $lang->l('song_list_title') ?></a>
                    <?php if (!empty($list_song)) { ?>
                        <ul>
                            <?php
                            foreach($list_song as $item) {
                                echo '<li><a href="'.URL.'chanson-' . $item['slug'] . '-' . $item['id'].'" title="Chanson '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>liste-auteurs-compositeurs-<?= $mainartistslug ?>"><?= $lang->l('contributor_list_title') ?></a>
                    <?php if (!empty($list_contributor)) { ?>
                        <ul>
                            <?php
                            foreach($list_contributor as $item) {
                                echo '<li><a href="'.URL.'auteur-compositeur-' . $item['slug'] . '-' . $item['id'].'" title="Chanson '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>tournees-<?= $mainartistslug ?>"><?= $lang->l('tour_list_title') ?></a>
                    <?php if (!empty($list_tour)) { ?>
                        <ul>
                            <?php
                            foreach($list_tour as $item) {
                                echo '<li><a href="'.URL.'tournee-'.$item['slug'].'-'.$item['id'].'" title="Dates de la tournée de '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
                <li><a href="<?= URL ?>salles-concerts-<?= $mainartistslug ?>"><?= $lang->l('salle_list_title') ?></a>
                    <?php if (!empty($list_salles)) { ?>
                        <ul>
                            <?php
                            foreach($list_salles as $item) {
                                echo '<li><a href="'.URL.'salle-concert-'.$mainartistslug.'-'. $item['dpt'] .'-'. $item['id'].'" title="Salle concert '.$mainartist.' '.$item['name'].'">'. strtoupper($item['country']) .' - '. $item['city'] .'('. $item['dpt'] .') - '. $item['name'] .'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
            </ul>

        </div>
    </div>

</div>

<?php include("footer.php") ?>