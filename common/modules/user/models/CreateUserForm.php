<?php

namespace common\modules\user\models;

use yii\base\Model;
use common\models\User;
use Yii;

/**
 * Signup form
 */
class CreateUserForm extends Model {

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    public $username;
    public $email;
    public $password;
    public $employe_id;
    public $roles;
    public $id;

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        return[
            self::SCENARIO_CREATE => ['username','password','email','employe_id','roles'],
            self::SCENARIO_UPDATE => ['id','username','password','email','employe_id','roles'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Это имя пользователя уже используется.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'safe'],
            ['email', 'trim'],
            [['employe_id'], 'integer'],
            ['password', 'required','on'=>self::SCENARIO_CREATE],
            ['password', 'string', 'min' => 6],
            ['roles', 'safe'],
            ['id', 'safe'],
        ];
    }

  
    /**
     * Save new user 
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save() {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->employe_id = $this->employe_id;

        if ($user->save()) {
            $role = Yii::$app->authManager->getRole($this->roles);
            Yii::$app->authManager->assign($role, $user->id);
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        $user = User::getUserById($this->id);
        $user->password_hash = $this->password ? $user->setPassword($this->password) : $user->password_hash;
        if ($user->save(true, ['username', 'email', 'password_hash', 'employe_id'])) {
            Yii::$app->authManager->revokeAll($user->id);
            $role = Yii::$app->authManager->getRole($this->roles);
            Yii::$app->authManager->assign($role, $user->id);
            return true;
        }
        return false;
    }

}
