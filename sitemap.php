<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('sitemap_title');
$page_metadesc = $lang->l('sitemap_metadesc');
$og_url = 'plan-du-site';
$og_image = 'public/images/tournees-'.$mainartistslug.'.jpg';
$og_type = '';

$list_contributor = Contributor::getStack();

function doSublink($menuitem) {
    global $mainartist;
    global $mainartistslug;

    $list_podcast = Podcast::getStack(ARTISTID_MAIN);
    $list_tour = Tour::getStack();
    $list_pagephotos = PicturePage::getStack('id ASC');
    $list_disc_cd = Disc::getStack(Disc::SUPPORT_CD, 'is_main DESC, name ASC');
    $list_disc_single = Disc::getStack(Disc::SUPPORT_SINGLE, 'is_main DESC, name ASC');
    $list_disc_vinyle = Disc::getStack(Disc::SUPPORT_VINYLE, 'is_main DESC, name ASC');
    $list_disc_video = Disc::getStack(Disc::SUPPORT_DVD, 'is_main DESC, name ASC');
    $list_song = Song::getStack('artist_id ASC, name ASC');
    $list_salles = Salle::getStackArtist();

    if ($menuitem['link_url'] == URL . 'podcast-list' && !empty($list_podcast)) {
        echo '<ul>';
            foreach ($list_podcast as $item) {
                echo '<li><a href="' . URL . 'podcast-details-' . $item['id'] . '" title="Podcast ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'discographie' && !empty($list_disc_cd)) {
        echo '<ul>';
            foreach ($list_disc_cd as $item) {
                echo '<li><a href="' . URL . 'disc-' . $item['slug'] . '-' . $item['id'] . '" title="Disque ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'vinyles' && !empty($list_disc_vinyle)) {
        echo '<ul>';
            foreach ($list_disc_vinyle as $item) {
                echo '<li><a href="' . URL . 'disc-' . $item['slug'] . '-' . $item['id'] . '" title="Vinyle ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'singles' && !empty($list_disc_single)) {
        echo '<ul>';
            foreach ($list_disc_single as $item) {
                echo '<li><a href="' . URL . 'disc-' . $item['slug'] . '-' . $item['id'] . '" title="Single ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'videographie' && !empty($list_disc_video)) {
        echo '<ul>';
            foreach ($list_disc_video as $item) {
                echo '<li><a href="' . URL . 'disc-' . $item['slug'] . '-' . $item['id'] . '" title="Vidéo ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'chansons-' . $mainartistslug && !empty($list_song)) {
        echo '<ul>';
            foreach ($list_song as $item) {
                echo '<li><a href="' . URL . 'chanson-' . $item['slug'] . '-' . $item['id'] . '" title="Chanson ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'tournees-' . $mainartistslug && !empty($list_tour)) {
        echo '<ul>';
            foreach ($list_tour as $item) {
                echo '<li><a href="' . URL . 'tournee-' . $item['slug'] . '-' . $item['id'] . '" title="Dates de la tournée de ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'salles-concerts-' . $mainartistslug && !empty($list_salles)) {
        echo '<ul>';
            foreach ($list_salles as $item) {
                echo '<li><a href="' . URL . 'salle-concert-' . $mainartistslug . '-' . $item['dpt'] . '-' . $item['id'] . '" title="Salle concert ' . $mainartist . ' ' . $item['name'] . '">' . strtoupper($item['country']) . ' - ' . $item['city'] . '(' . $item['dpt'] . ') - ' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }

    if ($menuitem['link_url'] == URL . 'photos' && !empty($list_pagephotos)) {
        echo '<ul>';
            foreach ($list_pagephotos as $item) {
                echo '<li><a href="' . URL . 'album-photo-' . $item['slug'] . '-' . $item['id'] . '" title="Album photo ' . $mainartist . ' ' . $item['name'] . '">' . $item['name'] . '</a>';
            }
        echo '</ul>';
    }
}

include("header.php");
?>

<div id="sitemap">
    <div class="content">
        <div class="wrapper">

            <h2><?= $page_title ?> de <?= $mainartist ?></h2>
            <ul>
                <li><a href="<?= URL ?>"><?= TITLE ?></a></li>
                <?php if (isset($menu_header) && !empty($menu_header)) { ?>
                    <?php foreach ($menu_header as $menu_item) { ?>
                        <li>
                            <?php if (!empty($menu_item['link_url'])) { ?><a href="<?= $menu_item['link_url'] ?>"><?= $menu_item['name'] ?></a><?php } else { echo $menu_item['name'];} ?>

                            <?php doSublink($menu_item); ?>

                            <?php if (!empty($menu_item['childs'])) { ?>
                                <ul>
                                    <?php foreach ($menu_item['childs'] as $child) { ?>
                                        <li>
                                            <?php if (!empty($child['link_url'])) { ?><a href="<?= $child['link_url'] ?>"><?= $child['name'] ?></a><?php } else { echo $child['name']; } ?>

                                            <?php doSublink($child); ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>

                        </li>
                    <?php } ?>
                <?php } ?>

                <li><a href="<?= URL ?>liste-auteurs-compositeurs-<?= $mainartistslug ?>"><?= $lang->l('contributor_list_title') ?></a>
                    <?php if (!empty($list_contributor)) { ?>
                        <ul>
                            <?php
                            foreach($list_contributor as $item) {
                                echo '<li><a href="'.URL.'auteur-compositeur-' . $item['slug'] . '-' . $item['id'].'" title="Chanson '.$mainartist.' '.$item['name'].'">'.$item['name'].'</a>';
                            }
                            ?>
                        </ul>
                    <?php } ?>
                </li>
            </ul>

        </div>
    </div>

</div>

<?php include("footer.php") ?>