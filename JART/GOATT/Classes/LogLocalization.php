<?php

namespace JART\GOATT\Classes;

// TODO Написать обработчик сессии чтобы при закрытии сессии лог сохранялся в БД.

/**
 * Лог, предназначенный для сохранения проблем с локализацией
 *
 * @author fiftystars
 */
class LogLocalization extends Log
{

    use \JART\GOATT\Traits\VersionTrait,
        \JART\GOATT\Traits\DependencyTrait;

    CONST VERSION = '1.0';

    /**
     * 
     * @param integer|string $id - id перевода
     * @param string $message описание проблемы
     */
    public function addMessage($id, $message)
    {
        parent::addMessage([$id,
            $message]);
    }

}
