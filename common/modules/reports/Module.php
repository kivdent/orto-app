<?php

namespace common\modules\reports;

use common\abstractClasses\WorkModule;
use Yii;
/**
 * recall module definition class
 */
class Module extends WorkModule {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\reports\controllers';
//    public $defaultRoute = 'manage';
    public $moduleName = "Отчёты";



    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        Yii::configure($this, require __DIR__ . '/config.php');
        ;
    }

}
