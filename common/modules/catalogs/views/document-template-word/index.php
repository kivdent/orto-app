<?php

use common\modules\documents\models\TemplateVariables;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\documents\models\DocumentTemplateWordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны докментов Words';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-template-word-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Новый шаблон докмента Word', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div>
        <h3>Стандартные перменные</h3>
        <?php foreach (TemplateVariables::getStandartTemplateVariablesDescription() as $varName => $varDesc): ?>
            <p><?= $varDesc . ' - ${' . $varName . '}' ?></p>
        <?php endforeach; ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description:ntext',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}{link}',
                'buttons' => [

                    'link' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-screenshot"></span>',
                            $model->docLink,
                            ['target' => '_blank']
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
