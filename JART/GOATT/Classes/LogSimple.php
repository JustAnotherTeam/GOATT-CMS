<?php

namespace JART\GOATT\Classes;

/**
 * Простой лог в добавлением времени
 * @author fiftystars
 */
class LogSimple extends LogAbstract
{
    public function addMessage(string $text, array $data = [])
    {
        $data['time'] = time();
        $data['text'] = $text;
        parent::addMessage($data);
    }
}