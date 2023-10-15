<?php


namespace common\modules\patient\models;

use common\modules\pricelists\models\Pricelist;
use common\modules\pricelists\models\PricelistItems;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 *
 * @property-read OperationPricelistItemsCompliance[] $operationCompliance
 * @property-read int $actualPrice
 * @property-read PricelistItems[] $pricelistItems
 */
class Operation extends \common\models\Operation
{
    const FROM_COMMENT = 1;

    public static function getList()
    {
        $list = self::find()->asArray()->all();
        $list = ArrayHelper::map($list, 'id', 'title');
        return $list;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'price_from' => 'Цена от',
            'price_to' => 'Цена до',
            'duration_from' => 'Длительность от',
            'duration_to' => 'Длительность до',
        ];
    }

    public function getPricelistItems()
    {
        return $this->hasMany(PricelistItems::class, ['id' => 'pricelist_item_id'])
            ->via('operationCompliance');
    }

    public function getOperationCompliance()
    {
        return $this->hasMany(OperationPricelistItemsCompliance::class, ['operation_id' => 'id']);
    }

    public function getActualPrice()
    {
        $price = null;

        if ($this->pricelistItems !== null) {
            $price = array_sum(ArrayHelper::map($this->pricelistItems,'id','price'));
        }
        return $price;
    }

}