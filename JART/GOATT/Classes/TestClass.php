<?php

namespace JART\GOATT\Classes;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of testClass
 *
 * @author fiftystars
 */
class TestClass
{

    public static $a = 'OldThing';

    public static function getA()
    {
        return self::$a;
    }

    public static function setA($val)
    {
        self::$a = $val;
    }

}
