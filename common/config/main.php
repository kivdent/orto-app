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
        'storage'=>[
            'class'=>'\common\components\Storage',
        ],
        'i18n' => [
            'translations' => [
                'file-input*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => dirname(__FILE__).'/../vendor/2amigos/yii2-file-input-widget/src/messages/',
                    'basePath' =>  dirname(dirname(__DIR__)) . '/common/i18n/',
                ],
            ],
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
        'schedule' => [
            'class' => 'common\modules\schedule\Module',
        ],
        'cash' => [
            'class' => 'common\modules\cash\Module',
        ],
        'reports' => [
            'class' => 'common\modules\reports\Module',
        ],
        'catalogs' => [
            'class' => 'common\modules\catalogs\Module',
        ],

        'recall' => [
            'class' => 'common\modules\recall\Module',
        ],
        'discounts' => [
            'class' => 'common\modules\discounts\Module',
        ],
        'sale' => [
            'class' => 'common\modules\sale\Module',
        ],
        'salary' => [
            'class' => 'common\modules\salary\Module',
        ],
        'materials' => [
            'class' => 'common\modules\materials\Module',
        ],
        'old_app' => [
            'class' => 'frontend\modules\old_app\Module',
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',

        ],
        'documents' => [
            'class' => 'common\modules\documents\Module',
        ],
        'photos' => [
            'class' => 'common\modules\images\Module',
        ],
    ],
];
