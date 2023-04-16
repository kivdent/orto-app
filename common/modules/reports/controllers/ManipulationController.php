<?php

namespace common\modules\reports\controllers;

use common\modules\patient\models\Patient;
use common\modules\pricelists\models\PricelistItems;
use common\modules\user\models\User;
use common\modules\userInterface\models\UserInterface;
use Yii;
use yii\helpers\ArrayHelper;

class ManipulationController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionRequest()
    {
        $ids = Yii::$app->request->get('ids');

        $pricelistItems = PricelistItems::find()
            ->leftJoin('prices', 'prices.pricelist_items_id=pricelist_items.id')
            ->where(['prices.id' => $ids])
            ->all();

        $patients = PricelistItems::getPatientsWith(ArrayHelper::getColumn($pricelistItems, 'id'));

        return $this->render('request', [
            'patients' => $patients,
            'pricelistItems' => $pricelistItems,
        ]);
    }
}