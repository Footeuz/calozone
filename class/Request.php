<?php

/**
 * Description of Request
 *
 * @author vincent
 */
class Request {
    
    /**
     * @param mixed $int
     * @return boolean
     */
    public static function isInt($int){
        if(is_numeric($int) === true){
	    if((int)$int == $int){
		return true;
	    }else{
		return false;
	    }
	}
	else{
	    return false;
	}
    }
    
    /**
     * Vérifie si une variable POST existe et retourne la valeur 
     * @param string $key
     * @param int $maxSize coupe le résultat à $maxSize caractères si différent de 0
     * @return string valeur "sécurisée"
     */
    public static function checkPostOrDie($key, $maxSize = 0){
        if(!isset($_POST[$key])){
            if(DEBUG){
                print_r(debug_backtrace());
                die("ERREUR ".$key);
            }
            else die("ERREUR".$key);
        }
        
        if($maxSize) return substr($_POST[$key], 0, $maxSize);
        
        return $_POST[$key];
    }

    /**
     * check if duration POSTED is higher than media length et retourne la valeur
     * @param string $key
     * @return string valeur "sécurisée"
     */
    public static function checkPostDuration($key, $mediaduration){
        $langstr = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        if (!in_array($langstr, Lang::$supportedLang)) $langstr = Lang::LL_FR;
        $lang = Cache::getLang($langstr);

        if(!isset($_POST[$key])){
            if(DEBUG){
                print_r(debug_backtrace());
                die("ERREUR ".(DEBUG?$key:''));
            }
            else die("ERREUR");
        }
        $post = intval($_POST[$key]);
        if ($post == 0) return $_POST[$key];

        if ($post<$mediaduration && $mediaduration>0 && $post>0) {
            return false;
        }

        return $_POST[$key];
    }



    /**
     * Vérifie si  variable POST youtube_id existe et renvoie l'id de youutbe sans toute l'url
     * @return string youtube_id
     */
    public static function checkYoutubeId(){
        if(!isset($_POST['youtube_id'])){
            if(DEBUG){
                print_r(debug_backtrace());
                die("ERREUR ".(DEBUG?'youtube_id':''));
            }
            else die("ERREUR");
        }

        if (!empty($_POST['youtube_id'])) {
            parse_str(parse_url( trim($_POST['youtube_id']), PHP_URL_QUERY ), $vars );
            if (isset($vars['v']))
                return $vars['v'];
            else
                return trim($_POST['youtube_id']);
        } else {
            return '';
        }
    }

    /**
     * transforme chaîne en url path
     * @param string $key
     * @param int $maxSize coupe le résultat à $maxSize caractères si différent de 0
     * @return string valeur "sécurisée"
     */
    public static function doPath($key){
        if(empty($key)) {
            die("Erreur : slug vide");
        }

        $return = str_replace(array("é","è","û","ù","ç","î","à"),array("e","e","u","u","c","i","a"),$key);
        $return = preg_replace("/[^a-zA-Z0-9]/","-",$return);
        $return = preg_replace("/\-+/", "-", $return);
        $return = trim($return, '-');
        $return = trim(strtolower(urlencode($return)));
        return $return;
    }

    /**
     * Vérifie si une variable POST existe et s'il s'agit d'un int
     * @param string $key
     * @return int valeur
     */
    public static function checkPostIntOrDie($key){
        if(!isset($_POST[$key]) || !self::isInt($_POST[$key])){
            if(DEBUG){
                print_r(debug_backtrace());
                die("ERREUR ".(DEBUG?$key:''));
            }
            else die("ERREUR");
        }

        return intval($_POST[$key]);
    }
    
    /**
     * appel checkPostIntOrDie avec id
     * @return int
     */
    public static function postIdOrDie($key = 'id'){
        return self::checkPostIntOrDie($key);
    }
    
    /**
     * Vérifie si une variable POST existe et s'il s'agit d'un int
     * @param string $key
     * @return int[] valeur
     */
    public static function checkPostIntArrayOrDie($key){
        if(!isset($_POST[$key]) || !isIntArray($_POST[$key])){
            if(DEBUG){
                print_r(debug_backtrace());
                die("ERREUR ".(DEBUG?$key:''));
            }
            else die("ERREUR");
        }

        return $_POST[$key];
    }    
    
    /**
     * @return int
     */
    public static function requestId($key = 'id'){
        if(isset($_REQUEST[$key])){
            return intval($_REQUEST[$key]);
        }
        return 0;
    }    
    
}
