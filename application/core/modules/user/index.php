<?php

class module_user{
    use module_trait;
    
    CONST MODULE_NAME = 'user';
    CONST MODULE_VERSION = '1.0';
    CONST MODULE_REQUIRED_FILES = [
        'user',
        'permissions'
    ];
}