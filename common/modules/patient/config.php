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
            ['label' => 'Работа с пациентами', 'url' => '/patient', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior nurse', ]],
            ['label' => 'Добавить нового пациента', 'url' => '/patient/manage/create','roles'=>['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder', 'senior nurse', ]],
        ],
       // 'moduleMenu' => '@common/modules/clinic/components/moduleMenu.php',
    ],
];
