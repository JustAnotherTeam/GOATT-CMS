<?php

namespace JART\GOATT\Classes;

// TODO Написать обработчик сессии чтобы при закрытии сессии лог сохранялся в БД.
/**
 * Лог, предназначенный для сохранения исключений
 *
 * @author fiftystars
 */
class LogException extends Log
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';

    /** Добавление сообщения об исключении
     * 
     * @param Exception $exception исключение
     */
    public function addMessage(Exception $exception)
    {
        $message['URI']     = $_SERVER['REQUEST_URI'];
        $message['code']    = $exception->getCode();
        $message['file']    = $exception->getFile();
        $message['line']    = $exception->getLine();
        $message['message'] = $exception->getMessage();
        $message['trace']   = $exception->getTraceAsString();
        $message['user']    = serialize(user::getCurrentUser());
        parent::addMessage($message);
    }

}
