<?php

namespace GOATT;

trait version_trait{

    public static function activateModule(&$moduleInfo){
        // заполнение информации о модуле
        $moduleInfo['name']           = self::MODULE_NAME;
        $moduleInfo['version']        = self::MODULE_VERSION;
        $moduleInfo['required files'] = self::MODULE_REQUIRED_FILES;
        $moduleInfo['activated']      = TRUE;

        // получение имени файла класса
        $reflection = new ReflectionClass('module_' . str_replace('-',
                                                                  '_',
                                                                  self::MODULE_NAME));
        // директория файла класса
        $basePath   = realpath(dirname($reflection->getFileName()));
        // подключение файлов
        foreach (self::MODULE_REQUIRED_FILES as $item){
            require_once($basePath . '/' . $item . '.php');
        }
    }

}
