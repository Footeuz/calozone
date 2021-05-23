<?php
require '../../../boot.php';

$class = Clip::class;
if(isset($_REQUEST['id'])) $item = new Clip(intval($_REQUEST['id']));
else $item = new Clip();
$resRes = UserAdmin::getStack();
$admins = [];
if ($resRes) {
    foreach($resRes as $admin) {
        $admins[$admin['id']] = $admin['name'];
    }
}

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}
$default_admin_id = (isset($_REQUEST['id'])) ? $item->admin_id : $user->id;

$list_artists = [];
$artists = Artist::getStack();
if (!empty($artists)) {
    foreach($artists as $artist_id => $artist) {
        $list_artists[$artist_id] = $artist['name'];
    }
}

$list_discs[0] = '';
$resRes = SQL::select(Disc::TBNAME, ['active'=>1], ['id', 'name'], 'name');
while ($disc = $resRes->fetch_assoc()) {
    $list_discs[$disc['id']] = $disc['name'];
}

$list_songs[0] = '';
$resRes = SQL::select(Song::TBNAME, ['active'=>1], ['id', 'name'], 'name');
while ($song = $resRes->fetch_assoc()) {
    $list_songs[$song['id']] = $song['name'];
}
?>
<form id="clip_edit_form" method="post" action="pages/clip/clipSave.php">

    <input type="hidden" name="id" value="<?= $item->id ?>" />

    <h2><?= ($item->id?'Clip : '.$item->name:$lang->l('new_clip')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w65" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('path_clip'); ?> </label><input type="text" name="path" class="w65" value="<?= htmlentities($item->path) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('realisateur'); ?> </label><input type="text" name="realisateur" class="w65" value="<?= htmlentities($item->realisateur) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('artist_clip'); ?> </label><?= Render::select('artist_id', $list_artists, $item->artist_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_clip'); ?> </label><?= Render::select('disc_id', $list_discs, $item->disc_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('song_clip'); ?> </label><?= Render::select('song_id', $list_songs, $item->song_id) ?></div>
        <div class="f2 clr"><label><?php echo $lang->l('type_clip'); ?> </label><?= Render::select('type', array('solo'=>'solo','duo'=>'duo','groupe'=>'groupe','participation'=>'participation','cover'=>'cover'), $item->type) ?></div>
        <div class="f2"><label><?php echo $lang->l('complement_type'); ?> </label><input type="text" name="complement_type" class="w65" value="<?= htmlentities($item->complement_type) ?>" /></div>
        <div class="w80 flt"><p><?php echo $lang->l('description'); ?> </p><textarea name="description" rows="10" cols="50"><?= htmlentities($item->description) ?></textarea></div>
        <div class="clr f2">
            <div><label><?php echo $lang->l('thumb'); ?></label><input type="file" name="thumb" /><span><?= $lang->l('img_recommanded_size'); ?></span></div>
        </div>
        <div class="f2">
            <?php
            if ($item->thumb != '') {
                echo '<div class="img_wrapper" id="item_img_'.$item->id.'">';
                echo '<img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item->id.'" alt="" height="150" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteImg('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>

        <div class="clr f2"><label><?php echo $lang->l('date_parution'); ?> </label><input type="text" name="date_parution" value="<?php if (!empty($item->date_parution)) echo date('d-m-Y', $item->date_parution); else echo date('d-m-Y'); ?>" id="datepickerdateparution" /></div>
        <div class="f2"><label><?php echo $lang->l('admin'); ?></label><?= Render::select('admin_id', $admins, $default_admin_id) ?></div>
        <div class="f2 clr"><label><?php echo $lang->l('clip_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="hidden" value="0" name="imgs_to_delete" id="imgs_to_delete" />
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('clip');"/>
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

    /**** Date picker ****/
    var fieldstart = document.getElementById('datepickerdateparution');
    var pickerstart = new Pikaday({
        field: document.getElementById('datepickerdateparution'),
        onSelect: function(date) {
            fieldstart.value = pickerstart.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/

    inittiny();
</script>