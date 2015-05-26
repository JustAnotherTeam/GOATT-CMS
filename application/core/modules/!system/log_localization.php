<?php

/**
 * Лог, предназначенный для сохранения проблем с локализацией. TODO Написать обработчик сессии чтобы при закрытии сессии лог сохранялся в БД.
 *
 * @author fiftystars
 */
class log_localization extends log{
    
    /**
     * 
     * @param integer|string $id
     * @param string $message описание проблемы
     */
    public function addMessage($id, $message) {
        parent::addMessage([$id, $message]);
    }
    
}
