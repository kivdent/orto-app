<?php


namespace console\controllers;


use common\modules\patient\models\Operation;
use yii\console\Controller;

class FillOperationController extends Controller
{
public $items=[
    ['title'=>'Указана в комментарии','price_from'=>'','price_from'=>''],
    ['title'=>'Лечение кариеса','price_from'=>'2500','price_from'=>'3500'],
    ['title'=>'Замена пломбы','price_from'=>'2500','price_from'=>'3500'],
    ['title'=>'Эндодонтическое лечение','price_from'=>'5000','price_from'=>'15000'],
    ['title'=>'Извлечение штифта','price_from'=>'2000','price_from'=>'3500'],
    ['title'=>'Консультация терапевта','price_from'=>'250','price_from'=>'500'],
    ['title'=>'Консультация ортодонта','price_from'=>'250','price_from'=>'500'],
    ['title'=>'Консультация ортопеда','price_from'=>'250','price_from'=>'500'],
    ['title'=>'Консультация хирурга','price_from'=>'','price_from'=>''],
    ['title'=>'Консультация специалиста','price_from'=>'','price_from'=>''],
    ['title'=>'Исправление прикуса брекет системой','price_from'=>'','price_from'=>''],
    ['title'=>'Исправление прикуса элайнерами','price_from'=>'','price_from'=>''],
    ['title'=>'Исправление прикуса съемными ортодонтическими аппаратами','price_from'=>'','price_from'=>''],
    ['title'=>'Повторное эндодонтическое лечение','price_from'=>'','price_from'=>''],
    ['title'=>'Пришлифовывание зубов','price_from'=>'','price_from'=>''],
    ['title'=>'Коронка металлокерамическая на литом каркасе','price_from'=>'','price_from'=>''],
    ['title'=>'Коронка металлокерамичесская на фрезерованном каркаса','price_from'=>'','price_from'=>''],
    ['title'=>'Коронка из диоксида циркония','price_from'=>'','price_from'=>''],
    ['title'=>'Частичный съемный протез','price_from'=>'','price_from'=>''],
    ['title'=>'Полный съёмный протез','price_from'=>'','price_from'=>''],
    ['title'=>'Литая культевая вкладка','price_from'=>'','price_from'=>''],
    ['title'=>'Стекловолоконный анкерный штифт','price_from'=>'','price_from'=>''],
    ['title'=>'Съемный иммедиат протез','price_from'=>'','price_from'=>''],
    ['title'=>'Удаление зуба','price_from'=>'','price_from'=>''],
    ['title'=>'Имплантация','price_from'=>'','price_from'=>''],
    ['title'=>'Аугментация','price_from'=>'','price_from'=>''],
    ['title'=>'Синуслифтинг','price_from'=>'','price_from'=>''],
    ['title'=>'Профессиональная гигиена полости рта','price_from'=>'','price_from'=>''],
    ['title'=>'Фторирование эмали','price_from'=>'','price_from'=>''],
    ['title'=>'Пародонтологическое обследование','price_from'=>'','price_from'=>''],
    ['title'=>'Лечение заболеваний пародонта','price_from'=>'','price_from'=>''],
    ['title'=>'Шинирование зубов','price_from'=>'','price_from'=>''],
    ['title'=>'Открытый кюретаж','price_from'=>'','price_from'=>''],
    ['title'=>'Закрытый кюретаж','price_from'=>'','price_from'=>''],
    ['title'=>'Вектор терапия','price_from'=>'','price_from'=>''],
    ['title'=>'Пластика преддверия полости рта','price_from'=>'','price_from'=>''],
    ['title'=>'Пластика губы','price_from'=>'','price_from'=>''],
    ['title'=>'Пластика языка','price_from'=>'','price_from'=>''],
];
    public function actionFill()
    {
        echo "Очистка таблицы Операции...";
        Operation::deleteAll();
        echo "Выполнено".PHP_EOL;
        echo "Заполнение таблицы Операции в плане лечения...";
        foreach ($this->items as $item) {
            $region = new Operation();
            $region->title = $item['title'];
            $region->save(false);
        }
        echo "Выполнено.".PHP_EOL;
    }
    private function deleteAll()
    {

        return true;
    }
}