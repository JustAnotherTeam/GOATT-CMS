<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of router
 *
 * @author fiftystars
 */
class router{

    public static function start(){
        self::breakURI();

        new mvc('home');
    }

}
