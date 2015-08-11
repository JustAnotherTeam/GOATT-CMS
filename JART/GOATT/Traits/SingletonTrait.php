<?php
namespace JART\GOATT\Traits;

/** Трейт синглтон. Позволяет существование только одного экземпляра класса
 *
 * @author fiftystars
 */
trait SingletonTrait
{
    /** @var object|null экземпляр класса */
    private static $instance = null;
    
    /** Возвращает экземпляр класса
     * @return object
     */
    public static function getInstance(){
        if (is_null(self::$instance)){
            self::$instance = new self;
        }
        
        return self::$instance;
    }
    
    /** Уничтожает экземпляр класса */
    public static function removeInstance(){
        self::$instance = null;
    }
}
