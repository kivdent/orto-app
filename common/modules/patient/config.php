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
            ['label' => 'Работа с пациентами', 'url' => '/patient', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse', 'senior_recorder', 'accountant']],
            ['label' => 'Добавить нового пациента', 'url' => '/patient/manage/create', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior_nurse', 'senior_recorder',]],
        //    ['label' => 'Дни рождения', 'url' => '/patient/birthday/', 'roles' => ['admin', 'recorder', 'senior_recorder',]],
        ],
        'moduleMenu' => [
            'file' => '@common/modules/patient/components/ModuleMenu.php',
        ]
    ],
];
