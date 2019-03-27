<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'old_app' => [
            'class' => 'frontend\modules\old_app\Module',
        ],
        'userInterface' => [
            'class' => 'frontend\modules\userInterface\Module',
            
        ],
//        'admin' => [   //Модуль для управления правами на основе RBAC
//            'class' => 'mdm\admin\Module',
//            'layout' => 'left-menu',
//            'controllerMap' => [
//                'assignment' => [
//                    'class' => 'mdm\admin\controllers\AssignmentController',
//                    'userClassName' => 'common\models\User',
//                    'idField' => 'id'
//                ],
//            ],
//        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
       
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/'=>'/site/index',
            ],
        ],
       
    ],
//     'as access' => [
//        'class' => 'mdm\admin\components\AccessControl',
//        'allowActions' => [
//            'site/*',
//        // The actions listed here will be allowed to everyone including guests.
//        // So, 'admin/*' should not appear here in the production, of course.
//        // But in the earlier stages of your development, you may probably want to
//        // add a lot of actions here until you finally completed setting up rbac,
//        // otherwise you may not even take a first step.
//        ]
//    ],
    'params' => $params,
];
