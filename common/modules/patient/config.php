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
        'menuItems' => [
            ['label' => 'Работа с пациентами', 'url' => '/patient', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse', ]],
            ['label' => 'Добавить нового пациента', 'url' => '/patient/manage/create','roles'=>['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse', ]],
//            ['label' => 'Работа с пациентами ортодонтия', 'url' => '/old_app/pat_card_orto.php', 'roles' => ['admin', 'orthodontist',]],

        ],
        'moduleMenu' => [
            'file'=>'@common/modules/patient/components/ModuleMenu.php',
            ]
    ],
];
