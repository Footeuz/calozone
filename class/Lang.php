<?php

/**
 * @package      WeBerry
 * @author Stephanie Michel <footeuz@gmail.com>
 */


class Lang {

    const STORAGE = 'caloz_trad';
    const STORAGE_LANG = 'caloz_lang';

    const LL_FR = 'fr';
    /*const LL_EN = 'en';
    const LL_ES = 'es';*/
    /**
     * Langue supportée par le système
     * @var string[]
     */
    static $supportedLang = array(
        self::LL_FR
        /*,self::LL_EN,
        self::LL_ES*/
    );

    static $currentLang = self::LL_FR;

    /**
     * Langue chargée
     * @var string
     */
    var $langue = self::LL_FR;
    /**
     * Array cache traduction
     * @var array
     */
    var $trad = array();
    /**
     * Charge la langue
     * @param string $l
     */
    public function load($l = self::LL_FR) {
        if (!empty($l)) $this->langue = $l;
        include $this->makeCache();
    }
    /**
     * FONCTION DE TRADUCTION PRINCIPALE
     * @param string $item
     * @return string
     */
    public function l($item) {
        if (isset($this->trad[$item])) return $this->trad[$item];

        $res = SQL::select(self::STORAGE,array("text" => $item));

        if ($res->num_rows == 0) SQL::insert(self::STORAGE, array("text" => $item));
        $this->trad[$item] = $item;

        return $item;

    }
    /**
     * Lit une chaine d'erreur
     * @param int $code
     * @return string
     */
    function errStr($code) {
        return $this->l("error_" . $code);
    }
    /**
     * Génère les fichiers plats de cache
     * @return string
     */
    function makeCache(){

        if(!file_exists(TMP)) mkdir(TMP);
        $path = TMP.'lang-'.$this->langue.'.cache.php';

        if(!file_exists($path)){

            $res = SQL::select(self::STORAGE);
            $h = 0;
            $mx = $res->num_rows;
            $sp = "<?php\n";

            while ($h != $mx) {
                $rec = $res->fetch_assoc();

                if(!empty($rec['text']) && !empty($rec[$this->langue])){
                    $stx = str_replace("'","\\'",$rec['text']);
                    $stt = str_replace("'","\\'",$rec[$this->langue]);

                    $sp .= '$this->trad[\''.$stx.'\'] = \''.$stt.'\';'."\n";
                }
                $h++;
            }

            $fp = fopen($path,'w');
            fwrite($fp, $sp);
            fclose($fp);

        }

        return $path;

    }
    /**
     * Delete cache's file
     * @return boolean
     */
    function resetCache(){
        $path = TMP.'lang-'.$this->langue.'.cache.php';
        if(file_exists($path)){
            return unlink($path);
        }
        return false;
    }

    /**
     * Renvoi la langue en fonction du code
     * @param string $code
     * @return int
     */
    public static function getLangByCode($code){

        $cd     = explode("-",$code);
        $codex  = $cd[0];
        $res    = SQL::select(self::STORAGE_LANG,array("code" => $codex),array('nom'));

        if($res->num_rows > 0){
            $rec = $res->fetch_assoc();
            return $rec['nom'];
        }
        else return 0;
    }
    /**
     * Construit le cache pour une langue
     * @return Lang
     */
    public static function buildLang(){
        return Cache::getLang(self::$currentLang);
    }

    /**
     *
     * @param string $lang
     * @return array
     */
    public static function getAPIData($lang){

        $r = array();

        $res = SQL::select(self::STORAGE,array(
            "type" => "api"
        ));

        while($rec = $res->fetch_assoc()){
            $r[$rec['text']] = $rec[$lang];
        }

        return $r;

    }

}