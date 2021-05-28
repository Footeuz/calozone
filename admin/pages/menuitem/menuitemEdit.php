<?php
require '../../../boot.php';

$class = MenuItem::class;
if(isset($_REQUEST['id'])) $item = new MenuItem(intval($_REQUEST['id'])); else $item = new MenuItem();
if(isset($_REQUEST['parentid'])) $item->menu_id = intval($_REQUEST['parentid']);

if($item->position == 0) {
    $resRes = SQL::select(MenuItem::TBNAME, ['menu_id'=>$item->menu_id], ['position'], 'position DESC');
    if ($resRes && $resRes->num_rows>0) {
        $lastPosition = $resRes->fetch_object()->position;
        $item->position = $lastPosition + 1;
    }
}

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
    $user = new UserAdmin($_SESSION['user_id']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else $user = null;

$list_menuitems[0] = '';
$menuitems = MenuItem::getStackMenu($item->menu_id);
if (!empty($menuitems)) {
    foreach($menuitems as $menuitem_id => $menuitem) {
        if ($item->id > 0 && $item->id != $menuitem_id)
            $list_menuitems[$menuitem_id] = $menuitem['name'];
    }
}
sat($item->menu_id);
?>
<form id="menuitem_edit_form" method="post" action="pages/menuitem/menuitemSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    <input type="hidden" name="menu_id" id="menu_id" value="<?= $item->menu_id ?>" />

    <h2><?= ($item->id?$item->name:$lang->l('new_menu_item')) ?></h2>
    <fieldset>
        <div class="clr f2"><label><?php echo $lang->l('name'); ?> *</label><input type="text" name="name" value="<?= htmlentities($item->name) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('link_blank'); ?> </label><?= Render::select('blank', $ouinon, $item->blank) ?></div>
        <div class="f2"><label><?php echo $lang->l('position'); ?> *</label><input type="text" name="position" value="<?= htmlentities($item->position) ?>" /></div>
        <div class="f2"><label><?php echo $lang->l('parent_menuitem'); ?> </label><?= Render::select('parent_id', $list_menuitems, $item->parent_id) ?></div>
        <div class="f2"><label><?php echo $lang->l('link_url'); ?> </label><input type="text" name="link_url" value="<?= htmlentities($item->link_url) ?>" /></div>

        <p class="clr">* <?php echo $lang->l('needed_fields') ?></p>
    </fieldset>

    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('menu_item');"/>
</form>

<script>controlsave('<?= strtolower($class) ?>');inittiny();</script>