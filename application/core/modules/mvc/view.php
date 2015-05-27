<?php

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
class view {
    public static function generate($view, $templateView = NULL, $data = NULL) {
        if (is_null($templateView)){
            include $view;
        }else{
            include $templateView;
        }
    }
}
