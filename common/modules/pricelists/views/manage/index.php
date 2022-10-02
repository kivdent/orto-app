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
        <?= Html::a('Сохранить без коэффициентов', ['xls-save'], ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
        <?= Html::a('Сохранить как XML', ['csv-save'], ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
        <?= Html::a('Сохранить с коэффициентами', ['xls-save', 'coefficient' => 'true'], ['class' => 'btn btn-primary btn-xs','target'=>'_blank']) ?>
        <?= Html::a('Пакетное редактирование', ['batch-editing', ], ['class' => 'btn btn-primary btn-xs']) ?>
        <?= Html::button('Загрузить на Яндекс Диск', [
            'class' => 'btn btn-success btn-xs',
            'id' => 'save-to-yandex-disk',
            'onclick'=>'
             $.ajax({
            url: \'manage/save-to-yandex-disk\',
            type: \'POST\',
            success: function (response) {
                alert(\'Прайслист загружен\');
            },
            });
        '
        ]) ?>
    </div>
</div>



    <?= PriceListsWidget::widget([
        'type'=>PriceListsWidget::TYPE_EDIT,
        'activePriceList'=>$priceListId
    ])?>

</div>
