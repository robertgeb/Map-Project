<?php

    define ('DEVELOPMENT_ENVIRONMENT',true);
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));

    require_once (ROOT . DS . '..' . DS .'vendor' . DS . 'autoload.php');

    use BreakCheck\Logger;

    echo 'Iniciando servidor socket...';
    $server = new Hoa\Websocket\Server(
        // new Hoa\Socket\Server('tcp://192.168.1.11:8889')
        new Hoa\Socket\Server('tcp://192.168.0.101:8889')
    );
    echo "\nServidor socket Online.\n";

    $server->on('open', function (Hoa\Event\Bucket $bucket)
    {
        echo "Usuário conectado \n";
        $bucket->getSource()->send('PARA DE SE CONECTAR O TEMPO TODO');
        return;
    });

    $server->on('message', function (Hoa\Event\Bucket $bucket) {
        $dataMsg = $bucket->getData();
        echo "\nRecebido: \n";
        $arrayMsg = json_decode($dataMsg['message'], true);
        var_dump($arrayMsg);
        $action = array_shift($arrayMsg);
        // echo 'Executando ' . $action . "\n";
        $model = new BreakCheck\Map();

        $erro = '';
        try {
            $controller = new BreakCheck\SocketController($model, $action, $arrayMsg);
            $controller->{$action}();
        } catch (\Throwable $e) {
            // var_dump($dataMsg);
            $erro = $e->getMessage();
            echo $e->getMessage()."\n";
            Logger::setLog($e->getMessage());
        }
        // $bucket->getSource()->send(json_encode($model->getOutcome()));
        $self = $bucket->getSource();
        $view = new BreakCheck\SocketView($model, $self, $erro);
        $view->render();


        return;
    });

    $server->on('close', function (Hoa\Event\Bucket $bucket)
    {
        echo "Usuário desconectado \n";

        return;
    });

    $server->run();
