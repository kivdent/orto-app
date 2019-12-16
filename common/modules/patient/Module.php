<?php

namespace common\modules\patient;

use common\abstractClasses\WorkModule;
use Yii;
/**
 * patient module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\patient\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Пациенты";

    /**
     * Устанавливает параметры для работы userInterface
     * @param type $action
     * @return type
     */
    public function beforeAction($action) {
        if (Yii::$app->request->get('patient_id')!==null){
            Yii::$app->userInterface->params['patient_id']=Yii::$app->request->get('patient_id');

        }
        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
        ;
    }

}
