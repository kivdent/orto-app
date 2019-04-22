<?php

namespace common\modules\catalogs;

use common\abstractClasses\WorkModule;
use Yii;

/**
 * catalogs module definition class
 */
class Module extends WorkModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\catalogs\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();


        $this->modules = [
            'baseSchedulesTypes' => [
                'class' => 'common\modules\catalogs\modules\baseSchedulesTypes\Module',
            ],
            'positions' => [
                'class' => 'common\modules\catalogs\modules\positions\Module',
            ],

        ];
        Yii::configure($this, require __DIR__ . '/config.php');
    }
}
