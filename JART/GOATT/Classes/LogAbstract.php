<?php

namespace JART\GOATT\Classes;

abstract class LogAbstract
{

    protected $logName = null;
    private $cache     = null;

    /**
     * @param string $name - имя лога
     */
    public function __construct(string $name)
    {
        $this->logName = $name;
        $this->cache   = new SessionCache(get_called_class(), $this->logName);
    }

    public function addMessage(array $data)
    {

        $this->cache->pushItem($data);
    }

    public function getAllMessages() /* PHP7 : array */
    {
        return $this->cache->getAllItems();
    }
}
