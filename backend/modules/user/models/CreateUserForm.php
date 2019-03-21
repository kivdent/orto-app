<?php

namespace backend\modules\user\models;

use yii\base\Model;
use backend\models\User;
use Yii;

/**
 * Signup form
 */
class CreateUserForm extends Model {

    public $username;
    public $email;
    public $password;
    public $employe_id;
    public $roles;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\backend\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'safe'],
            ['email', 'trim'],
            [['employe_id'], 'integer'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['roles','safe']
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
        $user->employe_id=$this->employe_id;
       
        if( $user->save()){
            $role=Yii::$app->authManager->getRole($this->roles);
            Yii::$app->authManager->assign($role, $user->id);
            return true;
        }else{
            return false;
        }
        
    }

}
