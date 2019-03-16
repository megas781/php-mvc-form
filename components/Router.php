<?php


class Router {

    //Массив, в котором будут храниться маршруты
    private $routes;

    public function __construct()
    {
        //путь к файлу маршрутов
        $routesPath = ROOT . '/config/Routes.php';
        //запоминаем маршруты
        $this->routes = include($routesPath);
    }


    //Метод, принимающий управление от FrontController'a
    public function run() {
        echo 'Router started handling the request<br>';

        echo 'Вот что мне удалось у знать про маршруты:<br>';

        print_r($this->routes);
    }
}