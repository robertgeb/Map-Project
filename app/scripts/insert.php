<?php

    define ('DEVELOPMENT_ENVIRONMENT',true);
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));

    require_once (ROOT . DS . '..' . DS .'vendor' . DS . 'autoload.php');


    $model = new BreakCheck\Map();
    $action = 'setMarker';
    $arrayMsg = array(
        'nome' => 'ponto 2',
        'latitude' => -22.62991236176709,
        'longitude' => -43.70664164810182
    );
    try {
        $controller = new BreakCheck\SocketController($model, $action, $arrayMsg);
        $controller->{$action}();
    } catch (Exception $e) {
        echo $e->getMessage();
    }
    exit;
