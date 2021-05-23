<?php
require_once 'boot.php';

$is_home = true;
$page_title = $lang->l('avent_title');
$page_metadesc = $lang->l('avent_metadesc');
$og_url = 'calendrier-avent-2019';
$og_image = URL_IMG.'bg/Calogero-ZenithParis-20041218.jpg';

$css[] = 'css/avent.css';

$js[] = 'js/avent.js';

include("header.php");

function gethref($id_case) {
    return (date('Ymd') >= intval('201912'.str_pad($id_case, 2, "0",STR_PAD_LEFT))) ? '/cases/'.$id_case.'/' : '/cases/99/';
}
?>
<!--[if lt IE 9]><script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script><![endif]-->

<style>
    #content, #footer div, .fixed_nav { max-width: 1024px; }
    @media screen and (min-width:1300px) and (min-height:1024px) { #content, #footer div .fixed_nav { max-width: 1280px; } }
    #cboxOverlay { opacity: .85 !important; }
    #cboxLoadedContent{ background: transparent; }
</style>

<div id="calendrier-avent" class="">
    <div class="content">
        <div class="wrapper">
            <h2 style="font-size:2em;text-align:center">Calendrier de l'Avent de la Zone <?= $mainartist ?></h2>
            <p>Ouvrez une case par jour et redécouvrez un clip, une vidéo live, une interview, ou un jeu</p>

            <div class="pure-g">
                <div class="pure-u-1">
                    <div class="calendar w80 mx-auto">
                        <img src="<?= URL_IMG ?>bg/Calogero-ZenithParis-20041218.jpg" class="pure-img">
                        <div style="position:absolute;top:10%;left:0;right:0;bottom:0">
                            <div id="day_4" class="day"><em class="modal" data-w="960" data-href="<?= gethref(4) ?>">4</em></div><div id="day_2" class="day"><em class="modal" data-w="960" data-href="<?= gethref(2) ?>">2</em></div><div id="day_19" class="day"><em class="modal" data-w="960" data-href="<?= gethref(19) ?>">19</em></div><div id="day_10" class="day"><em class="modal" data-w="960" data-href="<?= gethref(10) ?>">10</em></div><div id="day_9" class="day"><em class="modal" data-w="960" data-href="<?= gethref(9) ?>">9</em></div><div id="day_24" class="day"><em class="modal" data-w="960" data-href="<?= gethref(24) ?>">24</em></div><div id="day_22" class="day"><em class="modal" data-w="960" data-href="<?= gethref(22) ?>">22</em></div><div id="day_14" class="day"><em class="modal" data-w="960" data-href="<?= gethref(14) ?>">14</em></div><div id="day_17" class="day"><em class="modal" data-w="960" data-href="<?= gethref(17) ?>">17</em></div><div id="day_16" class="day"><em class="modal" data-w="960" data-href="<?= gethref(16) ?>">16</em></div><div id="day_20" class="day"><em class="modal" data-w="960" data-href="<?= gethref(20) ?>">20</em></div><div id="day_5" class="day"><em class="modal" data-w="960" data-href="<?= gethref(5) ?>">5</em></div><div id="day_11" class="day"><em class="modal" data-w="960" data-href="<?= gethref(11) ?>">11</em></div><div id="day_6" class="day"><em class="modal" data-w="960" data-href="<?= gethref(6) ?>">6</em></div><div id="day_7" class="day"><em class="modal" data-w="960" data-href="<?= gethref(7) ?>">7</em></div><div id="day_1" class="day"><em class="modal" data-w="960" data-href="<?= gethref(1) ?>">1</em></div><div id="day_12" class="day"><em class="modal" data-w="960" data-href="<?= gethref(12) ?>">12</em></div><div id="day_8" class="day"><em class="modal" data-w="960" data-href="<?= gethref(8) ?>">8</em></div><div id="day_21" class="day"><em class="modal" data-w="960" data-href="<?= gethref(21) ?>">21</em></div><div id="day_15" class="day"><em class="modal" data-w="960" data-href="<?= gethref(15) ?>">15</em></div><div id="day_13" class="day"><em class="modal" data-w="960" data-href="<?= gethref(13) ?>">13</em></div><div id="day_23" class="day"><em class="modal" data-w="960" data-href="<?= gethref(23) ?>">23</em></div><div id="day_3" class="day"><em class="modal" data-w="960" data-href="<?= gethref(3) ?>">3</em></div><div id="day_18" class="day"><em class="modal" data-w="960" data-href="<?= gethref(18) ?>">18</em></div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="push"></div>

            <img id="ajax_spinner" src="<?= URL_IMG ?>/loading-spin.svg">
        </div>
    </div>

    <div class="text-center mt">
    </div>
</div>

<?php include("footer.php") ?>
<script>
    var t = Math.round(new Date().getTime()/1000);
    $('.day em').each(function(){
        $(this).data('href', $(this).data('href')+'?t='+t);
    });
</script>