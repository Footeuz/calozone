<?php
/**** List of users's admin ****/
if(!defined('ROOT')) require_once '../../../boot.php';
    $class = Gig::class;

$result = SQL::select(Gig::TBNAME, array('active' => 1), '*', 'date_start ASC');


$list_tours = [];
$tours = Tour::getStack();
if (!empty($tours)) {
    foreach($tours as $tour_id => $tour) {
        $list_tours[$tour_id] = $tour['name'];
    }
}

echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_gig" class="mainlist">';
    echo '<tr>';
        echo '<th class="width: 40px;">'.$lang->l('id').'</th>';
        echo '<th class="w5">'.$lang->l('date_gig').'</th>';
        echo '<th class="w20">'.$lang->l('tour').'</th>';
        echo '<th class="w20">'.$lang->l('salle').'</th>';
        echo '<th class="w15">'.$lang->l('more_infos').'</th>';
        echo '<th class="w10">'.$lang->l('is_concertprive').'</th>';
        echo '<th class="w15">'.$lang->l('radio').'</th>';
        echo '<th class="w5">'.$lang->l('canceled').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="width: 40px;"></td>';
        echo '<td class="w5">';
            echo '<select id="yearfilter" name="year" onchange="filtertable(\'full_list_gig\', \'yearfilter\', \'year\');">';
                echo '<option value="all" selected>'.$lang->l('all year').'</option>';
                for ($y = 1999; $y <= date('Y'); $y++) echo '<option value="'.$y.'" >'.$y.'</option>';
            echo '</select>';
        echo '</td>';
        echo '<td class="w20">';
            echo '<select id="tourfilter" name="tour" onchange="filtertable(\'full_list_gig\', \'tourfilter\', \'tour\');">';
            echo '<option value="all" selected>'.$lang->l('all').'</option>';
                foreach($list_tours as $tour_id =>$tourname)
                    echo '<option value="'.$tour_id.'" >'.$tourname.'</option>';
            echo '</select>';
        echo '</td>';
        echo '<td class="w20">';
            echo '<select id="countryfilter" name="country" onchange="filtertable(\'full_list_gig\', \'countryfilter\', \'country\');">';
                echo '<option value="all" selected>'.$lang->l('all country').'</option>';
                echo '<option value="FR" >France</option>';
                echo '<option value="BE" >Belgique</option>';
                echo '<option value="CH" >Suisse</option>';
            echo '</select>';
            echo '<select id="dptfilter" name="dpt" onchange="filtertable(\'full_list_gig\', \'dptfilter\', \'dpt\');">';
                echo '<option value="all" selected>'.$lang->l('all dpt').'</option>';
                for ($dpt = 1; $dpt <= 99; $dpt++) echo '<option value="'.str_pad($dpt, 2, '0', STR_PAD_LEFT).'" >'.str_pad($dpt, 2, '0', STR_PAD_LEFT).'</option>';
            echo '</select>';
        echo '</td>';
        echo '<td class="w15"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w5"></td>';
        echo '<td></td>';
    echo '</tr>';
    if ($result->num_rows>0) {
        while ($item = $result->fetch_assoc()) {
            $salle = new Salle($item['salle_id']);
            echo '<tr class="tour' . $item['tour_id'] . ' country' . $salle->country . ' dpt' . $salle->dpt . ' year' . date('Y', $item['date_start']) . '">';
                echo '<td class="w5">' . $item['id'] . '</td>';
                echo '<td class="w5">' .date('d.m.Y', $item['date_start']). '</td>';
                echo '<td class="w20">' . Tour::getName($item['tour_id']) . '</td>';
                echo '<td class="w20">' . $salle->name . ' - ' . $salle->city . '('.$salle->dpt.')</td>';
                echo '<td class="w15">' . $item['more_infos'] . '</td>';
                echo '<td class="w10">' . $ouinon[$item['is_cp']] . '</td>';
                echo '<td class="w15">' . $item['radio'] . '</td>';
                echo '<td class="w5">' . $ouinon[$item['canceled']] . '</td>';
                echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\'' . strtolower($class) . '\', ' . $item['id'] . ', \'' . str_replace("'", "\'", $item['id']) . '\');" title="' . $lang->l('action_delete') . '"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\'' . strtolower($class) . '\', ' . $item['id'] . ');" title="' . $lang->l('action_edit') . '"></a>';
                echo '</td>';
            echo '</tr>';
        }
    }
echo '</table>';

$result = SQL::select(Gig::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td class="w20">'.Artist::getName($item['artist_id']).'</td>';
            echo '<td class="w20">'.Tour::getName($item['tour_id']).'</td>';
            echo '<td class="w30">'.Salle::getName($item['salle_id']).'</td>';
            echo '<td class="w20">'.$item['date_start'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}
