<?php


namespace common\modules\pricelists\models;

use common\modules\pricelists\models\Prices;


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

        return self::find()->where(['superior_category_id' => $this->id,'active'=>1])->all();
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
    public function getCoefficient(){
        return $this->priceForItem ? $this->priceForItem->coefficient : 'Не указан';
    }
    public function getPriceId(){
        return $this->priceForItem ? $this->priceForItem->id : 'Не указан';
    }
}