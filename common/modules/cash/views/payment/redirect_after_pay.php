<?php
use yii\helpers\Url;
/* @var $this \yii\web\View*/
/* @var $payment \common\modules\cash\models\Payment*/
//$this->registerJs('window.open("' . Url::to(['payment/print', 'payment_id' => $payment->id]) . '"");
//window.location.href ="/"');


?>
<script>
    window.open("<?=Url::to(['payment/print', 'payment_id'=> $payment->id])?>");
    window.location.href ="/";
</script>

