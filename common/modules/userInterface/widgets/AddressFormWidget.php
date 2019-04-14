<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\userInterface\widgets;

use yii\base\Widget;

/**
 * Description of AddressForm
 *
 * @author kivde
 */
class AddressFormWidget extends Widget {

    public $form;
    public $model;

    public function run() {
        return $this->render('_addressForm', [
                    'form' => $this->form,
                    'model' => $this->model,
        ]);
    }

}
