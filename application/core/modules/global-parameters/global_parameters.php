<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of global_parameters
 *
 * @author fiftystars
 */
class global_parameters {
    
    private static $URI_Language = NULL;
    private static $URI_Controller = NULL;
    private static $URI_Action = NULL;
    private static $URI_Other = NULL;
    
    public static function getUriLanguage() {
        return self::$URI_Language;
    }
    
    public static function setUriLanguage($language) {
        if (!empty($language)){
            self::$URI_Language = $language;
        }
    }
    
    public static function getUriController(){
        return self::$URI_Controller;
    }
    
    public static function setUriController($controller) {
        if (!empty($controller)){
            self::$URI_Controller = $controller;
        }
    }
}
