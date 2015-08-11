<?php

namespace JART\GOATT\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

abstract class Language
{

    use \JART\GOATT\Traits\MultitonTrait,
        \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait,
        \JART\GOATT\Traits\SessionCacheTrait;

    /** @var string|int идентификатор языка в БД */
    private $DBID = null;
    /** @var string аббревиатура языка */
    private $abbreviation                      = null;
    /** @var string полное имя языка */
    private $fullName                          = null;
    /** @var bool признак использования как родного языка вебсайта */
    private $websiteNativeLanguage             = false;
    /** @var bool признак использования в URI */
    private $usedInURI                         = false;
    /** @var bool язык используется для локализации */
    private $usedInLocalization                = false;
    /** @var bool статус инициализации языков */
    private static $initialized                = false;

    /** Инициализация экземпляров
     */
    private static function initAllInstances()
    {
        $languages = DatabaseQueryLibrary::getAllLanguages();

        foreach ($languages as $language){
            // создание экземпляра
            $instance = new self($language);

            // запись ссылок в массив всех экземпляров
            self::$instances[] = &$instance;
        }

        self::$initialized = true;
    }

    private function __construct($langArray)
    {
        $this->fullName              = $langArray['fullName'];
        $this->abbreviation          = $langArray['abbreviation'];
        $this->usedInLocalization    = $langArray['usedInLocalization'];
        $this->usedInURI             = $langArray['usedInURI'];
        $this->websiteNativeLanguage = $langArray['websiteNative'];
    }
    
    /** Возвращает массив языков, определенных для локализации
     * @return array 
     */
    public function getLocalizationLanguages()
    {
        $filterRules = ['usedInLocalization' => true];
        return self::simpleSearchInstancesByFilter($filterRules);
    }
    
    /** Возвращает родной язык вебсайта
     * @return Language
     * @throws DBDataException если определено количество языков, отличное от одного
     */
    public function getWebsiteNativeLanguage(){
        $filterRules = ['websiteNativeLanguage' => true];
        $array = self::simpleSearchInstancesByFilter($filterRules);
        if (is_array($array)){
            if (count($array) === 1){
                return $array[0];
            }else{
                throw new DBDataException("Too much native languages!!!", 9001002);
            }
        }else{
            throw new DBDataException("No native languages!!!", 9001003);
        }
    }
    
    /** Возвращает ссылку на ИД языка в БД
     * 
     * @return string|int|null ИД языка в БД
     */
    public function &getDBID(){
        return $this->DBID;
    }
}
