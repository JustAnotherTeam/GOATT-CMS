<?php

namespace JART\GOATT\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * класс для работы с языками
 *
 * @author fiftystars
 */
class Language
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    private $abbr;
    private $fullname;
    private static $languages        = []; // [['abbr'=>'ru', 'fullname'=>'russian']]
    private static $languagesUpdated = false;
    public static $instances         = [];

    /** Валидная аббревиатура языка?
     * 
     * @param string $string строка
     * @return boolean результат
     */
    public static function isValidAbbr($string)
    {
        foreach (self::$languages as $language){
            if ($language['abbr'] == $string){
                return true;
            }
        }
        return false;
    }

    /** Валидное полное имя языка?
     * 
     * @param string $string строка
     * @return boolean результат
     */
    public static function isValidFullname($string)
    {
        foreach (self::$languages as $language){
            if ($language['fullname'] == $string){
                return true;
            }
        }
        return false;
    }

    /** Возвращает аббревиатуру языка по полному имени
     * 
     * @param string $fullname полное имя языка
     * @return string|null аббревиатура языка или null если полное имя не найдено
     */
    public static function findAbbrByFullname($fullname)
    {
        foreach (self::$languages as $language){
            if ($language['fullname'] == $fullname){
                return $language['abbr'];
            }
        }
        return null;
    }

    /** Возвращает полное имя языка по аббревиатуре
     * 
     * @param string $abbr аббревиатура языка
     * @return string|null полное имя языка или null если аббревиатура не найдена
     */
    public static function findFullnameByAbbr($abbr)
    {
        foreach (self::$languages as $language){
            if ($language['abbr'] == $abbr){
                return $language['fullname'];
            }
        }
        return null;
    }

    /** Возвращает объект, представляющий язык(на каждый язык не более одного экземпляра класса)
     * 
     * @param string $language
     * @return language объект, представляющий язык
     */
    public static function getInstance($language)
    {
        // если нет такого языка в экземплярах, то создаем новый
        if (!isset(self::$instances[$language])){
            $new = new self($language);
            // если не удалось 
            if (is_null($new)){
                return null;
            }else{
                self::$instances[$new->getAbbr()]     = $new;
                self::$instances[$new->getFullname()] = $new;
            }
        }

        return self::$instances[$language];
    }

    /**
     * обновление списка языков(получение из БД
     */
    public static function updateLanguagesList()
    {
        self::$languages = DatabaseQueryLibrary::getAllLanguagesOfWebsite();
    }

    /**
     * 
     * @param string $abbrOrFull аббревиатура языка или полное имя
     * @return language|null null возвращается если строка $abbrOrFull не найдена в списке языков
     */
    private function __construct($abbrOrFull)
    {
        // если список языков не обновлен, то обновляем
        if (!self::$languagesUpdated){
            self::updateLanguagesList();
            self::$languagesUpdated = true;
        }
        // проверка на существование строки как аббревиатуры или полного имени
        $validAbbr = self::isValidAbbr($abbrOrFull);
        $validFull = self::isValidFullname($abbrOrFull);
        // если не найдено, но возвращаем null
        if (!$validAbbr && !$validFull){
            return null;
        }else{
            // действуем в зависимости от того, что было передано в конструктор
            if ($validAbbr){
                $this->abbr     = $abbrOrFull;
                $this->fullname = self::findFullnameByAbbr($abbrOrFull);
            }
            if ($validFull){
                $this->fullname = $abbrOrFull;
                $this->abbr     = self::findAbbrByFullname($abbrOrFull);
            }
        }
    }

    /** возвращает аббревиатуру языка
     * 
     * @return type
     */
    public function getAbbr()
    {
        return $this->abbr;
    }

    /** возвращает полное имя языка
     * 
     * @return type
     */
    public function getFullname()
    {
        return $this->fullname;
    }
    
    /** Возвращает язык по умолчанию
     * 
     * @return Language
     */
    public static function getDefault(){
        return self::getInstance('en');
    }
}
