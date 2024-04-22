<?php

namespace common\modules\notifier\controllers;

use common\modules\notifier\models\Sms;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Default controller for the `notifier` module
 */
class ManageController extends Controller
{

    /**
     * Renders the index view for the module
     * @return string
     */


    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Sms::find()->orderBy('created_at DESC'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,]);

    }

}