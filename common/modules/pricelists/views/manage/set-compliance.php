<?php


/* @var $this \yii\web\View
 * @var $pricelistItem \common\modules\pricelists\models\PricelistItems
 */


use common\modules\pricelists\widgets\assets\PriceListsComplianceAsset;
use common\modules\pricelists\widgets\PriceListsWidget;
use common\modules\pricelists\models\Pricelist;
use yii\helpers\Html;

$this->title = 'Установка соответвия для позиции ';
PriceListsComplianceAsset::register($this);
?>
    <h1><?= $this->title ?></h1>
    <h2 id="compliance-text-title"><?= $pricelistItem->title ?><span id="manipulation-title">
            <?php if ($pricelistItem->technicalItemCompliance): ?>
                <?= '->' . $pricelistItem->technicalItemCompliance->title ?>
            <?php endif; ?>
        </span></h2>


<?php if ($pricelistItem->technicalItemCompliance): ?>
    <div id="compliance-data" hidden>
        <div id="compliance-btn-block">
            <?= Html::a('Сохранить', [
                '/pricelists/manage/update-compliance',
                'pricelistItemId' => $pricelistItem->id,
            ],
                [
                    'class' => 'btn btn-success',
                    'id' => 'compliance-btn',
                ]) ?>
        </div>
    </div>
<?php else: ?>
    <div id="compliance-data" hidden>
        <div id="compliance-btn-block">
    <?= Html::a('Сохранить', [
        '/pricelists/manage/save-compliance',
        'pricelistItemId' => $pricelistItem->id
    ],
        [
            'class' => 'btn btn-success',
            'id' => 'compliance-btn',
        ]) ?>
    </div>
    </div>
<?php endif; ?>


<?= PriceListsWidget::widget([
        'typePriceLists' => Pricelist::TYPE_TECHNICAL_ORDER,
        'type' => PriceListsWidget::TYPE_INVOICE,
    ]
) ?>