<?php

/* @var $this \yii\web\View */

use yii\helpers\Html;
$this->registerJs("
    $('#full_table').on('change', function () {
        if ($('#full_table').val() == 'full') {
            $('.appointment').show();
            $('.empty').show();
        }
        if ($('#full_table').val() == 'empty') {
            $('.appointment').hide();
            $('.empty').show();
        }
        if ($('#full_table').val() == 'appointment') {
            $('.empty').hide();
            $('.appointment').show();
        }
    });
    $('#full_table').trigger('change');
")
?>
<?= Html::dropDownList('full_table', 'full',
    [
        'full' => 'Полное расписание',
        'empty' => 'Свободные часы',
        'appointment' => 'Назначенные',
    ],
    [
        'id' => 'full_table',
        'class' => 'form-control',
    ]
);
?>