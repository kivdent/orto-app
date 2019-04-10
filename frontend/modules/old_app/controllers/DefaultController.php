<?php

namespace frontend\modules\old_app\controllers;

use yii\web\Controller;
use Yii;
use common\modules\userInterface\models\UserInterface;

/**
 * Default controller for the `old_app` module
 */
class DefaultController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
    /* @var $userInterface UserInterface */
    public function actionIndex($path) {
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/login']);
        }

        $userInterface = Yii::$app->userInterface;
        $_SESSION['UserName'] = $userInterface->user_full_name;
        $_SESSION['UserID'] = $userInterface->employe_id;
        // $_SESSION['valid_user'] = $row['Nazv'];
        $_SESSION['user_prava'] = $this->getOldUserPrava();
        
     
        $this->view->params['userMenuItems'] = $userInterface->getMenuItems();
        return $this->render('index', [
                    'path' => $path,
                    'userInterface' => $userInterface,
        ]);
    }

/**
 * 
 * @return string;
 */

    public function getOldUserPrava() {
        /*@var $module  frontend\modules\old_app\Module*/
      
        $module = Yii::$app->getModule('old_app');
        $roleName = UserInterface::getRoleName(Yii::$app->user->id);
        
        return   $module->userprava[$roleName];
    }

}
