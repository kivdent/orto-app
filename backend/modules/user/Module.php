<?php

namespace backend\modules\user;

/**
 * user module definition class
 */
class Module extends \yii\base\Module {

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\user\controllers';
    public $defaultRoute = 'manage';

    /**
     * {@inheritdoc}
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

}
