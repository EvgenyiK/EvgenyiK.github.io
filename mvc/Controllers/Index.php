<?php
/**
 * Работа с нашим приложением (можно даже сказать минифреймворком) теперь сводится к созданию видов и контроллеров.
 * Пример контроллера следующий (в папке Controllers):
*/
namespace Controllers;

class Index extends \App\Controller
{
    public function index()
    {
        return $this->render('index');
    }
}
