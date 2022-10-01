<?php
/* @var $this \yii\web\View */

use common\modules\pricelists\models\Pricelist;
use common\modules\pricelists\widgets\PriceListsWidget;

?>
<?= PriceListsWidget::widget([
    'type' => PriceListsWidget::TYPE_COMPLIANCE,

]) ?>
