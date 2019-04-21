<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\clinic\models\FinancialDivisions */

$this->title = 'Изменение финансового подразделения' . $model->name;

?>
<div class="financial-divisions-update">

    <h1><?= Html::encode($this->title) ?></h1>
<?=
        Html::a('Удалить', ['delete', 'id' => $model->id,'clinic_id' => $model->clinic_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить' . $model->name . '?',
                'method' => 'post',
            ],
        ])
        ?>
    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>
