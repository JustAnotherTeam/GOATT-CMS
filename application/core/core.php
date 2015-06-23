<?php

namespace GOATT;

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
class core{

    /**
     * Хранит экземпляр объекта
     * @var core синглтон экземпляр объекта
     */
    private static $instance = NULL;

    /**
     * Создание ядра
     */
    public function __construct(){
        spl_autoload_register('\GOATT\autoloader');
        self::$instance = $this;
    }

    /**
     * Клонирование запрещено
     */
    private function __clone(){
        
    }

    /**
     * Синглтон функция
     * @return core получение экземпляра объекта
     */
    public static function getInstance(){
        if (self::$instance === NULL){
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
function autoloader($name){

// разбиение для обработки случая когда $name содержит пространство имен
    $name = explode('\\',
                    $name);
    $name = $name[count($name) - 1];

    // классы ядра
    $fileName = "application/core/classes/{$name}.php";
    if (file_exists($fileName)){
        require_once $fileName;
        return;
    }

    // трейты
    $fileName = "application/core/traits/{$name}.php";
    if (file_exists($fileName)){
        require_once $fileName;
        return;
    }

    // интерфейсы
    $fileName = "application/core/interfaces/{$name}.php";
    if (file_exists($fileName)){
        require_once $fileName;
        return;
    }
}
