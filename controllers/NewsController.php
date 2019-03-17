<?php

//Здесь мы будем использовать модель News для отображения новостей. Давайте импортируем её
include_once ROOT . '/models/News.php';

class NewsController
{

    public function __construct()
    {

    }


    public function actionIndex()
    {
        //Извлекаем новость из модели News
        $newsArray = News::getNewsList();

        echo "<pre>";

        print_r($newsArray);

        echo "</pre>";


        require_once ROOT . '/views/news/index.php';

        return "последние 10 новостей";
    }


    //Посмотреть отдельную новость
    public function actionView($newsId)
    {

        //Извлекаем новость из модели News
        $news = News::getNewsItemById($newsId);

        echo "<pre>";

        print_r($news);

        echo "</pre>";


        return "news #$newsId";
    }

}