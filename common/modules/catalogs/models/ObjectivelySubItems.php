<?php


namespace common\modules\catalogs\models;


class ObjectivelySubItems extends \common\models\ObjectivelySubItems
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['value'],'trim'],
            [['objectively_Items_id'], 'integer'],
            [['objectively_Items_id'], 'safe'],
            [['value'], 'string', 'max' => 255],
        ];
    }
}