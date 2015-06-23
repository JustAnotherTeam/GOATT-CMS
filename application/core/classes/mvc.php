<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Класс представляет собой триаду MVC
 * 
 * @author fiftystars
 */
final class mvc{

    use version_trait,
        dependency_trait;

    CONST VERSION         = '1.0';
    CONST DEPENDENCY_LIST = [
        ['name' => 'global-parameters', 'versionFrom' => '1.0', 'versionTo' => ''],
        ['name' => 'router', 'versionFrom' => '1.0', 'versionTo' => ''],
        ['name' => 'core', 'versionFrom' => '1.0', 'versionTo' => '']
    ];

    private $controller = NULL;

    /**
     * 
     * @param type $mvcName базовое имя триады. Имя контроллера(без пути, 'mvc_controller_' и '.php')
     */
    public function __construct($mvcName = NULL){
        // по mvcName  получаем имена файла и класса контроллера, подключаем файл и создаем контроллер

        if ($mvcName === NULL){
            $mvcName = global_parameters::getUriController();
        }
        $controllerClassName = "mvc_controller_{$mvcName}";

        $this->controller = new $controllerClassName($mvcName);

        // вызываем действие

        $action = global_parameters::getUriAction();
        if (method_exists($this->controller,
                          $action)){
            $this->controller->$action;
        }
    }

}
