<?php

define('_DEV_MODE_', false);

if(_DEV_MODE_){
    require 'dev-index.php';
}else{
    require 'production-index.php';
}