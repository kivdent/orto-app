<?php

namespace common\models;

use Yii;
use backend\modules\employe\models\Employe;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at 
 * @property int $employe_id
 * 
 */
class User extends \yii\db\ActiveRecord {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $newPassword;


    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'user';
    }

    public function behaviors() {
       return [
            [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['username', 'auth_key', 'password_hash'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'safe'],
            [['newPassword'],'safe'],

            [['password_reset_token'], 'unique'],
            [['employe_id'],'integer'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'username' => 'Имя пользователя',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Пароль',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Электронная почта',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Изменён',
            'employe_id'=>'Cотрудник',
            'newPassword'=>'Новый пароль'
        ];
    }

    public function getEmploye() {
        return $this->hasOne(Employe::className(), ['id' => 'employe_id']);
    }
    public function getRoles() {
         return Yii::$app->authManager->getRolesByUser($this->id);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
     /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        return $this->password_hash;
    }
    /**
     * inactivate current user
     * @return boolean
     */
    public function inactivate() {
        $this->status=self::STATUS_DELETED;
        return $this->save(false, ['status']);
    }
    /**
     * Activate current user
     * @return boolean
     */
    public function activate() {
        $this->status=self::STATUS_ACTIVE;
        return $this->save(false, ['status']);
    }
    /**
     * Find user by id
     * @return common\models\User object
     */
    public static function getUserById($id) {
        $user=self::findOne($id);
        return $user ? $user : false;
    }
}
