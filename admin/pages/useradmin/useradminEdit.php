<?php
require '../../../boot.php';

$class = UserAdmin::class;
if(isset($_REQUEST['id'])) $item = new UserAdmin(intval($_REQUEST['id']));
else $item = new UserAdmin();
$resRes = SQL::select(ClientTheme::TBNAME, [], ['id', 'name'], 'name');
?>
<form id="useradmin_edit_form" method="post" action="pages/useradmin/useradminSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?$item->login:$lang->l('new_user')) ?></h2>
    <fieldset>
        <div class="f2"><label><?php echo $lang->l('login'); ?> </label><input type="text" name="login" value="<?= htmlentities($item->login) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('password'); ?> </label><input type="password" name="password" value="" <?= ($item->id?'placeholder="laisser vide pour ne pas modifier"':'') ?> /></div>
        <div class="f2"><label><?php echo $lang->l('email'); ?> </label><input type="text" name="email" value="<?= htmlentities($item->email) ?>" /></div>
        <div class=""><label><?php echo $lang->l('status'); ?> </label>
            <?=
            Render::select('status',  array(UserAdmin::S_ADMIN => $lang->l('administrator'),  UserAdmin::S_SUPERADMIN => $lang->l('super_admin'),  UserAdmin::S_CUSTOMER => $lang->l('customer')), $item->status)
            ?>
        </div>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('url'); ?> </label><input type="text" name="url" value="<?= htmlentities($item->url) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('date_start_subscription'); ?> </label><input type="text" name="subscription_stamp_start" value="<?php if (!empty($item->subscription_stamp_start)) echo date('d-m-Y', $item->subscription_stamp_start); else echo date('d-m-Y'); ?>" id="datepickersubstart" /></div>
        <div class="f2"><label><?php echo $lang->l('date_end_subscription'); ?></label><input type="text" name="subscription_stamp_end" value="<?php if (!empty($item->subscription_stamp_end)) echo date('d-m-Y', $item->subscription_stamp_end); else echo date('d-m-Y'); ?>" id="datepickersubend" /></div>
        <div class="f2"><label><?php echo $lang->l('client_theme'); ?></label><?= Render::select('client_theme_id', $resRes, $item->client_theme_id) ?></div>

        <div class="f2">
            <div><label><?php echo $lang->l('client_logo'); ?></label><input type="file" name="client_logo" /><span><?= $lang->l('img_recommanded_size'); ?></span></div>
            <div class="clr">&nbsp;</div>
            <?php
            if ($item->client_logo != '') {
                echo '<div class="img_wrapper" id="item_img_'.$item->id.'">';
                echo '<img src="'.URL.'utils/get_img.php?type='.strtolower($class).'&id='.$item->id.'" alt="" height="50" />';
                echo '<br/><a class="icon_btn delete_btn" onclick="javascript:itemDeleteImg('.$item->id.')" ></a> ';
                echo '</div>';
            }
            ?>
        </div>
    </fieldset>
    <input type="hidden" value="0" name="imgs_to_delete" id="imgs_to_delete" />
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('useradmin');"/>
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
    var fieldstart = document.getElementById('datepickersubstart');
    var pickerstart = new Pikaday({
        field: document.getElementById('datepickersubstart'),
        onSelect: function(date) {
            fieldstart.value = pickerstart.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });

    var fieldend = document.getElementById('datepickersubend');
    var pickerend = new Pikaday({
        field: document.getElementById('datepickersubend'),
        onSelect: function(date) {
            fieldend.value = pickerend.getDateFormatted();
        },
        showDaysInNextAndPreviousMonths:true
    });
    /**** End Date picker ****/
</script>