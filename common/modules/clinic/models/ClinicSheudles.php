<?php

namespace common\modules\clinic\models;

use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "clinic_sheudles".
 *
 * @property int $id
 * @property string $name
 * @property int $clinic_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $start_date
 * @property int $status
 * @property string $start_time
 * @property string $end_time
 */
class ClinicSheudles extends \yii\db\ActiveRecord
{

    const STATUS_ACTIVE = '1';
    const STATUS_INACTIVE = '0';

    const START_TIME = '08:00:00';
    const END_TIME = '20:00:00';
    const DURATION = '15';

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        $this->start_date = Yii::$app->formatter->asDate($this->start_date, 'php:Y-m-d');

        return true;
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clinic_sheudles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'clinic_id', 'start_date', 'status'], 'required'],
            [['clinic_id', 'status'], 'integer'],
            [['start_date'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'clinic_id' => 'Клиника',
            'created_at' => 'Создано',
            'updated_at' => 'Изменено',
            'start_date' => 'Вступает в силу',
            'status' => 'Статус',
        ];
    }

    public function getStatusLists()
    {
        return [
            self::STATUS_ACTIVE => 'Активно',
            self::STATUS_INACTIVE => 'Неактивно'
        ];
    }

    public static function getStart_time()
    {
        return self::START_TIME;
    }

    public static function getEnd_time()
    {
        return self::END_TIME;
    }
    public static function getDuration()
    {
        return self::DURATION;
    }
}
