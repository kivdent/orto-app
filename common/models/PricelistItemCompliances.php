<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pricelist_item_compliances".
 *
 * @property int $id
 * @property int $pricelist_item_id
 * @property int $compliance_item_id
 */
class PricelistItemCompliances extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pricelist_item_compliances';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pricelist_item_id', 'compliance_item_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pricelist_item_id' => 'Pricelist Item ID',
            'compliance_item_id' => 'Compliance Item ID',
        ];
    }
}
