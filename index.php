<?php
ini_set('display_errors', 1);
session_start();
require_once 'application/core/modules/module-loader.php';
module_loader::addModule('users');
module_loader::addModule('db-PDO');
module_loader::activateModules();