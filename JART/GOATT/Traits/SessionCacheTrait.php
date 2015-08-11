<?php
namespace JART\GOATT\Traits;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SessionCacheTrait
 *
 * @author fiftystars
 */
trait SessionCacheTrait
{

    

    public function saveToSessionCache($id)
    {
        return JART\GOATT\Classes\SessionCache::saveObjectToSessionCache($this, $id);
    }

    public function loadFromSessionCache($id, $consume = true)
    {
        $className = get_class($this);
        return JART\GOATT\Classes\SessionCache::loadObjectFromSessionCache($className,
            $className, $consume);
    }
    
    public static function loadAllFromSessionCache($className, $consume = false){
        return JART\GOATT\Classes\SessionCache::loadAllFromSessionCache($className,
                $consume);
    }
    
    public static function setStaticProperty($propertyName, $propertyValue){
        self::$$propertyName = $propertyValue;
    }

}
