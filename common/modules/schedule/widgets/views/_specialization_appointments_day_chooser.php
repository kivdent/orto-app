<?php


/* @var $this \yii\web\View */

use common\modules\schedule\models\AppointmentsDay;
use yii\helpers\Html;

$this->registerJs(<<<JS
    $('#specialization_appointments_day_chooser').on('change', function () {
        
        var specialization=$(this).val();
        if (specialization=='all') {
            $('.appointment-day').show();
        }else{
            $('.appointment-day').hide();  
            $('table.'+specialization).show();
        }

    });
    $('#specialization_appointments_day_chooser').trigger('change');
JS
);
?>
<?= Html::dropDownList('specialization_appointments_day_chooser', 'all',
    array_merge(['all' => 'Все'], AppointmentsDay::getSpezializationLabels()),
    [
        'id' => 'specialization_appointments_day_chooser',
        'class' => 'form-control',
    ]
); ?>
