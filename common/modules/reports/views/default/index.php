<?php
/* @var $this \yii\web\View*/

use common\widgets\tableWidget\TableWidget;

/* @var $table array*/
?>
<h2><?=$table->summary?></h2>
<?php if (isset($table->summaryByPricelist)):?>
    <?= TableWidget::widget(['table' => $table->summaryByPricelist]);?>
<?php endif;?>
<?= TableWidget::widget(['table' => $table->table])?>
