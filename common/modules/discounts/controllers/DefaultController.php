<?php

namespace common\modules\discounts\controllers;

use yii\web\Controller;

/**
 * Default controller for the `discounts` module
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
