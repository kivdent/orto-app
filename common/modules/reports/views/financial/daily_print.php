<?php
/** @var $this \yii\web\View
 * @var $cashbox \common\modules\cash\models\Cashbox
 * @var $financial_report \common\modules\reports\models\FinancialReports
 * @var $divisions array
 **/

/* @var $print boolean*/

use common\modules\clinic\models\FinancialDivisions;
use common\modules\userInterface\models\UserInterface;
$this->title = "Финансовый отчёт за " . UserInterface::getFormatedDate($cashbox->date);
?>
<div class="small">
<?= $this->render('_daily_form', [
    'cashbox' => $cashbox,
    'financial_report' => $financial_report,
    'divisions' => $divisions,
    'print'=>$print,
]) ?>
</div>