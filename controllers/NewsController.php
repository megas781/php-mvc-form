<?php

class NewsController
{

    public function actionIndex()
    {
        return "news' index";
    }

    public function actionView()
    {
//        echo 'Просмотр новости #' . $newsId;
        echo 'просмотр конкретной новости';
    }

}