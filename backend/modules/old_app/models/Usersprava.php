<?php

namespace backend\modules\old_app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "usersprava". Модуль правпользователей из старой программы пользователей из старой программы
 *
 * @property int $id
 * @property string $Nazv
 * @property string $alias
 * @property int $new_user_id
 */
class Usersprava extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usersprava';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['new_user_id'], 'string'],
            [['Nazv'], 'string', 'max' => 15],
            [['alias'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'Nazv' => 'Название',
            'alias' => 'Псевдоним',
            'new_user_id' => 'Роль из rbac новой программы ID',
        ];
    }
    public static function getNewRoles() {
        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
      
    }
}
