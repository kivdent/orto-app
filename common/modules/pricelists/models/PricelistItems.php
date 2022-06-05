<?php


namespace common\modules\pricelists\models;

use common\modules\invoice\models\Invoice;
use common\modules\pricelists\models\Prices;
use common\modules\userInterface\models\UserInterface;

/**
 * @property int $price
 * @property Prices $priceForItem
 */
class PricelistItems extends \common\models\PricelistItems
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function getStatus()
    {
        return $this->active;
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Активный',
            self::STATUS_INACTIVE => 'Неактивный',
        ];
    }

    public function getStatusName()
    {
        return $this->statusList[$this->active];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'pricelist_id' => 'Прейскурант',
            'category' => 'Является категорией',
            'superior_category_id' => 'Категория',
            'active' => 'Статус',
        ];
    }

    public function getItemsFromCategory()
    {

        return self::find()->where(['superior_category_id' => $this->id])->all();
    }

    public function getActiveItemsFromCategory()
    {

        return self::find()->where(['superior_category_id' => $this->id, 'active' => 1])->all();
    }

    public function getAllPrices()
    {
        return $this->hasMany(Prices::className(), ['pricelist_items_id' => 'id']);
    }

    public function getPriceForItem()
    {
        return Prices::find()->where(['pricelist_items_id' => $this->id, 'active' => 1]);
    }

    public function getPrice()
    {
        return $this->priceForItem ? $this->priceForItem->price : 'Не указана';
    }

    public function getCoefficient()
    {
        return $this->priceForItem ? $this->priceForItem->coefficient : 'Не указан';
    }

    public function getPriceId()
    {
        return $this->priceForItem ? $this->priceForItem->id : 'Не указан';
    }

    public function getLastUse()
    {
        $lastUse = '';
//        $lastUse = self::find()
//            ->select('invoice.created_at')
//            ->leftJoin('prices', 'prices.pricelist_items_id=pricelist_items.id')
//            ->leftJoin('invoice_items', 'invoice_items.prices_id=prices.id')
//            ->leftJoin('invoice', 'invoice.id=invoice_items.invoice_id')
//            ->where(['pricelist_items.id'=>$this->id])
//            ->orderBy('invoice.created_at')
//            ->asArray()
//            ->one();
        $lastUse = Invoice::find()
            ->select('invoice.created_at')
            ->leftJoin('invoice_items', 'invoice.id=invoice_items.invoice_id')
            ->leftJoin('prices', 'invoice_items.prices_id=prices.id')
            ->leftJoin('pricelist_items', 'prices.pricelist_items_id=pricelist_items.id')
            ->where(['pricelist_items.id' => $this->id])
            ->orderBy('invoice.created_at DESC')
            ->asArray()
            ->one();
        $lastUse = UserInterface::getFormatedDate($lastUse['created_at']);
        //UserInterface::getVar($lastUse);
        return $lastUse;
    }

}