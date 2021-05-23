<?php
require_once '../boot.php';
error_reporting(E_ALL);
ini_set('display_errors','on');

$fp = fopen('../sitemap.xml', 'w');
if ($fp) {
    fputs($fp, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n");
    fputs($fp, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\r\n");
}

fputs($fp, Render::xmlSitemap(URL , 'yearly', '1'));
fputs($fp, Render::xmlSitemap(URL . 'podcast-list', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'salles-concerts-'.$mainartistslug, 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'tournees-'.$mainartistslug, 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'discographie', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'vinyles', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'singles', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'videographie', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'chansons-'.$mainartistslug, 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'liste-auteurs-compositeurs-'.$mainartistslug, 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'clip-list', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'media-list', 'yearly', '0.9'));
fputs($fp, Render::xmlSitemap(URL . 'recompenses', 'yearly', '0.9'));

fputs($fp, Render::xmlSitemap(URL . 'photos', 'yearly', '0.9'));
$list_pagephotos = PicturePage::getStack('');
if (!empty($list_pagephotos)) {
    foreach($list_pagephotos as $item) {
        fputs($fp, Render::xmlSitemap(URL.'album-photo-' . $item['slug'].'-' . $item['id'], 'yearly', '0.9'));
    }
}

$list_podcast = Podcast::getStack('1');
if (!empty($list_podcast)) {
    foreach($list_podcast as $item) {
        fputs($fp, Render::xmlSitemap(URL.'podcast-details-' . $item['id'], 'weekly', '0.8'));
    }
}

$list_disc = Disc::getStack(Disc::SUPPORT_CD);
if (!empty($list_disc)) {
    foreach($list_disc as $item) {
        fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.8'));
    }
}
$list_disc = Disc::getStack(Disc::SUPPORT_SINGLE);
if (!empty($list_disc)) {
    foreach($list_disc as $item) {
        fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
    }
}
$list_disc = Disc::getStack(Disc::SUPPORT_DVD);
if (!empty($list_disc)) {
    foreach($list_disc as $item) {
        fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
    }
}
$list_disc = Disc::getStack(Disc::SUPPORT_VINYLE);
if (!empty($list_disc)) {
    foreach($list_disc as $item) {
        fputs($fp, Render::xmlSitemap(URL.'disc-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
    }
}

$list_song = Song::getStack();
if (!empty($list_song)) {
    foreach($list_song as $item) {
        fputs($fp, Render::xmlSitemap(URL.'chanson-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.7'));
    }
}

$list_contributor = Contributor::getStack();
if (!empty($list_contributor)) {
    foreach($list_contributor as $item) {
        fputs($fp, Render::xmlSitemap(URL.'auteur-compositeur-' . $item['slug'] . '-' . $item['id'], 'monthly', '0.5'));
    }
}

$list_tour = Tour::getStack();
if (!empty($list_tour)) {
    foreach($list_tour as $item) {
        fputs($fp, Render::xmlSitemap(URL.'tournee-tour-' . $item['slug'] . '-' . $item['id'], 'yearly', '0.7'));
    }
}

$list_salles = Salle::getStackArtist();
if (!empty($list_salles)) {
    foreach($list_salles as $item) {
        fputs($fp, Render::xmlSitemap(URL.'salle-concert-'.$mainartistslug.'-'. $item['dpt'] .'-'. $item['id'], 'yearly', '0.5'));
    }
}

fputs($fp, "</urlset>");
fclose($fp);

echo 'Flux mis à jour : <a href="'.URL.'sitemap.xml">'.URL.'sitemap.xml</a>';