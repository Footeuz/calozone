<?php
/**** List of media's ****/
if(!defined('ROOT')) require_once '../../../boot.php';
$class = Media::class;

$result = SQL::select(Media::TBNAME, array('active' => 1, 'artist'=>array(1,3,4)), '*', 'id ASC');
echo '<h2>'.$lang->l('liste').'</h2>';
echo '<table id="full_list_media" class="mainlist">';
    echo '<tr>';
        echo '<th class="w5">'.$lang->l('id').'</th>';
        echo '<th class="w15">'.$lang->l('media_title').'</th>';
        echo '<th class="w15">'.$lang->l('artist').'</th>';
        echo '<th class="w15">'.$lang->l('media').'</th>';
        echo '<th class="w10">'.$lang->l('datediff').'</th>';
        echo '<th class="w10">'.$lang->l('nb_lancement').'</th>';
        echo '<th class="w10">'.$lang->l('nb_vues').'</th>';
        echo '<th class="w10">'.$lang->l('duration').'</th>';
        echo '<th class="w10">'.$lang->l('media_type').'</th>';
        echo '<th></th>';
    echo '</tr>';
    echo '<tr>';
        echo '<td class="w5"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w15"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td class="w10"></td>';
        echo '<td></td>';
    echo '</tr>';
    while($item = $result->fetch_assoc()){
        echo '<tr class="">';
            echo '<td class="w5">'.$item['id'].'</td>';
            echo '<td class="w15">'.$item['title'].'</td>';
            echo '<td class="w15">'.Artist::getName($item['artist']).'</td>';
            echo '<td class="w15">'.$item['media'].'</td>';
            echo '<td class="w10">'.$item['datediff'].'</td>';
            echo '<td class="w10">'.$item['lancement'].'</td>';
            echo '<td class="w10">'.$item['vues'].'</td>';
            echo '<td class="w10">'.$item['duree'].'</td>';
            echo '<td class="w10">'.(($item['type']=='1') ? 'Vidéo' : 'Audio').'</td>';
            echo '<td>';
                echo '<a class="icon_btn delete_btn" href="javascript:askDel(\''.strtolower($class).'\', '.$item['id'].', \''. str_replace("'", "\'", $item['id']).'\');" title="'.$lang->l('action_delete').'"></a>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');" title="'.$lang->l('action_edit').'"></a>';
            echo '</td>';
        echo '</tr>';
    }
echo '</table>';

$result = SQL::select(Media::TBNAME, array('active' => 0), '*');
echo '<h2>'.$lang->l('elts_supprimes').'</h2>';
while($item = $result->fetch_assoc()){
    echo '<table class="mainlist">';
        echo '<tr>';
            echo '<td class="w20">'.$item['title'].'</td>';
            echo '<td class="w20">'.$item['media'].'</td>';
            echo '<td>';
                echo '<a class="icon_btn create_btn" href="javascript:edit(\''.strtolower($class).'\', '.$item['id'].');"></a>';
            echo '</td>';
        echo '</tr>';
    echo '</table>';
}

