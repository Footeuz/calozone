<?php
require_once 'boot.php';

$id = Request::requestId();
$class = 'disc';
$disc = new Disc($id);
$clips = Clip::getDiscStack($id);
$videos = Media::getDiscStack($id, MEDIATYPEVIDEO);
$audios = Media::getDiscStack($id, MEDIATYPEAUDIO);
$songs = DiscSong::getStackDisc($id);
if (!empty($songs)) {
    foreach ($songs as $discsong) {
        if ($discsong['face'] == '') $discsong['face'] = 0;
        $songsbycd[$discsong['disk_number']][$discsong['face']][] = $discsong;
    }
}

$is_home = false;
$page_title = $list_supports[$disc->support].' de '.$disc->getArtist().' - '.$disc->name;
$page_metadesc = 'Tous les détails sur le '.$list_supports[$disc->support].' de '.$disc->getArtist().' '.$disc->name.' - Chansons, date de sortie, producteur, vidéos promo, clips ...';
$og_url = 'disc-'.$disc->slug.'-'.$id;
$og_image = 'disc-img-'.$disc->slug.'-'.$id.'.jpg';

$og_type = 'music.album';
$og_music_release_date = date('Y-m-d H:i', $disc->date_parution); // datetime - The date the album was released.
$og_music_song = $disc->name;
$og_music_song_disc = 1; // integer >=1 - The same as music:album:disc but in reverse.
$og_music_song_track = sizeof($songs); // integer >=1 - The same as music:album:track but in reverse.
$og_music_musician = ''; // profile - The musician that made this song.

include("header.php");

