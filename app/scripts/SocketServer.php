<?php

    define ('DEVELOPMENT_ENVIRONMENT',true);
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));

    require_once (ROOT . DS . '..' . DS .'vendor' . DS . 'autoload.php');

    echo 'Iniciando servidor socket...';
    $server = new Hoa\Websocket\Server(
        new Hoa\Socket\Server('tcp://192.168.1.11:8889')
    );
    echo "\nServidor socket Online.";

    $server->on('message', function (Hoa\Event\Bucket $bucket) {
        $data = $bucket->getData();

        echo "\nmessage: ", $data['message'];
        $bucket->getSource()->send($data['message']);

        return;
    });

    $server->run();
