<?php
    // NOTE: Verificar ambiente de desenvolvimento
    define ('DEVELOPMENT_ENVIRONMENT',true);
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(dirname(__FILE__)));

    require_once (ROOT . DS . 'vendor' . DS . 'autoload.php');

    namespace Arroz;

    $uri = (empty($_GET['uri']) || $_GET['uri'] ==='/') ? '/index' : $_GET['uri'];

    // TODO: Error log handing seemly
    $erro = ''; // NOTE: Guarda as messagens de erro e passa para o View

    //  Cria Rotas
    Arroz\Router::route("/(\w+)/?(\w+)?/?(\w+)?", function($model, $action = '', $argument = '')
    {
        $params = func_get_args();
        $modelName =  . ucwords(strtolower($params[0]));
        if (empty($params[1])) {
            $params[1] = "index";
        }

        // Instancia o Model e o Controller para os a rota
        try {
            $model = new $modelName();
            $controller = new Arroz\Controller($model, $params[1]);
            $controller->{$params[1]}($params[2]);

        }catch (\Throwable $t){
            $erro = $t->getMessage();

        }catch(\Exception $e){
            $erro = $e->getMessage();

        }

        // XXX: Para efeitos de depuracao
        // echo $erro;
        // exit;

        // View renderiza o model com o template base, e os erros
        $view = new Arroz\View($model, "base", $erro);
        $view->render();
        return;
    });

    // Executa o Router para gerar a rota

    try {
        Arroz\Router::execute($uri);
    } catch (\Exception $e) {
        echo $e->getMessage();
    }
