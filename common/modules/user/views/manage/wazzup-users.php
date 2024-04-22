<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $user common\models\User */
$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
\common\modules\user\assets\WazzupUserAsset::register($this);
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Новый пользователь', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'username',
            [
                'attribute' => 'roles',
                'format' => 'raw',
                'value' => function ($model) {
                    return implode(ArrayHelper::getColumn($model->roles, 'description'));
                }
            ],
            // 'auth_key',
            //  'password_hash',
            //  'password_reset_token',
            // 'email:email',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($user) {
                    return $user->status ? 'Активен' : 'Заблокирован';
                }
            ],
            //'created_at',
            //'updated_at',
            //'employe_id'
            [
                'attribute' => 'employe_id',
                'format' => 'raw',
                'value' => function ($user) {
                    return $user->employe !== null ? $user->employe->getFullName() : 'Не указан';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{wazzup-user}',
                'header' => 'Wazzup',
                'buttons' => [
                    'wazzup-user' => function ($url, $model, $key) {
                        $button = Html::button('-', [
                            'user_id' => $model->id,
                            'action' => 'delete',
                            'class' => 'button',
                        //    'onclick' => 'alert("1")'
                        ]);
                        return $button;
                    },
                    'activate' => function ($url, $model, $key) {
                        return $model->status === User::STATUS_DELETED ? Html::a("<span class=\"glyphicon glyphicon-ok\"></span>", $url, $options = ['title' => 'Разблокировать', 'aria-label' => 'Разблокировать', 'data-pjax' => '0']) : '';
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>
