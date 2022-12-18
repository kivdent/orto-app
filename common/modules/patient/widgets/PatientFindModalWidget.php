<?php

namespace common\modules\patient\widgets;

class PatientFindModalWidget extends \yii\base\Widget
{
    public $findBtnText='<span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>';
    public $newPatBtnText='<span class="glyphicon glyphicon-plus" aria-hidden="true">';
    public $patientIdTarget;
    public $patientNameTarget='#patient_name';
    public $newPatBtn=true;

    public function run()
    {
        return $this->render('_view',[
           'findBtnText'=>$this->findBtnText,
           'patientIdTarget'=>$this->patientIdTarget,
           'patientNameTarget'=>$this->patientNameTarget,
           'newPatBtnText'=>$this->newPatBtnText,
           'newPatBtn'=>$this->newPatBtn,
        ]);
    }
}