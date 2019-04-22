<?php

namespace common\modules\catalogs\modules\positions;

/**
 * positions module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\catalogs\modules\positions\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Должности";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
