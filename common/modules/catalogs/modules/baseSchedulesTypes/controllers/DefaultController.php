<?php

namespace common\modules\catalogs\modules\baseSchedulesTypes\controllers;

use yii\web\Controller;

/**
 * Default controller for the `baseSchedulesTypes` module
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
