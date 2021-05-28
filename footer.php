
        <div class="container mb-3"><a href="https://www.awin1.com/cread.php?s=2591312&v=7939&q=384138&r=303247"><img src="https://www.awin1.com/cshow.php?s=2591312&v=7939&q=384138&r=303247" border="0"  class="w-100"></a></div>

        <footer class="row w-100 m-0 p-0">
            <div class="col-12 col-lg-6 text-start wrapper">
                <?= $lang->l('join-fr'); ?> <a href="https://www.facebook.com/groups/fzcalo/" title="Fanzone Calogero Facebook" target="_blank">FanZone</a> (non officiel) - <a href="<?= URL ?>plan-du-site"><?= $lang->l('sitemap_title') ?></a>
            </div>
            <div class="col-12 col-lg-6 text-end wrapper">
                &copy; <a href="mailto:contact@stephaniemichel.com">S. Michel</a> 2019-<?= date('Y'); ?> * Un site <a href="https://stephaniemichel.com">WeBerry.fr</a>
            </div>
        </footer>
    </div>
</div>

<?php if (!empty(GTMTAG)) { ?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= GTMTAG ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= GTMTAG ?>');
</script>
<?php } ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<?php if (!empty($js)) { ?>
    <?php foreach ($js as $urljs) { ?>
        <script type="text/javascript" src="<?= URL_PUBLIC.$urljs ?>"></script>
    <?php } ?>
<?php } ?>

    </body>
</html>