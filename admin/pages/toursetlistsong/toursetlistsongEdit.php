<?php
require '../../../boot.php';

$class = TourSetlistSong::class;
if(isset($_REQUEST['id'])) $item = new TourSetlistSong(intval($_REQUEST['id'])); else $item = new TourSetlistSong();
if(isset($_REQUEST['parentid'])) $item->tour_setlist_id = intval($_REQUEST['parentid']);

$list_tour_setlists[0] = '';
$tour_setlists = TourSetlist::getStack('0', 'name ASC');
if (!empty($tour_setlists)) {
    foreach($tour_setlists as $tour_setlist) {
        $list_tour_setlists[$tour_setlist['id']] = $tour_setlist['name'];
    }
}

$list_songs[0] = '';
$songs = Song::getStack('name ASC');
if (!empty($songs)) {
    foreach($songs as $song) {
        $list_songs[$song['id']] = $song['name'];
    }
}
?>
<form id="toursetlistsong_edit_form" method="post" action="pages/toursetlistsong/toursetlistsongSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    <input type="tour_setlist_id" name="tour_setlist_id" value="<?= $item->tour_setlist_id ?>" />

    <h2><?= ($item->id?'Chanson de la setlist : '.TourSetlist::getName($item->tour_setlist_id):$lang->l('new_toursetlistsong')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('disc'); ?> </label><?= Render::select('tour_setlist_id', $list_tour_setlists, $item->tour_setlist_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('song'); ?> </label><?= Render::select('song_id', $list_songs, $item->song_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('track_position'); ?> </label><input type="text" name="track_position" class="w50" value="<?= htmlentities($item->track_position) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('more_infos'); ?> </label><input type="text" name="more_infos" class="w50" value="<?= htmlentities($item->more_infos) ?>" /></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('toursetlist');"/>
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