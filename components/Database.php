<?php

class Database {

    /**
     * Returns PDO connection instance
     * @return PDO pdoInstance
     */
    public static function getPdoConnection()
    {
        //Импортируем файл конфигурирующий словарь для БД
        $configPath = ROOT . '/config/db_params.php';
        $params = include($configPath);

        $host = $params['host'];
        $dbname = $params['dbname'];
        $username = $params['user'];
        $password = $params['password'];

        //DSN - Data Source Name
        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);

        return $pdo;

    }
}

