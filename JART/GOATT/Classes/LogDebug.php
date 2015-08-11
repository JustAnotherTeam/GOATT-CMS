<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JART\GOATT\Classes;

/**
 * Description of LogDebug
 *
 * @author fiftystars
 */
class LogDebug
{
    CONST DEBUG_KEY = 'debug';
    
    protected static $useDebug = false;
    protected static $log = null;
    
    public static function addMessage($text, array $data = []){
        if (self::$useDebug){
            if (self::$log === null){
                self::$log = new LogSimple(self::DEBUG_KEY);
            }
            $data['backtrace'] = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 0);
            self::$log->addMessage($text, $data);
        }
    }
    public static function getAllMessages()
    {
        if (self::$log === null){
            self::$log = new LogDebug(self::DEBUG_KEY);
        }
        
        return self::$log->getAllMessages();
    }
    public static function enableLog()
    {
        self::$useDebug = true;
    }
}
