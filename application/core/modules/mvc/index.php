<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of module_mvc
 *
 * @author fiftystars
 */
class module_mvc {
    use module_trait;
    
    CONST MODULE_NAME = 'mvc';
    CONST MODULE_VERSION = '1.0';
    CONST MODULE_REQUIRED_FILES = [
        'mvc',
        'controller',
        'model',
        'view'
    ];
}
