<?php

namespace frontend\modules\old_app\controllers;

use yii\web\Controller;
use Yii;

use frontend\modules\userInterface\models\UserInterface;

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
        
        $userInterface = new UserInterface(Yii::$app->user->id);
        $_SESSION['UserName'] = $userInterface->user_full_name;
        $_SESSION['UserID'] = $userInterface->employe_id;
        // $_SESSION['valid_user'] = $row['Nazv'];
        $_SESSION['user_prava'] = $userInterface->old_user_prava;
        //var_dump($userInterface->getMenuItems());
        $this->view->params['userMenuItems']=$userInterface->getMenuItems();
        return $this->render('index', [
                    'path' => $path,
                    'userInterface' => $userInterface,
        ]);
    }

}
