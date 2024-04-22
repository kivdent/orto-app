<?php

/**
 * notifier
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

            ['label' => 'Смс оповещения', 'url' => '/notifier/manage-sms', 'roles' => ['admin','recorder','senior_recorder',]],
            ['label' => 'Цетр сообщений', 'url' => '/notifier/manage', 'roles' => ['admin','recorder','senior_recorder',]],
//            ['label' => 'День рождения пациентов', 'url' => '/old_app/dr_pat.php', 'roles' => ['recorder',]],
//            ['label' => 'Диспансеризация врачи', 'url' => '/old_app/disp_vrach.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],

        ],
        //'moduleMenu' => []
    ],
];
