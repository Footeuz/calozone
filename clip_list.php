<?php
require_once 'boot.php';

$is_home = true;
$has_timelineclip = true;

$page_title = $lang->l('clip_list_title');
$page_metadesc = $lang->l('clip_list_metadesc');
$og_url = 'clip-list';
$og_image = 'public/images/clips-'.$mainartistslug.'.jpg';

$css[] = 'css/timelineclip.css';
$js[] = 'js/youtube.js';

include("header.php");

$clips = Clip::getStack('date_parution DESC');
$items = [];
if (!empty($clips)) {
    foreach ($clips as $clip_id => $item) {
        $year = date('Y', $item['date_parution']);
        $month = date('m', $item['date_parution']);
        $items[$year][$month][$clip_id] = $item;
        $items[$year][$month][$clip_id]['description'] = strip_tags($item['description']);
        $items[$year][$month][$clip_id]['clipurl'] = str_replace("https://www.youtube.com/watch?v=", "", $item['path']);
    }
}
?>
<div id="clip-list" class="clip">
    <div class="content">
        <div class="wrapper pb-5">
            <h2 class="mb-3"><?php echo $lang->l('clip_list_details'); ?></h2>

            <div class="row">
                <div class="col-lg-7 col-12">
                    <div id="clipplayer1" class="text-center mx-auto mt-3 d-block"></div>
                    <div id="clipplayer2" class="text-center mx-auto mt-3 d-block"></div>
                    <div id="cliptype" class="text-center mt-3 fw-bold"></div>
                    <div id="clipdate" class="text-center"></div>
                    <div id="clipreal" class="text-center"></div>

                    <div class="text-center mt-3">
                        <span class="fw-bold mt-3">Chaîne officielle : </span> <a href="<?= URLYTOFF; ?>" title="<?= $mainartist ?> Youtube" target="_blank"><button>Youtube de <?= $mainartist ?></button></a>
                    </div>
                </div>

                <div class="col-lg-5 col-12">
                    <div class="container">
                        <div class="item">
                            <div id="timelineclip">
                                <div>
                                    <?php foreach($items as $yearitem => $itemsbyyear) { ?>
                                    <section class="year">
                                        <h3><?= $yearitem ?></h3>
                                        <?php foreach($itemsbyyear as $monthitem => $itemsbymonth) { ?>
                                        <section>
                                            <h4><?= $monthitem ?></h4>
                                            <ul>
                                                <?php foreach($itemsbymonth as $itemid => $clip) { ?>
                                                    <li class="clearfix">
                                                        <div class="float-start thumbclip">
                                                            <a href="#" onclick="
                                                                    <?php if (substr($clip['path'], 0, 19) != 'https://www.youtube') { ?>
                                                                    setEmbed('<?= $clip['id'] ?>', '<?= $clip['clipurl'] ?>', '<?= trim($clip['type'].' '.$clip['complement_type']) ?>', '<?= $clip['realisateur'] ?>', '<?= date('d.m.Y',$clip['date_parution']) ?>', '<?= $clip['artistname'] ?>'); return false;
                                                                    <?php } else { ?>
                                                                    showVideo('<?= $clip['id'] ?>', '<?= $clip['clipurl'] ?>', '<?= trim($clip['type'].' '.$clip['complement_type']) ?>', '<?= $clip['realisateur'] ?>', '<?= date('d.m.Y',$clip['date_parution']) ?>', '<?= $clip['artistname'] ?>'); return false;
                                                                    <?php } ?>">
                                                                <img src="<?= URL.'clip-img-'.$clip['id'] ?>.jpg" alt="Clip <?= Artist::getName($clip_id) ?> <?= $clip['name']; ?>" height="40" />
                                                            </a>
                                                        </div>
                                                        <div class="float-start" style="max-width: 270px;">
                                                            <a href="#" onclick="
                                                                <?php if (substr($clip['path'], 0, 19) != 'https://www.youtube') { ?>
                                                                    setEmbed('<?= $clip['id'] ?>', '<?= $clip['clipurl'] ?>', '<?= trim($clip['type'].' '.$clip['complement_type']) ?>', '<?= $clip['realisateur'] ?>', '<?= date('d.m.Y',$clip['date_parution']) ?>', '<?= $clip['artistname'] ?>'); return false;
                                                                <?php } else { ?>
                                                                    showVideo('<?= $clip['id'] ?>', '<?= $clip['clipurl'] ?>', '<?= trim($clip['type'].' '.$clip['complement_type']) ?>', '<?= $clip['realisateur'] ?>', '<?= date('d.m.Y',$clip['date_parution']) ?>', '<?= $clip['artistname'] ?>'); return false;
                                                                <?php } ?>">
                                                                <?= $clip['name']; ?>
                                                            </a>
                                                        </div>
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
</div>
<?php
$clip_id = Request::requestId('clip_id');
if ($clip_id>0) {
    $firstclip = str_replace("https://www.youtube.com/watch?v=", "", $clips[$clip_id]['path']);
} else {
    $firstclip = IDCLIP1;
}
echo '<input type="hidden" id="firstclip" name="firstclip" value="'.$firstclip.'">';
?>

<?php include("footer.php") ?>