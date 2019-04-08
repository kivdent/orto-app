<?php

return [
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'userInterface' => [
            'class' => 'common\modules\userInterface\models\UserInterface',
        ],
    ],
    'modules' => [
        'clinic' => [
            'class' => 'common\modules\clinic\Module',
        ],
        'employee' => [
            'class' => 'common\modules\employee\Module',
        ],
        'appointment' => [
            'class' => 'common\modules\appointment\Module',
        ],
        'patient' => [
            'class' => 'common\modules\patient\Module',
        ],
        'userInterface' => [
            'class' => 'common\modules\userInterface\Module',
        ],
        'user' => [
            'class' => 'common\modules\user\Module',
        ],
        'old_app' => [
            'class' => 'frontend\modules\old_app\Module',
        ],
    ],
];
