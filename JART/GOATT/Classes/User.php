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
class User implements \JART\GOATT\Interfaces\CacheableInSession
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';

    private static $current = null;
    private static $users   = [];
    private $id             = null;
    private $firstName      = null;
    private $middleName     = null;
    private $lastName       = null;
    private $birthDate      = null;
    private $lastOnline     = null;
    private $birthCity      = null;
    private $currentCity    = null;

    public static function setCurrentUser(user $user)
    {
        self::$current = $user;
    }

    public static function getCurrentUser()
    {
        return self::$current;
    }

    public static function getUser()
    {
        $newUser = new user();
        array_push(self::$users, $newUser);
    }

    public static function createUsersByIdArray(array $idArray)
    {
        // создание пользователей по списку ID
        $usersInfo = self::getInfoByIDList($idArray);
        foreach ($usersInfo as $userInfo){
            $newUser              = new self();
            $newUser->id          = $userInfo['user_id'];
            $newUser->firstName   = $userInfo['first_name'];
            $newUser->middleName  = $userInfo['middle_name'];
            $newUser->lastName    = $userInfo['last_name'];
            $newUser->birthDate   = $userInfo['birth_date'];
            $newUser->birthCityId = $userInfo['birth_city_id'];
        }
    }

    public static function getInfoByIDList(array $idArray)
    {
        // получение данных о полььзователях по списку ID 
    }

    public function __construct()
    {
        ;
    }
    
    public function saveToSessionCache()
    {
        ;
    }
    public function loadFromSessionCache()
    {
        ;
    }
}
