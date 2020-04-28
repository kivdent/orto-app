<?php


namespace common\modules\pricelists\models;


use yii\helpers\ArrayHelper;

class Pricelist extends \common\models\Pricelist
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    const TYPE_MANIPULATIONS='manipulations';
    const TYPE_MATERIALS='materials';
    const TYPE_GIFT_CARDS='gift_cards';



    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'active' => 'Активен',
            'type' => 'Тип',
        ];
    }

    public function getStatus()
    {
        return $this->active;
    }

    public static function getStatusList(){
        return [
            self::STATUS_ACTIVE=>'Активный',
            self::STATUS_INACTIVE=>'Неактивный',
        ];
    }

    public static function getTypeList(){
        return [
            self::TYPE_MANIPULATIONS=>'Манипуляции',
            self::TYPE_MATERIALS=>'Материалы',
            self::TYPE_GIFT_CARDS=>'Подарочные сертификаты',
        ];
    }

    public function getStatusName(){
        return $this->statusList[$this->active];
    }

    public static function getList(){
        $list=self::find()->all();
        return $list;
    }
    public static function getActiveList($type){
        $list=self::find()->where(['active'=>1]);
        if (array_key_exists($type,self::getTypeList())){
            $list=$list->andWhere(['type'=>$type]);
        }
       $list=$list->all();
        return $list;
    }

    public function getCategoryes()
    {
        return PricelistItems::find()->where(['pricelist_id' => $this->id, 'category' => 1])->all();
    }
    public function getActiveCategoryes()
    {
        return PricelistItems::find()->where(['pricelist_id' => $this->id, 'category' => 1,'active'=>1])->all();
    }
    public static function getListArray(){
        return ArrayHelper::map(self::getList(),'id','title');
    }
}