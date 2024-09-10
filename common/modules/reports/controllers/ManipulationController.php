<?php

namespace common\modules\reports\controllers;

use common\modules\patient\models\Patient;
use common\modules\reports\models\FinancialPeriods;
use common\modules\reports\models\PatientSearch;
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

    private function getFinancialPeriod()
    {
        if (Yii::$app->request->get('financialPeriodId') and FinancialPeriods::findOne(Yii::$app->request->get('financialPeriodId')) != null) {
            $financialPeriod = FinancialPeriods::findOne(Yii::$app->request->get('financialPeriodId'));
        } else {
            $financialPeriod = FinancialPeriods::getPeriodForCurrentDate();
        }
        return $financialPeriod;
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

    public function actionTreatmentPlans()
    {
        $financialPeriod = $this->getFinancialPeriod();
        $patients = Patient::find()->select('`klinikpat`.*,')
            ->leftJoin('invoice', 'invoice.patient_id = `klinikpat`.`id`')
            ->where('invoice.created_at>="' . $financialPeriod->nach . '"')
            ->andWhere('invoice.created_at<="' . $financialPeriod->okonch . '"')
            ->all();
        $patientWOTreatmentPlans = 0;
        $patientsCount = count($patients);
        foreach ($patients as $patient) {
            if (!$patient->treatmentPlansCount > 0) {
                $patientWOTreatmentPlans++;
            }
        }
        $searchModel = new PatientSearch([
            'type' => PatientSearch::TYPE_TREATMENT_PLAN,
            'financialPeriod' => $financialPeriod,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('treatment-plans', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'patientWOTreatmentPlans' => $patientWOTreatmentPlans,
            'patientsCount' => $patientsCount,
        ]);
    }
}