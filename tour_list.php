<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('tour_list_title');
$page_metadesc = $lang->l('tour_list_metadesc');
$og_url = 'tournees-'.$mainartistslug;
$og_image = 'public/images/tournees-'.$mainartistslug.'.jpg';

include("header.php");

$listtours = Tour::getStack();
if (!empty($listtours)) {
    $tournees = [];
    foreach($listtours as $tour_id => $tour) {
        $tournees[$tour_id]['datas'] = $tour;
        $tournees[$tour_id]['gigs'] = Gig::getTourStack($tour_id);
    }

?>
<div id="tour-list">
    <div class="content">
        <div class="wrapper">
            <h2 class="mt-3"><?php echo $lang->l('tour_list_details'); ?></h2>

            <?php foreach($tournees as $tour_id => $tour) { ?>
                <div class="mt-3 ms-3 float-start">
                    <a href="tournee-<?= $tour['datas']['slug'] ?>-<?= $tour_id ?>" title="Dates de la tournée de Calogero <?= $tour['datas']['name'] ?>"><img src="<?= URL.'tourimg-img-'.$tour_id ?>.jpg" alt="Affiche de la tournée de Calogero <?= addslashes($tour['datas']['name']) ?>"  height="300" /></a>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="text-center mt-3">
        <p>Les tournées de <?= $mainartist ?> sont produites par <a href="<?= TOURPRODLINK ?>" title="<?= TOURPRODNAME ?>"><?= TOURPRODNAME ?></a>.</p>
        <p><?= $lang->l('txt_thx_tour') ?></p>
    </div>
</div>

<?php } else { ?>
    <div>
        <p>Pas encore de tournées</p>
    </div>
<?php } ?>

<?php include("footer.php") ?>
