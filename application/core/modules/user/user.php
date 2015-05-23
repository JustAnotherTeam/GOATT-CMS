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
    private $id = NULL;
    private $pageName = NULL;
    private $phoneNumber = NULL;
    private $birthDate = NULL;
    private $birthCity = NULL;
    private $currentCity = NULL;
    
    public function __construct($id = NULL) {
        // создает экземпляр пользователя
    }
    public function makeCurrent(){
        
    }
    
    public function exists(){
        // проверка существования пользователя в БД
    }
    
    public function fillInfo(){
        // запрос к БД, заполнение данных пользователя
    }
    
    public function authorizeUser($login, $password){
        // авторизация пользователя из POST данных
        // возрат - успех или неудача
    }
}
