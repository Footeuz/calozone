<?php
require_once 'boot.php';

$id = Request::requestId();
$class = 'song';
$song = new Song($id);
$authors = $song->getAuthors();
$composers = $song->getComposers();
$clips = Clip::getSongStack($id);
$discs = Disc::getSongStack($id);

$is_home = false;
$page_title = ($song->is_cover) ? 'Chanson reprise par '.$mainartist.' - Paroles '.$song->name : 'Chanson de '.$mainartist.' - Paroles '.$song->name;
$page_metadesc = 'Tous les détails et paroles sur la chanson de '.$mainartist.' "'.$song->name.'" paroles, auteur, compositeur';

$og_url = 'chanson-'.$song->slug.'-'.$id;
if (!empty($discs)) { foreach ($discs as $disc_id => $disc) { $og_image = 'disc-img-'.$disc->slug.'-'.$disc_id.'.jpg'; break; } }

$og_type = 'music.song';
$og_music_song = $song->name;

$css[] = 'css/hovermedia.css';
include("header.php");

$artist_name = Artist::getName($song->cover_artist_id);
$artist_www = Artist::getWebsite($song->cover_artist_id);
?>
<div id="song-list">
    <section class="content">
        <div class="wrapper">
            <h1 class="fw-bold text-center"><?= $song->name ?></h1>
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2 class="mt-3">Détails :</h2>
                    <p><label class="fw-bold">Auteur(s)</label> :
                        <?php if (!empty($authors)) {
                            foreach($authors as $contributor) {
                                echo '<a href="auteur-compositeur-'.$contributor->slug.'-'.$contributor->id.'">'.$contributor->name.'</a>&nbsp;';
                            }
                        }
                        ?>
                    </p>
                    <p><label class="fw-bold">Compositeur(s)</label> :
                        <?php if (!empty($composers)) {
                            foreach($composers as $contributor) {
                                echo '<a href="auteur-compositeur-'.$contributor->slug.'-'.$contributor->id.'">'.$contributor->name.'</a>&nbsp; ';
                            }
                        }
                        ?>
                    </p>
                    <div><?= $song->details ?></div>
                    <?php if ($song->is_cover) { ?><p><label class="fw-bold">Artiste repris</label> : <?= (!empty($artist_www)) ? '<a href="'.$artist_www.'" title="Site officiel '.$artist_name.'" target="_blank">' : '' ?><?= $artist_name ?><?= (!empty($artist_www)) ? '</a>' : '' ?></p><?php } ?>

                    <?php if (!empty($clips)) { ?>
                        <h2 class="mt-3">Le(s) clip(s) de "<?= $song->name ?>" :</h2>
                        <?php foreach ($clips as $clip_id => $clip) { ?>
                            <a title="Clip <?= $clip['artistname'] ?> <?= $clip['name']; ?>" href="<?= URL.'clip-list' ?>?clip_id=<?= $clip_id ?>"><img src="<?= URL.'clip-img-'.$clip_id ?>.jpg" alt="Clip <?= $clip['artistname'] ?> <?= $clip['name']; ?>" height="70" /></a>
                        <?php } ?>
                    <?php } ?>

                    <?php if (!empty($discs)) { ?>
                        <h2 class="mt-3">Le(s) disques(s) où apparaît "<?= $song->name ?>" :</h2>
                        <ul class="nopoints m-0">
                        <?php foreach ($discs as $disc_id => $disc) { ?>
                            <li class="float-start me-3 mt-3 maindisc">
                                <a href="<?= URL.'disc-'.$disc->slug.'-'.$disc_id ?>" class="hovermediadisc" title="Album <?= $disc->name ?>">
                                    <div class="hoverlayer text-center"><p><?= $disc->name ?><br/><?= date('Y', $disc->date_parution); ?></p></div>
                                    <img src="<?= URL.'disc-img-'.$disc->slug.'-'.$disc_id.'.jpg'; ?>" alt="<?= $disc->name ?>" height="200" />
                                </a>
                                <p class="text-center w200px"><?= $disc->version ?></p>
                            </li>
                        <?php } ?>
                        </ul>
                    <?php } ?>
                    <div class="clearfix">&nbsp;</div>
                </div>
                <div class="col-12 col-lg-6">
                    <h2>Paroles</h2>
                    <div class"text-start"><?= $song->lyrics ?></div>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center mt-3">
        <a href="<?= URL.'chansons-'.$mainartistslug; ?>"><button>Retrouvez toutes les chansons de <?= $mainartist ?></button></a>
    </div>
</div>

<?php include("footer.php"); ?>