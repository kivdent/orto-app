<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "preysk".
 *
 * @property int $id
 * @property string $preysk
 * @property string $modules Доступность прейскурантов в различных модулях в массив через searilize
 * @property string $roles
 */
class Pricelists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preysk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['preysk'], 'string', 'max' => 50],
            [['modules'], 'string', 'max' => 200],
            [['roles'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'preysk' => 'Preysk',
            'modules' => 'Modules',
            'roles' => 'Roles',
        ];
    }
}