if ($disc->support == '1') {
    $url = 'discographie';
    $txtretour = 'Retour à la discographie';
} else if ($disc->support == '2') {
    $url = 'singles';
    $txtretour = 'Retour aux singles';
} else if ($disc->support == '3') {
    $url = 'videographie';
    $txtretour = 'Retour à la vidéographie';
} else if ($disc->support == '4') {
    $url = 'vinyles';
    $txtretour = 'Retour aux vinyles';
}
$artist = new Artist($disc->artist);
?>
<div id="disc-details" class="disc">
    <section class="content">
        <div class="wrapper">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="text-center">
                        <a href="<?= (!empty($disc->lnk_fnac)) ? $disc->lnk_fnac : $disc->lnk_amazon ?>" title="Acheter <?= $disc->name.' - '.Artist::getName($disc->artist) ?>" target="_blank"><img src="<?= URL.'disc-img-'.$disc->slug.'-'.$id.'.jpg'; ?>" alt="<?= $disc->name ?>" class="col-8" /></a>
                        <h1 class="fw-bold"><?= $disc->name ?></h1>
                        <p><?= $artist->name ?> <?= (!empty($artist->website)) ? '&nbsp;&nbsp;&nbsp;<a href="'.$artist->website.'" title="'.$artist->name.'" target="_blank">ωωω  &#10148;</a>' : '' ?></p>
                        <p><label>Sortie</label> : <?= date('d.m.Y', $disc->date_parution) ?></p>
                        <p><label>Support</label> : <?= $list_supports[$disc->support] ?></p>
                    </div>
    
                    <h2 class="mt-3">Liens :</h2>
                    <div class="disc-links mt-3">
                        <span class="fw-bold">Ecoutez ou achetez sur :</span>
                        <?php if (!empty($disc->lnk_difymusic)) { ?><a class="lnkbutton" title="Boutique Officielle <?= $mainartist ?>>" target="_blank" href="<?= $disc->lnk_difymusic ?>">Boutique officielle &#10148;</a><?php } ?>
                        <?php if (!empty($disc->lnk_fnac)) { ?><a class="lnkbutton" title="<?= $disc->getArtist() ?> sur Fnac" target="_blank" href="<?= $disc->lnk_fnac ?>">FNAC &#10148;</a><?php } ?>
                        <?php if (!empty($disc->lnk_amazon)) { ?><a class="lnkbutton" title="<?= $disc->getArtist() ?> sur Amazon" target="_blank" href="<?= $disc->lnk_amazon ?>">Amazon &#10148;</a><?php } ?>
                        <?php if (!empty($disc->lnk_deezer)) { ?><a class="lnkbutton" title="<?= $disc->getArtist() ?> sur Deezer" target="_blank" href="<?= $disc->lnk_deezer ?>">Deezer &#10148;</a><?php } ?>
                        <?php if (!empty($disc->lnk_spotify)) { ?><a class="lnkbutton" title="<?= $disc->getArtist() ?> sur Spotify" target="_blank" href="<?= $disc->lnk_spotify ?>">Spotify &#10148;</a><?php } ?>
                        <?php if (!empty($disc->lnk_itunes)) { ?><a class="lnkbutton" title="<?= $disc->getArtist() ?> sur Apple Music" target="_blank" href="<?= $disc->lnk_itunes ?>">Apple Music &#10148;</a><?php } ?>
                    </div>
    
                    <h2 class="mt-3">Détails :</h2>
                    <p><label class="fw-bold">Producteur</label> : <?= $disc->producer ?></p>
                    <div><?= $disc->description ?></div>
    
                    <?php if (!empty($disc->lnk_deezer)) { ?>
                        <?php $dz_album_id = str_replace("https://www.deezer.com/fr/album/", "", $disc->lnk_deezer); ?>
                        <div class="mt-3">
                            <iframe scrolling="no" frameborder="0" allowTransparency="true" src="https://www.deezer.com/plugins/player?format=classic&autoplay=false&playlist=true&width=650&height=350&color=ff0000&layout=&size=medium&type=album&id=<?= $dz_album_id ?>" width="650" height="350"></iframe>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-12 col-lg-6">
                    <?php if (!empty($songsbycd)) { ?>
                        <h2 class="mt-3">Chanson(s) de "<?= $disc->name ?>" :</h2>
                        <?php foreach ($songsbycd as $discnumber => $songsbyface) { ?>
                            <h3>Volume <?= $discnumber ?></h3>
                            <?php foreach ($songsbyface as $facename => $discsongs) { ?>
                                <?php if ($facename != '0') echo '<h4>Face '.$facename.'</h4>'; ?>
                                <ul class="nopoints">
                                    <?php foreach ($discsongs as $discsong) { ?>
                                        <?php
                                        $song = new Song($discsong['song_id']);
                                        $authors = $song->getAuthors();
                                        $composers = $song->getComposers();
                                        ?>
                                        <li class="">
                                            <?= str_pad($discsong['track_position'], 2, "0", STR_PAD_LEFT) ?>. <a href="chanson-<?= $song->slug ?>-<?= $song->id ?>" title="Chanson <?= $song->name ?>"> <?= $song->name ?> </a> <?= (!empty($discsong['version']) ? '('.$discsong['version'].')' : '') ?> &nbsp;&nbsp;&nbsp;&nbsp; <small><strong>🖉</strong>
                                                <?php if (!empty($authors)) {
                                                    foreach($authors as $contributor) {
                                                        echo '<a href="auteur-compositeur-'.$contributor->slug.'-'.$contributor->id.'">'.$contributor->name.'</a>&nbsp;';
                                                    }
                                                }
                                                ?> &nbsp;&nbsp;&nbsp;&nbsp; <strong>♪</strong>
                                                <?php if (!empty($composers)) {
                                                    foreach($composers as $contributor) {
                                                        echo '<a href="auteur-compositeur-'.$contributor->slug.'-'.$contributor->id.'">'.$contributor->name.'</a>&nbsp;';
                                                    }
                                                }
                                                ?></small>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
    
                    <?php if (!empty($clips)) { ?>
                        <h2 class="mt-3">Le(s) clip(s) de l'album <?= $disc->name ?> :</h2>
                        <div class="list_medias">
                        <?php foreach ($clips as $clip_id => $clip) { ?>
                            <a title="Clip <?= $clip['artistname'] ?> <?= $clip['name']; ?>" href="<?= URL.'clip-list' ?>?clip_id=<?= $clip_id ?>"><img src="<?= URL.'clip-img-'.$clip_id ?>.jpg" alt="Clip <?= $clip['artistname'] ?> <?= $clip['name']; ?>" height="70" /></a>
                        <?php } ?>
                        </div>
                    <?php } ?>
    
                    <?php if (!empty($videos)) { ?>
                        <h2 class="mt-3">Les vidéos dans les médias pour la promo de l'album :</h2>
                        <div class="list_medias">
                        <?php foreach ($videos as $media_id => $item) { ?>
                            <?php $media = new Media($item['id']) ?>
                            <a title="<?= Artist::getName($media->artist) ?> - <?= $media->media; ?> - <?= $media->title; ?>" href="<?= $media->getUrl() ?>" target="_blank"><img src="https://www.archivons.com/medias/videos/<?= $item['artistpath'] ?>/<?= str_replace("mp4","jpg",$media->path) ?>" alt="Media <?= Artist::getName($media->artist) ?> <?= $media->title; ?>" height="70" /></a>
                        <?php } ?>
                        </div>
                    <?php } ?>
    
                    <?php if (!empty($audios)) { ?>
                        <h2 class="mt-3">Les émissions de radio pour la promo de l'album :</h2>
                        <ul>
                        <?php foreach ($audios as $media_id => $item) { ?>
                            <?php $media = new Media($item['id']) ?>
                            <li><?= substr($media->datediff,8,2). '.'.substr($media->datediff,5,2). '.'.substr($media->datediff,0,4) ?>
                                <a class="ms-3" title="<?= Artist::getName($media->artist) ?> - <?= $media->media; ?> - <?= $media->title; ?>" href="<?= $media->getUrl() ?>" target="_blank"><?= $media->media; ?> - <?= $media->title; ?>&nbsp;&#10148;</a></li>
                        <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>


    <div class="text-center mt-3">
        <a href="<?= URL.$url; ?>"><button><?= $txtretour ?></button></a>
    </div>
</div>

<?php include("footer.php"); ?>