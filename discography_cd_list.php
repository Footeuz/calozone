<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('disc_list_title');
$page_metadesc = $lang->l('disc_list_metadesc');
$og_url = 'discographie';
$og_image = 'public/images/discographie-'.$mainartistslug.'.jpg';

$css[] = 'css/hovermedia.css';
$css[] = 'css/sort.css';
$js[] = 'js/modernizr.custom.29473.js';

include("header.php");

$class = 'Disc';
$discs = Disc::getStack('1', 'is_main DESC');

$cptismain=0;
?>
<div id="disc-list" class="disc">
    <div class="content">
        <div class="wrapper">
            <?php if (!empty($discs)) { ?>
                <section class="ff-container">
                    <label class="filtre">Filtrer par :</label>

                    <input id="select-type-all" name="radio-set-1" type="radio" class="ff-selector-type-all" checked="checked" />
                    <label for="select-type-all" class="ff-label-type-all">Voir tous les disques</label>
                    <input id="select-type-1" name="radio-set-1" type="radio" class="ff-selector-type-1" />
                    <label for="select-type-1" class="ff-label-type-1">Album studio</label>
                    <input id="select-type-2" name="radio-set-1" type="radio" class="ff-selector-type-2" />
                    <label for="select-type-2" class="ff-label-type-2">Album live</label>
                    <input id="select-type-3" name="radio-set-1" type="radio" class="ff-selector-type-3" />
                    <label for="select-type-3" class="ff-label-type-3">Coffret</label>

                    <input id="select-role1" name="radio-set-1" type="radio" class="ff-selector-role1" />
                    <label for="select-role1" class="ff-label-role1">Compositeur</label>
                    <input id="select-role2" name="radio-set-1" type="radio" class="ff-selector-role2" />
                    <label for="select-role2" class="ff-label-role2">Arrangeur</label>
                    <input id="select-role3" name="radio-set-1" type="radio" class="ff-selector-role3" />
                    <label for="select-role3" class="ff-label-role3">Réalisateur</label>
                    <input id="select-role4" name="radio-set-1" type="radio" class="ff-selector-role4" />
                    <label for="select-role4" class="ff-label-role4">Artiste</label>
                    <input id="select-role5" name="radio-set-1" type="radio" class="ff-selector-role5" />
                    <label for="select-role5" class="ff-label-role5">Interprète</label>

                    <div class="clearfix">&nbsp;</div>
                    <ul class="ff-items discs mt-3">
                        <?php foreach ($discs as $disc_id => $disc) { ?>
                            <?php if ($disc['is_main']==0) $cptismain++; ?>
                            <?php if ($cptismain==1) echo '<div class="clearfix mt-5">&nbsp;</div>'; ?>
                            <li class="float-start text-center <?= ($disc['is_main'] == 1) ? ' maindisc':'' ?> ff-item-type-<?= $disc['type'] ?><?= (!empty($disc['role1'])) ? ' ff-item-role'.$disc['role1']:'' ?>
<?= (!empty($disc['role2'])) ? ' ff-item-role'.$disc['role2']:'' ?><?= (!empty($disc['role3'])) ? ' ff-item-role'.$disc['role3']:'' ?>
<?= (!empty($disc['role4'])) ? ' ff-item-role'.$disc['role4']:'' ?><?= (!empty($disc['role5'])) ? ' ff-item-role'.$disc['role5']:'' ?>">
                                <a href="<?= URL.'disc-'.$disc['slug'].'-'.$disc_id ?>" class="hovermediadisc" title="Album <?= $disc['name'].' - '.$disc['artistname'] ?>">
                                    <div class="hoverlayer text-center"><p><?= $disc['name'] ?><br/><?= $disc['artistname'] ?><br/><?= date('Y', $disc['date_parution']); ?></p></div>
                                    <img src="<?= URL.'disc-thumb-'.$disc['slug'].'-'.$disc_id; ?>.jpg" alt="<?= $disc['name'] ?>" height="200" />
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <div class="clearfix">&nbsp;</div>
                    <div class="mt-3">
                        <p class="text-center fw-bold">La playlist des chansons collaborations ou reprises :</p>
                        <div class="mx-auto" style="width:650px;">
                            <iframe scrolling="no" frameborder="0" allowTransparency="true" src="https://www.deezer.com/plugins/player?format=classic&autoplay=false&playlist=true&width=650&height=350&color=ff0000&layout=dark&size=medium&type=playlist&id=<?= PLSTID ?>&app_id=107951" width="650" height="350"></iframe>
                        </div>
                    </div>
                </section>
            <?php } ?>
        </div>
    </div>

    <div class="text-center mt-3">
        <?= $lang->l('txt_promo_book') ?>
    </div>
</div>

<?php include("footer.php") ?>
