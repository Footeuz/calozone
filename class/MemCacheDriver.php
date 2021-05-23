<?php

/**
 *    ____                       _
 *   |  _ \                     | |
 *   | |_) | ___  _ __ ___  __ _| |
 *   |  _ < / _ \| '__/ _ \/ _` | |
 *   | |_) | (_) | | |  __/ (_| | |
 *   |____/ \___/|_|  \___|\__,_|_|
 *
 *
 * Short Description
 *
 * Long Description
 *
 * @package      Beta Testing
 * @copyright    Copyright(c) 2016 Boreal Business, All Rights Reserved.
 * @author       Aurelien Munoz <aurelien@boreal-business.net>
 */


class MemCacheDriver {

    /**
     *
     * @var boolean
     */
    private static $connected = false;

    /**
     *
     * @var Memcached
     */
    private static $instance = null;

    /**
     *
     * @var int
     */
    private static $timeToLive = 3600;

    /**
     *
     * @return boolean
     */
    private static function connect(){

        self::$instance = new Memcached(MEMCACHED_POOL);
        self::$connected = true;

        foreach (self::$instance->getServerList() as $server) {
            if ($server['host'] == MEMCACHED_HOST and $server['port'] == MEMCACHED_PORT) {
                return true;
            }
        }

        self::$instance->resetServerList();
        self::$instance->addServer(MEMCACHED_HOST,MEMCACHED_PORT);
        self::$instance->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
        self::$instance->setOption(Memcached::OPT_COMPRESSION, false);

        return self::$connected;
    }

    /**
     * Récupère une data dans les server memcache
     * @param string $key
     * @return mixed
     */
    public static function getData(string $key){
        if(!self::$connected) self::connect();
        return self::$connected ? self::$instance->get($key) : null;
    }

    /**
     * Set une data sur memcache
     * @param string $key
     * @param mixed $data
     * @return boolean
     */
    public static function setData(string $key,$data){
        if(!self::$connected) self::connect();
        $r = self::$instance->set($key,$data,self::$timeToLive);

        if(!$r){
            DBG::logs("Add $key to memcache failure ".self::$instance->getResultCode()." ".self::$instance->getResultMessage());
        }

        return $r;
    }

    /**
     * Vide le cache
     * @return boolean
     */
    public static function flushData(){
        if(!self::$connected) self::connect();
        return self::$instance->flush();
    }

    /**
     *
     * @param string $key
     * @return boolean
     */
    public static function deleteData(string $key){
        if(!self::$connected) self::connect();
        return self::$instance->delete($key);
    }

}
