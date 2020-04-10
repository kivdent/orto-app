<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\pricelists\widgets\PriceListsWidget;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $priceListId string*/

$this->title = 'Прейскуранты';
?>
<div class="pricelist-index">

    <h1><?= Html::encode($this->title) ?><?= Html::a('Новый прейскурант', ['create'], ['class' => 'btn btn-success']) ?></h1>
    <?= PriceListsWidget::widget([
        'type'=>PriceListsWidget::TYPE_EDIT,
        'activePriceList'=>$priceListId
    ])?>
</div>
