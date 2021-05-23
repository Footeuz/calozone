<?php
require_once 'boot.php';

$id = Request::requestId();
$class = 'contributor';
$contributor = new Contributor($id);

$stack = SongContributor::getStackContributor($id);
$songs_author = (isset($stack[SongContributor::R_AUTHOR])) ? $stack[SongContributor::R_AUTHOR] : array();
$songs_composer = (isset($stack[SongContributor::R_COMPOSER])) ? $stack[SongContributor::R_COMPOSER] : array();

$is_home = false;
$page_title = 'Contributeur (auteur ou compositeur) '.$contributor->name;
$page_metadesc = 'Toutes les chansons pour lesquelles le contributeur "'.$contributor->name.'" a collaboré en tant que auteur ou compositeur';

$og_url = 'auteur-compositeur-'.$contributor->slug.'-'.$id;

$og_type = '';
$og_music_contributor = $contributor->name;

include("header.php");
?>
<div id="contributor-list" class="contributor">
    <section class="content">
        <div class="wrapper">
            <h1 class="fw-bold text-center">Contributions en tant qu'auteur et/ou compositeur de <strong><?= $contributor->name ?></strong></h1>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <?php if (!empty($songs_author)) { ?>
                        <h2 class="mt-3">En tant qu'auteur :</h2>
                        <ul class="nopoints m-0 clearfix">
                        <?php foreach ($songs_author as $assoc) { ?>
                            <?php $song = new Song($assoc['song_id']); ?>
                            <li class="float-start me-3 mt-3 ms-3 mb-3 maindisc">
                                <a href="<?= URL.'chanson-'.$song->slug.'-'.$song->id ?>" title="Chanson <?= $song->name ?>"><?= $song->name ?></a>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-12 col-lg-6">
                    <?php if (!empty($songs_composer)) { ?>
                        <h2 class="mt-3">En tant que compositeur :</h2>
                        <ul class="nopoints m-0">
                            <?php foreach ($songs_composer as $assoc) { ?>
                                <?php $song = new Song($assoc['song_id']); ?>
                                <li class="float-start me-3 mt-3 ms-3 mb-3 maindisc">
                                    <a href="<?= URL.'chanson-'.$song->slug.'-'.$song->id ?>" title="Chanson <?= $song->name ?>"><?= $song->name ?></a>
                                </li>
                            <?php } ?>

                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>


    <div class="text-center mt-3">
        <a href="<?= URL.'chansons-'.$mainartistslug; ?>"><button>Retrouvez toutes les chansons de <?= $mainartist ?></button></a> - <a href="<?= URL.'liste-auteurs-compositeurs-'.$mainartistslug; ?>"><button>Retrouvez tous les auteurs/compositeurs</button></a>
    </div>
</div>

<?php include("footer.php"); ?>