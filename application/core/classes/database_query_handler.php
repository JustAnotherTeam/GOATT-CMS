<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * статический класс, содержит функции, выполняющие запросы к БД
 *
 * @author fiftystars
 */
class database_query_handler{

    private static $database = NULL;

    /** устанавливает БД, к которой будут производиться запросы
     * 
     * @param PDO $database БД
     */
    public static function setDatabase(PDO $database){
        self::$database = $database;
    }

    /** Возвращает информацию о пользователе если логин+пароль корректные
     * 
     * @param type $login логин пользователя
     * @param type $password пароль пользователя
     * @return array ассоциативный массив с параметрами пользователя
     */
    public static function authorizeUser($login,
                                         $password){
        $query = 'CALL authorizeUser(:login, :password)';
        $stmt  = self::$db->prepare($query);
        // привязка параметров
        $stmt->bindParam(':login',
                         $login,
                         PDO::PARAM_STR);
        $stmt->bindParam(':password',
                         $password,
                         PDO::PARAM_STR);

        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }

    /** Возвращает массив с правами пользователя по ИД пользователя
     * 
     * @param integer $id ИД пользователя
     * @return array массив с правами пользователя
     */
    public static function getUserPermissions($id){
        $query = 'CALL getUserPermissions(:user_id)';
        $stmt  = self::$db->prepare($query);

        // привязка параметров
        $stmt->bindParam(':user_id',
                         $id,
                         PDO::PARAM_INT);

        // выполнение запроса
        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        return (array)$stmt->fetchAll();
    }

    /** Возвращает массив с языками сайта
     * 
     * @return array Массив с языками
     */
    public static function getAllLanguagesOfWebsite(){
        $query = 'CALL getAllLanguagesOfWebsite()';
        $stmt  = self::$db->prepare($query);

        // выполнение запроса
        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }

}
