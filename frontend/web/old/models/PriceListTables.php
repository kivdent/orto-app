<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Prices Модуль работы с ценами
 *
 * @author kivde
 */
class PriceListTables {

    public $name;
    public $id;
    public $start;
    public $end;
    public $modules;

    /*
     * Получение списка таблий прейскурантов из базы данных считая архивные таблица типа manip_dd_mm_yyyy
     */

    private static function getSortingArrayOfTables($table) {
        $db = Db::getConnection();
        $result = $db->query('SHOW TABLES');
        $i = 0;
        $pattern = '/' . $table . '_([0-9]{2})_([0-9]{2})_([0-9]{4})/';
        while ($row = $result->fetch()) {
            if ($row[0] == $table) {
                $endDate=new DateTime;
                $endDate->modify('+1 day');
                
                $tableName[$i]['end'] = DateTimeImmutable::createFromMutable($endDate); //дата окончания действия прейскуранта
                $tableName[$i]['addition'] = '';
                $i++;
            } else {

                if (preg_match($pattern, $row[0])) {
                    $tableName[$i]['end'] = DateTimeImmutable::createFromFormat('Y-m-d', preg_replace($pattern, '$3-$2-$1', $row[0]));
                    $tableName[$i]['addition'] = preg_replace($pattern, '_$1_$2_$3', $row[0]);
                    $i++;
                }
            }
        }
        /*
         * Сортировка массива с прайсами
         */
        foreach ($tableName as $key => $value) {
            $tableNameCampare[$key] = $tableName['end'];
        }
        array_multisort($tableNameCampare, SORT_DESC, $tableName);

        foreach ($tableName as $key => &$value) {
            if ($key == 0) {
                $value['start'] = DateTime::createFromFormat('Y-m-d', '2007-01-01');
            } else {
                $value['start'] = $tableName[$key - 1]['end']->modify('+1 day');
            }
        }

        return $tableName;
    }

    public static function getTableOfPriclists() {//Получаем список , отсортированных по дате Действия
        return PriceListTables::getSortingArrayOfTables('manip');
    }

}
