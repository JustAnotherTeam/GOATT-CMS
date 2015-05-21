<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db_PDO
 *
 * @author fiftystars
 */
class db_PDO {
    use module_trait;
    
    protected static $moduleInfo = [
        'name' => 'db_PDO', 
        'version' => '1.0', 
        'required modules' => [], 
        'require files' => []
    ];
    private static $instance = NULL;
    
    public function __construct() {
        $dsn = 'mysql:dbname=main_database;host=localhost';
        $username = 'root';
        $password = '2O3s8a8m8a8';
        $options = NULL;
        
        try{
            parent::__construct($dsn, $username, $password, $options);
            
// установка тихого режима
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);
// установка экземпляра
            self::$instance = $this;
        }  catch (PDOException $e){
            echo $e->getMessage();
//self::dbErr($this);
        }
    }
    
    public static function getInstance(){
        if (is_null(self::$instance)){
            new self;
        }
        return self::$instance;
    }
    
    public static function prepareCustom($statement, array $driver_options = []) {
        $stmt = self::getInstance()->prepare($statement, $driver_options);
        if (!$stmt){
            self::stmtErr($stmt);
        }
        return $stmt;
    }
    
    private static function stmtErr(PDOStatement $stmt){
        // TODO обработка ошибок stmt
        var_dump($stmt->errorInfo());
    }
    
    private static function dbErr(PDO $db){
        // TODO обработка ошибок БД
        var_dump($db->errorInfo());
    }

    public static function authorizeUser($login, $password) {
        $stmt = self::prepareCustom('CALL authorizeUser(:login, :password)');
        
        $stmt->bindParam(':login',      $login,     PDO::PARAM_STR);
        $stmt->bindParam(':password',   $password,  PDO::PARAM_STR);
        
        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }
    
    public static function getUserPermissions($id) {
        $stmt = self::prepareCustom('CALL getUserPermissions(:user_id)');
        
        $stmt->bindParam(':user_id',      $id,     PDO::PARAM_INT);
        
        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }
    
    public static function getAllLanguages(){
        $stmt = self::prepareCustom('CALL getAllLanguages()');
        
        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }
    /** Получает все переводы для всех id из массива
     * 
     * @param array $array - массив id переводимых строк
     */
    public static function getAllTranslationsOfArray(array $array) {
        $stmt = self::prepareCustom('CALL getAllTranslationsOfArray(:array)');
        
        $params = implode(',', $array);
        
        $stmt->bindParam(':array',      $params,     PDO::PARAM_STR);
        
        if (!$stmt->execute()){
            self::stmtErr($stmt);
        }
        
        $temp = $stmt->fetchAll();
        
        $result = [];
        foreach ($temp as $value) {
            $result[$value['id'].'-'.$value['language']] = ['id' => $value['id'], 'language' => $value['language'], 'translated' => $value['translated']];
        }
        return $result;
    }
}
