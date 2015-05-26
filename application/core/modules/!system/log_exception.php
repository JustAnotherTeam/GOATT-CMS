<?php

/**
 * Лог, предназначенный для сохранения исключений. TODO Написать обработчик сессии чтобы при закрытии сессии лог сохранялся в БД.
 *
 * @author fiftystars
 */
class log_exception extends log{
    
    /** Добавление сообщения об исключении
     * 
     * @param Exception $exception исключение
     */
    public function addMessage(Exception $exception) {
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
