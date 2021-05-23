<?php
require_once 'boot.php';

$id = Request::requestId();
$class = 'salle';
$salle = new Salle($id);
$gigs = $salle->getGigs($id);

$is_home = false;
$page_title = 'Concerts de '.$mainartist.' : '.$salle->name.' ('.$salle->city.')';
$page_metadesc = 'Tous les concerts de '.$mainartist.' dans la salle '.$salle->name.'';

$og_url = 'salle-concert-'.$mainartistslug.'-'.$salle->dpt.'-'.$id;
$og_image = 'public/images/tournees-'.$mainartistslug.'.jpg';

include("header.php");
?>
<div id="salle-list">
    <section class="content">
        <div class="wrapper">
            <h1 class="fw-bold text-center"><?= $salle->name ?> - <?= $salle->city ?> (<?= $salle->dpt ?>)</h1>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <h2 class="mt-3">Informations :</h2>
                    <p><?= $salle->address ?></p>
                    <p><?= $salle->cp ?> <?= $salle->city ?></p>
                    <p><?= $countries[strtoupper($salle->country)] ?></p>
                    <p><?= (!empty($salle->website)) ? 'Site internet : <a href="'.$salle->website.'" target="_blank">'.$salle->website.'</a>' : '' ?></p>
                    <p><?= (!empty($salle->places)) ? 'Places : '.$salle->places : '' ?></p>
                </div>
                <div class="col-12 col-lg-8">
                    <h2 class="mt-3">Le(s) concert(s) de <?= $mainartist ?> dans ce lieu :</h2>

                    <?php if (!empty($gigs)) {
                        echo '<ul>';
                        foreach ($gigs as $gig_id => $gig) {
                            if ($gig['media_id']>0)
                                $media = new Media($gig['media_id']);
                            $salle = new Salle($gig['salle_id']);
                            $tour = new Tour($gig['tour_id']);
                            echo '<li class="'. (($gig['is_cp']) ? 'concertprive' : '') .' '. (($gig['canceled']) ? 'canceled' : '') .'">'.
                                date('d.m.Y', $gig['date_start']) .
                                ' - <a href="'. URL .'tournee-'. $tour->slug .'-'. $tour->id .'">'. $tour->name .'</a> '.
                                ((!empty($gig['more_infos'])) ? ' - '.$gig['more_infos'] : '') .' '.
                                ((!empty($gig['radio'])) ? ' - <span class="fw-bold">'.$gig['radio'].'</span>' : '') .' '.
                                (($gig['media_id']>0) ? ' <a href="'.$media->getUrl().'" target="_blank"> ↬ média associé</a>' : '') .' '.
                                (($gig['canceled']) ? strtoupper('Annulé') : '') .
                                '</li>';
                        }
                        echo '</ul>';
                    } ?>
                </div>
            </div>
        </div>
    </section>

    <div class="text-center mt-3">
        <a href="<?= URL.'salles-concerts-'.$mainartistslug; ?>"><button>Les salles de concerts de <?= $mainartist ?></button></a>
        <a href="<?= URL.'tournees-'.$mainartistslug; ?>"><button>Les tournées de <?= $mainartist ?></button></a>
    </div>
</div>

<?php include("footer.php"); ?>