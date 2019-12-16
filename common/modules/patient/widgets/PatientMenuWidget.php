<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\clinic\widgets;

use yii\base\Widget;
use Yii;

/**
 * Description of MenuWidget
 *
 * @author kivdent
 */
class ClinicManageMenuWidget extends Widget {

    public $menuItems = [
    ];
    public $clinic_id;

    public function run() {
        $this->menuItems = [
            ['label' => 'Сведения', 'url' => ['/clinic/manage/update', 'clinic_id' => $this->clinic_id],],
            ['label' => 'Расписания', 'url' => ['/clinic/scheudles', 'clinic_id' => $this->clinic_id],],
            ['label' => 'Рабочие места', 'url' => ['/clinic/workplaces', 'clinic_id' => $this->clinic_id],],
              ['label' => 'Подразделения', 'url' => ['/clinic/financial-divisions', 'clinic_id' => $this->clinic_id],],
        ];
        foreach ($this->menuItems as &$menuItem) {
            $routeArray = explode('/', $menuItem['url'][0]);
            $menuItemController = $routeArray[2];
            $currentController = Yii::$app->controller->id;
            $menuItem['active'] = ($menuItemController === $currentController) ? true : false;
        }



        return $this->render('_clinicManageMenu', [
                    'menuItems' => $this->menuItems,
        ]);
    }

}
