<?php
namespace App;

/**
 * В простом mvc приложении роутер содержит всего один метод.
 * Он парсит адрес из $_SERVER['REQUEST_URI'].
 * Я ещё не сказал,
 * что все наши ссылки на страницы сайта должны быть вида www.ourwebsite.com/%controller%/%action%, где %controller% — имя файла контроллера,
 * а %action% — имя метода контроллера, который будет вызван.
 */
class Router
{
    public function resolve()
    {
        if ($pos= strpos($_SERVER['REQUEST_URI'],'?') !== false) {
            $route = substr($_SERVER['REQUEST_URI'],0,$pos);
        }
        $route = is_null($route) ? $_SERVER['REQUEST_URI'] : $route;
        $route= explode('/',$route);
        array_shift($route);
        $result[0] = array_shift($route);
        $result[1] = array_shift($route);
        $result[2] = $route;
        return $result;
    }
}