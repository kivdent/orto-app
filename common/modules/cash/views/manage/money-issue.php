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
$this->title = "Выдача денег из кассы";

$form = ActiveForm::begin(['id' => 'account-cash-form']);
?>
<h1><?= $this->title ?></h1>

<?= TableWidget::widget(['table' => $financial_divisions_balance['table'],'labels' => $financial_divisions_balance['labels']])?>
<?= $form->field($accountCash, 'summ')->textInput() ?>
<?= $form->field($accountCash, 'otv')->dropDownList(Employee::getList()) ?>
<?= $form->field($accountCash, 'oper')->dropDownList(AccountCashType::getListArray()) ?>
<?= $form->field($accountCash, 'podr')->dropDownList(FinancialDivisions::getDivisionList()) ?>
<div class="form-group">
    <?= Html::submitButton($accountCash->isNewRecord ? 'Сохранить' : 'Обновить', ['class' => 'btn btn-primary']) ?>
</div>


<?php ActiveForm::end(); ?>

