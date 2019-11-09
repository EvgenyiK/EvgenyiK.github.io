<?php
/**
 * Ещё нам нужно создать базовый класс для наших контроллеров, чтобы потом наследоваться от него.
 * Наследовать методы нужно для того, чтобы вы могли рендерить (сформировать вывод) виды.
 * Методы рендеринга поддерживают использование лэйаутов — шаблонов,
 * которые содержат общие для всех видов компоненты, например футер и хэдер.
*/

namespace App;

use App;

class Controller
{
    public $layoutFile = 'Views/Layout.php';

    public function renderLayout($body)
    {
        ob_start();
        require ROOTPATH.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'Layout'.DIRECTORY_SEPARATOR."Layout.php";
        return ob_get_clean();

    }

    public function render($viewName, array $params = [])
    {
        $viewFile = ROOTPATH.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.$viewName.'.php';
        extract($params);
        ob_start();
        require $viewFile;
        $body = ob_get_clean();
        ob_end_clean();
        if (defined('NO_LAYOUT')){
            return $body;
        }
        return $this->renderLayout($body);
    }
}