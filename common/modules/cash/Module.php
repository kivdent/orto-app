<?php

namespace common\modules\cash;

use common\abstractClasses\WorkModule;
use Yii;
/**
 * recall module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\cash\controllers';
//    public $defaultRoute = 'manage';
    public $moduleName = "Касса";



    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
        ;
    }

}
