<?php
/**** List of users's admin ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = UserAdmin::class;

$result = SQL::select(UserAdmin::TBNAME, array('active' => 1), '*');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_useradmin" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('url').'</th>';
        echo '<th class="w20">'.$lang->l('login').'</th>';
        echo '<th class="w15">'.$lang->l('email').'</th>';
        echo '<th class="w20">'.$lang->l('name').'</th>';
        echo '<th class="w10">'.$lang->l('date_start_subscription').'</th>';
        echo '<th class="w10">'.$lang->l('date_end_subscription').'</th>';
        echo '<th class="w20">'.$lang->l('status').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="width: 40px;"></td>';
        echo '<td class="w20"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w20"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w20">';
            echo '<select id="statusfilter" name="status" onchange="filtertable(\'full_list_useradmin\', \'statusfilter\', \'status\');">';
                echo '<option value="all" selected>'.$lang->l('all').'</option>';
                echo '<option value="'.UserAdmin::S_ADMIN.'" >'. UserAdmin::getStatusLabel(UserAdmin::S_ADMIN).'</option>';
                echo '<option value="'.UserAdmin::S_SUPERADMIN.'" >'. UserAdmin::getStatusLabel(UserAdmin::S_SUPERADMIN).'</option>';
                echo '<option value="'.UserAdmin::S_CUSTOMER.'" >'. UserAdmin::getStatusLabel(UserAdmin::S_CUSTOMER).'</option>';
            echo '</select>';
        echo '</td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="status'.$item['status'].'">';
            echo '<td style="width:40px">';
            if (!empty($item['url'])) echo '<a class="icon_btn link_btn" href="' . $item['url'].'" target="_blank"></a>';
            echo '</td>';
            echo '<td class="w20">'.$item['login'].'</td>';
            echo '<td class="w15">'.$item['email'].'</td>';
            echo '<td class="w20">'.$item['name'].'</td>';
            echo '<td class="w10">'.date('d.m.Y H:i', $item['subscription_stamp_start']).'</td>';
            echo '<td class="w10">'.date('d.m.Y H:i', $item['subscription_stamp_end']).'</td>';
            echo '<td class="w20">'. UserAdmin::getStatusLabel($item['status']).'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['login']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(UserAdmin::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td style="width: 20%;">'.$item['login'].'</td>';
            echo '<td style="width: 20%;">'. UserAdmin::getStatusLabel($item['status']).'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}

