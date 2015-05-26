<?php


class log{
    
    protected static $rootBranch = 'logs';
    protected $logName = NULL;
    protected $log = NULL;
    protected $lastConsumed = 0;
    /**
     * 
     * @param string $logName - имя лога
     * @param bool $forceNoLoading - TRUE - Сбрасывает лог, даже если его можно продолжить
     */
    public function __construct($logName, $forceNoLoading = FALSE) {
        $this->logName = $logName;
        $loaded = FALSE;
        // если можно загружать, то пытаемся загрузить
        if (!$forceNoLoading){
            $loaded = $this->tryLoadLog();
        }
        // если принуждение создания нового лога или лог не загружен, то создаем новый
        if ($forceNoLoading || !$loaded){
            $this->newLog();
        }
    }
    
    public function tryLoadLog() {
        if (isset($_SESSION[self::$rootBranch][$this->logName])){
            $this->log = &$_SESSION[self::$rootBranch][$this->logName];
            return TRUE;
        }else{
            return FALSE;
        }
    }
    
    private function newLog(){
        $_SESSION[self::$rootBranch][$this->logName] = [];
        $this->log = &$_SESSION[self::$rootBranch][$this->logName];
    }
    
    public function addMessage($message){
        if (!is_array($message)){
            $message = [$message];
        }
        $message['timestamp'] = time();
        
        array_push($this->log, $message);
    }
    public function getAllMessages(){
        return $this->log;
    }
    
    public function getNewMessages(){
        if (count($this->log) > $this->lastConsumed){
            $this->lastConsumed = count($this->log)-1;
            return array_slice($this->log, $this->lastConsumed);
        }else{
            return [];
        }
    }
}