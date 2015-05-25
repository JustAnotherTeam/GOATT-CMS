<?php
ini_set('display_errors', 1);
session_start();
require_once 'application/core/core.php';
require_once 'application/core/modules/!system/log.php';
require_once 'application/core/modules/!system/exception_handler.php';
try{
    $php_log = new log('php-debug');
    
    core::initCore();

    $php_log->addMessage(date(DATE_RSS));
    
} catch (Exception $exception){
    exception_handler::handleException($exception);
}
