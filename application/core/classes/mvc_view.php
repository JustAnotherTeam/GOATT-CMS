<?php

namespace GOATT;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of view
 *
 * @author fiftystars
 */
class mvc_view{

    use version_trait;

    CONST VERSION = '1.0';

    public static function generate($view,
                                    $templateView = NULL,
                                    $data = NULL){
        if (is_null($templateView)){
            include $view;
        }else{
            include $templateView;
        }
    }

}
