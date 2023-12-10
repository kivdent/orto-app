<?php

namespace common\modules\invoice\controllers;

use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\invoice\models\SchemeOrthodontics;
use common\modules\invoice\models\SchemeOrthodonticsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SchemeOrthodonticsController implements the CRUD actions for SchemeOrthodontics model.
 */
class SchemeOrthodonticsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all SchemeOrthodontics models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchType = SchemeOrthodonticsSearch::SEARCH_TYPE_DOCTOR;
        if (UserInterface::getRoleNameCurrentUser() == UserInterface::ROLE_ADMIN) {
            $searchType = SchemeOrthodonticsSearch::SEARCH_TYPE_ALL;
        }
        $searchModel = new SchemeOrthodonticsSearch(['searchType' => $searchType]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SchemeOrthodontics model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SchemeOrthodontics model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($patient_id = null, $doctor_id = null)
    {
        $model = new SchemeOrthodontics();
        $model->pat = $patient_id;
        $model->sotr = $doctor_id;
        $model->date = date('Y-m-d');
        $model->last_pay_month = 0;
        $model->full = 0;
        $model->vnes = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/invoice/scheme-orthodontics/']);
        }
        $form = UserInterface::getRoleNameCurrentUser() == UserInterface::ROLE_ADMIN ? '_form-admin' : '_form';
        return $this->render('create', [
            'model' => $model,
            'form'=>$form,
        ]);
    }

    /**
     * Updates an existing SchemeOrthodontics model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/invoice/scheme-orthodontics/']);
        }
        $form = UserInterface::getRoleNameCurrentUser() == UserInterface::ROLE_ADMIN ? '_form-admin' : '_form';
        return $this->render('update', [
            'model' => $model,
            'form'=>$form,
        ]);
    }

    /**
     * Deletes an existing SchemeOrthodontics model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SchemeOrthodontics model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SchemeOrthodontics the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SchemeOrthodontics::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
