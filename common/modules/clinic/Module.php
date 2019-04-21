<?php

namespace common\modules\clinic;

/**
 * clinic module definition class
 */
use common\abstractClasses\WorkModule;
use Yii;

/**
 * 
 */

class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $defaultRoute = 'manage';
    public $controllerNamespace = 'common\modules\clinic\controllers';
    public $moduleName = "Клиника";
    /**
     * Устанавливает параметры для работы userInterface
     * @param type $action
     * @return type
     */
    public function beforeAction($action) {
        if (Yii::$app->request->get('clinic_id')!==null){
                Yii::$app->userInterface->params['clinic_id']=Yii::$app->request->get('clinic_id');
                            
        }
        return parent::beforeAction($action);
    }
    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        
        Yii::configure($this, require __DIR__ . '/config.php');;
    }

}
