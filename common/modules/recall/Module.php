<?php

namespace common\modules\recall;

use common\abstractClasses\WorkModule;
use Yii;
/**
 * recall module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\recall\controllers';
//    public $defaultRoute = 'manage';
    public $moduleName = "Диспансеризация";



    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');

    }

}
