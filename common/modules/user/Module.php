<?php

namespace common\modules\user;

/**
 * user module definition class
 */
use common\abstractClasses\WorkModule;
use Yii;

class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\user\controllers';
    public $defaultRoute = 'manage';
     public $moduleName = "Пользователи";

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        Yii::configure($this, require __DIR__ . '/menu.php');
    }
    
}
