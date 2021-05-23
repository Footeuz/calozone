<?php
require_once 'boot.php';

$is_home = true;

$page_title = $lang->l('accueil');
$page_metadesc = TITLE.' - Zone d\'informations sur la carrière de '.Artist::getName(ARTISTID_MAIN);
$og_image = 'public/images/home/'.$mainartistslug.'-discographie.jpg';
$og_url = URL;

include("header.php");
?>
<div class="content mb-5">
    <div class="wrapper row">
        <div class="col-12 col-lg-4 text-center mb-5">
            <div class="mt-5 col-8 mx-auto">
                <div class="maincaroussel mx-auto">
                    <div id="carouselMain" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="3" aria-label="Slide 4"></button>
                            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="4" aria-label="Slide 5"></button>
                            <button type="button" data-bs-target="#carouselMain" data-bs-slide-to="5" aria-label="Slide 6"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="<?= URL_IMG ?>Calo_micro.gif" alt="<?= $mainartist ?> lâche son micro>" />
                            </div>
                            <div class="carousel-item">
                                <a href="<?= URL ?>podcast-list" title="<?= PODCAST_TITLE ?>">
                                    <img class="d-block w-100" src="<?= URL_IMG ?>home/<?= $mainartistslug ?>-podcast.jpg" alt="Zone <?= PODCAST_TITLE ?>" />
                                    <div class="carousel-caption d-none d-sm-block">
                                        <h5 class="text-white">"<?= PODCAST_TITLE ?>"</h5>
                                        <p>Ecoutez les podcasts par Cédric, Maëlyss, Pascal et Stéphanie</p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="<?= URL ?>media-list" title="Calogero Archives audios et vidéos">
                                    <img class="d-block w-100" src="<?= URL_IMG ?>home/<?= $mainartistslug ?>-archives.jpg" alt="Archives audios et vidéos" />
                                    <div class="carousel-caption d-none d-sm-block">
                                        <h5 class="text-white">Archives audios et vidéos</h5>
                                        <p>Archives des passages radios, web ou télévisés de <?= $mainartist ?></p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="<?= URL ?>tournees-<?= $mainartistslug ?>" title="Tournées <?= $mainartist ?>">
                                    <img class="d-block w-100" src="<?= URL_IMG ?>home/<?= $mainartistslug ?>-tournee.jpg" alt="Tournées <?= $mainartist ?>" />
                                    <div class="carousel-caption d-none d-sm-block">
                                        <h5 class="text-white">Tournées <?= $mainartist ?></h5>
                                        <p>Dates de concerts de <?= $mainartist ?> classés par tournée</p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="<?= URL ?>clip-list" title="Clips <?= $mainartist ?>">
                                    <img class="d-block w-100" src="<?= URL_IMG ?>home/<?= $mainartistslug ?>-clips.jpg" alt="Clips <?= $mainartist ?>" />
                                    <div class="carousel-caption d-none d-sm-block">
                                        <h5 class="text-white">Clips <?= $mainartist ?></h5>
                                        <p>Regardez tous les clips de <?= $mainartist ?></p>
                                    </div>
                                </a>
                            </div>
                            <div class="carousel-item">
                                <a href="<?= URL ?>discographie" title="Discographie de <?= $mainartist ?>">
                                    <img class="d-block w-100" src="<?= URL_IMG ?>home/<?= $mainartistslug ?>-discographie.jpg" alt="Discographie de <?= $mainartist ?>" />
                                    <div class="carousel-caption d-none d-sm-block">
                                        <h5 class="text-white">Discographie de <?= $mainartist ?></h5>
                                        <p>Tous les albums de <?= $mainartist ?></p>
                                    </div>
                                </a>
                            </div>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselMain" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Précédent</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselMain" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Suivant</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-7 mt-3 mb-3 border-start border-white ps-5">
            <h2 class="mb-5"><?= $lang->l('introduction'); ?></h2>
            <div class="txtcontainer">
                <?= $lang->l('txt_home'); ?>
            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
