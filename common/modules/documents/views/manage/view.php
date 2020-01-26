<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\modules\documents\models\Notes;

/* @var $this yii\web\View */
/* @var $model common\modules\documents\models\Notes */

$this->title = $model->title;

\yii\web\YiiAsset::register($this);
?>
<div class="notes-view">

    <h4><?= $model->title ?>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Печать', ['print', 'id' => $model->id], ['class' => 'btn btn-success','target'=>'_blank']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить документ?',
                'method' => 'post',
            ],
        ]) ?>
    </h4>

    <div class="row">Врач:
        <?=
        Html::encode($model->authorName)
        ?>
    </div>
</br>
    <div class="row">
        <?=
        Yii::$app->formatter->format(Html::encode($model->text), 'ntext')
        ?>
    </div>

</div>
