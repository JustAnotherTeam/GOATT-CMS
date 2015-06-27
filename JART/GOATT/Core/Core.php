<?php

namespace JART\GOATT\Core;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Ядро подключает автолоадеры
 *
 * @author fiftystars
 */
class Core
{
    /** @var core синглтон экземпляр объекта */
    private static $instance = null;

    /**
     * Создание ядра
     */
    public function __construct()
    {
        spl_autoload_register('\JART\GOATT\Core\autoloader');
        self::$instance = $this;
    }

    /**
     * Клонирование запрещено
     */
    private function __clone()
    {
        
    }

    /**
     * Синглтон функция
     * @return core получение экземпляра объекта
     */
    public static function getInstance()
    {
        if (self::$instance === null){
            new self();
        }
        return self::$instance;
    }

}

/**
 * Функция автозагрузки классов/трейтов/интерфейсов
 * @param string $name имя искомого класса/трейта/интерфейса
 * @return
 */
function autoloader($fullClassName)
{
    
    $className = ltrim($fullClassName, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    echo 'AUTOLOAD: ' . $fileName.'<br>';
    require $fileName;
}
