<?php

namespace common\modules\schedule\controllers;

use common\modules\schedule\models\CallListSearch;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\schedule\models\CallList;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CallListController implements the CRUD actions for CallList model.
 */
class CallListController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [],
                        'roles' => ['recorder', 'admin', 'senior_recorder', 'director','therapist','surgeon','orthodontist','orthopedist'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CallList models.
     * @return mixed
     */
    public function actionIndex()
    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => CallList::find()->orderBy('status'),
//        ]);

        $searchModel = new CallListSearch();
        if (UserInterface::isUserRole(UserInterface::ROLE_ADMIN) || UserInterface::isUserRole(UserInterface::ROLE_RECORDER) || UserInterface::isUserRole(UserInterface::ROLE_SENIOR_RECORDER)) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        } else {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, UserInterface::getEmployeeId());
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single CallList model.
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
     * Creates a new CallList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CallList();
        $model->status = CallList::STATUS_ACTIVE;
        $model->type = CallList::TYPE_USERS;
        $model->employee_id = UserInterface::getEmployeeId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CallList model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CallList model.
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

    public function actionChangeStatus($id)
    {
        $callList = $this->findModel($id);
        $callList->status = $callList->status == CallList::STATUS_ACTIVE ? CallList::STATUS_INACTIVE : CallList::STATUS_ACTIVE;
        $callList->save(false);

        return $this->redirect(['index']);
    }

    /**
     * Finds the CallList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CallList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CallList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}