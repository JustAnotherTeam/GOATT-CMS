<?php

namespace JART\GOATT\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller
 *
 * @author fiftystars
 */
class MVCController
{

    use VersionTrait,
        DependencyTrait;

    /**
     * версия класса
     */
    CONST VERSION = '1.0';
    /**
     * Список зависимостей
     */
    CONST DEPENDENCY_LIST = [];

    /**
     * Базовое имя триады(указывается в конструкторе дочернего класса)
     * @var string  
     */
    protected $baseName = null;
    /**
     * имя модели без пути, префикса и расширения
     * @var string 
     */
    protected $modelName = null;
    /**
     * Используется-ли модель в триаде 
     * @var bool 
     */
    protected $modelUse = true;
    /**
     * Экземпляр модели
     * @var mvc_model  
     */
    protected $modelObj;
    protected $viewName = null;
    protected $viewObj  = null;

    /**
     * Конструктор вызывается после конструктора дочернего класса
     */
    public function __construct()
    {
        
    }

    /**
     * Действие по умолчанию
     * @throws Exception 3 исключения
     */
    public function action_default()
    {
        if ($this->modelName === null){
            // модель не используется
            $this->modelUse = false;
        }elseif ($this->modelName === ''){
            // TODO исключение: модель - пустая строка
            throw new Exception('Пустая строка в качестве имени модели недопустима. Контроллер - ' . $this->baseName,
            12345);
        }else{
            // модель используется, указано корректное имя
            $this->modelUse  = true;
            $this->modelName = strtolower($this->modelName);

            $modelClassName = "mvc_model_{$this->modelName}";
            //$modelFileName = 'application/content/mvc/models/'.$this->modelName.'.php';
            $this->modelObj = new $modelClassName();
            $this->data     = $this->modelObj->getData();
        }

        if ($this->viewName === null){
            // TODO исключение представление не указано
            throw new Exception('Не указано имя представления. Контроллер - ' . $this->baseName,
            12345);
        }elseif ($this->viewName === ''){
            // TODO исключение: модель - пустая строка
            throw new Exception('Пустая строка в качестве имени представления недопустима. Контроллер - ' . $this->baseName,
            12345);
        }else{
            // корректное имя представления
            $this->viewName = strtolower($this->viewName);
            // получаем имя файла представления
            $viewFileName   = 'application/content/mvc/views/mvc_view_' . $this->viewName . '.php';
            // создаем представление
            $this->viewObj  = new mvc_view();
            $this->viewObj->generate($viewFileName, null, $this->data);
        }
    }

}
