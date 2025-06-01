<?php

define('_DEV_MODE_', false);

if (_DEV_MODE_) {
    ini_set('display_errors', 1);
}

require 'adminer.php';
