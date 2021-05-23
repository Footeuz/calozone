<?php
require_once 'boot.php';

$episode_id = Request::requestId();
$podcast = Podcast::getEpisodeById($episode_id);

$is_home = false;
$page_title = $lang->l('podcast_details').' '.$podcast->episode;
$page_metadesc = $lang->l('podcast_details_metadesc').' - Podcast du : '.date('d.m.Y', $podcast->date_add).' avec '.$podcast->participants;
$og_url = 'podcast-details-'.$podcast->episode;
$og_image = (!empty($podcast->socialimg)) ? 'podcast-socialimg-'.$podcast->id.'.jpg' : 'public/images/podcast-'.$mainartistslug.'-2.jpg';

$css[] = 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

include("header.php");
?>

<div id="podcast-details" class="podcast">
    <section class="col-12 col-lg-6 mx-auto content mb-3">
        <div class="wrapper">
            <h2 class="">Podcast : <?= $podcast->name; ?></h2>
            <article class="mt-3 mb-3 ms-3">
                <p class=""><span class="fw-bold">Publié le :</span> <?= date('d.m.Y', $podcast->date_add); ?></p>

                <div class="mt-3 col-12 col-lg-6 float-start">
                    <p class=""><img src="<?= URL.'podcast-img-'.$podcast->id; ?>.jpg" alt="Podcast <?= $podcast->name; ?>" width="250" height="250" /></p>
                </div>
                <div class="col-12 col-lg-6 float-start">
                    <p class="mt-3 fw-bold">Au programme :</p>
                    <div><?= $podcast->description; ?></div>
                    <p class="mt-3 mb-3"><span class="fw-bold">Avec : </span><?= $podcast->participants; ?></p>
                </div>

                <?php if (!empty($podcast->path)) {
                    echo '<div class="mt-3 clearfix"><audio controls controlsList="nodownload" id="audiopodcast" class="col-12"><source src="'.URL.$podcast->path.'" type="audio/mpeg">Your browser does not support the audio element.</audio></div>'; }
                ?>

                <div class="clearfix mt-5"> </div>
                <div class="col-12 col-lg-6 float-start">
                    <div class="text-start">
                        <span class="fw-bold pb-3 me-3">Télécharger le fichier :</span> <a href="<?= URL; ?>podcast-file-<?= $podcast->id ?>" title="Telecharger <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-download btnpodcast"></i></a>
                    </div>
                </div>
                <div class="col-12 col-lg-6 float-start">
                    <div class="text-end">
                        <span class="fw-bold pb-3 me-3">S'abonner : </span> <a href="<?= URLRSS; ?>" title="Flux RSS <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-rss btnpodcast"></i></a>
                        <a href="<?= URLDZ ?>" title="<?= PODCAST_TITLE ?> sur Deezer" target="_blank"><i class="fa fa-signal btnpodcast"></i></a>
                        <a href="<?= URLSPOTIFY ?>" title="<?= PODCAST_TITLE ?> sur Spotify" target="_blank"><i class="fa fa-spotify btnpodcast"></i></a>
                        <a href="<?= URLITUNES ?>" title="Flux Itunes <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-apple btnpodcast"></i></a>
                    </div>
                </div>
            </article>

            <div class="text-center clearfix mt-3">
                <span class="fw-bold pe-3 ms-3">Pour ne pas rater le prochain épisode suivez-nous sur  : </span> <a href="<?= URLFBPODCAST; ?>" title="Facebook <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-facebook btnpodcast"></i></a>
                <a href="<?= URLTWPODCAST; ?>" title="Twitter <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-twitter btnpodcast"></i></a>
                <a href="<?= URLINSTPODCAST; ?>" title="Instagram <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-instagram btnpodcast"></i></a>
            </div>
        </div>
    </section>

    <div class="text-center mt">
        <a href="<?= URL.'podcast-list'; ?>"><button>Retrouvez tous les podcasts</button></a>
    </div>
</div>

<script>
    var aud = document.getElementById("audiopodcast");
    aud.onplay = function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= URL."action/podcast_addplay.php?id=".$podcast->id; ?>' );
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Ajout lecture : ' + xhr.responseText);
            }
            else {
                alert('Request failed.  Returned status of ' + xhr.status);
            }
        };
        xhr.send();
    };
    aud.onended = function() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '<?= URL."action/podcast_addend.php?id=".$podcast->id; ?>' );
        xhr.onload = function() {
            if (xhr.status === 200) {
                console.log('Ajout lecture : ' + xhr.responseText);
            }
            else {
                alert('Request failed.  Returned status of ' + xhr.status);
            }
        };
        xhr.send();
    };
</script>

<?php include("footer.php") ?>
