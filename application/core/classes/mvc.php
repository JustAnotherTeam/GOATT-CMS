<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mvc
 *
 * @author fiftystars
 */
class mvc {
    use version_trait;
    CONST VERSION = '1.0';
    private $controller = NULL;
    
    public function __construct($mvcName) {
        // по mvcName  получаем имена файла и класса контроллера, подключаем файл и создаем контроллер
        
        $controllerFileName = 'application/content/mvc/controllers/'.$mvcName.'.php';
        
        $controllerClassName = $mvcName;
        
        $this->controller = new $controllerClassName();
        
        // вызываем действие
        
        $action = global_parameters::getUriAction();
        
        $this->controller->$action;
    }
}
