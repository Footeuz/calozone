<?php

/**
 * Image
 *
 * @author vincent
 */
class Image extends Root {
    
    const TBNAME = 'imgs';
    
    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'stamp' => 'int(11) NOT NULL',
        'data' => 'mediumblob NOT NULL'
    );    
    
    /**
     * @var int
     */
    var $stamp = 0;
    var $data = null;
    
    public function __construct($id = 0) {
        $this->stamp = time();
        parent::__construct($id);
    }
    
    /**
     * Charge le contenu du fichier dans $this->data
     * @param string $path
     */
    public function fromPath($path){
        $this->data = file_get_contents($path);
    }
    
    public function delete() {
        SQL::delete(self::TBNAME, $this->id);
    }
    
}
