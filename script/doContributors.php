<?php
require '../boot.php';

$contributor_id = 0;
$songs = Song::getStack();
if (!empty($songs)) {
    foreach($songs as $song) {
        if (!empty($song['compositeur'])) {

            $composers = explode(",", trim($song['compositeur']));
            if (!empty($composers)) {
                foreach($composers as $composer) {
                    $exist = Contributor::checkExist(trim($composer));
                    if ($exist) {
                        $contributor_id = $exist;
                    } else {
                        $contributor = new Contributor();
                        $contributor->name = trim($composer);
                        $contributor->save();
                        $contributor_id = $contributor->id;
                    }

                    $assoc = new SongContributor();
                    $assoc->song_id = $song['id'];
                    $assoc->contributor_id = $contributor_id;
                    $assoc->role = SongContributor::R_COMPOSER;
                    $exec = $assoc->save();
                    if($exec) echo 'Add ok for '.$composer.' to '.$song['name'].'<br/>'; else echo $lang->l('save_ko');
                }
            }
        }
        unset($composers);

        if (!empty($song['auteur'])) {
            $composers = explode(",", trim($song['auteur']));
            if (!empty($composers)) {
                foreach($composers as $composer) {
                    $exist = Contributor::checkExist(trim($composer));
                    if ($exist) {
                        $contributor_id = $exist;
                    } else {
                        $contributor = new Contributor();
                        $contributor->name = trim($composer);
                        $contributor->save();
                        $contributor_id = $contributor->id;
                    }

                    $assoc = new SongContributor();
                    $assoc->song_id = $song['id'];
                    $assoc->contributor_id = $contributor_id;
                    $assoc->role = SongContributor::R_AUTHOR;
                    $exec = $assoc->save();
                    if($exec) echo 'Add ok for '.$composer.' to '.$song['name'].'<br/>'; else echo $lang->l('save_ko');
                }
            }
        }
        unset($composers);
    }
}

