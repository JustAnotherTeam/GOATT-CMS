<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Трейт получения зависимостей класса от других классов
 */
trait dependency_trait{

    function getDependencies(){
        return self::DEPENDENCY_LIST;
    }

}
