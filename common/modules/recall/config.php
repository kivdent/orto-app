<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [
            ['label' => 'Диспансеризация', 'url' => '/old_app/disp.php', 'roles' => ['recorder','senior_recorder',]],

//            ['label' => 'День рождения пациентов', 'url' => '/recall/dr_pat.php', 'roles' => ['recorder','senior_recorder',]],
            ['label' => 'Диспансеризация врачи', 'url' => '/old_app/disp_vrach.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            
//            ['label' => 'Диспансеризация', 'url' => '/recall/manage/recorder/','roles'=>['admin', 'recorder', 'senior_recorder']],
            ['label' => 'День рождения пациентов', 'url' => '/recall/manage/birthday/','roles'=>['admin', 'recorder','senior_recorder' ]],
//            ['label' => 'Диспансеризация', 'url' => '/recall/manage/doctor/','roles'=>['therapist', 'orthopedist', 'surgeon', 'orthodontist', ]],

        ],
        //'moduleMenu' => []
    ],
];
