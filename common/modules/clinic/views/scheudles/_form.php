<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\ClinicSchedleForm */
/* @var $day common\modules\clinic\models\DaysInClinicSheudles */
/* @var $form yii\widgets\ActiveForm */
/* composer require 2amigos/yii2-date-picker-widget:~1.0use dosamigos\datepicker\DatePicker;
 */
?>

<div class="clinic-sheudles-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'options' => ['class' => 'form-inline',],
                        'fieldConfig' => [
                           // 'template' => "{label}\n{input}\n{hint}\n{error}\n",
                   
                           // 'template' => "<div class=\"col-lg-3\">{label}</div>\n<div class=\"col-lg-9\">{input}</div>\n<div class=\"col-lg-12 col-lg-offset-3\">{error}</div>",
                            'labelOptions' => ['class' => ''],
                        ]
    ]);
    ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?><br>
    <?= $form->field($model, 'status')->radioList($model->getStatusLists()) ?><br>
    <?=
    $form->field($model, 'start_date')->widget(
            DatePicker::classname(), [
        'options' => ['placeholder' => 'Дата вступления в силу....'],
        'removeButton' => false,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ]);
    ?>
    <?php foreach ($model->days as $day): ?><br>
    <?= $this->render('_dayInCS', ['day' => $day, 'form' => $form,'model'=>$model]); ?>
<?php endforeach; ?>



    <div class="form-group">
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>

</div>
