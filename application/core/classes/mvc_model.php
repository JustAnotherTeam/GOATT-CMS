<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of model
 *
 * @author fiftystars
 */
class mvc_model{

    use version_trait,
        dependency_trait;

    CONST VERSION         = '1.0';
    CONST DEPENDENCY_LIST = [];

    protected $data = NULL;

    /**
     * Получает данные модели(повторное получение данных - из кэша)
     * @return mixed 
     */
    final public function getData(){
        if (is_null($data)){
            $this->data = $this->calculateData();
        }else{
            return $this->data;
        }
    }

    /**
     * расширяемая функция расчета данных. Должна возвращать результат
     */
    public function calculateData(){
        
    }

    /**
     * Перерасчет данных. Не переопределяется
     */
    final public function recalculateData(){
        $this->data = $this->calculateData();
    }

}
