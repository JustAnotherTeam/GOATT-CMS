<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of exception_handler
 *
 * @author fiftystars
 */
class exception_handler {
    public static function handleException(Exception $exception){
        echo "CODE: {$exception->getCode()} \n FILE: {$exception->getFile()} \n LINE: {$exception->getLine()} \n MESSAGE: {$exception->getMessage()} \n ";
    }
}
