<?php

namespace JART\GOATT\Traits;

/**
 *  Трейт мультитон. Хранит экземпляры класса в единственном числе для каждого ID.
 */
trait Multiton
{

    /** @var array список экземпляров */
    private static $instances = [];

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

}
