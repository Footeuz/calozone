<?php

/**
 *
 * @package      WeBerry
 * @author Stephanie Michel <footeuz@gmail.com>
 */

/**
 * Gestionnaire MYSQL
 */
class SQL {

    /**
     * Instance MySQLi
     * @var mixed
     */
    static $instance = NULL;
    /**
     * Indicateur echec connexion
     * @var boolean
     */
    static $failure = false;
    /**
     * Encoding connexion
     */
    const ENCODING = 'utf8';

    /**
     * Etabli la connexion SQL
     * @return boolean
     */
    public static function connect(){

        self::$instance = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);

        if (self::$instance->connect_errno) {
            DBG::crash("Failure SQL connection");
            self::$failure = true;
            return false;
        }
        else{
            self::setEncoding();
            return true;
        }
    }

    /**
     * Termine la connexion SQL
     * @return boolean
     */
    public static function disconnect(){
        return self::$instance->close();
    }

    /**
     * Change l'encoding de la connexion SQL
     * @return boolean
     */
    private static function setEncoding(){
        return self::query("SET NAMES ".self::ENCODING);
    }

    /**
     * requete sql standard
     *
     * @param string $qr Requete SQL
     * @return mysqli_result | bool
     * @assert ("SELECT * FROM clients") != false
     */
    public static function query($qr){

        if(self::$failure) return false;

        $start = microtime(true);
        $res = self::$instance->query($qr);

        if(!$res){
            if (DEBUG) DBG::crash("mysql: ".self::$instance->sqlstate.", request ".$qr);
            return false;
        }

        if(DEBUG){
            $decal = microtime(true)-$start;
            if($decal > 0.05) DBG::logs("Slow ".$decal." request ".print_r($qr,true),DBG::L_WARNING);
        }

        return $res;

    }

    /**
     * requete insert standard
     * @param string $qr Requete SQL
     * @return int
     * @assert ("INSERT INTO logs (id) VALUES (0)") > 0
     */
    public static function queryi($qr){
        self::query($qr);
        return self::$instance->insert_id;
    }

    /**
     * requete insert auto
     * @param string $table Nom de la table
     * @param array $data Array colonne => valeur
     * @return int|boolean
     */
    public static function insert($table ,array $data){

        if(is_array($data) == true){

            $req = "INSERT INTO `".$table."` (";
            $values = '';
            $u = 0;
            $z = count($data);

            if($z > 0){
                foreach($data as $k => $v){
                    if(!is_numeric($k)){


                        $req .= '`'.$k.'`';
                        if(!is_numeric($v) && strlen($v) > 0) $values .= "'".self::escp($v)."'";
                        else if(is_null($v)) $values .= 'NULL';
                        else $values .= "'".$v."'";

                        if($u != $z-1){
                            $req .= ',';
                            $values .= ',';
                        }
                    }
                    $u++;
                }
            }

            $req .= ") VALUES (".$values.")";
            return self::queryi($req);
        }
        else return false;
    }

    public static function insertIds($table, $col, $col2, $id, array $ids){
        self::delete($table, $id, $col);
        foreach ($ids as $i){
                SQL::insert($table, array($col => $id, $col2 => intval($i)));
        }
    }

    public static function delete($table,$id, $id_col = "id"){

        if(is_array($id)){
            $where = '';
            foreach ($id as $key => $value) {
                if($where != '') $where.=" AND";
                $where.=" $key='$value'";
            }
            return self::query("DELETE FROM ".$table." WHERE $where");
        }

        return self::query("DELETE FROM ".$table." WHERE `".$id_col."`='".$id."'");
    }
    /**
     * requete update auto
     * @param string $table Nom de la table SQL
     * @param array $data Array colonne => valeur
     * @param int $id Identifiant clef primaire (peut être un array de clé valeur)
     * @param string $id_col Nom de la colonne de clef primaire
     * @return boolean
     */
    public static function update($table,array $data, $id, $id_col = "id"){

        if(count($data) > 0 && $id > 0){

            $req = "UPDATE `".$table."` SET ";
            $z = 0;
            $g = count($data);

            foreach($data as $k => $v){
                if(!is_numeric($k)){
                    $req .= '`'.$k.'`=\''.self::escp($v).'\' ';
                    if($z != $g-1) $req .= ',';
                }
                $z++;
            }

            if(is_array($id)){
                $where = '';
                foreach ($id as $key => $value) {
                    if($where != '') $where.=" AND";
                    $where.=" $key='$value'";
                }
                $req .= " WHERE $where";
            }
            else{
                if(!$id_col) $id_col = 'id';
                $req .= " WHERE `".$id_col."`='".$id."'";
            }

            $ret = self::query($req);
            return $ret;
        }
    }
    /**
     * requete select auto
     * @param string $table Nom de la table SQL
     * @param array $whereCols Array conditions where
     * @param array $data Array nom des colonnes à sélectionner
     * @return mysqli_result
     */
   public static function select($table,$whereCols = array(),$data = array(), $order = ''){
       if(!is_array($data) && $data != '') $data = array($data);
       else if(count($data) == 0 || !$data) $data = array("*");

       $req = "SELECT ".implode(",",$data)." FROM ".$table;
       $c = count($whereCols);

       if($c > 0){
           $req .= " WHERE ";
           $l = 0;
           foreach($whereCols as $k => $v){
               if ($v !== '') {
                   if (is_array($v)) {
                       $req .= "`" . $k . "` in (" . implode(",", $v) . ")";
                   } else if (substr($v, 0, 3) == 'not') {
                       $req .= "`" . $k . "` " . self::escp($v);
                   } else {
                       $req .= "`" . $k . "` = '" . self::escp($v) . "'";
                   }
                   if ($l != $c - 1) $req .= " AND ";
               }
               $l++;
           }
       }

       if($order != ''){
           $req.=" ORDER BY ".$order;
       }
       if (DEBUG) echo $req;
       return self::query($req);
   }
   /**
    * Escape string
    * @param string $p Chaine à escape
    * @return string
    */
   public static function escp($p){
       return self::$instance->real_escape_string($p);
   }
    /**
     * requete multifield standard
     * @param string $table Nom de la table
     * @param array $col Nom des colonnes à lite
     * @param int $id Identifiant clef primaire
     * @param string $idcol Nom de la colonne clef primaire
     * @return boolean
     */
    public static function sqlrm($table,array $col,$id, $idcol = "id"){ //

        $res = self::query("SELECT ".implode(",",$col)." FROM `".$table."` WHERE `".$idcol."`='".$id."'");
        if($res->num_rows > 0){
            $rec = $res->fetch_assoc();
            return $rec;
        }
        else return false;

    }
    /**
     * requete singlefield standard
     * @param string $table Nom de la table SQL
     * @param string $col nom de la colonne à lire
     * @param int $id Identifiant de la clef primaire
     * @param string $idcol Nom de la colonne clef primaire
     * @return boolean
     */
    public static function sqlr($table,$col,$id, $idcol = "id"){

        $res = self::query("SELECT ".$col." FROM `".$table."` WHERE `".$idcol."`='".$id."'");
        if($res->num_rows > 0){
            $rec = $res->fetch_assoc();
            return $rec[$col];
        }
        else return false;
    }
    /**
     * Compte le nombre de résultat
     * @param string $qr
     * @return int
     */
    public static function countRows($qr){
        $res = self::query($qr);
        return $res->num_rows;
    }

    public static function keyToWhereIn($array){
            $str = '';
                    if(is_array($array)){
                        foreach($array as $key => $value){
                                if($str!='')  $str.=',';
                                $str .= $key;
                        }
                    }
            if($str != '') return " IN ($str)";
            return " IN (-1)";
    }

    public static function toWhereIn($array){
            $str = '';
                    if(is_array($array)){
                        foreach($array as $value){
                                if($str!='')  $str.=',';
                                $str .= $value;
                        }
                    }
            if($str != '') return " IN ($str)";
            return " IN (-1)";
    }

    /**
     * Requete SQL de calcul de distance géodésique
     * @param float $real_lat Latitude de départ
     * @param float $real_lng Longitude de dépar
     * @param string $field_lat Champ latitude de la DB
     * @param string $field_lng Champ longitude de la DBt
     * @param string $res Distance calculée (nom field sql)
     * @param int $rayon Rayon de la planète, la valeur par défaut 6371 est la valeur en km du rayon moyen volumétrique
     * @return string Requete SQL
     */
    public static function dist($real_lat,$real_lng, $field_lat = 'lat',$field_lng = 'lng',$res = 'dist', $rayon = 6371){
        // distance geodésique SQL
        return "(".$rayon."*(2*ATAN2(SQRT(POW(SIN((($field_lat-$real_lat)*PI()/180)/2),2) + POW( SIN( ($field_lng-$real_lng)*PI()/180/2),2) * COS($real_lat*PI()/180) * COS($field_lat*PI()/180)), SQRT(1-(POW(SIN((($field_lat-$real_lat)*PI()/180)/2),2) + POW(SIN(($field_lng-$real_lng)*PI()/180/2),2) * COS($real_lat*PI()/180) * COS($field_lat*PI()/180)))) )) AS $res";
    }

    /**
     *
     * @param string $table
     * @param string $key
     * @return bool
     */
    public static function checkKeyExists($table, $key = 'id', $keyName = 'PRIMARY'){
        if(empty($keyName) || $keyName === 'INDEX') $keyName = $key;
        return mysqli_num_rows(SQL::query("SHOW INDEX FROM $table WHERE Key_name = '$keyName' AND Column_name = '$key'")) == 1;
    }

    public static function createIdxIfNotExists($table, $key){
        if(!SQL::checkKeyExists($table, $key, 'INDEX')){
            SQL::query("ALTER TABLE `$table` ADD INDEX(`$key`)");
        }
    }

    public static function createRelation($key1, $key2){
        $table = $key1.'_'.$key2;
        $columnsStr = "id_$key1 int(11) NOT NULL, id_$key2 int(11) NOT NULL";
        SQL::query("CREATE TABLE IF NOT EXISTS `$table` ($columnsStr) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");
        self::createIdxIfNotExists($table, "id_$key1");
    }


}