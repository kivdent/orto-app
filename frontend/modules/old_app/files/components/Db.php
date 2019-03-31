<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Db
 * G\Создание подключения к базе данных
 *
 * @author kivdent
 */
class Db {

    public static function getConnection() {

        $paramsPath = Yii::$app->params['old_app_mvc_path'].'config/db_params.php';
        $params = include $paramsPath;
        $dsn = 'mysql:host=' . $params['host'] . ';dbname=' . $params['dbname'].';charset=utf8';
        try {
            $db = new PDO($dsn, $params['user'], $params['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        } catch (PDOException $e) {
            echo 'Соединение оборвалось: ' . $e->getMessage();
            exit;
        }
      
        return $db;
    }
    public static function sqlQuery($query,$visible=false){
        $db=Db::getConnection();
        $result = $db->query($query);
        if ($visible) {
            echo "<pre>Запрос:";
            print_r($query);
            echo "</pre>";
            echo "<pre>Ошибки:";
            print_r($db->errorInfo());
            echo "</pre>";
        }
        return $result;
    }

}
