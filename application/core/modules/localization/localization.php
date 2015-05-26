<?php

/** класс отвечающий за получение текстов на определенном языке
 * 
 */
class localization{
    /**
     *
     * @var array массив[<br>
     *      123 => [<br>
     *          ['ru' => 'текст']<br>
     *          ['en' => 'text']<br>
     *      ]<br>
     * ]
     * 
     * <b>ПРИМЕЧАНИЕ: </b> элемент 0 - пустая строка
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
    
    /** замещает элементы массива строк переводами
     * 
     * @param array $array переводимый массив
     * @param array $columnNames массив имен колонок, содержащих id для перевода
     */
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
    
    /** Замещает параметр массивом переводов
     * 
     * @param integer $value элемент, содержащий id переводимой строки
     */
    private static function replaceByTranslation(&$value) {
        if (isset(self::$data[$value])){
            $value = self::$data[$value];
        }else{
            $value = NULL;
        }
    }

    private static function addTranslationsToArrayOfColumns($array, array $columnNames){
 
    }
    
    /** получение всех используемых языков
     * 
     * @param database $dbObject объект БД
     * @return array массив найденных языков
     */
    public static function getAllLanguagesFromDB(database $dbObject){
        $stmt = $dbObject::prepare('CALL getAllLanguages()');
        
        if (!$stmt->execute()){
            $dbObject::stmtErr($stmt);
        }
        return $stmt->fetchAll();
    }
    
    // TODO оправлять в логи не найденные id
    
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