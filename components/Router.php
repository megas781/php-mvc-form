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

//        echo 'Router started handling the request<br>';
//        echo 'Вот что мне удалось у знать про маршруты:<br>';
        echo '<pre>';
        print_r($this->routes);
        echo '</pre><br><br>';


        //ЭТАП 1 - Получить строку запроса

        $theRequest = $this->getURI();

        echo 'запрос: ' . $theRequest . '<br>';


        //ЭТАП 2 - Проверить наличие такого запроса в routes.php

        foreach ($this->routes as $keyPattern => $genericPath) {

            /*Проверяем, соответствует ли запрос какому-нибудь ключу в маршрутах.
            Есть фокус относительно того, что благодаря тому, что мы рассматриваем
            $keyPattern как регулярное выражение, в мартрутах мы можем регулярное выражение
            ПРЯМО В КЛЮЧЕ!
            */
            if (preg_match("~^$keyPattern$~", $theRequest)) {

                //ЭТАП 3 - Если есть совпадение, определить, какой контроллер и action обрабатывают этот запрос


                /*Сначала нам нужно из шаблона genericPath создать
                внутренний путь.
                Давай по действиям:
                1. Находим совпадение $keyPattern во внешнем запросе $theRequest.
                2. Заменяем ВСЁ совпадение на внутренний путь $genericPath, в которые вставляются
                запоминающие группы.
                3. Таким образом, мы смогли конвертировать запрос из:
                    внешнего     : news/sport/45
                    во внутренний: news/view/sport/45
                Отличие в том, что во внутреннем описывается управляющий action.
                Для пользователя эта информация будет лишней, так что во внешнем запросе
                о нём инфорации нет*/

                $internalPath = preg_replace("~$keyPattern~", $genericPath, $theRequest);

                /*Здесь мы понимаем, что такой путь есть. Парсим URI*/
                echo 'internalPath: '.$internalPath . '<br>';

                //разделяем составные части запроса типа ctrlname/actionname на части
                $segments = explode('/', $internalPath);


                //ucfirst делает заглавной первую букву
                //array_shift – это как pop, только для первого элемента

                //Создаем имя контроллера согласно договорённости именования классов
                $controllerName =  ucfirst(array_shift($segments)) . 'Controller';
                //Создаем имя action'a согласно договорённости именования action'ов
                $controllerAction = 'action' . ucfirst(array_shift($segments));

                echo "имя контроллера: $controllerName<br>";
                echo "имя action'a   : $controllerAction<br>";

                //На этом этапе всё, если что-то осталось в массиве $segments, то это параметры
                $parameters = $segments;
//                echo '<pre>';
//                print_r($parameters);
//                echo '</pre>';

                //ЭТАП 4 - Подключить файл класса контроллера

                $controllerPath = ROOT . '/controllers/' . $controllerName . '.php';

                if (file_exists($controllerPath)) {

                    include_once $controllerPath;

                    //ЭТАП 5 - Создать контроллер, вызвать action

                    //Создаём класс с помощью строки с его названием
                    $controllerObject = new $controllerName;
                    /*Вызываем action, который возвращает булево значение.
                    Это значение поможет прервать цикл foreach
                    */

                    //Вызываем action, помещая в него оставшиеся параметры при помощи call_user_func_array
                    $result = call_user_func_array([$controllerObject, $controllerAction], $parameters);

                    //т.к. если мы смогли вызвать action, то он вернёт true.
                    //А значит можно прерывать foreach
                    if ($result != null) {
                        echo 'result: ' . $result;
                        break;
                    }

                }

            }

        }


    }
}