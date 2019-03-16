<?php


class Router
{

    //Массив, в котором будут храниться маршруты
    private $routes;

    public function __construct()
    {
        //путь к файлу маршрутов
        $routesPath = ROOT . '/config/Routes.php';
        //запоминаем маршруты
        $this->routes = include($routesPath);
    }


    /**
     * Функция, возвращающая строку запроса без лишних слэшей[
     * @return string
     */

    private function getURI()
    {
        //Достаем запрос
        if (!empty($_SERVER['REQUEST_URI'])) {
            //здесь убираем все лишние символы / (см. trim())
            $uri = trim($_SERVER['REQUEST_URI'], '/');
        } else {
            //в данном случае else излишен, т.к. REQUEST_URI не может быть пустым.
            //Всегда будет хотя бы "/"
            $uri = 'error';
        }

        return $uri;

    }

    //Метод, принимающий управление от FrontController'a
    public function run()
    {

        echo 'Router started handling the request<br>';
        echo 'Вот что мне удалось у знать про маршруты:<br>';
        print_r($this->routes);
        echo '<br>';


        $theRequest = $this->getURI();

        echo $theRequest . '<br>';
//        echo $_SERVER['REQUEST_METHOD'] . '<br>';

//        foreach ($this->routes as $uriKey => $uriPath) {
//            echo $uriKey . ': ' . $uriPath . '<br>';
//        }



        foreach ($this->routes as $key => $path) {

            //Проверяем, соответствует ли запрос какому-нибудь ключу в маршрутах
            if (preg_match("~$key~", $theRequest)) {


                /*Здесь мы понимаем, что такой путь есть. Парсим URI*/
                echo 'path: '.$path . '<br>';


                //разделяем составные части запроса типа ctrlname/actionname на части
                $segments = explode('/', $path);


                //ucfirst делает заглавной первую букву
                //array_shift – это как pop, только для первого элемента

                //Создаем имя контроллера согласно договорённости именования классов
                $controllerName =  ucfirst(array_shift($segments)) . 'Controller';
                //Создаем имя action'a согласно договорённости именования action'ов
                $controllerAction = 'action' . ucfirst(array_shift($segments));

                echo "имя контроллера: $controllerName<br>";
                echo "имя action'a   : $controllerAction<br>";




            }

        }


        //Получить строку запроса
        //Проверить наличие такого запроса в routes.php
        //Если есть совпадение, определить, какой контроллер и action обрабатывают этот запрос
        //Подключить файл класса контроллера
        //Создать контроллер, вызвать action


    }
}