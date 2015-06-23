<?php

namespace JART\GOATT\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Класс, обрабатывающий исключения
 *
 * @author fiftystars
 */
class ExceptionHandler
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';

    /** Функция занимается обработкой исключений
     * 
     * @param Exception $exception обрабатываемое исключение
     */
    public static function handleException(\Exception $exception)
    {
        echo "CODE: {$exception->getCode()} \n FILE: {$exception->getFile()} \n LINE: {$exception->getLine()} \n MESSAGE: {$exception->getMessage()} \n ";
    }

}
