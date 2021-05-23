<?php
require '../../../boot.php';

$class = DiscSong::class;
if(isset($_REQUEST['id'])) $item = new DiscSong(intval($_REQUEST['id'])); else $item = new DiscSong();
if(isset($_REQUEST['parentid'])) $item->disc_id = intval($_REQUEST['parentid']);

$list_discs[0] = '';
$discs = Disc::getStack('0', 'name ASC');
if (!empty($discs)) {
    foreach($discs as $disc) {
        $list_discs[$disc['id']] = $disc['name'];
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
<form id="discsong_edit_form" method="post" action="pages/discsong/discsongSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    <input type="hidden" name="disc_id" value="<?= $item->disc_id ?>" />

    <h2><?= ($item->id?'Chanson du disque : '.Disc::getName($item->disc_id):$lang->l('new_discsong')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('disc'); ?> </label><?= Render::select('disc_id', $list_discs, $item->disc_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('song'); ?> </label><?= Render::select('song_id', $list_songs, $item->song_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('disk_number'); ?> </label><input type="text" name="disk_number" class="w50" value="<?= htmlentities($item->disk_number) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('track_position'); ?> </label><input type="text" name="track_position" class="w50" value="<?= htmlentities($item->track_position) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('track_face'); ?> </label><input type="text" name="face" class="w50" value="<?= htmlentities($item->face) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('song_version'); ?> </label><input type="text" name="version" class="w50" value="<?= htmlentities($item->version) ?>" /></div>
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