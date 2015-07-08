<?php

namespace JART\GOATT\Classes;

/**
 * Класс позволяет сохранять данные в кэш сериализацией и записью в $_SESSION
 *
 * @author fiftystars
 */
class SessionCache
{
    /** @var string ветка в $_SESSION[] в которой хранится кэш*/
    CONST CACHE_BRANCH           = 'Session Cache';
    /** @var string ветка в $_SESSION[CACHE_BRANCH] в которой хранятся данные классов*/
    CONST CLASS_BRANCH           = 'Classes';
    /** @var string ветка в $_SESSION[CACHE_BRANCH][CLASS_BRANCH][className] в которой хранятся сохраненные экземпляры(экземпляры доступны по заданным вручную $id) данного класса*/
    CONST INSTANCES_BRANCH       = 'Instances';
    /** @var string ветка в $_SESSION[CACHE_BRANCH][CLASS_BRANCH][className] в которой хранятся сохраненные значения статических переменных*/
    CONST STATIC_BRANCH          = 'Static';
    /** @var string ветка в $_SESSION[CACHE_BRANCH][CLASS_BRANCH][className][STATIC_BRANCH] в которой хранятся сохраненные значения статических переменных*/
    CONST PROPERTY_NAME_BRANCH   = 'Property';
    /** @var string ветка в $_SESSION[] в которой хранится кэш*/
    CONST PROPERTY_VALUE_BRANCH  = 'Value';
    /** @var string ветка в $_SESSION[] в которой хранится кэш*/
    CONST PROPERTY_SETTER_BRANCH = 'Setter';
    /** @var string ветка в $_SESSION[] в которой хранится кэш*/
    CONST LOGS_BRANCH            = 'Logs';
    
    CONST BRANCH_DELIMITER = '\\\\';

    /** Сохраняет объект в кэш
     * 
     * @param mixed $object кэшируемое значение
     * @param mixed $id идентификатор объекта для загрузки из кэша
     */
    public static function saveObjectToSessionCache($object, $id)
    {
        $className = get_class($object);
        self::
        $_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH][$id] = serialize($object);
    }

    /** Возвращает объект из кэша
     * 
     * @param string $className имя класса
     * @param mixed $id любой тип, который может быть использован как ключ в ассоциативном массиве
     * @param bool $consume удалить после получения?
     * @return mixed объект
     */
    public static function loadObjectFromSessionCache($className, $id, $consume = true)
    {
        if (isset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH][$id])){
            $result = unserialize($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH][$id]);
            if ($consume){
                unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH][$id]);
            }
        }else{
            $result = null;
        }
        return $result;
    }

    /** Возвращает объект из кэша
     * 
     * @param string $className имя класса
     * @param mixed $id любой тип, который может быть использован как ключ в ассоциативном массиве
     * @param bool $consume удалить после получения?
     * @return mixed объект
     */
    public static function loadAllFromSessionCache($className, $consume = true)
    {
        if (isset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH])){
            foreach ($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH] as &$value){
                $result[] = unserialize($value);
                if ($consume){
                    unset($value);
                }
            }
        }else{
            $result = null;
        }
        return $result;
    }


    /** Возвращает ветку кэша в виде ссылки на массив данной ветки в $_SESSION[]
     * 
     * @param string $path
     * @return array ссылка на ветку суперглобального SESSION
     */
    public static function &getBranchRefByPath($path){
        $pathAsArray = explode(self::BRANCH_DELIMITER, $path);
        $branch = &$_SESSION[self::CACHE_BRANCH];
        foreach ($pathAsArray as $pathItem){
            if (!isset($branch[$pathItem])){
                $branch[$pathItem] = [];
            }
            $branch = &$branch[$pathItem];
        }
        return $branch;
    }
    
    public static function saveStaticPropertiesIntoCache($class, $propertiesToExclude = [])
    {
        $reflection = new \ReflectionClass($class);
        $className = $reflection->getName();
        $staticProperties = $reflection->getStaticProperties();
        // Сброс статической ветки кэша этого класса
        if (isset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH])){
            unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH]);
        }
        // Запись свойств
        foreach ($staticProperties as $staticProperty){
            // Проверка списка исключаемых свойств
            if (!array_search($propertiesToExclude, $staticProperty)){
                $_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH][$staticProperty] 
                    = $reflection->getStaticPropertyValue($staticProperty);
            }
        }
    }
    
    /** 
     * @param string|object $class имя класса или объект
     * @throws DeveloperException
     */
    public static function loadStaticPropertiesFromCache($class, $clearCache = false)
    {
        $reflection = new \ReflectionClass($class);
        $className = $reflection->getName();
        // Исключение если класс не имеет метода setStaticProperty для установки статических свойств
        if (!method_exists($class, 'setStaticProperty')){
            throw new DeveloperException('Class ' . $className . ' requires trait SessionCacheTrait to set static properties', 9001004);
        }
        if (!isset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH])){
            return false;
        }
        // перебор всех кэшированных данных
        foreach ($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH] as $staticPropertyName => $staticPropertyValue){
            // вызов метода трейта для установки статических свойств
            $className::setStaticProperty($staticPropertyName, $staticPropertyValue);
        }
        // Очистка ветки, если $clearCache == true
        if ($clearCache){
            unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH]);
        }
        return true;
    }
}
