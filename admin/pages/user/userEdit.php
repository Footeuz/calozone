<?php

require '../../../boot.php';

$class = User::class;
if(isset($_REQUEST['id']))
    $item = new User(intval($_REQUEST['id']));
else
    $item = new User();

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else $user = null;

if(isset($_REQUEST['parentid'])) $item->mailing_id = intval($_REQUEST['parentid']);
?>
<form id="user_edit_form" enctype="multipart/form-data" method="post" action="pages/user/userSave.php">
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?$item->getName($item->id):$lang->l('new_user')) ?></h2>
    <fieldset>
        <div><label><?php echo $lang->l('code'); ?></label><input type="text" name="code" value="<?= htmlentities($item->code) ?>" /></div>
        <div><label><?php echo $lang->l('email'); ?></label><input type="text" name="email" value="<?= htmlentities($item->email) ?>" /></div>
        <div><label><?php echo $lang->l('mailing_id'); ?></label><input type="text" name="mailing_id" value="<?= htmlentities($item->mailing_id) ?>" /></div>
        <div><label><?php echo $lang->l('firstname'); ?></label><input type="text" name="firstname" value="<?= htmlentities($item->firstname) ?>" /></div>
        <div><label><?php echo $lang->l('lastname'); ?></label><input type="text" name="lastname" value="<?= htmlentities($item->lastname) ?>" /></div>
        <div><label><?php echo $lang->l('dep'); ?></label><input type="text" name="dep" value="<?= htmlentities($item->dep) ?>" /></div>
        <div><label><?php echo $lang->l('genre'); ?></label><input type="text" name="genre" value="<?= htmlentities($item->genre) ?>" /></div>
        <div><label><?php echo $lang->l('age'); ?></label><input type="text" name="age" value="<?= htmlentities($item->age) ?>" /></div>
    </fieldset>

    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('user');"/>
</form>

<script>
    /**** Save form with keyboard : ctrl+s ****/
    var isCtrl = false;
    document.onkeyup=function(e){
        if(e.keyCode == 17) isCtrl=false;
    }
    document.onkeydown=function(e){
        if(e.keyCode == 17) isCtrl=true;
        if(e.keyCode == 83 && isCtrl == true) return save('<?= strtolower($class) ?>', 0);
    }
    /**** End Save form with keyboard : ctrl+s ****/
</script>