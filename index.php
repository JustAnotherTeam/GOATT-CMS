<?php

declare(strict_types = 1);
ini_set('memory_limit', '1024M');
/**
 * @author FiftyStars <fiftystarsdj@gmail.com>
 */
ini_set('display_errors', '1');
session_start();
//$_SESSION = [];
use JART\GOATT\Core as Core;
use JART\GOATT\Classes as Classes;
//var_dump(debug_backtrace());
// подключение ядра
require_once 'JART/GOATT/Core/Core.php';
new Core\Core();
Classes\LogDebug::enableLog();
Classes\LogDebug::addMessage('IMMA DEBUG MESSAGE');

$log = new Classes\LogSimple('someLog');
$log->addMessage('some');
echo '<pre>';
var_export(Classes\LogDebug::getAllMessages());
echo '</pre>';
try {
    
} catch (Exception $exception) {
    GOATT\Classes\ExceptionHandler::handleException($exception);
}

function &getTestData($key)
{
    $data = [['master_id' => 50,'name' => 'Name1', 'description' => 'Desc1'], ['master_id' => 100,'name' => 'Name2', 'description' => 'Desc2']];
    return $data;
}