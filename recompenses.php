<?php
require_once 'boot.php';

$is_home = true;
$has_timelineclip = true;

$page_title = $lang->l('recompenses_title');
$page_metadesc = $lang->l('recompenses_metadesc');
$og_url = 'recompenses';
$og_image = 'public/images/prix/Calogero-prix-NMA-ArtisteAnnee-20040124-3.jpg';

$css[] = 'css/timelineclip.css';
$css[] = 'css/lightbox.min.css';
$js[] = 'js/lightbox.min.js';

include("header.php");

$moonths = array('00'=>'','01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet','08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre');

$recompenses = [];
$recompenses['2001']['00'][] = array('date'=>'2001-00-00', 'price'=>'PRIX RADIO FRANCE - ARTISTE DE L’ANNEE', 'pictures' => array());
$recompenses['2004']['01'][] = array('date'=>'2004-01-24', 'price'=>'NRJ MUSIC AWARD - ARTISTE MASCULIN', 'pictures' => array('Calogero-prix-NMA-ArtisteAnnee-20040124-3.jpg', 'Calogero-prix-NMA-ArtisteAnnee-20040124-2.jpg', 'Calogero-prix-NMA-ArtisteAnnee-20040124-1.jpg'));
$recompenses['2004']['02'][] = array('date'=>'2004-02-28', 'price'=>'VICTOIRE DE LA MUSIQUE - ARTISTE INTERPRETE MASCULIN', 'pictures' => array('Calogero-prix-VDM-ArtisteAnnee-20040228.jpg'));
$recompenses['2004']['02'][] = array('date'=>'2004-02-05', 'price'=>'GRAND PRIX DE L’UNAC - CHANSON DE L\'ANNEE POUR PRENDRE RACINE', 'pictures' => array('Calogero-prix-UNAC-20040205-0.jpg','Calogero-prix-UNAC-20040205-1.jpg','Calogero-prix-UNAC-20040205-2.jpg'));
$recompenses['2005']['01'][] = array('date'=>'2005-01-22', 'price'=>'NRJ MUSIC AWARDS - GROUPE/DUO FRANCOPHONE (AVEC PASSI)', 'pictures' => array('Calogero-prix-NMA-DuoPassi-20050122.jpg'));
$recompenses['2005']['03'][] = array('date'=>'2005-03-05', 'price'=>'VICTOIRES DE LA MUSIQUE - CHANSON ORIGINALE DE L\'ANNEE POUR SI SEULEMENT JE POUVAIS LUI MANQUER', 'pictures' => array('Calogero-prix-VDM-SiSeulementChansonAnnee-20050305.jpg'));
$recompenses['2005']['06'][] = array('date'=>'2005-06-03', 'price'=>'PRIX VINCENT SCOTTO (PRIX DE PRINTEMPS DE LA SACEM) – MEILLEURE CHANSON POUR FACE A LA MER', 'pictures' => array('Calogero-prix-Sacem-Spring-20050603.jpg'));
$recompenses['2005']['06'][] = array('date'=>'2005-06-21', 'price'=>'LA CHANSON DE L’ANNEE (EMISSION DE TF1) POUR FACE A LA MER', 'pictures' => array());
$recompenses['2009']['12'][] = array('date'=>'2009-12-25', 'price'=>'ALBUM RTL DE L’ANNEE POUR L\'EMBELLIE', 'pictures' => array('Calogero-prix-RTL-FeteChansonFrancaise-AlbumAnnee2009-20100120-1.jpg','Calogero-prix-RTL-FeteChansonFrancaise-AlbumAnnee2009-20100120-2.jpg','Calogero-prix-RTL-FeteChansonFrancaise-AlbumAnnee2009-20100120-3.jpg','Calogero-prix-RTL-FeteChansonFrancaise-AlbumAnnee2009-20100120-4.jpg'));
$recompenses['2014']['11'][] = array('date'=>'2014-11-20', 'price'=>'ALBUM RTL DE L’ANNEE POUR LES FEUX D\'ARTIFICE', 'pictures' => array('Calogero-prix-RTL-AlbumAnnee-LesFeuxdArtifice-20141120-1.jpg','Calogero-prix-RTL-AlbumAnnee-LesFeuxdArtifice-20141120-2.jpg'));
$recompenses['2015']['02'][] = array('date'=>'2015-02-14', 'price'=>'VICTOIRE DE LA MUSIQUE - CHANSON ORIGINALE DE L\'ANNEE POUR UN JOUR AU MAUVAIS ENDROIT', 'pictures' => array('Calogero-prix-VDM-UJAMEChansonAnnee-20150214-1.jpg','Calogero-prix-VDM-UJAMEChansonAnnee-20150214-2.jpg'));
$recompenses['2017']['11'][] = array('date'=>'2017-11-27', 'price'=>'PRIX SACEM - ARTISTE DE L’ANNEE', 'pictures' => array('Calogero-prix-Sacem-ArtisteAnnee-20171127-1.jpg','Calogero-prix-Sacem-ArtisteAnnee-20171127-2.jpg'));
?>
<div id="recompense-list" class="clip">
    <div class="content">
        <div class="wrapper">
            <h2 class="mt-3"><?php echo $lang->l('recompenses_details'); ?></h2>

            <div class="col-12 col-lg-9 mx-auto">
                <div class="container">
                    <div class="item">
                        <div id="timelineclip">
                            <div>
                                <?php foreach($recompenses as $yearitem => $itemsbyyear) { ?>
                                <section class="year">
                                    <h3><?= $yearitem ?></h3>
                                    <?php foreach($itemsbyyear as $monthitem => $itemsbymonth) { ?>
                                    <section>
                                        <h4 class="text-white"><?= $moonths[$monthitem] ?></h4>
                                        <ul>
                                            <?php foreach($itemsbymonth as $itemid => $recompense) { ?>
                                                <li>
                                                    <?= $recompense['price'] ?>
                                                    <?php if (!empty($recompense['pictures'])) { ?>
                                                        <br/>
                                                        <?php foreach($recompense['pictures'] as $picture) { ?>
                                                            <a href="<?= URL_IMG.'prix/'.$picture ?>" class="" data-lightbox="albumphoto" data-title="<?= $recompense['price'].'<br/>'.substr($recompense['date'],8,2).' '.$moonths[$monthitem].' '.$yearitem ?>">
                                                                <img class="thumbrecompense" src="<?= URL_IMG.'prix/mini/'.$picture ?>" alt="<?= $recompense['price'].' - '.substr($recompense['date'],8,2).' '.$moonths[$monthitem].' '.$yearitem ?>" />
                                                            </a>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </section>
                                    <?php } ?>
                                </section>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include("footer.php") ?>
