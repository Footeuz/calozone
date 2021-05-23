<?php
require '../../../boot.php';

$class = Tour::class;
if(isset($_REQUEST['id'])) $item = new Tour(intval($_REQUEST['id'])); else $item = new Tour();
$resRes = SQL::select(UserAdmin::TBNAME, [], ['id', 'name'], 'name');

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}

$list_artists = [];
$artists = Artist::getStack();
if (!empty($artists)) {
    foreach($artists as $artist_id => $artist) {
        $list_artists[$artist_id] = $artist['name'];
    }
}

$list_discs = [];
$discs = Disc::getStack(1, 'name ASC');
if (!empty($discs)) {
    foreach($discs as $disc_id => $disc) {
        $list_discs[$disc_id] = $disc['name'];
    }
}
?>
<form id="tour_edit_form" method="post" action="pages/tour/tourSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Tour : '.$item->name:$lang->l('new_tour')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('slug'); ?> </label><input type="text" name="slug" class="w50" value="<?= htmlentities($item->slug) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('artist'); ?> </label><?= Render::select('artist_id', $list_artists, $item->artist_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc'); ?> </label><?= Render::select('disc_id', $list_discs, $item->disc_id) ?></div>
        <div class="w80 flt"><p><?php echo $lang->l('more_infos'); ?> </p><textarea name="more_infos" rows="10" cols="50"><?= htmlentities($item->more_infos) ?></textarea></div>
        <div class="f2"><label><?php echo $lang->l('tour_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    
        <div class="clr f2">
            <div><label><?php echo $lang->l('img'); ?></label><input type="file" name="img" /><span><?= $lang->l('img_recommanded_size1000'); ?></span></div>
        </div>
        <div class="f2">
            <?php
            if ($item->img != '') {
                echo '<div class="img_wrapper" id="item_img_'.$item->id.'">';
                echo '<img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item->id.'" alt="" height="150" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteImg('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('tour');"/>
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