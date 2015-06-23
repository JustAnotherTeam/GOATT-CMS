<?php

namespace GOATT;

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
class language{

    private $abbr;
    private $fullname;
    private static $languages        = []; // [['abbr'=>'ru', 'fullname'=>'russian']]
    private static $languagesUpdated = FALSE;
    public static $instances         = [];

    /** Валидная аббревиатура языка?
     * 
     * @param string $string строка
     * @return boolean результат
     */
    public static function isValidAbbr($string){
        foreach (self::$languages as $language){
            if ($language['abbr'] == $string){
                return TRUE;
            }
        }
        return FALSE;
    }

    /** Валидное полное имя языка?
     * 
     * @param string $string строка
     * @return boolean результат
     */
    public static function isValidFullname($string){
        foreach (self::$languages as $language){
            if ($language['fullname'] == $string){
                return TRUE;
            }
        }
        return FALSE;
    }

    /** Возвращает аббревиатуру языка по полному имени
     * 
     * @param string $fullname полное имя языка
     * @return string|NULL аббревиатура языка или NULL если полное имя не найдено
     */
    public static function findAbbrByFullname($fullname){
        foreach (self::$languages as $language){
            if ($language['fullname'] == $fullname){
                return $language['abbr'];
            }
        }
        return NULL;
    }

    /** Возвращает полное имя языка по аббревиатуре
     * 
     * @param string $abbr аббревиатура языка
     * @return string|NULL полное имя языка или NULL если аббревиатура не найдена
     */
    public static function findFullnameByAbbr($abbr){
        foreach (self::$languages as $language){
            if ($language['abbr'] == $abbr){
                return $language['fullname'];
            }
        }
        return NULL;
    }

    /** Возвращает объект, представляющий язык(на каждый язык не более одного экземпляра класса)
     * 
     * @param string $language
     * @return language объект, представляющий язык
     */
    public static function getInstance($language){
        // если нет такого языка в экземплярах, то создаем новый
        if (!isset(self::$instances[$language])){
            $new = new self($language);
            // если не удалось 
            if (is_null($new)){
                return NULL;
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
    public static function updateLanguagesList(){
        self::$languages = database_query_handler::getAllLanguagesOfWebsite();
    }

    /**
     * 
     * @param string $abbrOrFull аббревиатура языка или полное имя
     * @return language|NULL NULL возвращается если строка $abbrOrFull не найдена в списке языков
     */
    private function __construct($abbrOrFull){
        // если список языков не обновлен, то обновляем
        if (!self::$languagesUpdated){
            self::updateLanguagesList();
            self::$languagesUpdated = TRUE;
        }
        // проверка на существование строки как аббревиатуры или полного имени
        $validAbbr = self::isValidAbbr($abbrOrFull);
        $validFull = self::isValidFullname($abbrOrFull);
        // если не найдено, но возвращаем NULL
        if (!$validAbbr && !$validFull){
            return NULL;
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
    public function getAbbr(){
        return $this->abbr;
    }

    /** возвращает полное имя языка
     * 
     * @return type
     */
    public function getFullname(){
        return $this->fullname;
    }

}
