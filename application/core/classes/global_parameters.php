<?php

namespace GOATT;

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
class global_parameters{

    use version_trait;

    CONST VERSION = '1.0';

    /**
     *
     * @var string|NULL Аббревиатура языка, указанного в URI 
     */
    private static $URI_LanguageAbbr = NULL;

    /**
     *
     * @var string Имя контроллера в URI(если не указан в URI то исполльзуется значение по умолчанию)
     */
    private static $URI_Controller = 'home';

    /**
     *
     * @var string Имя действия в URI(если не указано в URI то исполльзуется значение по умолчанию)
     */
    private static $URI_Action = 'default';

    /**
     *
     * @var string оставшаяся часть URI - параметры и т.д. 
     */
    private static $URI_Other = NULL;

    /**
     *
     * @var array список языков, которые могут использоваться в URI. Например example.com/<b>ru</b> и example.com/<b>en</b>. Структура массива: [['abbr'=>'ru', 'fullname'=>'russian']]
     */
    private static $LanguagesAvailableForPages = [];

    /** Получение языков для страниц и запись в статическую переменную
     * 
     */
    public static function updateLanguages(){
        self::$LanguagesAvailableForPages = database_query_handler::getAllLanguagesOfPages();
    }

}
