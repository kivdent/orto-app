<?php

namespace common\modules\clinic\controllers;
use Yii;
use common\modules\clinic\models\CreateForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
class ManageController extends \yii\web\Controller
{
      public function behaviors() {
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
                        'actions' => [],
                        'roles' => ['admin','director'],
                    ],
                  
                ],
            ],
        ];
    }
    public function actionCreate()
    {
        
       $model = new CreateForm();

    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            // form inputs are valid, do something here
            return;
        }
    }

    return $this->render('create', [
        'model' => $model,
    ]);
    }

    public function actionIndex()
    {
        $clinic=Yii::$app->controller->module->getEntitie('clinic');
        
        return $this->render('index',[
            'clinic'=>$clinic
        ]);
    }

    public function actionUpdate()
    {
        return $this->render('update');
    }

    public function actionView()
    {
        return $this->render('view');
    }

}
