<?php

namespace JART\GOATT\Classes;

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
class MVCView
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';

    public static function generate($view, $templateView = null, $data = null)
    {
        if (is_null($templateView)){
            include $view;
        }else{
            include $templateView;
        }
    }

}
