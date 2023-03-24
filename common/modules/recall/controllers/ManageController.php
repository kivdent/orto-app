<?php

namespace common\modules\recall\controllers;

use common\modules\patient\models\PatientSearch;
use common\modules\recall\models\BirthdaysTable;
use Yii;

class ManageController extends \yii\web\Controller
{
    public function actionBirthday()
    {
        $birthdaysTable=new BirthdaysTable();
        return $this->render('birthday',[
            'birthdaysTable'=>$birthdaysTable,
        ]);
    }

    public function actionDoctor()
    {
        return $this->render('doctor');
    }

    public function actionRecorder()
    {
        $searchModel = new PatientSearch(['type'=>PatientSearch::TYPE_RECALL_RECORDER]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('recorder', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

}