<?php

namespace common\modules\catalogs\modules\baseSchedulesTypes;

/**
 * baseSchedulesTypes module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\catalogs\modules\baseSchedulesTypes\controllers';
    public $defaultRoute = 'manage';
    public $moduleName = "Типы базового расписания";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();


    }
}
