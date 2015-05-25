<?php

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
class user {
    
    private static $current = NULL;
    private static $users = [];

    private $id = NULL;
    private $firstName = NULL;
    private $middleName = NULL;
    private $lastName = NULL;
    private $birthDate = NULL;
    private $lastOnline = NULL;
    private $birthCity = NULL;
    private $currentCity = NULL;
    
    
    public static function setCurrentUser(user $user){
        self::$currentUser = $user;
    }
    
    public static function getCurrentUser(){
        return self::$currentUser;
    }
    
    public static function getUser(){
        $newUser = new user(id);
        array_push(self::$users, $newUser);
    }
    
    public static function createUsersByIdArray(array $idArray){
        // создание пользователей по списку ID
        $usersInfo = self::getInfoByIDList($idArray);
        foreach ($usersInfo as $userInfo) {
            $newUser = new self();
            $newUser->id = $userInfo['user_id'];
            $newUser->firstName     = $userInfo['first_name'];
            $newUser->middleName    = $userInfo['middle_name'];
            $newUser->lastName      = $userInfo['last_name'];
            $newUser->birthDate     = $userInfo['birth_date'];
            $newUser->birthCityId   = $userInfo['birth_city_id'];
        }
    }
    
    public static function getInfoByIDList(array $idArray){
        // получение данных о полььзователях по списку ID 
    }
    public function __construct() {
        ;
    }
}
