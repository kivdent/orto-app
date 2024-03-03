<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\PatientSearch;
use Yii;

class BirthdayController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $searchModel = new PatientSearch(['type'=>PatientSearch::TYPE_BIRTHDAY]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}