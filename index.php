<?php
ini_set('display_errors', 1);
session_start();
require_once 'application/core/modules/module-loader.php';
module_loader::addModule('log');
module_loader::addModule('users');
module_loader::addModule('db-PDO');
module_loader::activateModules();

$php_log = new log('php-debug');
$php_log->addMessage(date(DATE_RSS));
//$php_log->addMessage(module_loader::getModulesInfo());

foreach (array_reverse($php_log->getAllMessages()) as $message) {
    var_dump($message);
}
Новая строка
?>