<?php

namespace JART\GOATT\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author fiftystars
 */
class User
{

    use \JART\GOATT\Traits\SessionCacheTrait,
        \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION               = '1.0';
    CONST DB_FIELD_ID           = 'id';
    CONST DB_FIELD_FIRST_NAME   = 'firstName';
    CONST DB_FIELD_MIDDLE_NAME  = 'middleName';
    CONST DB_FIELD_LAST_NAME    = 'lastName';
    CONST DB_FIELD_BIRTH_DATE   = 'birthDate';
    CONST DB_FIELD_BIRTH_CITY   = 'birthCity';
    CONST DB_FIELD_CURRENT_CITY = 'currentCity';
    CONST DB_FIELD_LAST_ONLINE  = 'lastOnline';

    private static $current   = null;
    private static $instances = [];
    private $id               = null;
    private $firstName        = null;
    private $middleName       = null;
    private $lastName         = null;
    private $birthDate        = null;
    private $lastOnline       = null;
    private $birthCity        = null;
    private $currentCity      = null;

    public static function setCurrentUser(user $user)
    {
        self::$current = $user;
    }

    public static function getCurrentUser()
    {
        return self::$current;
    }

    public static function getInstance($id)
    {
        if (!isset(self::$instances[$id])){
            $propertyList = DatabaseQueryLibrary::getUserPropertiesByIdList([$id]);
            if (count($propertyList)){
                $newUser = new self($id, $propertyList[0]);
                self::$instances[$id] = &$newUser;
            }else{
                $result = null;
            }
        }
    }

    public static function getInstances(array $idList, array &$notLoaded = null)
    {
        $needToLoad = [];
        $result     = [];
        // определение не загруженных экземпляров
        foreach ($idList as $id){
            if (isset(self::$instances[$id])){
                // заполнения массива возврата
                $result[$id] = self::$instances[$id];
            }else{
                // заполнение массива получения из БД
                $needToLoad[] = self::$instances[$id];
            }
        }

        // получение данных из БД и создание экземпляров
        if (count($needToLoad)){
            // получение данных из БД
            $propertyList = DatabaseQueryLibrary::getUserPropertiesByIdList($needToLoad);
            if (count($propertyList)){
                // создание экземпляров и запись в массив экземпляров
                foreach ($propertyList as $propertySet){
                    $newUser = new self($propertySet[self::DB_FIELD_ID], $propertySet);
                    self::$instances[$newUser->id] = &$newUser;
                    $result[$newUser->id] = &$newUser;
                }
            }
        }
        // возврат не загруженных пользователей
        if (!is_null($notLoaded)){
            foreach ($idList as $id){
                if (!isset($result[$id])){
                    $notLoaded[] = $id;
                }
            }
        }
        
        return $result;
        
    }

    public static function getInfoByIDList(array $idArray)
    {
        // получение данных о полььзователях по списку ID 
    }

    public function __construct($id, array $properties = null)
    {
        $this->id          = $properties[self::DB_FIELD_ID];
        $this->firstName   = $properties[self::DB_FIELD_FIRST_NAME];
        $this->middleName  = $properties[self::DB_FIELD_MIDDLE_NAME];
        $this->lastName    = $properties[self::DB_FIELD_LAST_NAME];
        $this->lastOnline  = $properties[self::DB_FIELD_LAST_ONLINE];
        $this->birthDate   = $properties[self::DB_FIELD_BIRTH_DATE];
        $this->birthCity   = $properties[self::DB_FIELD_BIRTH_CITY];
        $this->currentCity = $properties[self::DB_FIELD_CURRENT_CITY];
    }

}
