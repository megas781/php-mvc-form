<?php

class News {

    /**
     * Возвращает одну новость по id
     * @param integer $id
     * @return array newsInstance
     */
    public static function getNewsItemById($id)
    {
        //запрос в БД

        $pdo = Database::getPdoConnection();
        $result = $pdo->query("select * from news where news_id = $id limit 1")->fetch(PDO::FETCH_ASSOC);
        return $result;

    }

    /**
     * возвращает массив новостей
     */
    public static function getNewsList()
    {
        //запрос в БД
        $pdo = Database::getPdoConnection();

        $newsArray = $pdo->query("select * from news where news.date <= now() order by date desc limit 10")->fetchAll(PDO::FETCH_ASSOC);

        return $newsArray;
    }


}