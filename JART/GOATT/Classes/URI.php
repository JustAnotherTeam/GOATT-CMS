<?php

namespace JART\GOATT\Classes;

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
class URI
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    private $language    = null;
    private $controller  = 'home';
    private $action      = 'default';
    private $other       = null;
    private $useLanguage = true;

    public function __construct($uri, $useLanguage = true)
    {
        $this->useLanguage = $useLanguage;
        $this->explodeUri($uri);
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function getController()
    {
        return $this->controller;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function getOther()
    {
        return $this->other;
    }

    private function explodeUri($uri)
    {
        $languageIndex   = 0;
        $controllerIndex = $this->useLanguage ? 1 : 0;
        $actionIndex     = $this->useLanguage ? 2 : 1;
        $otherIndex      = $this->useLanguage ? 3 : 2;
        
        $languageFound = false;
        $controllerFound = false;
        
        $routes = array_filter(explode('/', $uri));
        
        
        if ($this->useLanguage){
            if (isset($routes[$languageIndex])){
                //Язык найден
                
                // получаем первую позицию маршрута
                $languageStr = $routes[$languageIndex];
                // проверка существования языка
                if (language::isValidAbbr($languageStr)){
                    $this->language = $languageStr;
                    $languageFound  = true;
                }else{
                    $languageFound = false;
                }
            }else{
                // Язык не указан в URI - получаем язык по умолчанию
                
                
                Language::getDefault();
                // TODO exception
                throw new Exception('No language specified', 1234);
            }
        }
        
        echo "Language = {$this->language->getFullname()}";
        
        if (isset($routes[$controllerIndex])){
            $controllerFound = true;
        }else{
            $controllerFound = false;
        }
        
        
    }
}
