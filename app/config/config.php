<?php
    define('DB_NAME', 'breakcheck');
    define('DB_USER', 'root');
    define('DB_PASS', 'g741237');
    define('DB_HOST', 'localhost');

    if (DEVELOPMENT_ENVIRONMENT == true) {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
    } else {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'app'.DS.'logs'.DS.'error.log');
    }
