<?php

/**
 * @author FiftyStars <fiftystarsdj@gmail.com>
 */
ini_set('display_errors', 1);
session_start();

use JART\GOATT as GOATT;

// подключение ядра
require_once 'JART/GOATT/Core/Core.php';

new GOATT\Core\Core();
// перехват критических исключений или исключений с переадресацией
try{
    GOATT\Classes\CustomPDO::setConnectionParameters('mysql:dbname=main_database;host=localhost', 'root', 'testPass');
    
    GOATT\Classes\DatabaseQueryLibrary::setDatabase(GOATT\Classes\CustomPDO::getInstance());
    
    GOATT\Classes\Router::start();
}catch (Exception $exception){
    GOATT\Classes\ExceptionHandler::handleException($exception);
}
