<?php

namespace JART\GOATT\Classes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of global_parameters
 *
 * @author fiftystars
 */
class GlobalParameters
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';

    /**
     *
     * @var string|null Аббревиатура языка, указанного в URI 
     */
    private static $URI = null;

    /** Получение языков для страниц и запись в статическую переменную
     * 
     */
    public static function updateLanguages()
    {
        self::$LanguagesAvailableForPages = DatabaseQueryLibrary::getAllLanguagesOfWebsite();
    }

    public static function initGlobalParameters()
    {
        self::$URI = new URI($_SERVER['REQUEST_URI']);
    }

}
