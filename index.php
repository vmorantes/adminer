<?php

define('_DEV_MODE_', false);

if (_DEV_MODE_) {
    ini_set('display_errors', 1);
    function permanentLogin()
    {
        // key used for permanent login
        return '0839b0a8df9ea45fe280c47428fca941';
    }
}

require 'adminer.php';
