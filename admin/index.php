<?php
require_once '../boot.php';

$user = null;
if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0){
    $user = new UserAdmin($_SESSION['id_user']);
    if($user->id == 0 || $user->active == 0) $user = null; //user unknown or inactive
}

// check if user is connected
$noneAuthScript = array(ROOT.'login.php', ROOT.'login_action.php',
    ROOT.'admin/login.php', ROOT.'admin/login_action.php');

$scriptFileName = $_SERVER['SCRIPT_FILENAME'];

if($user == null && !in_array($scriptFileName, $noneAuthScript)){
    $adminDir = ROOT."admin/";
    if(substr($scriptFileName, 0, mb_strlen($adminDir)) === $adminDir) $loginURL = URL_ADM.'login.php';
    else $loginURL = URL.'login.php';
    header('Location: '.$loginURL, 303);
    die();
}

$menus = array('dashboard' => $lang->l('dashboard'));
$menus['podcast'] = $lang->l('podcast');
$menus['clip'] = $lang->l('clip');
$menus['disc'] = $lang->l('disc');
$menus['song'] = $lang->l('song');
$menus['media'] = $lang->l('media');
$menus['artist'] = $lang->l('artist');
$menus['salle'] = $lang->l('salle');
$menus['tour'] = $lang->l('tour');
$menus['gig'] = $lang->l('gig');
$menus['picturepage'] = $lang->l('picturepage');
$menus['trad'] = $lang->l('trad');

if($user->status === UserAdmin::S_ADMIN || $user->status === UserAdmin::S_SUPERADMIN) {
    $menus['useradmin'] = $lang->l('admin_users');
}
?><!DOCTYPE html>
<html>
    <head>
        <title><?= TITLE ?> - <?php echo $lang->l('administration'); ?></title>
        <meta charset="UTF-8" />
        <link href="<?= URL_ADM ?>css/admin.css" rel="stylesheet" />
        <link href="<?= URL_ADM ?>css/pikaday.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans+Condensed" rel="stylesheet" />
        <link rel="icon" type="image/png" href="<?= URL_PUBLIC ?>images/favicon.ico"/>
        <script src="<?= URL_PUBLIC ?>js/utils.js"></script>
        <script src="<?= URL_PUBLIC ?>js/base.js"></script>
        <script>
        var base_url = '<?= URL_ADM ?>';
        <?php
        foreach($menus as $m => $name){
            echo "registerMenu('$m');";
        }
        ?>
        </script>
        <script src="<?= URL_ADM ?>js/tinymce/tinymce.min.js"></script>
    </head>
        
    <body <?php if(isset($_SESSION['id_user']) && $_SESSION['id_user'] > 0) echo 'id="not-home"'; ?>>
        <div id="top_menu">
            <?php
            $i = 0;
            foreach($menus as $menu => $name){
                
                echo '<a id="tab_'.$menu.'" '. 
                        'href="javascript:setTab(\''.$menu.'\');" '.
                        (!$i?'class="selected"':'').
                        '>'.$name.'</a>';
                $i++;
            }
            ?>
            
            <a href="javascript:redirect('<?= URL_ADM ?>login.php');" title="Deconnexion" class="disconnect"><img src="<?php echo URL_IMG; ?>disconnect.png" alt="Deconnexion" height="26"/></a>
            <a id="logolink" href="<?= URL ?>" target="_blank"><img alt="Retour à l'accueil" src="<?= URL_IMG ?>logo-zone.png" alt="<?php echo TITLE; ?>" id="logo" /></a>
            <div class="clr"></div>
        </div>

        <?php
        $i = 0;
        foreach ($menus as $menu => $name) {
            ?>
            <div id="<?= $menu ?>" <?= ($i?'style="display: none;"':'') ?> class="master_content" >
                    <h1><?= $name ?></h1>

                    <div class="left_menu_and_content">
                        <?php if(file_exists("./menus/menu_$menu.php")) : ?>
                        <div id="left_menu_<?= $menu ?>" class="left_menu">
                        <?php include "./menus/menu_$menu.php"; ?>
                        </div>
                        <?php endif; ?>

                        <div class="content_wrapper">
                            <div class="content_shadow"></div>
                            <div id="content_<?= $menu ?>" class="content"><?php if(!$i) include './pages/dashboard/dashboard.php'; ?></div>
                        </div>
                    </div>
            </div>        
            <?php
            $i++;
        }
        ?>
        <div id="alert"><div class="message"></div><div class="text-center clr"><span class="btn" onclick="oid('alert').style.display='none';">OK</span></div></div>
        <script src="<?php echo URL_ADM; ?>js/pikaday.js"></script>
        <script src="<?= URL_PUBLIC ?>js/jquery.min.js"></script>
        <script src="<?= URL_PUBLIC ?>js/jquery-ui-1.10.3.js"></script>
        <script src="<?= URL_ADM ?>js/admin.js"></script>
        <script src="<?= URL_PUBLIC ?>js/jquery.sortable.js"></script>
    </body>
</html>



