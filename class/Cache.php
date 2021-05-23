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
 * Functions to get cached objects
 *
 * Long Description
 *
 * @package      BetaTesting
 * @copyright    Copyright(c) 2016 Boreal Business, All Rights Reserved.
 * @author       Aurelien Munoz <aurelien@boreal-business.net>
 */

class Cache {
    //put your code here

    const JSON_CACHE_MAX_AGE = 172800;

    /**
     *
     * @var \User[]
     */
    static $cache_user              = array();
    /**
     *
     * @var \UserAdmin[]
     */
    static $cache_useradmin         = array();
    /**
     *
     * @var \Question[]
     */
    static $cache_question         = array();
    /**
     *
     * @var \Response[]
     */
    static $cache_response         = array();
    /**
     *
     * @var \Image[]
     */
    static $cache_image            = array();
    /**
     *
     * @var \Lang
     */
    static $cache_lang             = null;
    /**
     *
     * @param int $id
     * @return \User
     */
    public static function getUser($id){
        if(isset(self::$cache_user[$id])) return self::$cache_user[$id];
        self::$cache_user[$id] = new User($id);
        return self::$cache_user[$id];
    }
    /**
     *
     * @param int $id
     * @return \UserAdmin
     */
    public static function getUserAdmin($id){
        if(isset(self::$cache_useradmin[$id])) return self::$cache_useradmin[$id];
        self::$cache_useradmin[$id] = new UserAdmin($id);
        return self::$cache_useradmin[$id];
    }

    /**
     *
     * @param int $id
     * @return \Question
     */
    public static function getQuestion($id){
        if(isset(self::$cache_question[$id])) return self::$cache_question[$id];
        $cdb = MemCacheDriver::getData(Question::class.".$id");
        if($cdb) return $cdb;

        self::$cache_question[$id] = new Question($id);
        MemCacheDriver::setData(Question::class.".$id",self::$cache_question[$id]);

        return self::$cache_question[$id];
    }

    /**
     * @param int $id
     * @return Response
     */
    public static function getResponse($id){
        if(isset(self::$cache_response[$id])) return self::$cache_response[$id];
        $cdb = MemCacheDriver::getData(Response::class.".$id");
        if($cdb) return $cdb;
        self::$cache_response[$id] = new Response($id);
        MemCacheDriver::setData(Response::class.".$id",self::$cache_response[$id]);

        return self::$cache_reponses[$id];
    }

    /**
     * @param int $id
     * @return Image
     */
    public static function getImage($id){
        if(isset(self::$cache_image[$id])) return self::$cache_image[$id];
        self::$cache_image[$id] = new Image($id);
        return self::$cache_image[$id];
    }
    /**
     * @param $lg
     * @return mixed
     */
    public static function getLang($lg){
        if(isset(self::$cache_lang[$lg])) return self::$cache_lang[$lg];

        self::$cache_lang[$lg] = new Lang();
        self::$cache_lang[$lg]->load($lg);

        return self::$cache_lang[$lg];

    }


}
