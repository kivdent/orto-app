<?php

namespace frontend\modules\old_app\controllers;

use yii\web\Controller;
use Yii;
use backend\models\User;

/**
 * Default controller for the `old_app` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    /*@var $user User*/
    public function actionIndex($file) {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/login']);
        }
        $user= User::getUserById(Yii::$app->user->id);
        $_SESSION['UserName'] = $user->employe->surname.' '.$user->employe->name.' '.$user->employe->otch.' ';
        $_SESSION['UserID'] = $user->id;
       // $_SESSION['valid_user'] = $row['Nazv'];
      //  $_SESSION['user_prava'] = $row['UsarPrava'];
        return $this->render('index', [
                    'file' => $file,
        ]);
    }

}
