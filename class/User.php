<?php

/**
 * User : Participants of tests
 *
 * @author Stephanie Michel <stephanie@boreal-business.net>
 */
class User extends Root {
    const TBNAME = TABLEPREFIX.'_user';
    const Genre_H = 'H';
    const Genre_F = 'F';
    const Genre_Nan = 'A';

    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'code' => 'varchar(255) NOT NULL',
        'email' => 'varchar(255) NOT NULL',
        'firstname' => 'varchar(30) NOT NULL',
        'lastname' => 'varchar(30) NOT NULL',
        'stamp_created' => 'int(11) NOT NULL DEFAULT 0',
        'stamp_last' => 'int(11) NOT NULL DEFAULT 0',
        'mailing_id' => 'int(11) NOT NULL DEFAULT 0',
        'active' => 'tinyint(4) NOT NULL DEFAULT 1',
        'genre' => 'enum(\'H\',\'F\',\'A\') NOT NULL DEFAULT \'A\'',
        'age' => 'int(11) NOT NULL DEFAULT 0',
        'cp' => 'int(11) NOT NULL DEFAULT 0',
        'dep' => 'int(11) NOT NULL DEFAULT 0'
    );

    /**
     * code given by email to connect
     * @var string
     */
    var $code = '';

    /**
     * participant's email
     * @var string
     */
    var $email = '';

    /**
     * participant's firstname
     * @var string
     */
    var $firstname = '';

    /**
     * participant's lastname
     * @var string
     */
    var $lastname = '';

    /**
     * date of account's creation
     * @var int (timestamp)
     */
    var $stamp_created = 0;

    /**
     * date of last connexion
     * @var int (timestamp)
     */
    var $stamp_last = 0;

    /**
     * id of emailing who generate this account
     * @var int (timestamp)
     */
    var $mailing_id = 0;

    /**
     * genre of the user (H = men, F = women or A = not filled)
     * @var string (enum)
     */
    var $genre = 'A';

    /**
     * how old is the user
     * @var int
     */
    var $age = 0;

    /**
     * User's Postal code
     * @var string
     */
    var $cp = '';
    /**
     * User's Department
     * @var string
     */
    var $dep = '';

    /**
     * @param string $code
     * @param string $email
     * @return \User | null if no connection
     */
    static function connexion($code, $email){
        $res = SQL::select(self::TBNAME, array('code' => $code, 'email' => $email, 'active' => 1));
        if($res->num_rows > 0){
            $rec = $res->fetch_assoc();
            $user = new User();
            $user->loadRec($rec);
            $_SESSION['id_user'] = $user->id;
            return $user;
        } else {
            return 'Error : Bad code';
        }
        
        return null;
    }

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new User($id);
        $name = $obj->firstname.' '.$obj->lastname.' '.$obj->email;
        if (trim($name) == '') $name = $obj->code;
        return $name;
    }

    /**
     * Get the user by code
     * @param string $code
     */
    static function getByCode($code){
        $res = SQL::select(self::TBNAME, array('code' => $code));
        if($res->num_rows > 0){
            $rec = $res->fetch_assoc();
            $obj = new User();
            $obj->loadRec($rec);
            return $obj;
        } else {
            return false;
        }

        return false;
    }

    /**
     * Get full stack
     * $campaign_id int id of campaign
     * @return \Users[]
     */
    public static function getStack($campaign_id = 0)
    {
        $campaign_id = intval($campaign_id);

        $items = array();
        $where = ($campaign_id != 0) ? array('mailing_id' => $campaign_id, 'active' => 1) : array();
        $result = SQL::select(self::TBNAME, $where, [], '');
        if ($result) {
            while ($item = $result->fetch_assoc()) {
                $items[$item['id']] = $item;
            }
        }
        return $items;
    }
}
