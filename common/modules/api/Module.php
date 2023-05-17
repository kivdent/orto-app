<?php

namespace common\modules\api;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'common\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        \Yii::configure($this, [
            'components' => [
                'urlManager' => [
                    'class' => 'yii\web\UrlManager',
                    'enablePrettyUrl' => true,
                    'enableStrictParsing' => true,
                    'showScriptName' => false,
                    'rules' => [
                        ['class' => 'yii\rest\UrlRule', 'controller' => 'user', 'pluralize' => false,],
                    ],
                ],
                'request' => [
                    'class' => ' yii\web\Request',
                    'parsers' => [
                        'application/json' => 'yii\web\JsonParser',
                    ]
                ]
            ],
        ]);
    }
}
