<?php

namespace common\modules\clinic\models;

use common\modules\cash\models\Cashbox;
use common\modules\cash\models\Payment;
use common\modules\catalogs\models\PaymentType;
use common\modules\userInterface\models\UserInterface;
use phpDocumentor\Reflection\Types\Self_;
use Yii;
use common\modules\userInterface\models\Requisites;
use yii\helpers\ArrayHelper;
use common\models\FinancialDivisions as Old;

/**
 * This is the model class for table "financial_divisions".
 *
 * @property int $id
 * @property int $clinic_id
 * @property string $name
 * @property int $requisites_id
 * @property Requisites $requisites
 */
class FinancialDivisions extends \yii\db\ActiveRecord
{

    public $requisites;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'financial_divisions';
    }

    public static function getDivisions()
    {
        return self::find()->all();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['clinic_id', 'name'], 'required'],
            [['clinic_id',], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'clinic_id' => 'Клиника',
            'name' => 'Название',
            'requisites' => 'Реквизиты',
        ];
    }

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->requisites->save()) {
            $this->requisites_id = $this->requisites->id;
            return true;
        } else {
            return false;
        }
        return true;
    }

    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $result = $this->requisites->delete();
        return $result;
    }

    public function afterFind()
    {
        $this->requisites = Requisites::findOne($this->requisites_id);
    }

    public function getRequisites()
    {
        return $this->hasOne(Requisites::className(), ['id' => 'requisites_id']);
    }

    public static function getDivisionList()
    {
        //return ArrayHelper::map(Old::find()->asArray()->orderBy('id')->all(),'id','nazv');
        return ArrayHelper::map(self::find()->asArray()->orderBy('id')->all(), 'id', 'name');
    }

    public function getCash($cashbox)
    {
        /* @var $cashbox Cashbox*/
        $sum = 0;
        $payments = Payment::find()
            ->where(['date' => $cashbox->date])
            ->andWhere(['VidOpl' => PaymentType::TYPE_CASH])
            ->andWhere(['podr' => $this->id])
            ->all();
        $sum += array_sum(ArrayHelper::getColumn($payments, 'vnes'));

        if ($this->isMain()) {
            $sum += $cashbox->getPreviousBalance();
        }

        $sum-=$cashbox->getAccountCashSummForDivision($this);

        return $sum;
    }

    public function isMain()
    {

        return Clinic::getMain()->requisites_id == $this->requisites_id;
    }
}
