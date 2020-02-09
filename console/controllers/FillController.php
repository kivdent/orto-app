<?php


namespace console\controllers;


use common\modules\patient\models\Region;
use yii\console\Controller;
use Yii;
use common\models\Manipulations;

class FillController extends Controller
{
    private $items;
    public $table;

    private function setVariables($tables)
    {

        foreach ($tables as $table) {
            if (Yii::$app->db->getTableSchema($table, true) !== null) {

                echo "Установка переменных...";
                try {
                    require 'tables_for_fill/' . $table . '.php';
                } catch (Exception $e) {
                    echo 'Нет файла с данными для таблицы: ' . $table . ".", $e->getMessage(), "\n";
                }

                $this->items[$table] = $items;


            } else {
                throw new Exception('Таблица " . $table . " отсутвует.');
            }

            echo "Перменная  " . $table . " зарегестрирована." . PHP_EOL;
        }
        echo "Выполнено." . PHP_EOL;
    }

    private function truncateTables($tables)
    {
        echo "Очистка таблиц...";
        foreach ($tables as $table) {

            $sql = Yii::$app->db->createCommand();
            $sql->truncateTable($table)->execute();
            echo "Таблица " . $table . " очищена." . PHP_EOL;
        }
        echo "Выполнено." . PHP_EOL;
    }

    private function insertDataInTable($tableName, $items)
    {

        $properties = array_keys($items[0]);


        foreach ($this->items[$tableName] as $item) {
            $className = 'common\models\\' . ucfirst($tableName);
            $schema = new $className();
            foreach ($properties as $property) {
                $schema->{$property} = $item[$property];
            }
            $schema->save('false');
        }

    }


    public function actionFill(array $tables)
    {

        $this->setVariables($tables);

        $this->truncateTables($tables);
        echo "Заполнение таблиц...";
        foreach ($this->items as $tableName => $items) {
            echo "Таблица " . $tableName;
            $this->insertDataInTable($tableName, $items);
            echo "Заполнено. " . PHP_EOL;
        }
        echo "Выполнено." . PHP_EOL;
    }

    /*
     *Формат данных array
     *
`id`('new'),
`manip`,
`preysk`,
`zapis`,
`price`,
`cat`,
`UpId`,
`range`,
`koef`
     * */
    public function actionFillManip()
    {
        echo "Обновление данных манипуляций начато." . PHP_EOL;
        echo "Загрузка данных из файла manip_update.php";
        try {
            require 'tables_for_fill/manip_update.php';
        } catch (Exception $e) {
            echo 'Нет файла с данными для таблицы: manip_update.php', $e->getMessage(), "\n";
        }
        echo "Загрузка данных из файла..." . PHP_EOL;
        $properties = array_keys($items[0]);
        $UpId = (isset($items[0]['UpId'])) ? $items[0]['UpId'] : 0;
        foreach ($items as $item) {


            if ($item['id'] !== '') {
                echo "Обновление данных для мнипуляции";
                $manip = Manipulations::findOne($item['id']);

            } else {
                echo "Добавление мнипуляции ";
                $manip = new Manipulations();

            }


            foreach ($properties as $property) {
                if ($property !== 'id') {
                    
                    $manip->{$property} = $item[$property];
                }
            }
            $manip->UpId=$UpId;

            $manip->save('false');

            if ($item['cat']=='1') {
                $UpId = $manip->id;
            }

            echo "с кодом " . $manip->id . ' выполнено' . PHP_EOL;
        }
        echo "Обновление данных манипуляций окончено." . PHP_EOL;
    }
}