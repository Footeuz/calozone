<?php
require '../../../boot.php';

$class = Salle::class;
if(isset($_REQUEST['id'])) $item = new Salle(intval($_REQUEST['id'])); else $item = new Salle();
$resRes = SQL::select(UserAdmin::TBNAME, [], ['id', 'name'], 'name');

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}
?>
<form id="salle_edit_form" method="post" action="pages/salle/salleSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?'Salle : '.$item->name:$lang->l('new_salle')) ?></h2>
    <fieldset>
        <div class="f2 clr"><label><?php echo $lang->l('name'); ?> </label><input type="text" name="name" class="w50" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('city'); ?> </label><input type="text" name="city" value="<?= htmlentities($item->city) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('dpt'); ?> </label><input type="text" name="dpt" value="<?= htmlentities($item->dpt) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('address'); ?> </label><input type="text" name="address" value="<?= htmlentities($item->address) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('metro'); ?> </label><input type="text" name="metro" value="<?= htmlentities($item->metro) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('cp'); ?> </label><input type="text" name="cp" value="<?= htmlentities($item->cp) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('region'); ?> </label><input type="text" name="region" value="<?= htmlentities($item->region) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('country'); ?> </label><input type="text" name="country" value="<?= htmlentities($item->country) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('ardt'); ?> </label><input type="text" name="ardt" value="<?= htmlentities($item->ardt) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('tel'); ?> </label><input type="text" name="tel" value="<?= htmlentities($item->tel) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('tel2'); ?> </label><input type="text" name="tel2" value="<?= htmlentities($item->tel2) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('mail'); ?> </label><input type="text" name="mail" value="<?= htmlentities($item->mail) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('fax'); ?> </label><input type="text" name="fax" value="<?= htmlentities($item->fax) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('type'); ?> </label><input type="text" name="type" value="<?= htmlentities($item->type) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('places'); ?> </label><input type="text" name="places" value="<?= htmlentities($item->places) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('contact1'); ?> </label><input type="text" name="contact1" value="<?= htmlentities($item->contact1) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('fonction1'); ?> </label><input type="text" name="fonction1" value="<?= htmlentities($item->fonction1) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('tel1'); ?> </label><input type="text" name="tel1" value="<?= htmlentities($item->tel1) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('mail1'); ?> </label><input type="text" name="mail1" value="<?= htmlentities($item->mail1) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('date_festival'); ?> </label><input type="text" name="date_festival" value="<?= htmlentities($item->date_festival) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('code_fnac'); ?> </label><input type="text" name="code_fnac" value="<?= htmlentities($item->code_fnac) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lat'); ?> </label><input type="text" name="lat" value="<?= htmlentities($item->lat) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('lng'); ?> </label><input type="text" name="lng" value="<?= htmlentities($item->lng) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('style'); ?> </label><input type="text" name="style" value="<?= htmlentities($item->style) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('date_festival2'); ?> </label><input type="text" name="date_festival2" value="<?= htmlentities($item->date_festival2) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('website'); ?> </label><input type="text" name="website" value="<?= htmlentities($item->website) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('salle_active'); ?> </label><?= Render::select('active', $ouinon, $item->active) ?></div>
    </fieldset>
    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('salle');"/>
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