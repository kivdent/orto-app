<?php

namespace backend\modules\old_app\controllers;

use yii\web\Controller;

/**
 * Default controller for the `old_app` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
