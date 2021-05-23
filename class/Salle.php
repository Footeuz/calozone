<?php
/**
 * Salle : Official Salles from France and more
 *
 * @author Stephanie Michel <footeuz@gmail.com>
 */

class Salle extends Root {
    const TBNAME = 'caloz_salle';
    
    static $columns = array(
        'id' => 'int(8) NOT NULL',
        'name' => 'varchar(100) NOT NULL',
        'city' => 'varchar(30)',
        'dpt' => 'varchar(2)',
        'address' => 'text',
        'metro' => 'varchar(250)',
        'cp' => 'varchar(5)',
        'region' => 'varchar(5)',
        'country' => 'varchar(2)',
        'ardt' => 'varchar(2)',
        'tel' => 'varchar(15)',
        'tel2' => 'varchar(15)',
        'mail' => 'varchar(250)',
        'fax' => 'varchar(15)',
        'type' => 'varchar(250)',
        'places' => 'varchar(70)',
        'contact1' => 'varchar(250)',
        'fonction1' => 'varchar(250)',
        'tel1' => 'varchar(15)',
        'mail1' => 'varchar(250)',
        'date_festival' => 'varchar(250)',
        'code_fnac' => 'varchar(50)',
        'lat' => 'varchar(25)',
        'lng' => 'varchar(25)',
        'style' => 'varchar(250)',
        'date_festival2' => 'varchar(250)',
        'website' => 'varchar(250)',
        'active' => 'int(1) NOT NULL DEFAULT 1'
    );

    /**
     * Salle's name
     * @var string
     */
    var $name = '';
    /**
     * Salle's city
     * @var string
     */
    var $city = '';
    /**
     * Salle's department
     * @var string
     */
    var $dpt = '';
    /**
     * Salle's address
     * @var string
     */
    var $address = '';
    /**
     * Salle's metro
     * @var string
     */
    var $metro = '';
    /**
     * Salle's postal code
     * @var string
     */
    var $cp = '';
    /**
     * Salle's region
     * @var string
     */
    var $region = '';
    /**
     * Salle's country
     * @var string
     */
    var $country = '';
    /**
     * Salle's arrondissement
     * @var string
     */
    var $ardt = '';
    /**
     * Salle's tel
     * @var string
     */
    var $tel = '';
    /**
     * Salle's tel 2
     * @var string
     */
    var $tel2 = '';
    /**
     * Salle's email address
     * @var string
     */
    var $mail = '';
    /**
     * Salle's fax number
     * @var string
     */
    var $fax = '';
    /**
     * Salle's type
     * @var string
     */
    var $type = '';
    /**
     * Salle's jauge
     * @var string
     */
    var $places = '';
    /**
     * Salle's contact 1
     * @var string
     */
    var $contact1 = '';
    /**
     * Salle's fonction of contact 1
     * @var string
     */
    var $fonction1 = '';
    /**
     * Salle's telephone for contact 1
     * @var string
     */
    var $tel1 = '';
    /**
     * Salle's email address for contact 1
     * @var string
     */
    var $mail1 = '';
    /**
     * Salle's date of the festival
     * @var string
     */
    var $date_festival = '';
    /**
     * Salle's fnac's code
     * @var string
     */
    var $code_fnac = '';
    /**
     * Salle's latitude
     * @var string
     */
    var $lat = '';
    /**
     * Salle's longitude
     * @var string
     */
    var $lng = '';
    /**
     * Salle's style musical
     * @var string
     */
    var $style = '';
    /**
     * Salle's date of festival 2
     * @var string
     */
    var $date_festival2 = '';
    /**
     * Salle's website
     * @var string
     */
    var $website = '';
    /**
     * Salle is active or not
     * @var int
     */
    var $active = 1;

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new Salle($id);
        return $obj->name;
    }

    /**
     * Get full stack
     * @return \Salle[]
     */
    public static function getStack(){
        $items = array();
        $where = array('active'=>1);
        $result = SQL::select(static::TBNAME, $where, [], 'country DESC, dpt ASC, city ASC, name ASC');
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }

    /**
     * Get stack of gigs for this Salle
     * @param int $id Salle identifiant
     * @return \Gig[]
     */
    public function getGigs($id = 0){
        $items = array();
        $where = array('salle_id'=>$id);
        $result = SQL::select(Gig::TBNAME, $where, [], 'date_start ASC');
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
        }
        return $items;
    }

    /**
     * Get id of this object
     * @return int
     */
    public function getID(){
        return $this->id;
    }

    /**
     * Get stack of salles where Calogero played
     * @param integer $order (1 = normal / 2 = by nb gigs desc
     * @return \Salle[]
     */
    public static function getStackArtist($order=1){
        $items = array();
        $query = 'SELECT count(*) as nbgigs, s.* FROM '.Gig::TBNAME.' as g 
                LEFT JOIN '.static::TBNAME.' as s ON (g.salle_id = s.id) 
                WHERE g.artist_id in ('.ARTISTID_MAIN.', '.ARTISTID_CHARTS.', '.ARTISTID_CIRCUS.') GROUP BY (g.salle_id) ORDER BY ';
        if ($order == 2) $query .= 'nbgigs DESC, ';
        $query .= 's.country ASC, s.dpt ASC, s.city ASC, s.name ASC';
        $result = SQL::query($query);
        while ($item = $result->fetch_assoc()) {
            $items[$item['id']] = $item;
        }
        return $items;
    }
}
