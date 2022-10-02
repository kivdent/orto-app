<?php

namespace common\modules\statistics\controllers;

class ExpensesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
