<?php

namespace common\modules\catalogs\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AnamnesisController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin',],
                    ],

                ],
            ],
        ];
    }
    public function actionIndex()
    {
        return $this->render('index');
    }

}
