<?php

/**
 * clinic
 */
return [
    'params' => [
        'entities' => [
            'clinic' => 'common\modules\clinic\models\clinic',
            'user' => 'common\models\User',
            'addresses' => 'common\modules\userInterface\models\addresses',
            'requisites' => 'common\modules\userInterface\models\Requisites',
        ],

        'moduleMenu' => [
            'file'=>'@common/modules/patient/components/ModuleMenu.php',
            ]
    ],
];
