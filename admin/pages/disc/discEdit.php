<?php
require '../../../boot.php';

$class = Disc::class;
if(isset($_REQUEST['id'])) $item = new Disc(intval($_REQUEST['id']));
else $item = new Disc();
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
?>
<form id="disc_edit_form" method="post" action="pages/disc/discSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Disc : '.$item->name:$lang->l('new_disc')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('artist_disc'); ?> </label><?= Render::select('artist', $list_artists, $item->artist) ?></div>
        <div class="f2"><label><?php echo $lang->l('support_disc'); ?> </label><?= Render::select('support', $list_supports, $item->support) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_producer'); ?> </label><input type="text" name="producer" class="w50" value="<?= htmlentities($item->producer) ?>" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('reference'); ?> </label><input type="text" name="isrc" class="w50" value="<?= htmlentities($item->isrc) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lnk_difymusic'); ?> </label><input type="text" name="lnk_difymusic" class="w50" value="<?= htmlentities($item->lnk_difymusic) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lnk_itunes'); ?> </label><input type="text" name="lnk_itunes" class="w50" value="<?= htmlentities($item->lnk_itunes) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lnk_deezer'); ?> </label><input type="text" name="lnk_deezer" class="w50" value="<?= htmlentities($item->lnk_deezer) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lnk_spotify'); ?> </label><input type="text" name="lnk_spotify" class="w50" value="<?= htmlentities($item->lnk_spotify) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lnk_amazon'); ?> </label><input type="text" name="lnk_amazon" class="w50" value="<?= htmlentities($item->lnk_amazon) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lnk_fnac'); ?> </label><input type="text" name="lnk_fnac" class="w50" value="<?= htmlentities($item->lnk_fnac) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('disc_slug'); ?> </label><input type="text" name="slug" class="w50" value="<?= htmlentities($item->slug) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('disc_type'); ?> </label><?= Render::select('type', $list_types, $item->type) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_main'); ?> </label><?= Render::select('is_main', $list_main, $item->is_main) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_role1'); ?> </label><?= Render::select('role1', $list_roles, $item->role1) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_role2'); ?> </label><?= Render::select('role2', $list_roles, $item->role2) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_role3'); ?> </label><?= Render::select('role3', $list_roles, $item->role3) ?></div>
        <div class="f2"><label><?php echo $lang->l('disc_role4'); ?> </label><?= Render::select('role4', $list_roles, $item->role4) ?></div>
        <div class="f2"></div>
        <div class="w80 flt"><p><?php echo $lang->l('description'); ?> </p><textarea name="description" rows="10" cols="50"><?= htmlentities($item->description) ?></textarea></div>
        <div class="clr f2">
            <div><label><?php echo $lang->l('thumb'); ?></label><input type="file" name="thumb" /><span><?= $lang->l('img_recommanded_size200'); ?></span></div>
        </div>
        <div class="f2">
            <?php
            if ($item->thumb != '') {
                echo '<div class="img_wrapper" id="item_thumb_'.$item->id.'">';
                echo '<img src="'.URL.'disc-thumb-'.$item->slug.'-'.$item->id.'.jpg" alt="" height="150" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteThumb('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>

        <div class="clr f2">
            <div><label><?php echo $lang->l('cover'); ?></label><input type="file" name="cover" /><span><?= $lang->l('img_recommanded_size1000'); ?></span></div>
        </div>
        <div class="f2">
            <?php
            if ($item->cover != '') {
                echo '<div class="img_wrapper" id="item_img_'.$item->id.'">';
                echo '<img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item->id.'" alt="" height="150" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteImg('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>

        <div class="clr f2"><label><?php echo $lang->l('date_parution'); ?> </label><input type="text" name="date_parution" value="<?php if (!empty($item->date_parution)) echo date('d-m-Y', $item->date_parution); else echo date('d-m-Y'); ?>" id="datepickerdateparution" /></div>
        <div class="f2 clr"><label><?php echo $lang->l('disc_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="hidden" value="0" name="imgs_to_delete" id="imgs_to_delete" />
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('disc');"/>
</form>

<?php
if(isset($item->id) && $item->id >0) {
    // Song's list of this disc
    $songs = DiscSong::getStackDisc($item->id);

    $classq = DiscSong::class;
    echo '<h2>'.$lang->l('list_songs').'</h2>';
    if ($songs && sizeof($songs) > 0) {
        echo '<table id="list_song" class="mainlist content_sortcat">';
            echo '<tr>';
                echo '<th class="w5"></th>';
                echo '<th class="w5">'.$lang->l('track_position').'</th>';
                echo '<th class="w20">'.$lang->l('disc_number').'</th>';
                echo '<th class="w15">'.$lang->l('song').'</th>';
                echo '<th class="w15">'.$lang->l('auteur').'</th>';
                echo '<th class="w15">'.$lang->l('compositeur').'</th>';
                echo '<th></th>';
            echo '</tr>';
        echo '</table>';

        echo '<ul id="sortable-songs" class="sortable list">';
        foreach ($songs as $song_id => $itemq) {
            $songitem = new Song($itemq['song_id']);
            echo '<li id="'.$itemq['id'].'">';
                echo '<table>';
                    echo '<tr class="">';
                        echo '<td class="w5 text-center "><span class="handle">::</span></td>';
                        echo '<td class="w5">'.$itemq['track_position'].'</td>';
                        echo '<td class="w20">'.$itemq['disk_number'].'</td>';
                        echo '<td class="w15">'.$songitem->name.'</td>';
                        echo '<td class="w15">'.$songitem->auteur.'</td>';
                        echo '<td class="w15">'.$songitem->compositeur.'</td>';
                        echo '<td>';
                            echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($classq).'\', ' . $itemq['id'] . ', null, '.$item->id.');"></a>';
                            echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($classq).'\', ' . $itemq['id'] . ', \'' . str_replace("'", "\'", Song::getName($itemq['song_id'])) . '\');"></a>';
                        echo '</td>';
                    echo '</tr>';
                echo '</table>';
            echo '</li>';
        }
        echo '</ul>';
    }
    echo '<p><a class="btn withtxt" href="javascript:edit(\''.strtolower($classq).'\', 0, null, '.$item->id.');"><span class="icon_btn add_btn"></span>'.$lang->l('add_song').'</a></p>';
}
?>

<script>
    inittiny();

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
</script>