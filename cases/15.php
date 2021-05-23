<script src="../public/js/jquery-1.4.2.min.js"></script>
<script src="../public/js/jquery.easydrag.handler.beta2.js"></script>
<script src="../public/js/crossword.js"></script>
<link rel="stylesheet" href="../public/css/crosswords.css">

<div class="pure-g">
    <div class="pure-u-1">
        <h2>Résolvez les mots croisés sur le thème de Calogero - Auteur : Pascal</h2>

        <div class="responsive-video">
            <h3>Instructions</h3>
            <p>Utilisez ces touches du clavier &larr; &uarr; &rarr; &darr; pour naviguer entre les cases.<br />
                Tab key   ⇥ Pour aller à la définition suivante.<br />
                BARRE ESPACE pour changer le sens du mot sélectionné.<br />
                Touche Retour pour effacer la valeur d'une case et aller à la case précédente.<br />
                Touche Suppr pour effacer la valeur d'une case sans bouger ensuite.<br />
                Cliquez sur une définition pour aller aux cases correspondantes.<br />
                Cliquez sur le bouton "Vérifier" pour vérifier si c'est la bonne réponse.</p>
                <div>
                    <input type="button" id="check" value="Vérifier" />
                    <a href="solution.png" target="_blank">Voir la solution</a>
                    <div id="definitions"></div>
                </div>
        </div>
    </div>
</div>

<script>
    $.get("https://calo.zone/cases/source.php", function(response) {
        $resp = $(response);
        var cw = $resp.find("#create_crossword").val(),
            hor = $resp.find("#create_hor").val(),
            ver = $resp.find("#create_ver").val(),
            cw_id = "crossword12345";

        html = $.crosswordCreate({
            crossword_id: cw_id,
            crossword_val: cw,
            hor_val: hor,
            ver_val: ver,
            caption: "Mot croisés Calogero 15 décembre 2019 par Pascal"
        });
        $("#definitions")
            .append("<div style=\"width:48%;float:left;\"><h3>Horizontal</h3>"+html.def[0]+"</div>")
            .append("<div style=\"width:48%;float:left;\"><h3>Vertical</h3>"+html.def[1]+"</div>")
            .before(html.schema);

        $("#"+cw_id).crossword();

        $("#check").click(function() {
            $.crosswordCheck({
                solution: cw,
                crossword_id: cw_id,
                level: 1
            });
        });
    });
</script>