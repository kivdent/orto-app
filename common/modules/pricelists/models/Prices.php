<?php


namespace common\modules\pricelists\models;

class Prices extends \common\models\Prices
{
    public function isChanged()
    {
        $oldPrices = self::findOne($this->id);
        return !(($this->price == $oldPrices->price) and ($this->coefficient == $oldPrices->coefficient));
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPricelistItems()
    {
        return $this->hasOne(PricelistItems::className(), ['id' => 'pricelist_items_id']);
    }
}