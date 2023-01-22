<?php

namespace common\modules\schedule\models;

use common\modules\employee\models\Employee;
use common\modules\userInterface\models\UserInterface;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "call_list".
 *
 * @property Employee $employee

 *
 * @property CallListTasks[] $callListTasks
 */
class CallList extends \common\models\CallList
{
    const TYPE_STANDARD='type_standard';
    const TYPE_USERS='type_users';
    const STATUS_ACTIVE='status_active';
    const STATUS_INACTIVE='status_inactive';

    public static function getActiveUserList($employees='all')
    {
        if ($employees=='all'){
            $callList=self::find()->where(['type'=>self::TYPE_USERS,'status'=>self::STATUS_ACTIVE,])->all();

        }else{
            $callList=self::find()->where(['type'=>self::TYPE_USERS,'status'=>self::STATUS_ACTIVE,'employee_id'=>$employees])->all();
        }
        $list=ArrayHelper::map($callList,'id','title');
        return $list;
    }


    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'employee_id',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'employee_id',
                ],
                'value' => function ($event) {
                    return UserInterface::getEmployeeId();
                },
            ],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'Description' => 'Описание',
            'created_at' => 'Создан',
            'updated_at' => 'Изменен',
            'employee_id' => 'Автор',
            'type' => 'Тип',
            'status' => 'Статус',
        ];
    }
    public static function getTypeList(){

        return[self::TYPE_STANDARD=>'Стандартный',
            self::TYPE_USERS=>'Пользовательский',

            ];
    }
    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE=>'Активен',
            self::STATUS_INACTIVE=>'Не активен',
        ];
    }
    public function getEmployee(){
        return $this->hasOne(Employee::class,['id'=>'employee_id']);
    }
}