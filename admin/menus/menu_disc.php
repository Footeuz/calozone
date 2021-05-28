<a id="menu_disc" href="javascript:set('disc');" class="selected">
    <span class="icon_menu_item_add" onclick="edit('disc', 0, event)"></span>
    <img src="<?= URL_IMG; ?>ic_view_list.png" /><?= $lang->l('disc_list'); ?>
</a>
<a href="javascript:edit('disc', 0);"><img src="<?= URL_IMG; ?>ic_note_add.png" /><?= $lang->l('add_disc'); ?></a>
<a href="<?= URL ?>script/doSitemap.php" target="_blank"><img src="<?= URL_IMG; ?>ic_refresh.png" />Rafraichir le sitemap</a>
