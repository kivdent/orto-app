<?php


namespace console\controllers;


use common\modules\patient\models\Region;
use yii\console\Controller;

class FillRegionController extends Controller
{
    public $items = [
        ['title' => 'Не указана'],
        ['title' => 'Полость рта'],
        ['title' => 'Верхняя челюсть'],
        ['title' => 'Нижняя челюсть'],
        ['title' => '10 сегмент'],
        ['title' => '20 сегмент'],
        ['title' => '30 сегмент'],
        ['title' => '40  сегмент'],
        ['title' => '18 зуб'],
        ['title' => '17 зуб'],
        ['title' => '16 зуб'],
        ['title' => '15 зуб'],
        ['title' => '14 зуб'],
        ['title' => '13 зуб'],
        ['title' => '12 зуб'],
        ['title' => '11 зуб'],
        ['title' => '21 зуб'],
        ['title' => '22 зуб'],
        ['title' => '23 зуб'],
        ['title' => '24 зуб'],
        ['title' => '25 зуб'],
        ['title' => '26 зуб'],
        ['title' => '27 зуб'],
        ['title' => '28 зуб'],
        ['title' => '38 зуб'],
        ['title' => '37 зуб'],
        ['title' => '36 зуб'],
        ['title' => '35 зуб'],
        ['title' => '34 зуб'],
        ['title' => '33 зуб'],
        ['title' => '32 зуб'],
        ['title' => '31 зуб'],
        ['title' => '41 зуб'],
        ['title' => '42 зуб'],
        ['title' => '43 зуб'],
        ['title' => '44 зуб'],
        ['title' => '45 зуб'],
        ['title' => '46 зуб'],
        ['title' => '47 зуб'],
        ['title' => '48 зуб'],
        ['title' => '55 зуб'],
        ['title' => '54 зуб'],
        ['title' => '53 зуб'],
        ['title' => '52 зуб'],
        ['title' => '51 зуб'],
        ['title' => '61 зуб'],
        ['title' => '62 зуб'],
        ['title' => '63 зуб'],
        ['title' => '64 зуб'],
        ['title' => '65 зуб'],
        ['title' => '75 зуб'],
        ['title' => '74 зуб'],
        ['title' => '73 зуб'],
        ['title' => '72 зуб'],
        ['title' => '71 зуб'],
        ['title' => '81 зуб'],
        ['title' => '82 зуб'],
        ['title' => '83 зуб'],
        ['title' => '84 зуб'],
        ['title' => '85 зуб'],
    ];

    public function actionFill()
    {
        echo "Заполнение таблицы Области в плане лечения...";
        foreach ($this->items as $item) {
            $region = new Region();
            $region->title = $item['title'];
            $region->save(false);
        }
        echo "Выполнено.".PHP_EOL;
    }
}