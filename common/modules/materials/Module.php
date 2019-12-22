<?php

namespace common\modules\materials;

use common\abstractClasses\WorkModule;
use Yii;
/**
 * recall module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\materials\controllers';
//    public $defaultRoute = 'manage';
    public $moduleName = "Материалы";



    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
        ;
    }

}
