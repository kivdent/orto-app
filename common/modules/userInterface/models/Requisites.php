<?php

namespace common\modules\userInterface\models;

use Yii;

/**
 * This is the model class for table "requisites".
 *
 * @property int $id
 * @property string $full_name
 * @property int $OGRN
 * @property int $INN
 * @property int $KPP
 * @property int $legal_address
 * @property int $OKPO
 * @property int $OKVED
 * @property int $checking_account
 * @property int $correspondent_bank_account
 * @property int $BIC
 */
class Requisites extends \common\abstractClasses\ActiveRecordEntity
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'requisites';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name'], 'string'],
            [['OGRN', 'INN'], 'required'],
            [['OGRN', 'INN', 'KPP', 'legal_address', 'OKPO', 'OKVED', 'checking_account', 'correspondent_bank_account', 'BIC'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'Полное название',
            'OGRN' => 'ОГРН',
            'INN' => 'ИНН',
            'KPP' => 'КПП',
            'legal_address' => 'Юридический адрес',
            'OKPO' => 'OKPO',
            'OKVED' => 'ОКВЭД',
            'checking_account' => 'Расчётный счёт',
            'correspondent_bank_account' => 'Кор счёт',
            'BIC' => 'БИК',
        ];
    }


}
