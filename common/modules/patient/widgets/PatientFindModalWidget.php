<?php

namespace common\modules\patient\widgets;

class PatientFindModalWidget extends \yii\base\Widget
{
    public $text='<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>';
    public $patientIdTarget;
    public $patientNameTarget;
    public function run()
    {
        return $this->render('_view',[
            'text'=>$this->text,
           'patientIdTarget'=>$this->patientIdTarget,
           'patientNameTarget'=>$this->patientNameTarget
        ]);
    }
}