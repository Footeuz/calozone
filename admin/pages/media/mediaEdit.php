<?php
require '../../../boot.php';

$class = Media::class;
if(isset($_REQUEST['id'])) $item = new Media(intval($_REQUEST['id'])); else $item = new Media();

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

$list_types=array('1'=>'Vidéo','2'=>'Audio');
$list_categories=array('Collaboration'=>'Collaboration','Autre'=>'Autre');
?>
<form id="media_edit_form" method="post" action="pages/media/mediaSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Media : '.$item->title:$lang->l('new_media')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('title'); ?> </label><input type="text" name="title" class="w50" value="<?= htmlentities($item->title) ?>" /></div>
        <div class="w80 flt"><p><?php echo $lang->l('description'); ?> </p><textarea name="description" rows="10" cols="30"><?= htmlentities($item->description) ?></textarea></div>
        <div class="f2"><label><?php echo $lang->l('media'); ?> </label><input type="text" name="media" class="w50" value="<?= htmlentities($item->media) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('path_media'); ?> </label><input type="text" name="path" class="w50" value="<?= htmlentities($item->path) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('media_type'); ?> </label><?= Render::select('type', $list_types, $item->type) ?></div>
        <div class="f2"><label><?php echo $lang->l('category_media'); ?> </label><?= Render::select('category', $list_categories, $item->category) ?></div>
        <div class="f2"><label><?php echo $lang->l('datediff'); ?> </label><input type="text" name="datediff" value="<?php if (!empty($item->datediff)) echo $item->datediff; else echo date('d-m-Y'); ?>" id="datepickerdatediff" /></div>
        <div class="f2"><label><?php echo $lang->l('heurediff'); ?> </label><input type="text" name="heurediff" class="w50" value="<?= htmlentities($item->heurediff) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('date_ajout'); ?> </label><input type="text" name="stampadd" value="<?php if (!empty($item->stampadd)) echo $item->stampadd; else echo date('Y-m-d h:i:s'); ?>" id="datepickerstampadd" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('artist_media'); ?> </label><?= Render::select('artist', $list_artists, $item->artist) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_media'); ?> </label><?= Render::select('albumid', $list_discs, $item->albumid) ?></div>
        <div class="f2"><label><?php echo $lang->l('nb_lancement'); ?> </label><input type="text" name="lancement" disabled class="w50" value="<?= htmlentities($item->lancement) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('nb_vues'); ?> </label><input type="text" name="vues" disabled class="w50" value="<?= htmlentities($item->vues) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>

    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('media');"/>
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
    var fieldstart = document.getElementById('datepickerdatediff');
    var pickerstart = new Pikaday({
        field: document.getElementById('datepickerdatediff'),
        onSelect: function(date) {
            fieldstart.value = pickerstart.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/

    /**** Date picker ****/
    var fieldstart2 = document.getElementById('datepickerstampadd');
    var pickerstart2 = new Pikaday({
        field: document.getElementById('datepickerstampadd'),
        onSelect: function(date) {
            fieldstart.value = pickerstart2.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/
    inittiny();
</script>