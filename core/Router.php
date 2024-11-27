<?php

namespace Core;

class Router
{
    public function run()
    {
        $url = $_SERVER['REQUEST_URI'];

        switch ($url) {
            case '/':
                $controllerName = 'App\controllers\HomeController';
                $actionName = 'index';
                break;
            case '/entrada':
                $controllerName = 'App\controllers\AuthController';
                $actionName = 'entrada';
                break;
            case '/sair':
                $controllerName = 'App\controllers\AuthController';
                $actionName = 'sair';
                break;
             case '/pagamento':
                    $controllerName = 'App\controllers\AuthController';
                    $actionName = 'pagamento';
                break;

             //Adicionar novas rotas aqui....
            default:
                http_response_code(404);
                echo "Página não encontrada!";
                exit;
        }

        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                echo "Método '$actionName' não encontrado no controller '$controllerName'!";
            }
        } else {
            echo "Controller '$controllerName' não encontrado!";
        }
    }
}