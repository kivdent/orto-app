<?php
/* @var $this \yii\web\View */

/* @var $doctor_id int */

use common\modules\schedule\models\AppointmentManager;
use yii\helpers\Html;

$this->registerJs("
    $('#doctor_id').on('change', function () {
        if ($(this).val() == 'all') {
            $('.doctor-grid').show();
        } else {
            $('.doctor-grid').hide();
            $('#doctor-grid-id-' + $(this).val()).show();
        }

    });
");

?>


<?= Html::dropDownList('doctor_id', $doctor_id, AppointmentManager::getActiveDoctorsNameList(''),
    [
        'id' => 'doctor_id',
        'class' => 'form-control',
    ]
);
?>