<?php
/**
 * Created by PhpStorm.
 * User: glebkalachev
 * Date: 2019-03-16
 * Time: 15:29
 */


//Маршрутизация с помощью массива

return [

    'news/([a-z_-]+)/([0-9]+)' => 'news/view/$1/$2', //actionIndex в NewsController

    'news' => 'news/index', //actionIndex в NewsController


    'products' => 'products/list' //actionIndex в ProductController
];