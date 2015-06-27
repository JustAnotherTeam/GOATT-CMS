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
    //$_SESSION = [];
    //var_dump($_SESSION);
    $core_log = new \JART\GOATT\Classes\Log('core-log');
    ///$core_log->addMessage('asdf');
    
    //GOATT\Classes\SessionCache::loadStaticFromSessionCache('\JART\GOATT\Classes\TestClass');
    
    /*GOATT\Classes\TestClass::setA('NewThing');
    GOATT\Classes\SessionCache::saveStaticToSessionCache('\JART\GOATT\Classes\TestClass',
        [[
        'name'   => 'a',
        'setter' => 'setA',
        'getter' => 'getA']]);
      
    */
    //echo GOATT\Classes\TestClass::getA();
    
    /*

    
    var_dump($_SESSION);*/
    
    //localizationTest();
    logTest();
    /*
      echo '3: '.GOATT\Classes\testClass::getA();
      GOATT\Classes\SessionCache::loadStaticFromSessionCache('testClass');
      echo '1: '.GOATT\Classes\testClass::getA();
      GOATT\Classes\testClass::setA('NewThing');
      echo '2: '.GOATT\Classes\testClass::getA();
      GOATT\Classes\SessionCache::saveStaticToSessionCache('testClass',
      [['name'   => 'a',
      'setter' => 'setA',
      'getter' => 'getA']]);


      echo '4: '.GOATT\Classes\testClass::getA();
      // настройка соединения с БД
      GOATT\Classes\CustomPDO::setConnectionParameters('mysql:dbname=main_database;host=127.0.0.1',
      'root', 'testPass');

      // указание БД для использования в запросах библиотеки запросов
      GOATT\Classes\DatabaseQueryLibrary::setDatabase(GOATT\Classes\CustomPDO::getInstance());

      //
      $user = new JART\GOATT\Classes\User;
      GOATT\Classes\User::setCurrentUser($user);

      // начало
      GOATT\Classes\Router::start(); */
}catch (Exception $exception){
    GOATT\Classes\ExceptionHandler::handleException($exception);
}

//************************************************************************************************************
//**88888888**888888**888888**88888888**88********88********************************************************
//*****88*****88******88*********88*****88888888**88********************************************************
//*****88*****888888**88*********88*****88****88**88********************************************************
//*****88*****88******88*********88*****88****88**88********************************************************
//*****88*****888888**888888*****88*****88888888**88********************************************************
//************************************************************************************************************
/**
 * тест лога
 * @global type $core_log
 */
function logTest()
{
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
function localizationTest()
{
    $array = [
        ['name'          => 1,
            'something'     => 2,
            'not_translate' => 'qwerty1'],
        ['name'          => 3,
            'something'     => 4,
            'not_translate' => 'qwerty2'],
        ['name'          => 5,
            'something'     => 6,
            'not_translate' => 'qwerty3'],
        ['name'          => 7,
            'something'     => 8,
            'not_translate' => 'qwerty4'],
        ['name'          => 9,
            'something'     => 10,
            'not_translate' => 'qwerty5'],
        ['name'          => 11,
            'something'     => 12,
            'not_translate' => 'qwerty6'],
        ['name'          => 13,
            'something'     => 14,
            'not_translate' => 'qwerty7'],
        ['name'          => 15,
            'something'     => 16,
            'not_translate' => 'qwerty8'],
        ['name'          => 17,
            'something'     => 18,
            'not_translate' => 'qwerty9'],
        ['name'          => 19,
            'something'     => 20,
            'not_translate' => 'qwerty10'],
        ['name'          => 21,
            'something'     => 22,
            'not_translate' => 'qwerty11'],
        ['name'          => 23,
            'something'     => 24,
            'not_translate' => 'qwerty12']
    ];
    localization::replaceIdByTranslationInArrayOfRows($array,
        ['name',
        'something']);
    var_dump($array);
}
