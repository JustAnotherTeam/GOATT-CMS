<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JART\GOATT\Classes;

/**
 * Абстрактный класс для расширения. <br>
 * Особенности: <br>
 * 1) Поиск по уникальному идентификатору <br>
 * 2) Хранение данных в кэше сессии для создания экземпляра  <br>
 * 3) При остутствии данных в кэше, вызывается расширяемый метод, служащий для получения данных
 * 
 * @abstract
 * @author fiftystars
 */
class CachedDataClass
{
    private static $instances = [];
    public static $cache;
    
    /** Возвращает экземпляр объекта по ключу. В первую очередь поиск производится в массиве экземпляров, во вторую - в кэше сессии, в третью - в БД
     * @param string|int $key ключ-идентификатор объекта/данных
     * @return object|null объект, в случае успеха, иначе null
     */
    public static function &getInstance($key)
    {
        
        if (isset(self::$instances[$key])){
            $instance = self::$instances[$key];
        } else {
            if (self::$cache->itemExists($key)){
                $instance = new static(self::$cache->getItemRef($key));
            }else{
                static::customDataFinder($key);
                if (self::$cache->itemExists($key)){
                    $instance = new static(self::$cache->getItemRef($key));
                }else{
                    $instance = null;
                }
            }
        }
        if (!($instance === null)){
            static::$instances[$key] = &$instance;
        }
        return $instance;
    }
    public static function newInstance(){
        
    }
    protected static function customDataFunction($key)
    {
    }

    protected static function customDataFinder($key)
    {
        $dbData = static::getData($key);
        if (is_array($dbData)) {
            foreach ($dbData as $dbRow) {
                self::$cache->bindItem($dbRow['master_id'], $dbRow);
            }
        }
    }

    protected function __construct()
    {
        
    }
    private function initCache(){
        if (self::$cache === null){
            self::$cache = new SessionCache(get_called_class());
        }
    }
}