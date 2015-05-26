<?php
ini_set('display_errors', 1);
session_start();
require_once 'application/core/core.php';
require_once 'application/core/modules/!system/log.php';
require_once 'application/core/modules/!system/exception_handler.php';
try{
    $core_log = new log('core-log');
    new core();

    //logTest();
    localizationTest();
    
} catch (Exception $exception){
    exception_handler::handleException($exception);
}

function logTest(){
    // log test
    global $core_log;
    $core_log->addMessage(date(DATE_RSS));
    $messages = array_reverse($core_log->getAllMessages());
    header('Content-type: text/plain');
    foreach ($messages as $value) {
        echo "$value\n";
    }
}

function localizationTest(){
    $array = [
        ['name' => 1, 'something' => 2, 'not_translate'=> 'qwerty1'],
        ['name' => 3, 'something' => 4, 'not_translate'=> 'qwerty2'],
        ['name' => 5, 'something' => 6, 'not_translate'=> 'qwerty3'],
        ['name' => 7, 'something' => 8, 'not_translate'=> 'qwerty4'],
        ['name' => 9, 'something' => 10, 'not_translate'=> 'qwerty5'],
        ['name' => 11, 'something' => 12, 'not_translate'=> 'qwerty6'],
        ['name' => 13, 'something' => 14, 'not_translate'=> 'qwerty7'],
        ['name' => 15, 'something' => 16, 'not_translate'=> 'qwerty8'],
        ['name' => 17, 'something' => 18, 'not_translate'=> 'qwerty9'],
        ['name' => 19, 'something' => 20, 'not_translate'=> 'qwerty10'],
        ['name' => 21, 'something' => 22, 'not_translate'=> 'qwerty11'],
        ['name' => 23, 'something' => 24, 'not_translate'=> 'qwerty12']
        
    ];
    localization::replaceIdByTranslationInArrayOfRows($array, ['name', 'something']);
    var_dump($array);
    
}