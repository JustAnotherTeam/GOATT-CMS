<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Ядро включает все модули, классы и информацию о классах
 *
 * @author fiftystars
 */
class core {
    private static $instance = NULL;
    
    public function __construct() {
        require_once 'application/core/modules/module_loader.php';
        module_loader::addModule('user');
        module_loader::addModule('database');
        module_loader::addModule('geo');
        module_loader::addModule('global-parameters');
        module_loader::activateModules();
        self::$instance = $this;
    }
    
    
    // PENDING необходим ли объект или можно обойтись static?
    public static function getInstance() {
        if (self::$instance === NULL){
           new self();
        }
        return self::$instance;
    }
}