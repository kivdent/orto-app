<?php


namespace common\modules\catalogs\models;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "oper_vid".
 *
 * @property int $id
 * @property string $naim
 * @property int $znak
 */
class AccountCashType extends \common\models\AccountCashType
{
    const TYPE_CASHBOX_END=1;

    public static function getListArray()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'naim');
    }
}