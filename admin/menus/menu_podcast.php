<a id="menu_podcast" href="javascript:set('podcast');" class="selected">
    <span class="icon_menu_item_add" onclick="edit('podcast', 0, event)"></span>
    <img src="<?php echo URL_IMG; ?>ic_view_list.png" /><?php echo $lang->l('podcast_list'); ?>
</a>
<a href="javascript:edit('podcast', 0);"><img src="<?php echo URL_IMG; ?>ic_note_add.png" /><?php echo $lang->l('add_podcast'); ?></a>
<a href="https://calo.zone/script/podcast_rss.php" target="_blank"><img src="<?php echo URL_IMG; ?>ic_refresh.png" />Rafraichir le flux Rss</a>
<a href="https://calo.zone/script/podcast_rss_itunes.php" target="_blank"><img src="<?php echo URL_IMG; ?>ic_refresh.png" />Rafraichir le flux Rss Itunes</a>