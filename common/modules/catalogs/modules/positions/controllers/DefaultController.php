<?php

namespace common\modules\catalogs\modules\positions\controllers;

use yii\web\Controller;

/**
 * Default controller for the `positions` module
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
