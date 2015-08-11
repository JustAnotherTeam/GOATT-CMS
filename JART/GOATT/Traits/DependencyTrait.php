<?php

namespace JART\GOATT\Traits;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Трейт получения зависимостей класса от других классов
 */
trait DependencyTrait
{

    function getDependencies()
    {
        return self::DEPENDENCY_LIST;
    }

}
