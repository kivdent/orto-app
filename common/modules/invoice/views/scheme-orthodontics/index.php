<?php

use common\modules\employee\models\Employee;
use common\modules\invoice\models\SchemeOrthodonticsSearch;
use common\modules\patient\models\Patient;
use common\modules\userInterface\models\UserInterface;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\invoice\models\SchemeOrthodonticsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Схема оплат за ортодонтию';

?>
<div class="scheme-orthodontics-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'pat',
            [
                'format' => 'raw',
                'attribute' => 'patientFullName',
                'content' => function ($data) {
                    return Html::a($data->patientFullName, ['/patient/manage/view', 'patient_id' => $data->pat], ['target' => '_blank']);
                }
            ],
//            'sotr',
            [
                'format' => 'raw',
                'attribute' => 'sotr',
                'content' => function ($data) {
                    return Html::a($data->employeeFullName, ['/employee/manage/view', 'id' => $data->sotr], ['target' => '_blank']);
                },
                'filter' => Employee::getDoctorsList(),
            ],
//            'date',
            [
                'format' => 'raw',
                'attribute' => 'date',
                'content' => function ($data) {
                    return UserInterface::getFormatedDate($data->date);
                }
            ],
//            'per_lech',
            [
                'format' => 'raw',
                'attribute' => 'per_lech',
                'content' => function ($data) {
                    return $data->per_lech. (' мес.');
                }
            ],
            [
                'format' => 'raw',
                'attribute' => 'summ',
                'label' => 'Сумма общая (сумма в месяц)',
                'content' => function ($data) {
                    return $data->summ.' ('.$data->summ_month.')';
                }
            ],
           // 'summ_month',
            [
                'format' => 'raw',
                'attribute' => 'paid',
                'label' => 'Оплачено',
                'contentOptions' => function ($data) {
                    return ['class' => $data->isCompleted() ? 'success' : 'danger'];
                },
                'content' => function ($data) {
                    return $data->vnes;
                },
                'filter' => SchemeOrthodonticsSearch::getPaidList(),

            ],
            //'full',
            //'last_pay_month',
            ['class' => 'yii\grid\ActionColumn',
                'template' => UserInterface::getRoleNameCurrentUser()==UserInterface::ROLE_ADMIN?'{update} {delete}':'',
                ],
        ],
    ]); ?>
</div>
