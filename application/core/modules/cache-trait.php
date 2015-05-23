<?php namespace \FS;

/** класс отвечающий за получение текстов на определенном языке
 * 
 */
class localization{
    /**
     *
     * @var array массив[
     *      123 => [
     *          ['language' => 'ru', 'translated' => 'какой то текст'] 
     *          ['language' => 'ru', 'translated' => 'какой то текст'] 
     *      ]
     * ] 
     */
    
    private static $data = []; 
    
    /** обновляет статический массив $data переводами из БД на основании массива $idArray
     * 
     * @param array $idArray массив с id переводимых строк
     */
    private static function updateTranslations(array $idArray) {
        $newTranslations = db_PDO::getAllTranslationsOfArray($idArray);
        if (is_array($newTranslations) && count($newTranslations)){
            self::$data = array_merge(self::$data, $newTranslations);
        }
    }
    private static function replaceIdByTranslationInArrayOfRows(array &$array, array $columnNames){
        // получение списка id для локализации
        $arrayToTranslate = [];
        foreach ($columnNames as $columnName) {
            foreach ($array as $row) {
                if (is_numeric($row[$columnName])){
                    array_push($arrayToTranslate,$row[$columnName]);
                }
            }  
        }
        // получение списка локализованных данных
        self::updateTranslations($arrayToTranslate);

        // замена id на массивы с переводами
        foreach ($array as $row) {
            foreach ($columnNames as $columnName){
                self::replaceByTranslations($row[$columnName]);
            }
        }

    }

    private static function replaceByTranslations(&$value) {
        if (isset(self::$data[$value])){
            $value = self::$data[$value]; 
        }else{

        }
    }

    private static function addTranslationsToArrayOfColumns($array, array $columnNames){

    }
}