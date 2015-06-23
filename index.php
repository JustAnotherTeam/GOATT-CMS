<?php

/**
 * @author FiftyStars <fiftystarsdj@gmail.com>
 */
ini_set('display_errors',
        1);
session_start();

// подключение ядра
require_once 'application/core/core.php';
new GOATT\core();

// перехват критических исключений или исключений с переадресацией
try{
    $core_log = new GOATT\log('core-log');

    //localizationTest();
    //logTest();

    GOATT\router::start();
}catch (Exception $exception){
    GOATT\exception_handler::handleException($exception);
}

//*************************************************************************************************************
//*************************************************************************************************************
//*************************************************************************************************************
//*************************************************************************************************************
//*************************************************************************************************************
//*************************************************************************************************************
/**
 * тест лога
 * @global type $core_log
 */
function logTest(){
    // log test
    global $core_log;
    $core_log->addMessage(date(DATE_RSS));
    $messages = array_reverse($core_log->getAllMessages());
//    header('Content-type: text/plain');
//    foreach ($messages as $value) {
//        echo "$value\n";
//    }
    var_dump($messages);
}

/**
 * тест локализации
 */
function localizationTest(){
    $array = [
        ['name' => 1, 'something' => 2, 'not_translate' => 'qwerty1'],
        ['name' => 3, 'something' => 4, 'not_translate' => 'qwerty2'],
        ['name' => 5, 'something' => 6, 'not_translate' => 'qwerty3'],
        ['name' => 7, 'something' => 8, 'not_translate' => 'qwerty4'],
        ['name' => 9, 'something' => 10, 'not_translate' => 'qwerty5'],
        ['name' => 11, 'something' => 12, 'not_translate' => 'qwerty6'],
        ['name' => 13, 'something' => 14, 'not_translate' => 'qwerty7'],
        ['name' => 15, 'something' => 16, 'not_translate' => 'qwerty8'],
        ['name' => 17, 'something' => 18, 'not_translate' => 'qwerty9'],
        ['name' => 19, 'something' => 20, 'not_translate' => 'qwerty10'],
        ['name' => 21, 'something' => 22, 'not_translate' => 'qwerty11'],
        ['name' => 23, 'something' => 24, 'not_translate' => 'qwerty12']
    ];
    localization::replaceIdByTranslationInArrayOfRows($array,
                                                      ['name', 'something']);
    var_dump($array);
}
