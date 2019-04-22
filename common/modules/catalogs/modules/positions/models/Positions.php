<?php

namespace common\modules\catalogs\modules\positions\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "dolzh".
 *
 * @property int $id
 * @property string $dolzh
 */
class Positions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dolzh';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dolzh'], 'string', 'max' => 60],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dolzh' => 'Название',
        ];
    }
    public function getName() {
        return $this->dolzh;
    }
    public static function getList(){
        $list=ArrayHelper::map(self::find()->asArray()->all(), 'id','dolzh');
        return $list;
    }
}
