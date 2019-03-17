<?php

class NewsController
{

    public function actionIndex()
    {
        return "NewController actionIndex performed";
    }

    public function actionView()
    {

        echo '<br>параметры внутри функции:';
        echo "<pre>";
        print_r(func_get_args());
        echo "</pre>";

        return "NewController actionView performed.";
    }

}