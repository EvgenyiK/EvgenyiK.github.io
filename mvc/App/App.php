<?php
/**
 * Сервис локатор нужен чтобы хранить в нём компоненты нашего приложения.
 * Поскольку у нас простое mvc приложение, то мы не используем паттерн registry (как например в yii сделано).
 * А просто сохраняем компоненты приложения в статические свойства, чтобы обращаться к ним было проще.
 * Ещё App регистрирует автозагрузчик классов и обработчик исключений.
*/
class App
{
    public static $router;
    public static $db;
    public static $kernel;

    public static function init()
    {
        spl_autoload_register(['static','loadClass']);
        static ::bootstrap();
        set_exception_handler(['App','handleException']);
    }

    public static function bootstrap()
    {
        static ::$router = new App\Router();
        static ::$kernel = new App\Kernel();
        static ::$db = new App\Db();
    }

    public static  function loadClass($className)
    {
          $classname =  str_replace('\\',DIRECTORY_SEPARATOR, $className);
          require_once ROOTPATH.DIRECTORY_SEPARATOR.$className.'.php';
    }

    public static function handleException(Throwable $e)
    {
        if ($e instanceof \App\Exceptions\InvalidRouteException){
            echo static ::$kernel->launchAction('Error','error404',[$e]);
        }else{
            echo static ::$kernel->launchAction('Error','error500',[$e]);
        }
    }
}