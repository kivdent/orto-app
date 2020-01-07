<?php


namespace console\controllers;


use common\modules\patient\models\Region;
use yii\console\Controller;
use Yii;

class FillRegionController extends Controller
{
    public $items = [
        ['title'=>'Не указана','type'=>'all'],
        ['title'=>'Полость рта','type'=>'all'],
        ['title'=>'Верхняя челюсть','type'=>'jaw'],
        ['title'=>'Нижняя челюсть','type'=>'jaw'],
        ['title'=>'10 сегмент','type'=>'segment'],
        ['title'=>'20 сегмент','type'=>'segment'],
        ['title'=>'30 сегмент','type'=>'segment'],
        ['title'=>'40  сегмент','type'=>'segment'],
        ['title'=>'18 зуб','type'=>'permanent_tooth'],
        ['title'=>'17 зуб','type'=>'permanent_tooth'],
        ['title'=>'16 зуб','type'=>'permanent_tooth'],
        ['title'=>'15 зуб','type'=>'permanent_tooth'],
        ['title'=>'14 зуб','type'=>'permanent_tooth'],
        ['title'=>'13 зуб','type'=>'permanent_tooth'],
        ['title'=>'12 зуб','type'=>'permanent_tooth'],
        ['title'=>'11 зуб','type'=>'permanent_tooth'],
        ['title'=>'21 зуб','type'=>'permanent_tooth'],
        ['title'=>'22 зуб','type'=>'permanent_tooth'],
        ['title'=>'23 зуб','type'=>'permanent_tooth'],
        ['title'=>'24 зуб','type'=>'permanent_tooth'],
        ['title'=>'25 зуб','type'=>'permanent_tooth'],
        ['title'=>'26 зуб','type'=>'permanent_tooth'],
        ['title'=>'27 зуб','type'=>'permanent_tooth'],
        ['title'=>'28 зуб','type'=>'permanent_tooth'],
        ['title'=>'38 зуб','type'=>'permanent_tooth'],
        ['title'=>'37 зуб','type'=>'permanent_tooth'],
        ['title'=>'36 зуб','type'=>'permanent_tooth'],
        ['title'=>'35 зуб','type'=>'permanent_tooth'],
        ['title'=>'34 зуб','type'=>'permanent_tooth'],
        ['title'=>'33 зуб','type'=>'permanent_tooth'],
        ['title'=>'32 зуб','type'=>'permanent_tooth'],
        ['title'=>'31 зуб','type'=>'permanent_tooth'],
        ['title'=>'41 зуб','type'=>'permanent_tooth'],
        ['title'=>'42 зуб','type'=>'permanent_tooth'],
        ['title'=>'43 зуб','type'=>'permanent_tooth'],
        ['title'=>'44 зуб','type'=>'permanent_tooth'],
        ['title'=>'45 зуб','type'=>'permanent_tooth'],
        ['title'=>'46 зуб','type'=>'permanent_tooth'],
        ['title'=>'47 зуб','type'=>'permanent_tooth'],
        ['title'=>'48 зуб','type'=>'permanent_tooth'],
        ['title'=>'55 зуб','type'=>'baby_tooth'],
        ['title'=>'54 зуб','type'=>'baby_tooth'],
        ['title'=>'53 зуб','type'=>'baby_tooth'],
        ['title'=>'52 зуб','type'=>'baby_tooth'],
        ['title'=>'51 зуб','type'=>'baby_tooth'],
        ['title'=>'61 зуб','type'=>'baby_tooth'],
        ['title'=>'62 зуб','type'=>'baby_tooth'],
        ['title'=>'63 зуб','type'=>'baby_tooth'],
        ['title'=>'64 зуб','type'=>'baby_tooth'],
        ['title'=>'65 зуб','type'=>'baby_tooth'],
        ['title'=>'75 зуб','type'=>'baby_tooth'],
        ['title'=>'74 зуб','type'=>'baby_tooth'],
        ['title'=>'73 зуб','type'=>'baby_tooth'],
        ['title'=>'72 зуб','type'=>'baby_tooth'],
        ['title'=>'71 зуб','type'=>'baby_tooth'],
        ['title'=>'81 зуб','type'=>'baby_tooth'],
        ['title'=>'82 зуб','type'=>'baby_tooth'],
        ['title'=>'83 зуб','type'=>'baby_tooth'],
        ['title'=>'84 зуб','type'=>'baby_tooth'],
        ['title'=>'85 зуб','type'=>'baby_tooth'],
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
    public function actionReFill()
    {
        echo "Очистка таблицы Области в плане лечения...";
        $sql=Yii::$app->db->createCommand();
        $sql->truncateTable('region')->execute();
        echo "Выполнено.".PHP_EOL;
        echo "Заполнение таблицы Области в плане лечения...";
        foreach ($this->items as $item) {
            $region = new Region();
            $region->title = $item['title'];
            $region->type = $item['type'];
            $region->save(false);
        }
        echo "Выполнено.".PHP_EOL;
    }
}