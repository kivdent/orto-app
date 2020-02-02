<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use Yii;

/* @var $this yii\web\View */
/* @var $model common\modules\images\models\Images */

$this->title = 'Фотография пациента '.$model->patientName;

\yii\web\YiiAsset::register($this);
?>
<div class="images-view">


    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="panel panel-default">
        <div class="panel-heading">
            <?= Yii::$app->formatter->asDate($model->created_at, 'php:d.m.Y') ?><br>
            <?= Html::encode($model->getAuthorName()) ?>
        </div>
        <div class="panel-body">
            <?= Html::a(Html::img($model->imageLink, ['class' => 'img-responsive']),[$model->imageLink],['target'=>'_blank']) ?>
        </div>
    </div>
</div>
