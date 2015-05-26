<?php

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
        if (empty(self::$data)){
            array_push(self::$data, '');
        }
        $newTranslations = self::getAllTranslationsOfArrayFromDB(database::getInstance(), $idArray);
        if (is_array($newTranslations) && count($newTranslations)){
            self::$data = array_merge(self::$data, $newTranslations);
        }
    }
    public static function replaceIdByTranslationInArrayOfRows(array &$array, array $columnNames){
        // получение списка id для локализации
        $arrayToTranslate = [];
        foreach ($array as $row) {
            foreach ($columnNames as $columnName) {
            
                if (is_numeric($row[$columnName])){
                    array_push($arrayToTranslate,$row[$columnName]);
                }
            }  
        }
        // получение списка локализованных данных
        self::updateTranslations($arrayToTranslate);

        // замена id на массивы с переводами
        foreach ($array as &$row) {
            foreach ($columnNames as $columnName){
                self::replaceByTranslation($row[$columnName]);
            }
        }

    }

    private static function replaceByTranslation(&$value) {
        if (isset(self::$data[$value])){
            $value = self::$data[$value];
        }else{
            $value = NULL;
        }
    }

    private static function addTranslationsToArrayOfColumns($array, array $columnNames){
 
    }
    
    public static function getAllLanguagesFromDB(database $dbObject){
        $stmt = $dbObject::prepare('CALL getAllLanguages()');
        
        if (!$stmt->execute()){
            $dbObject::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }
    /** Получает все переводы для всех id из массива
     * 
     * @param array $array - массив id переводимых строк
     */
    public static function getAllTranslationsOfArrayFromDB(database $dbObject, array $array) {
        // подготовка запроса вызова хранимой процедуры
        $stmt = $dbObject->prepare('CALL getAllTranslationsOfArray(:array)');
        
        //все id в строку через запятую
        $params = implode(',', $array);
        
        // установка параметра
        $stmt->bindParam(':array',      $params,     PDO::PARAM_STR);
        
        // выполнение запроса
        if (!$stmt->execute()){
            $dbObject::stmtErr($stmt);
        }
        // 
        $temp = $stmt->fetchAll();
        
        $result = [];
        foreach ($temp as $row) {
            $result[$row['id']][$row['language']] = $row['translated'];
        }
        return $result;
    }
}