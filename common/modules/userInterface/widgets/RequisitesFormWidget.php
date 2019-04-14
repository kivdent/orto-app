<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\modules\userInterface\widgets;

/**
 * Description of RequisitesFormWidget
 *
 * @author kivde
 * 
 */
use yii\base\Widget;

class RequisitesFormWidget extends Widget{
     public $form;
    public $model;
    
   public function run() {
        return $this->render('_requisitesForm', [
                    'form' => $this->form,
                    'model' => $this->model,
        ]);
    }
}
