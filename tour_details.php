<?php
require_once 'boot.php';

$is_home = false;

$id = Request::requestId();
$class = 'tour';
$tournee = new Tour($id);
$gigs = Gig::getTourStack($id);
if ($tournee->disc_id > 0) $disc = new Disc($tournee->disc_id);

$setlists = TourSetlist::getStackByTour($id);

$page_title = $lang->l('tour_details') . ' - ' . $tournee->name;
$page_metadesc = $lang->l('tour_list_metadesc') . ' - ' . $tournee->name;
$og_url = 'tournee-' . $tournee->slug . '-' . $id;
$og_image = 'public/images/tournees-'.$mainartistslug.'.jpg';

$css[] = 'css/hovermedia.css';

include("header.php");
?>
<div id="tour-list">
    <div class="content">
        <div class="wrapper">
            <h2 class="mt-3">Tournée : <?= $tournee->name ?></h2>

            <div class="row">
                <div class="col-12 col-lg-4 mt-3 text-end">
                    <?php if (isset($disc)) { ?>
                        <h3 class="text-start">Disque associ&eacute; &agrave; cette tourn&eacute;e :</h3>
                        <ul class="nopoints m-0">
                            <li class="mx-auto" style="width:200px;">
                                <a href="<?= URL . 'disc-' . $disc->slug . '-' . $tournee->disc_id ?>"
                                   class="hovermediadisc" title="Album <?= $disc->name ?>">
                                    <div class="hoverlayer text-center"><p><?= $disc->name ?>
                                            <br/><?= date('Y', $disc->date_parution); ?></p></div>
                                    <img src="<?= URL . 'disc-img-' . $disc->slug . '-' . $tournee->disc_id . '.jpg'; ?>"
                                         alt="<?= $disc->name ?>" height="200"/>
                                </a>
                            </li>
                        </ul>
                    <?php } ?>

                    <?php if (!empty($setlists)) { ?>
                        <?php foreach ($setlists as $setlist) { ?>
                            <h3 class="text-start"><?= $setlist['name'] ?></h3>
                            <?php $songs = TourSetlistSong::getStackTourSetlist($setlist['id']); ?>
                            <?php if (!empty($songs)) { ?>
                                <ul>
                                    <?php foreach ($songs as $song_ref) { ?>
                                        <?php $song = new Song($song_ref['song_id']); ?>
                                        <li class="text-start">
                                            <?= str_pad($song_ref['track_position'], 2, "0", STR_PAD_LEFT) ?>. <a
                                                    href="chanson-<?= $song->slug ?>-<?= $song->id ?>"
                                                    title="Chanson <?= $song->name ?>"> <?= $song->name ?> </a> <?= (!empty($song_ref['more_infos']) ? '(' . $song_ref['more_infos'] . ')' : '') ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                            <?php if (!empty($setlist['img'])) { ?>
                                <div class="text-center mt-3 pt-3 mb-3">
                                    <img src="<?= URL ?>toursetlist-img-<?= $setlist['id'] ?>.jpg" alt="<?= addslashes($setlist['name']) ?>" class="w-100" />
                                </div>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                    <div class="mt-3 more-infos">
                        <?= $tournee->more_infos ?>
                    </div>
                </div>
                <div class="col-12 col-lg-8 mt-3">
                    <?php if (!empty($gigs)) { ?>
                        <ul class="mt-3 note">
                            <?php foreach ($gigs as $gig_id => $gig) {
                                if ($gig['media_id'] > 0) $media = new Media($gig['media_id']);
                                $salle = new Salle($gig['salle_id']); ?>
                                <li class="<?= ($gig['is_cp']) ? 'concertprive' : '' ?> <?= ($gig['canceled']) ? 'canceled' : '' ?>">
                                    <?= date('d.m.Y', $gig['date_start']) ?> -
                                    (<?= $countries[strtoupper($salle->country)] ?><?= (!empty($salle->dpt)) ? ' - ' . $salle->dpt : '' ?>
                                    ) <a href="salle-concert-<?= $mainartistslug ?>-<?= $salle->dpt ?>-<?= $salle->id ?>"><span
                                                class="fw-bold"><?= $salle->city ?></span> - <?= $salle->name ?>
                                    </a> <?= (!empty($gig['more_infos'])) ? ' - ' . $gig['more_infos'] : '' ?> <?= (!empty($gig['radio'])) ? ' - <span class="fw-bold">' . $gig['radio'] . '</span>' : '' ?>
                                    <?= ($gig['media_id'] > 0) ? ' <a href="' . $media->getUrl() . '" target="_blank"> ↬ média associé</a>' : '' ?>  <?= ($gig['canceled']) ? strtoupper('Annulé') : '' ?>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } else { ?>
                        <p>Pas encore de concerts</p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="<?= URL . 'tournees-'.$mainartistslug; ?>"><button>Retour aux tournées</button></a>
            <p>Les tournées de <?= $mainartist ?> sont produites par <a href="<?= TOURPRODLINK ?>" title="<?= TOURPRODNAME ?>"><?= TOURPRODNAME ?></a>.</p>
            <p><?= $lang->l('txt_thx_tour') ?></p>
        </div>
    </div>
</div>

<?php include("footer.php") ?>