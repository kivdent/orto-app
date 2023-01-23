<?php

namespace common\modules\schedule\controllers;

use common\modules\employee\models\Employee;
use common\modules\schedule\models\CallList;
use common\modules\schedule\models\CallListTaskSearch;
use common\modules\userInterface\models\UserInterface;
use Yii;
use common\modules\schedule\models\CallListTasks;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * CallListTasksController implements the CRUD actions for CallListTasks model.
 */
class CallListTasksController extends Controller
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
     * Lists all CallListTasks models.
     * @return mixed
     */
    public function actionIndex($callListId)
    {
//        $dataProvider = new ActiveDataProvider([
//            'query' => CallListTasks::find()->where(['call_list_id' => $callListId]),
//        ]);
        $searchModel = new CallListTaskSearch();
        $authors = '';
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $callListId);
        $callList = CallList::findOne($callListId);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'callList' => $callList,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * Displays a single CallListTasks model.
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
     * Creates a new CallListTasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($callListId)
    {
        $model = new CallListTasks();

        $model->call_list_id = $callListId;

        $model->result = CallListTasks::TASK_DIDNT_CALL;

        $model->employee_id = UserInterface::getEmployeeId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'callListId' => $callListId]);
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CallListTasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'callListId' => $model->call_list_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CallListTasks model.
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
     * Finds the CallListTasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CallListTasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CallListTasks::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    function actionGetNoticeResult()
    {
        $response = ['html' => ''];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $callListTask = CallListTasks::findOne(Yii::$app->request->post('call-list-task_id'));

            $response = ['html' => $this->getNoticeResultHTML($callListTask)];
        }
        return $response;
    }

    function actionSetNoticeResult()
    {
        $response = ['html' => ''];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $callListTasks = CallListTasks::findOne(Yii::$app->request->post('call-list-task_id'));
            $noticeResult = Yii::$app->request->post('notice_result');
            $callListTasks->result = $noticeResult;
            $callListTasks->save(false);
            $response = ['html' => $this->getNoticeResultHTML($callListTasks)];
        }
        return $response;
    }

    protected function getNoticeResultHTML(CallListTasks $callListTasks)
    {
        $html = Html::dropDownList('notice-result', $callListTasks->result, CallListTasks::GetResultList(),
            [
                'class' => 'form-control-sm notice-result-select'
            ]);
        return $html;
    }

    public function actionGetDoctorIdSelect()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $doctor_id = Yii::$app->request->post('doctor_id') !== null && Yii::$app->request->post('doctor_id') !== '' ? Yii::$app->request->post('doctor_id') : UserInterface::getEmployeeId();
            $html = Html::dropDownList('doctor_id', $doctor_id, Employee::getWorkedDoctorsList(), [
                'class' => 'form-control',
                'id' => 'doctor_id',
            ]);
            return $html;
        }
    }

    public function actionGetCallListIdSelect()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            if (UserInterface::isUserRole(UserInterface::ROLE_ADMIN) || UserInterface::isUserRole(UserInterface::ROLE_RECORDER) || UserInterface::isUserRole(UserInterface::ROLE_SENIOR_RECORDER)) {
                $employees = 'all';
            } else {
                $employees = UserInterface::getEmployeeId();
            }
            $call_list_id = Yii::$app->request->post('call_list_id') !== null && Yii::$app->request->post('call_list_id') !== '' ? Yii::$app->request->post('call_list_id') : '';
            $html = Html::dropDownList('call_list_id', $call_list_id, CallList::getActiveUserList($employees), [
                'class' => 'form-control',
                'id' => 'call_list_id',
            ]);

            return $html;
        }
    }

    public function actionCreateTask()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $model = new CallListTasks();

            $model->call_list_id = Yii::$app->request->post('call_list_id');
            $model->doctor_id = Yii::$app->request->post('doctor_id');
            $model->patient_id = Yii::$app->request->post('patient_id');
            $model->appointment_content = Yii::$app->request->post('appointment_content');
            $model->note = Yii::$app->request->post('note');

            $model->result = CallListTasks::TASK_DIDNT_CALL;
            $model->employee_id = UserInterface::getEmployeeId();


            $model->save('false');

            return 'success';
        }
        return 'error';
    }

    public function actionChangeStatus($id,$callListId)
    {
        $callListTask = $this->findModel($id);

        $callListTask->status = $callListTask->status == CallListTasks::TASK_STATUS_ACTIVE ? CallListTasks::TASK_STATUS_INACTIVE : CallListTasks::TASK_STATUS_ACTIVE;
        $callListTask->save(false);

        return $this->redirect(['index','callListId'=>$callListId]);
    }
}