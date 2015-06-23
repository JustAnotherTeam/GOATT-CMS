<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of uri
 *
 * @author fiftystars
 */
class uri{

    private $language    = NULL;
    private $controller  = 'home';
    private $action      = 'default';
    private $other       = NULL;
    private $useLanguage = TRUE;

    public function __construct(){

        $this->explodeUri();
    }

    public function getLanguage(){
        return $this->language;
    }

    public function getController(){
        return $this->controller;
    }

    public function getAction(){
        return $this->action;
    }

    public function getOther(){
        return $this->other;
    }

    private function explodeUri(){
        $languageIndex   = 0;
        $controllerIndex = $this->useLanguage ? 1 : 0;
        $actionIndex     = $this->useLanguage ? 2 : 1;
        $otherIndex      = $this->useLanguage ? 3 : 2;

        $routes = array_filter(explode('/',
                                       $_SERVER['REQUEST_URI']));

        if ($this->useLanguage){
            $languageStr = $routes[$languageIndex];
            if (language::isValidAbbr($languageStr)){
                $this->language = $languageStr;
                $languageFound  = TRUE;
            }else{
                $languageFound = FALSE;
            }
        }
    }

}
