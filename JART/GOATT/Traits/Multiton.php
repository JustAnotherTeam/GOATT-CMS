<?php

namespace JART\GOATT\Traits;

/**
 *  Трейт мультитон. Хранит экземпляры класса в единственном числе для каждого ID.
 */
trait Multiton
{

    /** @var array список экземпляров */
    protected static $instances = [];

    /** Возвращает экземпляр класса по id экземпляра
     * 
     * @param mixed $id любой тип, подходящий для создания ключа в ассоциативном массиве
     * @return object экземпляр класса
     */
    public static function getInstance($id)
    {
        if (!isset(self::$instances[$id])){
            self::$instances[$id] = new self($id);
        }
        return self::$instances[$id];
    }

    /** Уничтожает экземпляр
     * 
     * @param mixed $id любой тип, подходящий для создания ключа в ассоциативном массиве
     */
    public static function removeInstance($id)
    {
        unset(self::$instances[$id]);
    }

    /**
     * Уничтожает все экземпляры класса
     */
    public static function removeAllInstances()
    {
        self::$instances = [];
    }
    /** Возвращает массив с экземплярами объекта, имеющие свойства, соответствующие заданному фильтру
     * @param array $filterRules ассоциативный массив со значениями фильтра[propertyName => propertyValue]
     * @return array|null массив экземпляров, соответствующих фильтру
     * @throws DeveloperException исключение, 
     */
    public static function simpleSearchInstancesByFilter(array $filterRules)
    {
        // проверка существования свойств
        foreach ($filterRules as $propertyName => $propertyValue){
            if (!property_exists(self, $propertyName)){
                // выход если хотя бы одно свойство не найдено
                throw new DeveloperException("Simple search failed. Wrong property name: $propertyName in class " . get_class(self), 9001001);
            }
        }
        $result = [];
        // перебор экземпляров
        foreach (self::$instances as $instance){
            $match = true;
            // перебор свойств фильтра
            foreach ($filterRules as $propertyName => $propertyValue){
                // если значние свойства не равно значению фильтра, 
                // то заканчиваем перебор свойств со значением $match = false
                if (self::$instances->$propertyName != $propertyValue){
                    $match = false;
                    break;
                }
            }
            // флаг $match = true только если все свойства равны заданным значениям
            if ($match){
                $result[] = $instance;
            }
        }
        return $result;
    }
}
