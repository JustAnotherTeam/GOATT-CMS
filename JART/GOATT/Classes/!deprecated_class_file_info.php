<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class_file_info
 *
 * @author fiftystars
 */
final class class_file_info {
    private $name = null,
            $fileName = null,
            $className = null,
            $type = 0;
    
    public function __construct($name = null, $type = 0) {
        $this->name = $name;
        $this->type = $type;
    }
    public function setName(){
        
    }
    public function setFileName(){
        
    }
    /**
     * 
     * @throws Exception
     */
    private function autoconstructNames(){
        switch ($this->type) {
            
            // controller
            case 0:

                break;
            // model
            case 1:

                break;
            // view
            case 2:

                break;
            default:
                throw new Exception('SomeThing', 1234);
        }
    }
}
