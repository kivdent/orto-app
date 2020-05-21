<?php
/* @var $this yii\web\View */

use common\modules\cash\models\AccountCash;
use common\modules\catalogs\models\AccountCashType;
use common\modules\clinic\models\FinancialDivisions;
use common\modules\employee\models\Employee;
use common\widgets\tableWidget\TableWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $financial_divisions_balance array */
/* @var  $accountCash AccountCash */
/* @var  $accountCashs array|AccountCash */
$this->title = "Закрытие кассовой смены";

$form = ActiveForm::begin(['id' => 'account-end-form']);
?>
<h1><?= $this->title ?></h1>

<?= TableWidget::widget(['table' => $financial_divisions_balance['table'], 'labels' => $financial_divisions_balance['labels']]) ?>
<?php foreach ($accountCashs as $i=> $accountCash): ?>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($accountCash, "[$i]podr")->dropDownList(FinancialDivisions::getDivisionList(),['disabled'=>'true']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4"> <?= $form->field($accountCash, "[$i]summ")->textInput(['value'=>$financial_divisions_balance['table'][$accountCash->podr]['sum']]) ?></div>
        <div class="col-lg-8"><?= $form->field($accountCash, "[$i]otv")->dropDownList(Employee::getList(),['value'=>Yii::$app->user->identity->employe_id]) ?></div>
    </div>
<?php endforeach; ?>
<div class="form-group">
    <?= Html::submitButton('Закрыть смену', ['class' => 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end(); ?>

