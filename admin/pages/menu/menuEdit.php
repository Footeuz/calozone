<?php
require '../../../boot.php';

$class = Menu::class;
if(isset($_REQUEST['id'])) $item = new Menu(intval($_REQUEST['id'])); else $item = new Menu();

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
    $user = new UserAdmin($_SESSION['user_id']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else $user = null;
?>
<form id="menu_edit_form" method="post" action="pages/menu/menuSave.php">
    
    <input type="hidden" name="id" value="<?= $item->id ?>" />
    
    <h2><?= ($item->id?$item->name:$lang->l('new_menu')) ?></h2>
    <fieldset>
        <div class=""><label><?php echo $lang->l('name'); ?> *</label><input type="text" name="name" value="<?= htmlentities($item->name) ?>" /></div>
        <p>* <?php echo $lang->l('needed_fields') ?></p>
    </fieldset>

    <input type="submit" value="<?php echo $lang->l('save'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 0);return false;" />
    <input type="submit" value="<?php echo $lang->l('save_quit'); ?>" class="mtop" onclick="return save('<?= strtolower($class) ?>', 1);return false;" />
    <input type="button" value="<?php echo $lang->l('cancel');?>" class="mtop" onclick="set('menu');"/>
</form>

<?php
if(isset($item->id) && $item->id >0) {
    // Link's list of this disc
    $menuitems = MenuItem::getStackMenu($item->id);

    $classq = MenuItem::class;
    echo '<h2>'.$lang->l('list_menu_items').'</h2>';
    if ($menuitems && sizeof($menuitems) > 0) {
        echo '<table id="list_menu_item" class="mainlist content_sortcat">';
        echo '<tr>';
        echo '<th class="w5"> </th>';
        echo '<th class="w5">'.$lang->l('position').'</th>';
        echo '<th class="w20">'.$lang->l('link_txt').'</th>';
        echo '<th class="w15">'.$lang->l('parent_link').'</th>';
        echo '<th class="w15">'.$lang->l('link_url').'</th>';
        echo '<th class="w15">'.$lang->l('link_page').'</th>';
        echo '<th class="w15">'.$lang->l('link_categoryproduct').'</th>';
        echo '<th></th>';
        echo '</tr>';
        echo '</table>';

        echo '<ul id="sortable-menu_items" class="sortable list">';
        foreach ($menuitems as $menu_item_id => $itemq) {
            echo '<li id="'.$itemq['id'].'">';
                echo '<table>';
                echo '<tr class="">';
                    echo '<td class="w5 tc"><span class="handle">::</span></td>';
                    echo '<td class="w5">'.$itemq['position'].'</td>';
                    echo '<td class="w20">'.$itemq['name'].'</td>';
                    echo '<td class="w15">'.MenuItem::getName($itemq['parent_id']).'</td>';
                    echo '<td class="w15">'.$itemq['link_url'].'</td>';
                    echo '<td>';
                        echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($classq).'\', ' . $itemq['id'] . ', null, '.$item->id.');"></a>';
                        echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($classq).'\', ' . $itemq['id'] . ', \'' . str_replace("'", "\'", Menu::getName($itemq['menu_id'])) . '\');"></a>';
                    echo '</td>';
                echo '</tr>';
                if (!empty($itemq['childs'])) {
                    foreach($itemq['childs'] as $submenu_item_id => $itemchild) {
                        echo '<tr class="">';
                            echo '<td class="w5 tc"></td>';
                            echo '<td class="w5">|--</td>';
                            echo '<td class="w20">'.$itemchild['name'].'</td>';
                            echo '<td class="w15">'.MenuItem::getName($itemchild['parent_id']).'</td>';
                            echo '<td class="w15">'.$itemchild['link_url'].'</td>';
                            echo '<td>';
                            echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($classq).'\', ' . $itemchild['id'] . ', null, '.$item->id.');"></a>';
                            echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($classq).'\', ' . $itemchild['id'] . ', \'' . str_replace("'", "\'", Menu::getName($itemchild['menu_id'])) . '\');"></a>';
                            echo '</td>';
                        echo '</tr>';
                    }
                }

                echo '</table>';
            echo '</li>';
        }
        echo '</ul>';
    }
    echo '<span id="menu_id" style="display:none;">'.$item->id.'</span>';
    echo '<p><a class="btn withtxt" href="javascript:edit(\''.strtolower($classq).'\', 0, null, '.$item->id.');"><span class="icon_btn add_btn"></span>'.$lang->l('add_link').'</a></p>';
}
?>

<script>controlsave('<?= strtolower($class) ?>');inittiny();</script>