<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('salle_list_title');
$page_metadesc = $lang->l('salle_list_metadesc');
$og_url = 'salles-concerts-'.$mainartistslug;
$og_image = 'public/images/Concert-Olympia-Steph-20190123.jpg';

include("header.php");

$class = 'Salle';
$order = (isset($_REQUEST['order'])) ? Request::requestId('order'):1;
$salles = Salle::getStackArtist($order);
?>
<div id="salle-list">
    <div class="content">
        <div class="wrapper">
            <h2>Salles de concerts où <?= $mainartist ?> a été en concert</h2>
            <?php if (!empty($salles)) { ?>
                <div class="row">
                    <div class="col-12 col-lg-7">
                        <ul class="salles mt-3 ms-3">
                            <?php foreach ($salles as $salle_id => $salle) { ?>
                                <li><a href="salle-concert-<?= $mainartistslug ?>-<?= $salle['dpt'] ?>-<?= $salle['id'] ?>" title="Salle <?= $salle['name'] ?>"><?= strtoupper($salle['country']) ?> - <?= $salle['city'] ?>(<?= $salle['dpt'] ?>) - <?= $salle['name'] ?></a> (<?= $salle['nbgigs'] ?> fois)</li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-5">
                        <img class="w-100" src="<?= URL_IMG ?>Concert-Olympia-Steph-20190123.jpg" alt="Calogero Olympia 2019" />

                        <p class="mt-3 ms-3">
                            <a href="<?= URL ?>salles-concerts-<?= $mainartistslug ?>?order=2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-down" viewBox="0 0 16 16"><path d="M3.5 2.5a.5.5 0 0 0-1 0v8.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L3.5 11.293V2.5zm3.5 1a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1h-1z"/></svg>
                                Voir la liste triée par nombre de concerts / salle</a></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<div class="text-center mt">
    <a href="<?= URL.'tournees-'.$mainartistslug; ?>"><button>Les tournées de <?= $mainartist ?></button></a>
</div>


<?php include("footer.php") ?>
