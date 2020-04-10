<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_for_scheme_orthodontics".
 *
 * @property int $invoice_id
 * @property int $scheme_orthodontics_id
 */
class InvoiceForSchemeOrthodontics extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_for_scheme_orthodontics';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'scheme_orthodontics_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'invoice_id' => 'Invoice ID',
            'scheme_orthodontics_id' => 'Scheme Orthodontics ID',
        ];
    }
}
