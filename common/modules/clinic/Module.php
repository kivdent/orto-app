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
     * {@inheritdoc}
     */
    public function init() {
        parent::init();
        
        Yii::configure($this, require __DIR__ . '/config.php');;
    }

}
