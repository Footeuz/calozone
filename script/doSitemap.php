<?php
require_once '../boot.php';
error_reporting(E_ALL);
ini_set('display_errors','on');

$list_contributor = Contributor::getStack();

function doSublink($menuitem) {
    global $fp;
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
        foreach ($list_podcast as $item) {
            fputs($fp, Render::xmlSitemap(URL.'podcast-details-' . $item['id'], 'weekly', '0.8'));
        }
    }

    if ($menuitem['link_url'] == URL . 'discographie' && !empty($list_disc_cd)) {
        foreach ($list_disc_cd as $item) {
            fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.8'));
        }
    }

    if ($menuitem['link_url'] == URL . 'vinyles' && !empty($list_disc_vinyle)) {
        foreach ($list_disc_vinyle as $item) {
            fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
        }
    }

    if ($menuitem['link_url'] == URL . 'singles' && !empty($list_disc_single)) {
        foreach ($list_disc_single as $item) {
            fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
        }
    }

    if ($menuitem['link_url'] == URL . 'videographie' && !empty($list_disc_video)) {
        foreach ($list_disc_video as $item) {
            fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
        }
    }

    if ($menuitem['link_url'] == URL . 'chansons-' . $mainartistslug && !empty($list_song)) {
        foreach ($list_song as $item) {
            fputs($fp, Render::xmlSitemap(URL.'chanson-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
        }
    }

    if ($menuitem['link_url'] == URL . 'tournees-' . $mainartistslug && !empty($list_tour)) {
        foreach ($list_tour as $item) {
            fputs($fp, Render::xmlSitemap(URL.'tournee-tour-' . $item['slug'] . '-' . $item['id'], 'yearly', '0.7'));
        }
    }

    if ($menuitem['link_url'] == URL . 'salles-concerts-' . $mainartistslug && !empty($list_salles)) {
        foreach ($list_salles as $item) {
            fputs($fp, Render::xmlSitemap(URL.'salle-concert-'.$mainartistslug.'-'. $item['dpt'] .'-'. $item['id'], 'yearly', '0.5'));
        }
    }

    if ($menuitem['link_url'] == URL . 'photos' && !empty($list_pagephotos)) {
        foreach ($list_pagephotos as $item) {
            fputs($fp, Render::xmlSitemap(URL.'album-photo-' . $item['slug'].'-' . $item['id'], 'yearly', '0.9'));
        }
    }
}


$fp = fopen('../sitemap.xml', 'w');
if ($fp) {
    fputs($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");
    fputs($fp, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n");
}

fputs($fp, Render::xmlSitemap(URL , 'yearly', '1'));

if (isset($menu_header) && !empty($menu_header)) {
    foreach ($menu_header as $menu_item) {

        if (!empty($menu_item['link_url'])) {
            fputs($fp, Render::xmlSitemap(URL . $menu_item['link_url'], 'yearly', '0.9'));
        }
        doSublink($menu_item);

        if (!empty($menu_item['childs'])) {
            foreach ($menu_item['childs'] as $child) {
                if (!empty($child['link_url'])) {
                    fputs($fp, Render::xmlSitemap(URL . $child['link_url'], 'yearly', '0.9'));
                }
                doSublink($child);
            }
        }

    }
}

fputs($fp, Render::xmlSitemap(URL . 'liste-auteurs-compositeurs-'.$mainartistslug, 'yearly', '0.9'));
if (!empty($list_contributor)) {
    foreach($list_contributor as $item) {
        fputs($fp, Render::xmlSitemap(URL.'auteur-compositeur-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.5'));
    }
}

fputs($fp, "</urlset>");
fclose($fp);

echo 'Flux mis à jour : <a href="'.URL.'sitemap.xml">'.URL.'sitemap.xml</a>';