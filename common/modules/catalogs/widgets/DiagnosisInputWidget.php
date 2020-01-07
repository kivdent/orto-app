<?php


namespace common\modules\catalogs\widgets;


use common\modules\catalogs\models\Diagnosis;
use kartik\select2\Select2;


class DiagnosisInputWidget extends Select2
{
    public function beforeRun()
    {
        if (!parent::beforeRun()) {
            return false;
        }

        $this->data=Diagnosis::getListByClassification();
        $this->options['placeholder']='Выберете диагноз ...';
        $this->pluginOptions['allowClear']=true;

        return true; // or false to not run the widget
    }
}