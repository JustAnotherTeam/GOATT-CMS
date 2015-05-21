<?php

class cache{
    protected static $cache = [];
    protected static $cacheBranch = 'cached data';
    protected static $cacheName = NULL;

    public static function getCachedData(){
        if (empty(self::$cache)){
            self::loadCache();
        }
    }

    /**
     * 
     */
    public static function saveCache() {
        $_SESSION[self::$cacheBranch][static::$cacheName] = serialize(self::$cache);
    }
    
    /**
     * 
     */
    public static function loadCache(){
        if (isset($_SESSION[self::$cacheBranch][static::$cacheName])){
            self::$cache = unserialize($_SESSION[self::$cacheBranch][static::$cacheName]);
        }
    }
    
    /**
     * 
     */
    public static function addToCache(array $array){
        
    }
}

class city_cached extends cache{
    protected static $cacheName = 'city';
    
    public static function getCachedData() {
        parent::getCachedData();
        if (isset)
    }
    
}


class localization{
    
    protected function getAllTranslations(array $idArray) {
        
    }
}