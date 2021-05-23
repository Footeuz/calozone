<!DOCTYPE html>
<html>
<head>
    <title>Zone <?= $mainartist ?> ♫ <?= addslashes($page_title) ?></title>
    <meta charset="UTF-8" />
    <meta name="description" content="<?= addslashes($page_metadesc) ?> ♪" />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta property="og:title" content="Zone <?= $mainartist ?> ♫ <?= addslashes($page_title) ?>" />
    <meta property="og:type" content="<?= (isset($og_type)&&!empty($og_type)) ? $og_type : 'website' ?>" />
    <meta property="og:url" content="<?= (isset($og_url)&&!empty($og_url)) ? URL.$og_url : URL ?>" />
    <meta property="og:description" content="<?= (isset($page_metadesc)&&!empty($page_metadesc)) ? addslashes($page_metadesc) : '' ?>" />
    <?php if (isset($og_image) && !empty($og_image)) { ?><meta property="og:image" content="<?= URL.$og_image ?>" /><?php } ?>
    <?php if (isset($og_music_release_date) && !empty($og_music_release_date)) { ?><meta property="og:music:release_date" content="<?= $og_music_release_date ?>" /><?php } ?>
    <?php if (isset($og_music_song) && !empty($og_music_song)) { ?><meta property="og:music:song" content="<?= $og_music_song ?>" /><?php } ?>
    <?php if (isset($og_music_song_disc) && !empty($og_music_song_disc)) { ?><meta property="og:music:song:disc" content="<?= $og_music_song_disc ?>" /><?php } ?>
    <?php if (isset($og_music_song_track) && !empty($og_music_song_track)) { ?><meta property="og:music:song:track" content="<?= $og_music_song_track ?>" /><?php } ?>
    <?php if (isset($og_music_musician) && !empty($og_music_musician)) { ?><meta property="og:music:musician" content="<?= $og_music_musician ?>" /><?php } ?>

    <?php if (!empty($og_url)) { ?><link rel="canonical" href="<?= URL.$og_url ?>" /><?php } ?>
    <link rel="icon" type="image/png" href="<?= URL_IMG ?>favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link href="<?= URL_PUBLIC ?>css/main.css" rel="stylesheet" />
    <link href="<?= URL_PUBLIC ?>css/timeline.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Questrial|Raleway" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Covered+By+Your+Grace" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lobster+Two:400" rel="stylesheet" />
    <?php if (!empty($css)) { foreach ($css as $urlcss) { ?><link rel="stylesheet" type="text/css" href="<?= (substr($urlcss, 0, 4) == "http") ? $urlcss : URL_PUBLIC.$urlcss ?>" /><?php } } ?>
    <script src="<?= URL_PUBLIC ?>js/site.js"></script>
    <script src="<?= URL_PUBLIC ?>js/utils.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>

<body>
    <div id="<?= ($is_home) ? 'home' : 'not-home' ?> m-0">
        <header class="fixed-top">
            <div id="headerdiv" class="row mx-auto">
                <div class="col-1 text-center d-none d-sm-block headerico">🖝</div>
                <div class="col-12 col-sm-10">
                    <div class="m-0 p-0 pr-3">
                        <div class="logosite float-left d-inline-block text-center">
                            <a class="align-items-center m-0 p-0" href="<?= URL ?>index.php"><img class="m-0 pt-sm-2 pt-0 pl-3 ps-sm-3" src="<?= URL_IMG ?>logo-zone.png" alt="Logo site <?= $mainartist ?>"/></a>
                            <p class="slogan">Zone d'informations sur la carrière de <?= $mainartist ?></p>
                        </div>
                        <nav class="navbar navbar-expand-xxl navbar-dark ml-3 float-left d-inline-block align-top">
                            <div class="container-fluid">
                                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="navbar-collapse collapse align-content-end" id="navbarSupportedContent" style="">
                                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-0 mt-2">
                                        <li class="nav-item"><a class="nav-link fw-bold" href="<?= URL . 'podcast-list' ?>"><?= PODCAST_TITLE ?></a></li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Concerts
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="<?= URL . 'tournees-'.$mainartistslug ?>">Tournées</a></li>
                                                <li><a class="dropdown-item" href="<?= URL . 'salles-concerts-'.$mainartistslug ?>">Salles de concerts</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Discographie
                                            </a>
                                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <li><a class="dropdown-item" href="<?= URL . 'discographie' ?>">Discographie CD</a></li>
                                                <li><a class="dropdown-item" href="<?= URL . 'vinyles' ?>">Discographie Vinyles</a></li>
                                                <li><a class="dropdown-item" href="<?= URL . 'singles' ?>">Discographie Singles</a></li>
                                                <li><a class="dropdown-item" href="<?= URL . 'videographie' ?>">Vidéographie</a></li>
                                            </ul>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" href="<?= URL . 'chansons-'.$mainartistslug ?>">Chansons</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= URL . 'clip-list' ?>">Clips</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= URL . 'media-list' ?>">Archives médias</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= URL . 'recompenses' ?>">Récompenses</a></li>
                                        <li class="nav-item"><a class="nav-link" href="<?= URL . 'photos' ?>">Photos</a></li>
                                        <!--<li class="nav-item"><a class="nav-link" href="<?= URL . 'calendrier-avent-2019' ?>">Calendrier de l'avent Calogero</a></li>-->
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-1 text-center d-none d-sm-block headerico">🖜</div>
            </div>
        </header>
        <div id="main" class="w-100">
            <section class="section intro">
                <div class="container">
                    <h1>↘ <?= $page_title ?> ↙</h1>
                </div>
            </section>
