<?php

/**
 * Description of db_PDO
 *
 * @author fiftystars
 */
class database extends PDO{

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
    
    public function prepare($statement, array $driver_options = []) {
        return parent::prepare($statement, $driver_options);
    }
    
//    public function prepare($statement, array $driver_options = []) {
//        $stmt = parent->prepare($statement, $driver_options);
//        if (!$stmt){
//            self::stmtErr($stmt);
//        }
//        return $stmt;
//    }
    
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
    
    
}
