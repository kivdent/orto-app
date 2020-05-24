<?php

use yii\helpers\Html;

use common\modules\documents\models\Notes;

/* @var $this yii\web\View */
/* @var $model common\modules\documents\models\Notes */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Notes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="notes-view">

    <div class="raw">
        <div class="col-xs-5">
            <?=
            Html::img('/images/logo orto premier.png', ['width' => 200])
            ?>
        </div>
        <div class="col-xs-7 small">
            Новокузнецк, пр. Кузнецкстроевский д.30 п.73<br>+7 (3843) 45 46 33, +7-913-429-97-23
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class='span12'>
                <hr>
            </div>
        </div>
    </div>

    <div class="raw text-center">
        <div class="col-xs-12">
            <b><?= Html::encode($this->title) ?></b>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <br>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            Пациент: <?=
            Yii::$app->formatter->format(Html::encode($model->patientName), 'ntext')
            ?>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?=
                    Yii::$app->formatter->format(Html::encode($model->text), 'ntext')
                    ?>
                </div>
            </div>

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
        <div class="col-xs-6">
            Дата: <?= $model->createdDate ?>
        </div>
        <div class="col-xs-6">
            Врач________________<?=
            Html::encode($model->authorName)
            ?>
        </div>

    </div>

</div>
