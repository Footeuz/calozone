<?php
include_once '../boot.php';

session_destroy();

?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        
        <title><?= TITLE ?> - Connexion</title>
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
        
        <link href="<?= URL_ADM ?>css/admin.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet" />
        <link rel="icon" type="image/png" href="<?= URL_IMG ?>favicon.ico" />
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/utils.js"></script>
        <script type="text/javascript" src="<?= URL_PUBLIC ?>js/base.js"></script>
        <script type="text/javascript" src="<?= URL_ADM ?>admin.js"></script>
    </head>
        
  <body class="bg<?php echo 1; /*rand(1,4);*/?> auth">
        <div id="top_menu">
            <a id="logolink" href="<?= URL ?>" class="tc"><img alt="Retour à l'accueil" src="<?= URL_IMG ?>logo-zone.png" alt="<?php echo TITLE; ?>" id="logo" /></a>
            <div class="clr""></div>
        </div>
        
        <div id="login" class="left_menu_and_content clr">
            <div class="left_menu" style="height: 100vh;">
                <form action="login_action.php" method="post" id="auth_form">
                    <fieldset class="identifiant">
                        <input type="text" name="login" placeholder="Identifiant" />
                    </fieldset>
                    <fieldset class="pwd">
                        <input type="password" name="pass" placeholder="Mot de passe" />
                    </fieldset>
                    <input type="image" src="<?= URL_IMG ?>admin-connexion.png" value="CONNEXION" />
                </form>
            </div>
        </div>
    </body>
    
    <script type="text/javascript">
        document.ontouchmove = function(e){ 
           e.preventDefault(); 
        }
    </script>
    
</html>





