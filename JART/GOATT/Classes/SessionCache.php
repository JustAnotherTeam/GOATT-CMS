<?php

namespace JART\GOATT\Classes;

/**
 * 
 * @author fiftystars
 */
class SessionCache
{

    const SECTION_CACHE     = 'cache';
    const SECTION_CLASSES   = 'classes';
    const SECTION_INSTANCES = 'instances';
    const SECTION_STATIC    = 'static';

    private static $ownerClassName = null;
    protected $cache               = null;

    /**
     * 
     * @param mixed $instanceKey опционально. Ключ экземпляра 
     */
    protected static function initializeCache($instanceKey = null)
    {
        // инициализация ветки кэша
        if (!isset($_SESSION[self::SECTION_CACHE]) || !is_array($_SESSION[self::SECTION_CACHE])) {
            $_SESSION[self::SECTION_CACHE] = [];
        }
        // инициализация ветки списка классов
        $cache = &$_SESSION[self::SECTION_CACHE];
        if (!isset($cache[self::SECTION_CLASSES]) || !is_array($cache[self::SECTION_CLASSES])) {
            $cache[self::SECTION_CLASSES] = [];
        }
        // инициализация ветки конкретного класса
        $classes = &$cache[self::SECTION_CLASSES];
        if (!isset($classes[self::$ownerClassName]) || !is_array($classes[self::$ownerClassName])) {
            $classes[self::$ownerClassName] = [];
        }
        // инициализация ветки данных, относящихся к классу в целом
        $curClass = &$classes[self::$ownerClassName];
        if (!isset($curClass[self::SECTION_STATIC]) || !is_array($curClass[self::SECTION_STATIC])) {
            $curClass[self::SECTION_STATIC] = [];
        }
        // инициализация ветки списка экземпляров класса
        if (!isset($curClass[self::SECTION_INSTANCES]) || !is_array($curClass[self::SECTION_INSTANCES])) {
            $curClass[self::SECTION_INSTANCES] = [];
        }
        // если ключ экземпляра указан, то инициализация ветки данных, относящихся к конкретному экземпляру
        if (!($instanceKey === null)) {
            $instances = &$curClass[self::SECTION_INSTANCES];
            if (!isset($instances[$instanceKey]) || !is_array($instances[$instanceKey])) {
                $instances[$instanceKey] = [];
            }
        }
    }

    public function __construct($className, $instanceKey = null)
    {
        self::$ownerClassName = $className;
        static::initializeCache($instanceKey);
        if ($instanceKey === null) {
            $this->cache = &$_SESSION[self::SECTION_CACHE][self::SECTION_CLASSES][$className][self::SECTION_STATIC];
        } else {
            $this->cache = &$_SESSION[self::SECTION_CACHE][self::SECTION_CLASSES][$className][self::SECTION_INSTANCES][$instanceKey];
        }
    }

    public function setItem($key, $data)
    {
        $this->cache[$key] = $data;
    }

    public function bindItem($key, &$data)
    {
        $this->cache[$key] = $data;
    }

    public function removeItem($key)
    {
        unset($this->cache[$key]);
    }

    public function pushItem($data)
    {
        $this->cache[] = $data;
    }

    public function itemExists($key)
    {
        if (isset($this->cache[$key])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function getItem($key)
    {
        if (isset($this->cache[$key])) {
            $result = $this->cache[$key];
        } else {
            $result = null;
        }
        return $result;
    }

    public function &getItemRef($key)
    {
        if (isset($this->cache[$key])) {
            $result = $this->cache[$key];
        } else {
            $result = null;
        }
        return $result;
    }

    public function getAllItems()
    {
        return $this->cache;
    }

    public function &getAllItemsRef()
    {
        return $this->cache;
    }
}
