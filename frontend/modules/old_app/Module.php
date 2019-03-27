<?php

namespace frontend\modules\old_app;
use Yii;

/**
 * old_app 
 * Модуль для интеграции старых функций
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\old_app\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

          Yii::configure($this, require __DIR__ . '/menu.php');
    }
}
