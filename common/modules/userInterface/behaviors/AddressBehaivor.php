<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\userInterface\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Description of AddressBehaivor
 *
 * @author kivde
 */
class AddressBehaivor extends Behavior {
    
    public function AddressSave($insert) {
       $owner->address_id
        return true;
    }

}
