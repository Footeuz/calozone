<?php

/**
 * UserAdmin : Users who manage client
 *
 * @author Stephanie Michel <stephanie@boreal-business.net>
 */

class UserAdmin extends Root {
    const TBNAME = 'caloz_user_admin';
    
    const S_ADMIN = 'admin';
    const S_SUPERADMIN = 'superadmin';
    const S_CUSTOMER = 'customer';

    static $columns = array(
        'id' => 'int(11) NOT NULL',
        'login' => 'varchar(30) NOT NULL',
        'password' => 'varchar(255) NOT NULL',
        'email' => 'varchar(255) NOT NULL',
        'status' => "enum('admin','superadmin','customer') NOT NULL DEFAULT 'admin'",
        'active' => 'tinyint(4) NOT NULL DEFAULT 1',
        'name' => 'varchar(255) NOT NULL',
        'url' => 'varchar(255) NOT NULL',
        'subscription_stamp_start' => 'in(11) NOT NULL DEFAULT 0',
        'subscription_stamp_end' => 'in(11) NOT NULL DEFAULT 0',
        'client_theme_id' => 'int(11) NOT NULL DEFAULT 0',
        'client_logo' => 'mediumblob'
    );

    /**
     * password's hash
     * @var string
     */
    protected $password = '';

    /**
     * admin's login
     * @var string
     */
    var $login = '';

    /**
     * admin's email
     * @var string
     */
    var $email = '';

    /**
     * User is Admin or Superadmin
     * @var enum
     */
    var $status = '';
    /**
     * Client's name
     * @var string
     */
    var $name = '';

    /**
     * Client's website's url
     * @var string
     */
    var $url = '';

    /**
     * Beginning's date of subscription
     * @var int (timestamp)
     */
    var $subscription_stamp_start = 0;

    /**
     * End date of subscription
     * @var int (timestamp)
     */
    var $subscription_stamp_end = 0;

    /**
     * Theme's id to applicate in front page
     * @var int (timestamp)
     */
    var $client_theme_id = 0;

    /**
     * Logo of company if user is a customer
     * @var string
     */
    var $client_logo = '';


    /**
     * An admin is connecting
     * @param string $login
     * @param string $pass
     * @return \UserAdmin | null si echec de la connexion
     */
    static function connection($login, $pass){
        $res = SQL::select(self::TBNAME, array('login' => $login, 'active' => 1));
        if($res->num_rows > 0){
            $rec = $res->fetch_assoc();
            if(password_verify($pass, $rec['password'])){
                $useradmin = new UserAdmin();
                $useradmin->loadRec($rec);
                $_SESSION['id_user'] = $useradmin->id;

                return $useradmin;
            } else {
                return 'Erreur : Mauvais mot de passe';
            }
        }
        
        return null;
    }

    /**
     * Get the label of one status
     * @param string $pass
     */
    static function getStatusLabel($status){
        $langstr = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        if (!in_array($langstr, Lang::$supportedLang)) $langstr = Lang::LL_FR;
        $lang = Cache::getLang($langstr);

        $a = array(self::S_ADMIN => $lang->l('administrator'), self::S_SUPERADMIN => $lang->l('super_admin'), self::S_CUSTOMER => $lang->l('customer'));
        return $a[$status];
    }

    /**
     * Get the name of one instance
     * @param int $id
     */
    static function getName($id){
        $obj = new UserAdmin($id);
        return $obj->name;
    }

    /**
     * Set new password
     * @param string $pass
     */
    function setPass($pass){
        $this->password = password_hash($pass, PASSWORD_DEFAULT);
    }

    /**
     * Get full stack
     * $status string Type of account
     * @return \UserAdmin[]
     */
    public static function getStack($status = '')
    {
        $items = array();
        $where = ($status != '') ? array('status' => $status) : array();
        $result = SQL::select(static::TBNAME, $where, [], '');
        while ($item = $result->fetch_assoc()) {
            $items[] = $item;
        }
        return $items;
    }
    
}
