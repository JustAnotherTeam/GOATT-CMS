<?php

namespace \GOATT;

/**
 * Расширенный класс PDO. Использует паттерн синглтон.
 *
 * @author fiftystars
 */
class database
        extends PDO{

    use version_trait;

    CONST VERSION = '1.0';

    private static $instance = NULL;
    private static $dsn      = NULL;
    private static $username = NULL;
    private static $password = NULL;
    private static $options  = NULL;

    /**
     * функция приватна для исключения использования вне синглтона
     */
    private function __construct(){
        try{
            parent::__construct(self::$dsn,
                                self::$username,
                                self::$password,
                                self::$options);
            // установка тихого режима
            $this->setAttribute(PDO::ATTR_ERRMODE,
                                PDO::ERRMODE_SILENT);
            // установка экземпляра
            self::$instance = $this;
        }catch (PDOException $e){
            // TODO exception?
        }
    }

    /** Устанавливает параметры подключения к БД
     * 
     * @param type $dsn строка подключения к БД
     * @param type $username Имя пользователя
     * @param type $password пароль пользователя
     * @param type $options дополнительные параметры подключения
     */
    public static function setConnectionParameters($dsn,
                                                   $username,
                                                   $password,
                                                   $options = NULL){
        self::$dsn      = $dsn;
        self::$username = $username;
        self::$password = $password;
        self::$options  = $options;
    }

    /** Возвращает подключение к БД(если подключение не удалось или не указаны данные подключения)
     * 
     * @return PDO||NULL
     */
    public static function getInstance(){
        if (is_null(self::$instance)){
            // если не указаны параметры подключения, то NULL
            if (is_null(self::$dsn) || is_null(self::$username) || is_null(self::$password)){
                return NULL;
            }else{
                new self;
            }
        }
        return self::$instance;
    }

}
