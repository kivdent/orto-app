<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\userInterface\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

/**
 * Description of userInterfaceBehaivor
 *
 * @author kivde
 */
class userInterfaceBehaivor extends Behavior {

    public function events() {
        return[
            Controller::EVENT_BEFORE_ACTION => 'setMenuItems',
        ];
    }
    public function setMenuItems(){
        
        $owner->view->params['userMenuItems']=Yii::$app->userInterface->menuItems;
    }
}
