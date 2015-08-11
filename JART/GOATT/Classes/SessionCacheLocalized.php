<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace JART\GOATT\Classes;

/**
 * Description of SessionCacheLocalized
 *
 * @author fiftystars
 */
class SessionCacheLocalized extends SessionCache
{

    const SECTION_LOCALIZATION = 'goatt loc';
    public function getLocalization($key, $langDBID)
    {
        if (isset($this->cache[$key][self::SECTION_LOCALIZATION][$langDBID])) {
            $result = $this->cache[$key][self::SECTION_LOCALIZATION][$langDBID];
        } else {
            $result = null;
        }
    }

    public function getAllLocalizations($key)
    {
        if (isset($this->cache[$key][self::SECTION_LOCALIZATION])) {
            $result = $this->cache[$key][self::SECTION_LOCALIZATION];
        } else {
            $result = null;
        }
    }
    public function addLocalization($key, $langDBID, $text)
    {
        $this->cache[$key][self::SECTION_LOCALIZATION][$langDBID] = $text;

    }

    public function addLocalizations($key, $array)
    {
        $this->cache[$key][self::SECTION_LOCALIZATION] = $array;
    }
}
