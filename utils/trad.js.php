<?php
include("../../../conf.inc.php");

$lang = Lang::buildLang($_GET['lang']);

header("Content-type: application/javascript");

if(gethostname() != 'nerv'){
    $clen = 3600*24*31;
    header("Last-Modified: ".gmdate('D, d M Y H:i:s \G\M\T',time()),true);
    header("Expires: ".gmdate('D, d M Y H:i:s \G\M\T', time() + $clen),true);
    header("Cache-Control: max-age=".$clen);
    header("User-Cache-Control: max-age=".$clen);
    header("Pragma: cache");
}


echo "var a_lang = new Array();\n";

foreach($lang->trad as $k =>$v){
    $v = str_replace("\n"," ",$v);
    $v = str_replace("\r"," ",$v);
    $v = str_replace("\t"," ",$v);
    echo "a_lang['$k'] = '".addslashes($v)."';\n";
}
