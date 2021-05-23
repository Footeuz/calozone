<?php
require_once 'boot.php';

$is_home = true;
$page_title = $lang->l('podcast_list_title');
$page_metadesc = $lang->l('podcast_list_metadesc');
$og_url = 'podcast-list';
$og_image = 'public/images/podcast-'.$mainartistslug.'-2.jpg';

$css[] = 'css/timelinepodcast.css';
$css[] = 'https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';

include("header.php");

$podcasts = Podcast::getStack('1');
$items = [];
if (!empty($podcasts)) {
    foreach ($podcasts as $item_id => $item) {
        $year = date('Y', $item['date_add']);
        $month = date('m', $item['date_add']);
        $items[$year][$month][$item_id] = $item;
    }
}
?>
<div id="podcast-list" class="podcast">
    <div class="content">
        <div class="wrapper container">
            <h2><?php echo $lang->l('podcast_list_details'); ?></h2>

            <div class="timelinepodcast">
                <?php
                if (!empty($items)) {
                    foreach ($items as $year => $itemyear) {
                        ?>

                        <div class="timeline-month">
                            <?= $year ?>
                            <span><?= count($itemyear) ?> podcasts</span>
                        </div>
                        <div class="timeline-section">
                            <?php foreach ($itemyear as $month => $itemmonth) { ?>
                                <div class="timeline-date">
                                    <?= $allmonths[$month] ?>
                                </div>
                                <div class="row">
                                <?php foreach ($itemmonth as $podcast_id => $item) { ?>
                                    <?php $description = strip_tags($item['description']); ?>
                                        <div class="col-sm-4 col-12 col-lg-6" style="position: relative;min-height: 1px;padding-left: 15px;padding-right: 15px;">
                                            <div class="timeline-box">
                                                <div class="box-title">
                                                    <i class="fa <?= ($item['episode']%2 == 1) ? 'fa-podcast' : 'fa-headphones'; ?> text-success" aria-hidden="true"></i> <?=  $item['name'] ?>
                                                </div>
                                                <div class="box-content">
                                                    <a href="<?= URL.'podcast-details-'.$item['episode']; ?>"><button><i class="fa fa-play"></i> Ecouter</button></a> <a href="<?= URL.'podcast-file-'.$podcast_id; ?>"><button><i class="fa fa-download"></i> Télécharger</button></a>
                                                    <div class="box-item row">
                                                        <div class="col-12 col-lg-4 text-center"><a href="<?= URL.'podcast-details-'.$item['episode']; ?>"><img src="<?= URL.'podcast-img-'.$podcast_id; ?>.jpg" alt="Podcast <?= $item['name']; ?>" width="125" height="125" /></a></div>
                                                        <div class="col-12 col-lg-8"><?= $description ?></div>
                                                    </div>
                                                    <div class="box-item"><strong>Date</strong>: <?= date('d.m', $item['date_add']) ?>
                                                        &nbsp;<strong>Nb. écoutes sur calo.zone</strong>: <?= $item['nb_listen'] ?>
                                                        &nbsp;<strong>Durée</strong>: <?= $item['duration'] ?>
                                                    </div>
                                                </div>
                                                <div class="box-footer">Avec : <?=  $item['participants'] ?></div>
                                            </div>
                                        </div>
                                <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                    <?php }
                }
                ?>
            </div>

            <div class="clearfix">&nbsp;</div>
            <div class="text-center mt-3">
                <span class="fw-bold mb-3 me-3">Pour laisser vos impressions et ne pas rater le prochain épisode suivez-nous sur  : </span> <a href="<?= URLFBPODCAST; ?>" title="Facebook <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-facebook btnpodcast"></i></a>
                <a href="<?= URLTWPODCAST; ?>" title="Twitter <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-twitter btnpodcast"></i></a>
                <a href="<?= URLINSTPODCAST; ?>" title="Instagram <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-instagram btnpodcast"></i></a>
            </div>
        </div>
    </div>

    <div class="text-center mt-3 mb-3">
        <span class="fw-bold mb mr">S'abonner : </span> <a href="<?= URLRSS; ?>" title="Flux RSS <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-rss btnpodcast"></i></a>
        <a href="<?= URLDZ ?>" title="<?= PODCAST_TITLE ?> sur Deezer" target="_blank"><i class="fa fa-signal btnpodcast"></i></a>
        <a href="<?= URLSPOTIFY ?>" title="<?= PODCAST_TITLE ?> sur Spotify" target="_blank"><i class="fa fa-spotify btnpodcast"></i></a>
        <a href="<?= URLITUNES ?>" title="Flux Itunes <?= PODCAST_TITLE ?>" target="_blank"><i class="fa fa-apple btnpodcast"></i></a>
    </div>
</div>

<?php include("footer.php") ?>
