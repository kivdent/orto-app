<?php

namespace common\modules\documents\widgets;

use yii\base\Widget;

class WordTemplateWidgetChooser extends Widget
{
    public $patient_id;

    public function run()
    {
        return $this->render('_word_template_chooser',
            [
                'patient_id' => $this->patient_id,
            ]
        );
    }
}