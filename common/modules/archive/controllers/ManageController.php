<?php

namespace common\modules\archive\controllers;

use common\modules\archive\models\ArchivalPatientRecords;
use common\modules\archive\models\Archive;
use common\modules\archive\models\ArchiveBoxes;
use common\modules\archive\models\ArchivePatientSearch;
use common\modules\patient\models\Patient;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class ManageController extends \yii\web\Controller
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
                        'actions' => ['index', 'change-status', 'create-archive-box', 'send-to-archive', 'duplicate-delete', 'unite'],
                        'roles' => ['admin', 'recorder', 'senior_nurse',],
                    ],
                ],
            ],
        ];
    }

    public function actionChangeStatus()
    {
        return $this->render('change-status');
    }

    public function actionCreateArchiveBox()
    {
        $archiveBox = new ArchiveBoxes();
        $archiveBox->save();
        Yii::$app->session->setFlash('success', 'Архивный короб №' . $archiveBox->id . ' создан');
        return $this->redirect('index');
    }

    public function actionIndex($type = ArchivePatientSearch::TYPE_OLD)
    {
        {
            $searchModel = new ArchivePatientSearch([
                'type' => $type,
            ]);
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    public function actionSendToArchive($patient_id)
    {
        $patient=Patient::findOne($patient_id);
        $archivalPatientRecord=new ArchivalPatientRecords([
            'patient_id' => $patient->id,
            'archive_boxes_id' => ArchiveBoxes::getCurrentBox(),
        ]);
        $patient->status=Patient::STATUS_ARCHIVE_IN_ARCHIVE;
        if ($archivalPatientRecord->load(Yii::$app->request->post())&& $archivalPatientRecord->save()) {
            $patient->save(false);
            Yii::$app->session->setFlash('success','Карта архивирована');
            $this->redirect('index');
        }

        return $this->render('send-to-archive',[
            'patient'=>$patient,
            'archivalPatientRecord'=>$archivalPatientRecord,
        ]);
    }

    public function actionDuplicateDelete($patient_id)
    {
        $remainablePatient = Patient::findOne($patient_id);
        $removablePatient = $remainablePatient->getDuplicate();
        return $this->render('duplicate-delete',
            [
                'remainablePatient' => $remainablePatient,
                'removablePatient' => $removablePatient,
            ]);
    }

    public function actionUnite($patient_id)
    {
        $remainablePatient = Patient::findOne($patient_id);
        $removablePatient = $remainablePatient->getDuplicate();
        if (Archive::removeDuplicate($remainablePatient, $removablePatient)) {
            return $this->redirect('/patient/manage/update?patient_id='.$remainablePatient->id);
        } else {
            return $this->render('duplicate-delete',
                [
                    'remainablePatient' => $remainablePatient,
                    'removablePatient' => $removablePatient,
                ]);
        }
    }
}
