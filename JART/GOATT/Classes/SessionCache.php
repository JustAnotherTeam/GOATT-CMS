<?php

namespace JART\GOATT\Classes;

/**
 * Класс позволяет 
 *
 * @author fiftystars
 */
class SessionCache
{

    CONST CACHE_BRANCH           = 'Session Cache';
    CONST CLASS_BRANCH           = 'Classes';
    CONST INSTANCES_BRANCH       = 'Instances';
    CONST STATIC_BRANCH          = 'Static';
    CONST PROPERTY_NAME_BRANCH   = 'Property';
    CONST PROPERTY_VALUE_BRANCH  = 'Value';
    CONST PROPERTY_SETTER_BRANCH = 'Setter';
    CONST LOGS_BRANCH            = 'Logs';
    
    /** Сохраняет объект в кэш
     * 
     * @param mixed $object кэшируемое значение
     * @param mixed $id идентификатор объекта для загрузки из кэша
     */
    public static function saveObjectToCache($object, $id)
    {
        $className = get_class($object);
        $_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::INSTANCES_BRANCH][$id] = serialize($object);
    }

    /** Возвращает объект из кэша
     * 
     * @param string $className имя класса
     * @param mixed $id любой тип, который может быть использован как ключ в ассоциативном массиве
     * @param bool $consume удалить после получения?
     * @return mixed объект
     */
    public static function loadObjectFromCache($className, $id, $consume = true)
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
    
    /** Удаляет из кэша определенные ветки данных 
     * @param string $branch имя общей ветки. Варианты - константы класса: CACHE_BRANCH, CLASS_BRANCH, INSTANCES_BRANCH, STATIC_BRANCH, LOGS_BRANCH;
     * @param string $subName имя конкретного класса или лога, указанные ветки которого нужно удалить
     * @return boolean false если параметр $branch некорректен, иначе true
     */
    public function removeCacheBranch($branch, $subName = null)
    {
        switch ($branch){
            case self::CLASS_BRANCH:
                if (!is_null($subName)){
                    // удаление всех веток определенного класса
                    unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$subName]);
                }else{
                    // Удаление всех веток всех классов
                    unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH]);
                }
                $result = true;
                break;
            case self::STATIC_BRANCH:
                if (!is_null($subName)){
                    // Удаление ветки STATIC определенного класса
                    unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$subName][self::STATIC_BRANCH]);
                }else{
                    // перебор всех кэшированных классов и удаление ветки STATIC
                    foreach ($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH] as $classBranch){
                        unset($classBranch[self::STATIC_BRANCH]);
                    }
                }
                $result = true;
                break;
            case self::INSTANCES_BRANCH:
                if (!is_null($subName)){
                    // Удаление ветки INSTANCES определенного класса
                    unset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$subName][self::INSTANCES_BRANCH]);
                }else{
                    // перебор всех кэшированных классов и удаление ветки INSTANCES
                    foreach ($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH] as $classBranch){
                        unset($classBranch[self::INSTANCES_BRANCH]);
                    }
                }
                $result = true;
                break;
            case self::LOGS_BRANCH:
                if (!is_null($subName)){
                    // удаление ветки определенного лога
                    unset($_SESSION[self::CACHE_BRANCH][self::LOGS_BRANCH][$subName]);
                }else{
                    // удаление веток всех логов
                    unset($_SESSION[self::CACHE_BRANCH][self::LOGS_BRANCH]);
                }
                $result = true;
                break;
            default:
                $result = false;
                break;
        }
        
        return $result;
    }

    /**
     * 
     * @param string $className имя класса, свойства которого должны быть отправлены в кэш
     * @param array $propertyNamesList массив из <br>['property' => 'имяСвойства', 
     * 'getter' => 'имяФункцииПолученияЗначенияСвойства', 'setter' => 'имяФункцииУстановкиЗначенияСвойства'] 
     */
    public static function saveStaticToSessionCache($className,
        array $propertyNamesList)
    {
        foreach ($propertyNamesList as $property){
            $getterName = $property['getter'];
            $value      = $className::$getterName();

            $_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH][$property['name']] = [
                self::PROPERTY_SETTER_BRANCH => $property['setter'],
                self::PROPERTY_VALUE_BRANCH  => serialize($value)];
        }
    }

    /** Функция выгружает из кэша статические свойства указанного класса
     * 
     * @param string $className имя класса для которого должны быть выгружены статические свойства
     * @param array $propertyList список выгружаемых свойств(если null, то выгрузятся все свойства)
     * @return bool true в случае успеха, иначе false
     */
    public static function loadStaticFromSessionCache($className,
        array $propertyList = null)
    {
        if (isset($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH])){

            if (is_null($propertyList)){
                foreach ($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH] as $varName => $static){
                    $setter = $static [self::PROPERTY_SETTER_BRANCH];
                    $value  = unserialize($static[self::PROPERTY_VALUE_BRANCH]);
                    $className::$setter($value);
                }
            }else{
                foreach ($propertyList as $propertyName){
                    $setter = $_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH][$propertyName]['setter'];
                    $value  = unserialize($_SESSION[self::CACHE_BRANCH][self::CLASS_BRANCH][$className][self::STATIC_BRANCH][$propertyName]['value']);
                    $className::$setter($value);
                }
            }
            return true;
        }else{
            return false;
        }
    }

    /** Возвращает ветку кэша в виде ссылки на массив данной ветки в $_SESSION[]
     * 
     * @param string $branchName
     * @return array ветка суперглобального SESSION для хранения лога
     */
    public static function &getBranchAsReference($branchName)
    {
        // если ветки не существует, то создаем пустую
        if (!isset($_SESSION[self::CACHE_BRANCH][$branchName])){
            $_SESSION[self::CACHE_BRANCH][$branchName] = [];
        }
        // Возвращаем ветку
        return $_SESSION[self::CACHE_BRANCH][$branchName];
    }

}
