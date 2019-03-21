<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Пользователи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены што хотите удалить пользователя?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            
            [
                'attribute' => 'roles',
                'format' => 'raw',
                'value' => function($model) {
                    return implode(ArrayHelper::getColumn($model->roles, 'description'));
                }
            ],
            [
                'attribute' => 'employe_id',
                'format' => 'raw',
                'value' => function($user) {
                    return $user->employe_id ? $user->employe->getFullName() : 'Не указан';
                }
            ],
            'email:email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($user) {
                    return $user->status ? 'Активен' : 'Удалён';
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ])
    ?>

</div>
