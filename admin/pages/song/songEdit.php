<?php
require '../../../boot.php';

$class = Song::class;
if(isset($_REQUEST['id'])) $item = new Song(intval($_REQUEST['id']));
else $item = new Song();
$resRes = SQL::select(UserAdmin::TBNAME, [], ['id', 'name'], 'name');
$songcontributors = SongContributor::getStackSong($item->id);
$composer1 = (isset($songcontributors[SongContributor::R_COMPOSER][0])) ? $songcontributors[SongContributor::R_COMPOSER][0]['contributor_id']:0;
$composer2 = (isset($songcontributors[SongContributor::R_COMPOSER][1])) ? $songcontributors[SongContributor::R_COMPOSER][1]['contributor_id']:0;
$composer3 = (isset($songcontributors[SongContributor::R_COMPOSER][2])) ? $songcontributors[SongContributor::R_COMPOSER][2]['contributor_id']:0;
$author1 = (isset($songcontributors[SongContributor::R_AUTHOR][0])) ? $songcontributors[SongContributor::R_AUTHOR][0]['contributor_id']:0;
$author2 = (isset($songcontributors[SongContributor::R_AUTHOR][1])) ? $songcontributors[SongContributor::R_AUTHOR][1]['contributor_id']:0;
$author3 = (isset($songcontributors[SongContributor::R_AUTHOR][2])) ? $songcontributors[SongContributor::R_AUTHOR][2]['contributor_id']:0;

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}

$list_artists[0] = '';
$artists = Artist::getStack();
if (!empty($artists)) {
    foreach($artists as $artist_id => $artist) {
        $list_artists[$artist_id] = $artist['name'];
    }
}

$list_contributors[0] = '';
$contributors = Contributor::getStack('1');
if (!empty($contributors)) {
    foreach($contributors as $contributor_id => $contributor) {
        $list_contributors[$contributor_id] = $contributor['name'];
    }
}
?>
<form id="song_edit_form" method="post" action="pages/song/songSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Song : '.$item->name:$lang->l('new_song')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('song_slug'); ?> </label><input type="text" name="slug" class="w50" value="<?= htmlentities($item->slug) ?>" /></div>
        <div class=""><label><?php echo $lang->l('auteurs'); ?> </label><?= Render::select('author_id[1]', $list_contributors, $author1) ?>  <?= Render::select('author_id[2]', $list_contributors, $author2) ?>  <?= Render::select('author_id[3]', $list_contributors, $author3) ?></div>
        <div class="clr"><label><?php echo $lang->l('compositeurs'); ?> </label><?= Render::select('composer_id[1]', $list_contributors, $composer1) ?> <?= Render::select('composer_id[2]', $list_contributors, $composer2) ?>  <?= Render::select('composer_id[3]', $list_contributors, $composer3) ?></div>
        <div class="f2 clr"><label><?php echo $lang->l('is_cover'); ?> </label><?= Render::select('is_cover', $ouinon, $item->is_cover) ?></div>
        <div class="f2"><label><?php echo $lang->l('cover_artist'); ?> </label><?= Render::select('cover_artist_id', $list_artists, $item->cover_artist_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('interprete_artist'); ?> </label><?= Render::select('artist_id', $list_artists, $item->artist_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('more_infos'); ?> </label><input type="text" name="details" class="w50" value="<?= htmlentities($item->details) ?>" /></div>
        <div class="w80 flt"><p><?php echo $lang->l('lyrics'); ?> </p><textarea name="lyrics" rows="10" cols="50"><?= htmlentities($item->lyrics) ?></textarea></div>
        <div class="f2 clr"><label><?php echo $lang->l('song_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('song');"/>
</form>
<script>
    var isCtrl = false;
    document.onkeyup=function(e){
        if(e.keyCode == 17) isCtrl=false;
    }
    document.onkeydown=function(e){
        if(e.keyCode == 17) isCtrl=true;
        if(e.keyCode == 83 && isCtrl == true) {
            return save('<?= strtolower($class) ?>', 0);
        }
    }

    inittiny();
</script>