<?php

namespace frontend\modules\userInterface;
use Yii;

/**
 * userInterface 
 * Модуль для релизации инивидульных пользовательских интерфейсов для разных ролей
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'frontend\modules\userInterface\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::configure($this, require __DIR__ . '/config.php');
        // custom initialization code goes here
    }
}
