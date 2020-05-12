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

    <h1><?= Html::encode($this->title) ?> </h1>
<div class="row" name="control">
    <div class="col-lg-12">
        <?= Html::a('Новый прейскурант', ['create'], ['class' => 'btn btn-success btn-xs']) ?>
        <?= Html::a('Сохранить без баллов', ['xls-save'], ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
        <?= Html::a('Сохранить c баллами', ['xls-save', 'coefficient' => 'true'], ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
    </div>
</div>



    <?= PriceListsWidget::widget([
        'type'=>PriceListsWidget::TYPE_EDIT,
        'activePriceList'=>$priceListId
    ])?>
</div>
