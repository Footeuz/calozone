<?php

/**
 *
 * @package      WeBerry
 * @author Stephanie Michel <footeuz@gmail.com>
 */

/**
 *
 *
 * @author AM
 */
class Str {

    /**
     * Retire les accents d'une chaine
     * @param string $string
     * @return string
     */
    public static function removeAccents($string){ // enleve tous les caractères accentués
	return strtr(utf8_decode($string),utf8_decode("ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ"),"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); // convertion utf8 > iso obligatoire (remplacement octet par octet)
    }

    /**
     * Fonction de nettoyage niveau dictateur
     * @param type $data
     * @return type
     */
    public static function cleanOutput($data){ // nettoie une chaine en url friendly

        // on remplace les caractères accentués

        $data = trim($data);
        $data = self::removeAccents($data);
        $data = preg_replace("/[^a-zA-Z0-9]/", "_", $data);
        $data = preg_replace("/\_+/","_",$data);
        $data = trim($data,'_');
        $data = strtolower($data);

        return $data;
    }

    /**
     * Fonction de nettoyage niveau flic mal payé
     * @param string $data
     * @return string
     */
    public static function hclean($data){

        $data = strip_tags($data);
        $data = preg_replace('/\s+/', ' ', $data);
        $data = html_entity_decode($data,ENT_COMPAT,"utf-8");
        $data = trim($data);

        return $data;
    }

    /**
     * Date formattée
     * @param int $stamp
     * @param string $lx
     * @return string
     */
    public static function realDate($stamp,$lx = Lang::LL_FR){

        $lang = Cache::getLang($lx);

        $mois[1]    = $lang->l('janvier');
        $mois[2]    = $lang->l('fevrier');
        $mois[3]    = $lang->l('mars');
        $mois[4]    = $lang->l('avril');
        $mois[5]    = $lang->l('mai');
        $mois[6]    = $lang->l('juin');
        $mois[7]    = $lang->l('juillet');
        $mois[8]    = $lang->l('aout');
        $mois[9]    = $lang->l('septembre');
        $mois[10]   = $lang->l('octobre');
        $mois[11]   = $lang->l('novembre');
        $mois[12]   = $lang->l('decembre');

        $jour[1]    = $lang->l('lundi');
        $jour[2]    = $lang->l('mardi');
        $jour[3]    = $lang->l('mercredi');
        $jour[4]    = $lang->l('jeudi');
        $jour[5]    = $lang->l('vendredi');
        $jour[6]    = $lang->l('samedi');
        $jour[7]    = $lang->l('dimanche');

        return $jour[intval(date('N',$stamp))]." ".date('d',$stamp)." ".$mois[intval(date('m',$stamp))]." ".date('Y',$stamp);

    }

    /**
     * Date formattée
     * @param int $stamp
     * @return string
     */
    public static function realHour($stamp){
        return date('H:i',$stamp);
    }

    /**
     * Date locale formattée
     * @param int $stamp
     * @param int $decal
     * @return string
     */
    public static function localHour($stamp,$decal){
        return date('H:i',($stamp+$decal-date('Z')));
    }

    /**
     * Conversion des quotes word chelou
     * @param string $string
     * @return string
     */
    public static function convertSmartQuotes($string) {
        $search = array(chr(145), chr(146), chr(147), chr(148), chr(151));
        $replace = array("'", "'", '"', '"', '-');
        return str_replace($search, $replace, $string);
    }

    /**
     * Normalise un numéro de téléphone
     * @param string $tel
     * @param string $cc
     * @return string
     */
    public static function telephoneNormalize($tel,$cc = "FR"){

        if(empty($tel)) return "";
        if(empty($cc)) $cc = 'FR';

        $tel = preg_replace("/([^0-9\+])/","",$tel);

        if(substr($tel,0,1) == "+")     return substr($tel,1,strlen($tel)-1);
        if(substr($tel,0,2) == "00")    return substr($tel,2,strlen($tel)-2);

        if(substr($tel,0,1) == "0"){

            require_once ROOT.'lib/libphonenumber/PhoneNumberUtil.php';
            $pfx = '';
            foreach(CountryCodeToRegionCodeMap::$countryCodeToRegionCodeMap as $prefix => $cnt){
                if(in_array(strtoupper($cc),$cnt)){
                    $pfx = $prefix;
                    break;
                }
            }
            $tel = $pfx.substr($tel,1,strlen($tel)-1); // prefix longue distance
        }


        return $tel;
    }

    /**
     * Déchiffrage AES
     * @param string $val
     * @param string $ky
     * @return string
     */
    public static function aesDecrypt($val,$ky){

        $val = base64_decode($val);

        $key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        for($a = 0;$a < strlen($ky);$a++) $key[$a%16] = chr(ord($key[$a%16]) ^ ord($ky[$a]));

        $mode   = MCRYPT_MODE_ECB;
        $enc    = MCRYPT_RIJNDAEL_128;
        $dec    = mcrypt_decrypt($enc, $key, $val, $mode, mcrypt_create_iv( mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM ) );

        return rtrim($dec,(( ord(substr($dec,strlen($dec)-1,1)) >= 0 and ord(substr($dec, strlen($dec)-1,1)) <= 16)? chr(ord( substr($dec,strlen($dec)-1,1))):NULL));
    }

    /**
     * Chiffrage AES
     * @param string $val
     * @param string $ky
     * @return string
     */
    public static function aesEncrypt($val,$ky){
        $key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
        for($a = 0;$a < strlen($ky);$a++) $key[$a%16] = chr(ord($key[$a%16]) ^ ord($ky[$a]));

        $mode   = MCRYPT_MODE_ECB;
        $enc    = MCRYPT_RIJNDAEL_128;
        $val    = str_pad($val, (16*(floor(strlen($val) / 16)+(strlen($val) % 16 == 0?2:1))), chr(16-(strlen($val) % 16)));

        return base64_encode(mcrypt_encrypt($enc, $key, $val, $mode, mcrypt_create_iv( mcrypt_get_iv_size($enc, $mode), MCRYPT_DEV_URANDOM)));
    }

    /**
     * Retourne le stack des type d'utilisateur
     * @return array
     */
    public static function userDefinition($ln = Lang::LL_FR){

        $lang = Cache::getLang($ln);

        $tp = array();
        $tp[0] = $lang->l('utilisateur_anonyme');
        $tp[1] = $lang->l('utilisateur_payant');
        $tp[2] = $lang->l('client');
        $tp[3] = $lang->l('admin');
        $tp[4] = $lang->l('demo');
        $tp[5] = $lang->l('utilisateur_identifié');
        $tp[6] = $lang->l('Opérateur');
        $tp[7] = $lang->l('compte_ouvert');
        $tp[8] = $lang->l('compte_payant_manuel');

        return $tp;
    }

    /**
     * Nettoie du code JS
     * @param string $d
     * @return string
     */
    public static function jsClean($d){
        return trim(str_replace("\n", " ", $d));
    }

    /**
     *
     * @param int $length
     * @return string
     */
    public static function randomStr($length = 40){

        $str        = '';
        $keyspace   = '0123456789abcdefghijklmnopqrstuvwxyz';
        $max        = mb_strlen($keyspace, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[rand(0, $max)];
        }
        return $str;
    }

    /**
     * Securité basique pour les input utilisateur
     * @param $val
     * @return string
     */
    public static function secureStr($val) {

        $allowTags = '<a></a><p></p><br><br/><b></b><i></i>';

        $val1 = trim($val);
        $val2 = preg_replace('/\s+/', ' ', $val1);
        $val3 = strip_tags($val2, $allowTags);

        return $val3;
    }

}
