<?php
namespace App;

use App;

/**
 * Ядро обращается к роутеру, а потом запускает действия контроллера.
 * Ещё ядро может кинуть исключение, если нет нужного контроллера или метода.
*/
class Kernel
{
    public $defaultControllerName = 'index';
    public $defaultActionName = 'index';

    public function  launch()
    {
        list($controllerName,$actionName,$params) = App::$router->resolve();
        echo $this->launchAction($controllerName,$actionName,$params);
    }

    public function launchAction($controllerName,$actionName,$params)
    {
        $controllerName = empty($controllerName)?$this->defaultActionName : ucfirst($controllerName);
        if (!file_exists(ROOTPATH.DIRECTORY_SEPARATOR.$controllerName.'.php')){
            throw new \App\Exceptions\InvalidRouteException();
        }
        $controllerName = "\\Controllers\\".ucfirst($controllerName);
        $controller = new $controllerName;
        $actionName = empty($actionName) ? $this->defaultActionName : $actionName;
        if (!method_exists($controller,$actionName)){
            throw new \App\Exceptions\InvalidRouteException();
        }
        return $controller->$actionName($params);
    }
}