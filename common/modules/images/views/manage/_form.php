<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\modules\images\assets\ImagesAsset;
use View;


/* @var $this yii\web\View */
/* @var $model common\modules\images\models\Images */
/* @var $form yii\widgets\ActiveForm */

ImagesAsset::register($this)
?>

<div class="images-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'description')->textarea(['rows' => 12]) ?>
        </div>
        <div class="col-lg-6">
            <?php //if (isset($model->file_name)): ?>
                <?= Html::a(Html::img(
                isset($model->file_name)?$model->imageLink:'#',
                    [
                        'class' => 'img-responsive',
                        'id' => 'patient_image',
                    ]
                ),
                    [isset($model->file_name)?$model->imageLink:'#'],
                    ['target' => '_blank',
                    'id'=> 'patient_image_link',]) ?>
            <?php //endif; ?>

            <?= $form->field($model, 'uploadedFile')->fileInput() ?>
        </div>


    </div>

    <div class="form-group">
        <?= Html::submitButton(
            isset($model->id) ? 'Изменить' : 'Загрузить',
            ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

