<?php
require_once 'boot.php';

$is_home = false;
$page_title = $lang->l('contributor_list_title');
$page_metadesc = $lang->l('contributor_list_metadesc');
$og_url = 'chansons-'.$mainartistslug;
$og_image = 'public/images/chansons-'.$mainartistslug.'.jpg';

include("header.php");

$contributors = Contributor::getStack();
$contributors_covers = array();

if (!empty($contributors)) {
    foreach ($contributors as $contributor_id => $contributor) {
        $contributors[$contributor_id]['only_covers'] = true;
        $stack = SongContributor::getStackContributor($contributor['id']);

        if (isset($stack[SongContributor::R_AUTHOR])) {
            foreach ($stack[SongContributor::R_AUTHOR] as $songcontributor) {
                $contributors[$contributor_id]['only_covers'] = $contributors[$contributor_id]['only_covers'] && Song::isCover($songcontributor['song_id']);
            }
            $contributors[$contributor_id]['is_author'] = 'contributor_author';
        } else {
            $contributors[$contributor_id]['is_author'] = '';
        }

        if (isset($stack[SongContributor::R_COMPOSER])) {
            foreach ($stack[SongContributor::R_COMPOSER] as $songcontributor) {
                $contributors[$contributor_id]['only_covers'] = $contributors[$contributor_id]['only_covers'] && Song::isCover($songcontributor['song_id']);
            }
            $contributors[$contributor_id]['is_composer'] = 'contributor_composer';
        } else {
            $contributors[$contributor_id]['is_composer'] = '';
        }

        // separate in 2 arrays
        if ($contributors[$contributor_id]['only_covers']) {
            $contributors_covers[$contributor_id] = $contributors[$contributor_id];
            unset($contributors[$contributor_id]);
        }
    }
}

?>
<div id="contributor-list" class="contributor">
    <div class="content">
        <div class="wrapper">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <?php if (!empty($contributors)) { ?>
                        <h2><?= $lang->l('Liste auteurs/compositeurs ayant collaboré avec Calogero'); ?></h2>
                        <div class="form-group row">
                            <label for="contributorfilter" class="col-auto col-form-label"><?= $lang->l('Filtrer par'); ?> :</label>
                            <div class="col">
                                <select id="contributorfilter" class="form-control d-inline-block" name="contributor" onchange="filtertable('list_contributors', 'contributorfilter', 'contributor_');">
                                    <option value="all" selected><?= $lang->l('all contributors') ?></option>
                                    <option value="authorcomposer">Auteur/Compositeur</option>
                                    <option value="author">Auteur</option>
                                    <option value="composer">Compositeur</option>
                                </select>
                            </div>
                        </div>
                        <ul id="list_contributors" class="contributors mt-3">
                            <?php foreach ($contributors as $contributor_id => $contributor) { ?>
                                <li class="<?= $contributor['is_author'] ?> <?= $contributor['is_composer'] ?>">
                                    <a href="auteur-compositeur-<?= $contributor['slug'] ?>-<?= $contributor['id'] ?>" title="Auteur/Compositeur <?= $contributor['name'] ?>"><?= $contributor['name'] ?></a>  <small><?= (!empty($contributor['is_author'])) ? ucfirst($lang->l('author')) : ''; ?> <?= (!empty($contributor['is_composer'])) ? ucfirst($lang->l('composer')) : ''; ?></small>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <div class="col-12 col-lg-6">
                    <?php if (!empty($contributors_covers)) { ?>
                        <h2><?= $lang->l('Liste auteurs/compositeurs de chansons reprises par Calogero'); ?></h2>
                        <ul id="list_contributors" class="contributors mt">
                            <?php foreach ($contributors_covers as $contributor_id => $contributor) { ?>
                                <li class="<?= $contributor['is_author'] ?> <?= $contributor['is_composer'] ?> <?= ($contributor['only_covers']) ? 'only_covers' : '' ?>">
                                    <a href="auteur-compositeur-<?= $contributor['slug'] ?>-<?= $contributor['id'] ?>" title="Auteur/Compositeur <?= $contributor['name'] ?>"><?= $contributor['name'] ?></a> <small><?= (!empty($contributor['is_author'])) ? ucfirst($lang->l('author')) : ''; ?> <?= (!empty($contributor['is_composer'])) ? ucfirst($lang->l('composer')) : ''; ?></small>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>

                    <div class="mt-3">
                        <img src="<?= URL ?>public/images/Calogero-Londres-20190119-FannyLinchet.jpg" alt="Calogero Londres 19 janvier 2019" class="w-100" />
                        <p class="text-center">Cr&eacute;dit photo : Fanny L.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    /* filter table */
    function filtertable(tableid, selectid, cls) {
        if (document.getElementById(tableid) != null && document.getElementById(selectid) != null) {
            var tabtr = document.getElementById(tableid).getElementsByTagName('li');
            for (var i = 0; i < tabtr.length; i++) {
                if (document.getElementById(selectid).value == 'all')
                    tabtr[i].style.display = 'list-item';
                else if (document.getElementById(selectid).value == 'authorcomposer')
                    tabtr[i].style.display = (tabtr[i].classList.contains(cls+'author') && tabtr[i].classList.contains(cls+'composer')) ? 'list-item' : 'none';
                else
                    tabtr[i].style.display = (tabtr[i].classList.contains(cls+document.getElementById(selectid).value)) ? 'list-item' : 'none';
            }
        }
    }
</script>
<?php include("footer.php") ?>
