<?php


//echo 'The file FrontController.php succeeded! <br>';



    //FRONT CONTROLLER


    //1. Общие настройки

//Устанавливаем правило для ini. Нужно отображать ошибки
ini_set('display_errors', 1);
//Нужны все виды ошибок
error_reporting(E_ALL);


    //2. Подключение файлов системы


/*
 * dirname – это название папки для пути к файлу. В данном случае у нас __FILE__ – это
 * абсолютный путь к FrontController.php. dirname извлекает название директории, в которой он находится.
 * Таким образом нам удаётся найти абсолютный путь для нашего проекта
 * */
define('ROOT', dirname(__FILE__));
echo '__FILE__: ' . ROOT . '<br>';

//Импортируем роутер
require_once ROOT . '/components/Router.php';



    //3. Установка соединения с БД


    //4. Вызов Router

//Создаём роутер и запускаем его
$router = new Router();
$router->run();



?>