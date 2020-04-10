<?php

namespace common\modules\clinic\models;

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
 */
class FinancialDivisions extends \yii\db\ActiveRecord {

    public $requisites;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'financial_divisions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['clinic_id', 'name'], 'required'],
            [['clinic_id',], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'clinic_id' => 'Клиника',
            'name' => 'Название',
            'requisites' => 'Реквизиты',
        ];
    }

    public function beforeSave($insert) {

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

    public function beforeDelete() {
        if (!parent::beforeDelete()) {
            return false;
        }

        $result= $this->requisites->delete();
        return $result;
    }

    public function afterFind() {
        $this->requisites = Requisites::findOne($this->requisites_id);
    }

    public function getRequisites() {
        return $this->hasOne(Requisites::className(), ['id' => 'requisites_id']);
    }

    public static function getDivisionList(){
        return ArrayHelper::map(Old::find()->asArray()->orderBy('id')->all(),'id','nazv');
    }

}
