<?php
/**** List of users ****/
if(!defined('ROOT')) require_once '../../../boot.php';

if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
} else {
    $user = null;
}
if($user && $user->status === UserAdmin::S_CUSTOMER)
    $result = SQL::query('SELECT u.* FROM '.User::TBNAME.' as u LEFT JOIN '.Campaign::TBNAME.' as c ON (u.mailing_id = c.id) LEFT JOIN '.Test::TBNAME.' as t ON c.test_id = t.id WHERE t.useradmin_id = '.$user->id );
else {
    $result = SQL::select(User::TBNAME, array(), '*');
    $campaigns = Campaign::getStack();
}
$class = User::class;
echo '<h2>'.$lang->l('liste').'</h2>';
if ($result && $result->num_rows > 0) {
    echo '<table id="full_list_users" class="mainlist">';
        echo '<tr>';
            echo '<th class="w20">'.$lang->l('code').'</th>';
            echo '<th class="w20">'.$lang->l('campaign').'</th>';
            echo '<th class="w10">'.$lang->l('email').'</th>';
            echo '<th class="w10">'.$lang->l('name').'</th>';
            echo '<th class="w10">'.$lang->l('date_create').'</th>';
            echo '<th class="w10">'.$lang->l('date_last_connect').'</th>';
            echo '<th></th>';
        echo '</tr>';
        echo '<tr>';
            echo '<td class="w20"></td>';
            echo '<td class="w20">';
                echo '<select id="campaignfilter" name="campaign" onchange="filtertable(\'full_list_users\', \'campaignfilter\', \'cpg\');">';
                    echo '<option value="all" selected>'.$lang->l('all').'</option>';
                    if (!empty($campaigns))
                        foreach($campaigns as $cpg)
                            echo '<option value="'.$cpg['id'].'" >'.$cpg['id'].' - '.Test::getName($cpg['test_id']).'</option>';
                echo '</select>';
            echo '</td>';
            echo '<td class="w10"></td>';
            echo '<td class="w10"></td>';
            echo '<td class="w10"></td>';
            echo '<td class="w10"></td>';
            echo '<td></td>';
        echo '</tr>';


        while ($item = $result->fetch_assoc()) {
            echo '<tr class="cpg'.$item['mailing_id'].'">';
                echo '<td style="width: 20%;">'.$item['code'].'</td>';
                $campaign = Campaign::get($item['mailing_id']);
                if (isset($campaign['test_id']))
                    echo '<td style="width: 20%;">N° '.$item['mailing_id'].' - '.Test::getName($campaign['test_id']).'</td>';
                else
                    echo '<td style="width: 20%;">'.$item['mailing_id'].'</td>';
                echo '<td style="width: 20%;">'.$item['email'].'</td>';
                echo '<td style="width: 10%;">'.$item['firstname'].' '.$item['lastname'].'</td>';
                echo '<td style="width: 10%;">'.date('d.m.Y H:i', $item['stamp_created']).'</td>';
                echo '<td style="width: 10%;">'.date('d.m.Y H:i', $item['stamp_last']).'</td>';
                echo '<td>';
                    echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', ' . $item['id'] . ', \'' . str_replace("'", "\'", $item['code']) . '\');" title="'.$lang->l('action_delete').'"></a>';
                    echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', ' . $item['id'] . ');" title="'.$lang->l('action_edit').'"></a>';
                echo '</td>';
            echo '</tr>';
        }
    echo '</table>';
} else {
    echo '<p class="mainlist">';
        echo $lang->l('no_data');
    echo '</p>';
}

