<?php
require '../../../boot.php';

$class = Podcast::class;
if(isset($_REQUEST['id'])) $item = new Podcast(intval($_REQUEST['id'])); else $item = new Podcast();
$resRes = SQL::select(UserAdmin::TBNAME, [], ['id', 'name'], 'name');

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}

$default_admin_id = (isset($_REQUEST['id'])) ? $item->admin_id : $user->id;
?>
<form id="podcast_edit_form" method="post" action="pages/podcast/podcastSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Podcast : '.$item->name:$lang->l('new_podcast')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('episode_number'); ?> </label><input type="text" name="episode" value="<?= $item->episode ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w65" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('participants'); ?> </label><input type="text" name="participants" value="<?= htmlentities($item->participants) ?>" /></div>
        <div class="w80 clr"><p><?php echo $lang->l('description'); ?> </p><textarea name="description" rows="10" cols="50"><?= htmlentities($item->description) ?></textarea></div>
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
        <div class="clr f2">
            <div><label><?php echo $lang->l('social_img'); ?></label><input type="file" name="socialimg" /><span><?= $lang->l('img_recommanded_size'); ?></span></div>
        </div>
        <div class="f2">
            <?php
            if ($item->socialimg != '') {
                echo '<div class="img_wrapper" id="item_socialimg_'.$item->id.'">';
                echo '<img src="'.URL.'utils/get_img.php?type=social'.strtolower($class).'&id='.$item->id.'" alt="" height="150" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteImg('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>
        <div class="clr f2">
            <div><label><?php echo $lang->l('audio'); ?></label><input type="file" name="upload_podcast" /><span>MP3 (sans espaces et accents)</span></div>
        </div>
        <div class="f2"><?php if (!empty($item->path)) { echo '<audio controls><source src="'.URL.$item->path.'" type="audio/mpeg">Your browser does not support the audio element.</audio>'; }  ?></div>
        <div class="f2"><label><?php echo $lang->l('podcast_duration'); ?> </label><input type="text" name="duration" value="<?= htmlentities($item->duration) ?>" /> (format : 00:00:00)</div>
        <div class="f3 clr"><label><?php echo $lang->l('nb_listen'); ?> </label><input type="text" name="nb_listen" disabled value="<?= $item->nb_listen ?>" /></div>
        <div class="f3"><label><?php echo $lang->l('nb_ended'); ?> </label><input type="text" name="nb_ended" disabled value="<?= $item->nb_ended ?>" /></div>
        <div class="f3"><label><?php echo $lang->l('nb_download'); ?> </label><input type="text" name="nb_listen" disabled value="<?= $item->nb_download ?>" /></div>

        <div class="clr f2"><label><?php echo $lang->l('date_add'); ?> </label><input type="text" name="date_add" value="<?php if (!empty($item->date_add)) echo date('d-m-Y', $item->date_add); else echo date('d-m-Y'); ?>" id="datepickerdateadd" /> <input type="time" name="heure_add" value="<?php if (!empty($item->date_add)) echo date('H:i', $item->date_add).':00'; else echo date('H:i:s'); ?>" /> </div>
        <div class="f2"><label><?php echo $lang->l('admin'); ?></label><?= Render::select('admin_id', $resRes, $default_admin_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('podcast_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="hidden" value="0" name="imgs_to_delete" id="imgs_to_delete" />
    <input type="hidden" value="0" name="imgs_social_to_delete" id="imgs_social_to_delete" />
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('podcast');"/>
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
    var fieldstart = document.getElementById('datepickerdateadd');
    var pickerstart = new Pikaday({
        field: document.getElementById('datepickerdateadd'),
        onSelect: function(date) {
            fieldstart.value = pickerstart.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/

    inittiny();
</script>