<?php
//Не забываем создать индексный файл в корне:

define('ROOTPATH',__DIR__);

require __DIR__.'/App/App.php';

App::init();
App::$kernel->launch();