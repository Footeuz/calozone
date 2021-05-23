<?php
require '../../../boot.php';

$class = Gig::class;
if(isset($_REQUEST['id'])) $item = new Gig(intval($_REQUEST['id'])); else $item = new Gig();
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

$list_tours = [];
$tours = Tour::getStack();
if (!empty($tours)) {
    foreach($tours as $tour_id => $tour) {
        $list_tours[$tour_id] = $tour['name'];
    }
}

$list_salles = [];
$salles = Salle::getStack();
if (!empty($salles)) {
    foreach($salles as $salle_id => $salle) {
        $list_salles[$salle_id] = strtoupper($salle['country']).$salle['dpt'].' '.$salle['city'].' - '.$salle['name'];
    }
}

$list_medias = [];
$list_medias[0] = 'Aucun média';
$medias = Media::getArtistStack(1);
if (!empty($medias)) {
    foreach($medias as $media_id => $media) {
        $list_medias[$media_id] = $media['datediff'].' '.$media['media'].' '.$media['title'].' ('.$list_types_media[$media['type']].')';
    }
}
?>
<form id="gig_edit_form" method="post" action="pages/gig/gigSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Gig : '.$item->date_start:$lang->l('new_gig')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('artist'); ?> </label><?= Render::select('artist_id', $list_artists, $item->artist_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('tour'); ?> </label><?= Render::select('tour_id', $list_tours, $item->tour_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('salle'); ?> </label><?= Render::select('salle_id', $list_salles, $item->salle_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('more_infos'); ?> </label><input type="text" name="more_infos" class="w50" value="<?= htmlentities($item->more_infos) ?>" /></div>
        <div class="f2 clr "><label><?php echo $lang->l('date_gig'); ?> </label><input type="text" name="date_start" value="<?php if (!empty($item->date_start)) echo date('d-m-Y', $item->date_start); else echo date('d-m-Y'); ?>" id="datepickerdatestart" /></div>
        <div class="f2"><label><?php echo $lang->l('media'); ?> </label><?= Render::select('media_id', $list_medias, $item->media_id) ?></div>
        <div class="f2 clr"><label><?php echo $lang->l('is_concertprive'); ?> </label><?= Render::select('is_cp', $ouinon, $item->is_cp) ?></div>
        <div class="f2"><label><?php echo $lang->l('radio_concertprive'); ?> </label><input type="text" name="radio" class="w50" value="<?= htmlentities($item->radio) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('gig_canceled'); ?> </label><?= Render::select('canceled', $ouinon, $item->canceled) ?></div>
        <div class="f2"><label><?php echo $lang->l('gig_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('gig');"/>
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
    var fieldstart = document.getElementById('datepickerdatestart');
    var pickerstart = new Pikaday({
        field: document.getElementById('datepickerdatestart'),
        onSelect: function(date) {
            fieldstart.value = pickerstart.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/

    inittiny();
</script>