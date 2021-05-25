<?php
/**** List of menus ****/
if(!defined('ROOT')) require_once '../../../boot.php';

if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0){
    $user = new UserAdmin($_SESSION['user_id']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}

$result = SQL::select(Menu::TBNAME, array('active' => 1), '*');
$class = Menu::class;

echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="list_menu" class="mainlist">';
    echo '<tr>';
        echo '<th class="w10">'.$lang->l('menu_id').'</th>';
        echo '<th class="w40">'.$lang->l('menu_name').'</th>';
        echo '<th class="w40">'.$lang->l('nb_items').'</th>';
        echo '<th></th>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        $nbItems = MenuItem::getCountItemsMenu($item['id']);
        echo '<tr class="">';
            echo '<td class="w10">'.$item['id'].'</td>';
            echo '<td class="w40">'.$item['name'].'</td>';
            echo '<td class="w40">'.$nbItems.'</td>';
            echo '<td>';
                if ($nbItems == 0) echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['name']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';