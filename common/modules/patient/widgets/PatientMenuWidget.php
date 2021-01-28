<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\patient\widgets;

use yii\base\Widget;
use Yii;

/**
 * Description of MenuWidget
 *
 * @author kivdent
 */
class PatientMenuWidget extends Widget
{

    public $menuItems = [
    ];
    public $patient_id;

    public function run()
    {
        $this->menuItems = [

            ['label' => 'Основные сведения', 'url' => ['/patient/manage/update', 'patient_id' => $this->patient_id]],
//            ['label' => 'Медицинская карта', 'url' => ['/patient/examination/index','patient_id' => $this->patient_id]],
//           ['label' => 'Дневник', 'url' => ['/patient/journal/index','patient_id' => $this->patient_id]],
//            ['label' => 'Диспансеризация', 'url' => ['/patient/recall/index','patient_id' => $this->patient_id]],
         ['label' => 'План лечения', 'url' => ['/patient/plan/index', 'patient_id' => $this->patient_id]],
            ['label' => 'Медицинская карта', 'url' => ['/patient/records/index', 'patient_id' => $this->patient_id]],

//            ['label' => 'Осмотры', 'url' => ['/old_app/pat_card.php', 'id' => $this->patient_id, 'action' => 'medcard']],
//            ['label' => 'Терапия', 'url' => ['/old_app/pat_card.php', 'id' => $this->patient_id, 'action' => 'ter']],
            ['label' => 'Счета', 'url' => ['/patient/invoices', 'patient_id' => $this->patient_id, 'action' => 'ter']],
//            ['label' => 'Ортодонтия', 'url' => ['/old_app/pat_card.php', 'id' => $this->patient_id, 'action' => 'ortd']],
//            ['label' => 'Ортопедия', 'url' => ['/old_app/pat_card.php', 'id' => $this->patient_id, 'action' => 'ortp']],
            ['label' => 'Диспансеризция', 'url' => ['/old_app/pat_card.php', 'id' => $this->patient_id, 'action' => 'disp']],
           // ['label' => 'Статистика', 'url' => ['/old_app/pat_card.php', 'id' => $this->patient_id, 'action' => 'stat']],
            ['label' => 'Статистика', 'url' => ['/patient/statistics/index','patient_id' => $this->patient_id]],
            ['label' => 'Документы', 'url' => ['/documents/', 'patient_id' => $this->patient_id]],
            ['label' => 'Фотографии', 'url' => ['/photos/', 'patient_id' => $this->patient_id]],


        ];
        foreach ($this->menuItems as &$menuItem) {
            $routeArray = explode('/', $menuItem['url'][0]);
            $menuItemAction = isset($routeArray[2]) ? $routeArray[2] : false;
            $currentAction = Yii::$app->controller->id;
            $menuItem['active'] = ($menuItemAction === $currentAction) ? true : false;

        }


        return $this->render('_patientMenu', [
            'menuItems' => $this->menuItems,
        ]);
    }

}
