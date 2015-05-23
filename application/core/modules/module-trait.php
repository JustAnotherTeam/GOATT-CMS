<?php

trait module_trait{
    /** массив со строками: 
     * 'name' => NULL - имя модуля
     * 'version' => NULL - версия модуля
     * 'required modules' => [['name'=>'', 'versions' => []]] - список модулей, необходимых для запуска этого модуля
     * 'require files' => [['name', ']] - список файлов, необходимых для включения и опционально активации
     *
     * @var array 
     */
    //protected static $moduleInfo = [];
    
    public static function activateModule(&$moduleInfo) {
        $moduleInfo = self::$moduleInfo;
    }
}
