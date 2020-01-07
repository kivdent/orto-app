<?php

use common\modules\catalogs\models\Complaints;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\catalogs\models\Objectively */

$this->title = 'Шаблон "'.$model->name.'" для раздела "Объективно" в медицинской карте.';
$this->params['breadcrumbs'][] = ['label' => 'Объективно', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$formName='objectivelyForm';
$textAreaName='objectively';
$this->registerJs(
    $model->renderScript(),
    View::POS_READY,
    'objectivelyScript'
);

?>
<div class="objectively-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить этот шаблон?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="row">
        <div class="col-lg-4">
            <?=
            $model->renderTextarea($model->type);
            ?>
        </div>
        <div class="col-lg-8">
            <?=
            $model->renderForm();
            ?>
        </div>
    </div>
</div>
