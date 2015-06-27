<?php

namespace JART\GOATT\Classes;

class Log
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';
    CONST BRANCH  = 'Logs';

    protected static $allLogs = null;
    protected $logName        = null;
    protected $log            = null;
    protected $lastConsumed   = 0;

    /**
     * @param string $logName - имя лога
     * @param bool $forceNoLoading - true - Сбрасывает лог, даже если его можно продолжить
     */
    public function __construct($logName, $forceNoLoading = false)
    {
        self::loadAllLogs();
        $this->logName = $logName;
        $loaded        = false;
        // если можно загружать, то пытаемся загрузить
        if (!$forceNoLoading){
            $loaded = $this->tryLoadLog();
        }
        // если принуждение создания нового лога или лог не загружен, то создаем новый
        if ($forceNoLoading || !$loaded){
            $this->newLog();
        }
    }

    private static function loadAllLogs()
    {
        self::$allLogs = &SessionCache::getBranchAsReference(SessionCache::LOGS_BRANCH);
    }

    /**
     * 
     * @return boolean
     */
    public function tryLoadLog()
    {
        if (isset(self::$allLogs[$this->logName])){
            $this->log = &self::$allLogs[$this->logName];
            return true;
        }else{
            return false;
        }
    }

    private function newLog()
    {
        self::$allLogs[$this->logName] = [];

        $this->log = &self::$allLogs[$this->logName];
    }

    public function addMessage($message)
    {
        if (!is_array($message)){
            $message = [$message];
        }
        $message['timestamp'] = time();

        array_push($this->log, $message);
    }

    public function getAllMessages()
    {
        return $this->log;
    }

    public function getNewMessages()
    {
        if (count($this->log) > $this->lastConsumed){
            $this->lastConsumed = count($this->log) - 1;
            return array_slice($this->log, $this->lastConsumed);
        }else{
            return [];
        }
    }

}
