<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of module-loader
 *
 * @author fiftystars
 */
class module_loader{
    
    private static $modules = [];
    
    public static function addModule($moduleName){
        $moduleArray = ['name' => $moduleName, 'exists' => NULL, 'activated' => FALSE];
        if (!in_array($moduleArray, self::$modules)){
            array_push(self::$modules, $moduleArray);
        }
    }
    
    public static function activateModules(){
        $basePath = realpath(dirname(__FILE__));
        require_once $basePath.'/module_trait.php';
        // перебор всех добавленных модулей
        foreach (self::$modules as &$moduleInfo) {
            // получение имени файла - основной файл модуля - index.php в директории с именем модуля
            $fileName = $basePath.'/'.$moduleInfo['name'].'/index.php';
            if (file_exists($fileName)){
                //файл существует
                $moduleInfo['exists'] = TRUE;
                require_once $fileName;
                // получение имени класса
                $className = 'module_' . strtolower(str_replace('-', '_', $moduleInfo['name']));
                // активация модуля
                $className::activateModule($moduleInfo);
            }else{
                //файла не существует
                $moduleInfo['exists'] = FALSE;
            }
        }
        foreach (self::$modules as $module) {
            if(!$module['exists']){
                throw new Exception($message, $code, $previous);
            }else{
                if(!$module['activated']){
                    echo "MODULE {$module['name']} NOT ACTIVATED!";
                }
            }
        }
    }
    public static function getModulesInfo() {
        return self::$modules;
        
    }
}
