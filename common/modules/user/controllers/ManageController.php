<?php

namespace common\modules\user\controllers;

use common\modules\employee\models\Employee;
use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\modules\user\models\CreateUserForm;
use yii\helpers\ArrayHelper;

use yii\filters\AccessControl;

/**
 * ManageController implements the CRUD actions for User model.
 */
class ManageController extends Controller
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
                        'roles' => ['admin'],
                    ],

                ],
            ],
        ];
    }

    /**
     * Updates password for User with $user->id=$id
     * @return mixed
     */
    public function actionChangePassword($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save(true, ['password_hash'])) {
            Yii::$app->session->setFlash('success', 'Пароль изменён');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            Yii::$app->session->setFlash('danger', 'Ошибка сервера');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateUserForm();
        $model->scenario = CreateUserForm::SCENARIO_CREATE;
        $roles = self::getRoles();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Пользователь создан');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $user = $this->findModel($id);
        $model = new CreateUserForm();
        $model->scenario = CreateUserForm::SCENARIO_UPDATE;

        $model->attributes = $user->attributes;
        $model->roles = ArrayHelper::getColumn($user->getRoles(), 'name');
        $roles = self::getRoles();
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'roles' => $roles,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     *  Inactivated an existing User model.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionInactivate($id)
    {
        $this->findModel($id)->inactivate();

        return $this->redirect(['index']);
    }

    /**
     *  Inactivated an existing User model.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActivate($id)
    {
        $this->findModel($id)->activate();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public static function getRoles()
    {

        return ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function actionWazzupUsers()
    {
        $employes = array_column(Employee::find()
            ->where(['status' => Employee::STATUS_WORKED])
            ->andWhere(['dolzh' => Employee::POSITION_REGISTRATOR])
            ->asArray()
            ->all(),'id');

        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['IN','employe_id',$employes])
        ]);

        return $this->render('wazzup-users', [
            'dataProvider' => $dataProvider,
        ]);

    }
}
