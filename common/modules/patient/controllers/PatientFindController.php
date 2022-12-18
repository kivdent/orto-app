<?php

namespace common\modules\patient\controllers;

use common\modules\patient\models\Patient;
use Yii;
use yii\web\Response;

class PatientFindController extends \yii\web\Controller
{
    public function actionGetPatientBySurname()
    {
        $response = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $findString = Yii::$app->request->post('find_string');
        }
        $patients = Patient::find()
            ->where(['like', 'surname', $findString . '%', false])
            ->all();
        foreach ($patients as $patient) {
            $response[$patient->id]['patient_id'] = $patient->id;
            $response[$patient->id]['patient_name'] = $patient->fullName;
            $response[$patient->id]['date_of_birth'] = $patient->dr;
        }
        return $response;
    }

    public function actionSavePatient()
    {
        $response = [];
        Yii::$app->response->format = Response::FORMAT_JSON;
        $patient = new Patient();
        if (Yii::$app->request->isAjax) {
            $patient->surname = strtoupper(Yii::$app->request->post('surname'));
            $patient->name = strtoupper(Yii::$app->request->post('name'));
            $patient->otch = strtoupper(Yii::$app->request->post('patronymic'));
            $patient->MTel = Yii::$app->request->post('phone');
            $patient->dr = '1900-01-01';
        }

        $transaction = Patient::getDb()->beginTransaction();
        try {
            $patient->save(false);
            $response = [
                'patient_id' => $patient->id,
                'patient_name' => $patient->fullName,
            ];
        } catch (\Throwable $e) {
            $transaction->rollBack();
            $response = "error";
            throw $e;
        }
        return $response;
    }
}