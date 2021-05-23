<a id="menu_song" href="javascript:set('song');" class="selected">
    <span class="icon_menu_item_add" onclick="edit('song', 0, event)"></span>
    <img src="<?php echo URL_IMG; ?>ic_view_list.png" /><?php echo $lang->l('song_list'); ?>
</a>
<a href="javascript:edit('song', 0);"><img src="<?php echo URL_IMG; ?>ic_note_add.png" /><?php echo $lang->l('add_song'); ?></a>

<a id="menu_contributor" href="javascript:set('contributor');" class="selected">
    <span class="icon_menu_item_add" onclick="edit('contributor', 0, event)"></span>
    <img src="<?php echo URL_IMG; ?>ic_view_list.png" /><?php echo $lang->l('contributor_list'); ?>
</a>
<a href="javascript:edit('contributor', 0);"><img src="<?php echo URL_IMG; ?>ic_note_add.png" /><?php echo $lang->l('add_contributor'); ?></a>