<?php
/**
 * Root : Main class with utils functions (save, delete, insert, ...) All others objects are extended of this class
 *
 * @package      WeBerry
 * @author Stephanie Michel <footeuz@gmail.com>
 */

abstract class Root {


     /**
     * Column's name
     * @var string[]
     */
    static $columns = [];

    var $id = 0;
    var $active = true;

    /**
     * @param int $id
     */
    public function __construct($id = 0) {
        if($id){
            $rec = SQL::sqlrm(static::TBNAME, ['*'], $id);
            if($rec){
                $this->loadRec($rec);
            }
        }
    }

    /**
     * Load record
     * @var record
     */
    public function loadRec($rec){
        foreach(static::$columns as $col => $type){
            if(isset($rec[$col])){
                if(is_bool($this->{$col})) $this->{$col} = $rec[$col] != 0;
                else $this->{$col} = $rec[$col];
            }
        }
    }

    public function save(){
        $ret = [];
        foreach(static::$columns as $c => $type){
            if($c != 'id'){
                if(is_bool($this->{$c})){
                    $ret[$c] = $this->{$c}?1:0;
                }
                else{
                    $ret[$c] = $this->{$c};
                }
            }
        }

        if($this->id == 0){
            $this->id = sql::insert(static::TBNAME, $ret);
            return $this->id;
        }
        else{
            $update = sql::update(static::TBNAME, $ret, $this->id);
            if ($update) return $this->id; else return false;
        }
    }

    /**
     * Delete a record
     */
    public function delete(){
        return SQL::delete(static::TBNAME, $this->id);
    }

    /**
     * Build table if not exist
     */
    public static function buildTable(){

        $columnsStr = '';
        $hasId = false;

        foreach(static::$columns as $name => $type){
            if(!empty($columnsStr)) $columnsStr.=', ';
            $columnsStr.="`$name` $type";
            if($name == 'id') $hasId = true;
        }

        SQL::query("CREATE TABLE IF NOT EXISTS `".static::TBNAME."` ($columnsStr) ENGINE=MyISAM DEFAULT CHARSET=utf8 ");

        if(!SQL::checkKeyExists(static::TBNAME)){
            SQL::query("ALTER TABLE `".static::TBNAME."` ADD PRIMARY KEY (`id`);");
            SQL::query("ALTER TABLE `".static::TBNAME."` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT");
        }
    }

    /**
     * Get full stack
     * @return \Root[]
     */
    public static function getStack()
    {
        $items = array();
        $result = SQL::select(static::TBNAME, [], [], '');
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
        }
        return $items;
    }


}
