<?php
/* @var $this yii\web\View */
/* @var $payment \common\modules\cash\models\Payment */
/* @var $invoice  \common\modules\invoice\models\Invoice */
/* @var $giftCard  \common\modules\sale\models\GiftCard */
if (!isset($giftCard)){
    $giftCard=null;
}
?>
<h3>
    Приём оплаты.
</h3>
<?= $this->render('_form', [
    'payment' => $payment,
    'invoice' => $invoice,
    'giftCard'=>$giftCard
]) ?>
