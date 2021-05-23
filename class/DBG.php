<?php

#####################################################################
#                                                                   #
#   Boreal Business                                                 #
#                                                                   #
#   Copyright(c) 2015 Boreal Business, All Rights Reserved.         #
#   Auteur : Aurélien Munoz (aurelien@boreal-business.net)          #
#                                                                   #
#####################################################################

/**
 * Fonction de log et débuggage
 * @author Aurélien
 */
class DBG {
    /**
     * Buffer logs text
     * @var array
     */
    static $logsl = array();
    /**
     * Message type notice
     */
    const L_NOTICE      = "0;37";
    /**
     * Message type warning
     */
    const L_WARNING     = "0;35";
    /**
     * Message type erreur
     */
    const L_ERROR       = "1;33";
    /**
     * Message type critique
     */
    const L_CRITICAL    = "0;31";
    /**
     * Message bancaire
     */
    const L_BANK        = "1;34";
    /**
     * Message success
     */
    const L_SUCCESS     = "1;32";
    
    /**
     * @param string $data
     * @param string $level
     */
    static public function logs($data, $level = ""){
        //$ms = substr(microtime(true)-time(),2,5);
        $addr = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'';
        $dtx = date("Y-m-d H:i:s")." | ".$addr." | ".utf8_decode($data);
        self::$logsl[] = $dtx;
        
        //syslog(LOG_INFO, $dtx);
    }
    
    /**
     * Insertion des logs
     */
    static public function logswrite(){

        if(DEBUG){
            if(count(self::$logsl) > 0){

                $fp = ROOT.'logs/';
                $fp1 = $fp.date('Y').'/';
                $fp2 = $fp1.date('m').'/';

                if(!file_exists($fp1)) mkdir($fp1);
                if(!file_exists($fp2)) mkdir($fp2);

                $fp = fopen($fp2.date('d').".txt","a+");
                fwrite($fp,"\n".implode("\n",self::$logsl));
                fclose($fp);

            }
        }

        self::$logsl = array();
    }
    
    static function crash($er){
    
        self::logs($er);
        self::logswrite(); 
        echo $er."\n<br />";
        
        $bt = debug_backtrace();
        
        echo '<pre>';
        for($i=1; $i<=4; $i++) if(isset($bt[$i])) print_r($bt[$i]);
        echo '</pre>';

    }
    
    static function show($var, $txt = ''){
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        if($txt !== null) die($txt);
    }


    static function errorHandler($errno, $errstr, $errfile, $errline) {
        
        $typestr = null;
        
        switch ($errno) {
            case E_ERROR:               $typestr = 'E_ERROR';                   break;
            case E_WARNING:             $typestr = 'E_WARNING';                 break;
            case E_PARSE:               $typestr = 'E_PARSE';                   break;
            case E_CORE_ERROR:          $typestr = 'E_CORE_ERROR';              break;
            case E_CORE_WARNING:        $typestr = 'E_CORE_WARNING';            break;
            case E_COMPILE_ERROR:       $typestr = 'E_COMPILE_ERROR';           break;
            case E_COMPILE_WARNING:        $typestr = 'E_COMPILE_WARNING';         break;
            case E_USER_ERROR:          $typestr = 'E_USER_ERROR';              break;
            case E_USER_WARNING:        $typestr = 'E_USER_WARNING';            break;
            case E_USER_NOTICE:         $typestr = 'E_USER_NOTICE';             break;
            case E_STRICT:              $typestr = 'E_STRICT';                  break;
            case E_RECOVERABLE_ERROR:   $typestr = 'E_RECOVERABLE_ERROR';       break;
            case E_DEPRECATED:          $typestr = 'E_DEPRECATED';              break;
            default : $typestr = 'OTHER';              break;
        }

        if($typestr){
            self::logs($typestr.': '.$errstr.' in '.$errfile.' on line '.$errline, DBG::L_CRITICAL);
            self::crash($typestr.': '.$errstr.' in '.$errfile.' on line '.$errline);
        }

    }
    /**
     * Fonction de logging
     * 
     * @global int $masterpid
     * @param string $data
     */
    static function slogs($data){
        
        //$dx .= $data."\n";
        //file_put_contents('php://stderr',$dx);
        
        self::logs($data);
        //self::logswrite();
    }
    
}
