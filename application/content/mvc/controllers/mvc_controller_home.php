<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of controller_home
 *
 * @author fiftystars
 */
class mvc_controller_home
        extends mvc_controller{

    public function __construct(){
        $this->baseName  = 'home';
        $this->modelName = 'home';
        $this->viewName  = 'home';
        parent::__construct();
    }

}
