<?php

use common\modules\clinic\models\Clinic;
use common\modules\clinic\models\Settings;
use yii\helpers\Html;

use common\assets\PrintAsset;


/* @var $this yii\web\View */
/* @var $model common\modules\patient\models\TreatmentPlan */

$this->title = "План лечения";

$i = 1;
//\yii\web\YiiAsset::register($this);
PrintAsset::register($this);
?>


<div class="raw">
    <div class="col-xs-5">
        <?=Html::img(Settings::getLogoUri(),[
            'class'=>'img-responsive',
            'width'=>'200'
        ])?>
    </div>
    <div class="col-xs-7 small">
       <?= Clinic::getClinicInfoString()?>
    </div>
</div>
<div class="raw text-center">
    <div class="col-xs-12">
        <b><?= Html::encode($this->title) ?></b>
    </div>

</div>

<div class="small">
    <div class="row">
        <div class="col-xs-12">
            <div class='span12'>
                <hr>
            </div>
        </div>
    </div>
    <div class="raw">
        <div class="col-xs-6">
            Дата : <?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y') ?><br>
            Пациент: <?= $model->getPatientName() ?>

        </div>
        <div class="col-xs-6">
            Врач: <?= $model->getAuthorName() ?><br>
            Диагноз: <?= Html::encode($model->getDiagnosisTitle()) ?>
        </div>
    </div>

    <div class="raw ">
        <div class="col-xs-12">
            <?= Yii::$app->formatter->format(Html::encode($model->comments), 'ntext') ?>

        </div>
    </div>


    <div class="raw">
        <div class="col-xs-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Область</th>
                    <th scope="col">Рекомендация</th>
                    <th scope="col">Примерная стоимость</th>
                    <th scope="col">Примерный срок</th>
                    <th scope="col">Комментарий</th>
                </tr>
                </thead>
<!--                <tfoot>-->
<!--                <tr>-->
<!--                    <td>&nbsp;</td>-->
<!--                    <td>&nbsp;</td>-->
<!--                    <td>Примерная стоимость:</td>-->
<!--                    <td>--><?//= Html::encode($model->getPrice()) ?><!--</td>-->
<!--                    <td>&nbsp;</td>-->
<!--                </tr>-->
<!--                </tfoot>-->
                <tbody>
                <?php foreach ($model->planItems as $planlItem): ?>
                    <tr>
                        <th scope="row"><?= Html::encode($i++) ?></th>
                        <td><?= Html::encode($planlItem->regionTitle) ?></td>
                        <td><?= Html::encode($planlItem->operationTitle) ?></td>
                        <td><?= Html::encode($planlItem->price_from) .'-'. Html::encode($planlItem->price_to) ?></td>
                        <td><?= Html::encode($planlItem->duration_from) ?>-<?= Html::encode($planlItem->duration_to) ?></td>
                        <td><?= Html::encode($planlItem->commentText) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class='span12'>
                <hr>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class='span12'>
                1.	Предложенный план лечения может быть изменён по медицинским показаниям.<br>
                2.	Срок оказания услуги в плане лечения указан неделях и отсчитывается с дня первого посещения у лечащего врача с целью оказания услуги.<br>
                3.	Предложенный план лечения теряет свою актуальность:<br>
                3.1.	В случае изменения состояния здоровья пациента.<br>
                3.2.	Если работе по плану лечения не начат в течении 1 месяца с момента подписания.<br>
                3.3.	Если работы указанные в плане не осуществлены в указанные сроки по вине пациента.<br>
            </div>
        </div>
    </div><div class="row">
        <div class="col-xs-12">
            <div class='span12'>
                <hr>
            </div>
        </div>
    </div>

    <div class="raw">
        <div class="col-xs-6">
            Пациент:_______________________<br><?= $model->getPatientName() ?>
        </div>
        <div class="col-xs-6">
           Врач:____________________________<br><?= $model->getAuthorName() ?>
        </div>
    </div>
</div>