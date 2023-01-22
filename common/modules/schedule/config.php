<?php

/**
 * clinic
 */
return [
    'params' => [

        'menuItems' => [
//            ['label' => 'Ежедневник', 'url' => '/old_app/raspis_show.php', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist','radiologist',]],
            ['label' => 'Изменить расписание', 'url' => '/schedule/schedule', 'roles' => ['admin','senior_recorder',]],
//            ['label' => "Назначение пациентов new", 'url' => '/schedule/appointment', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'senior_recorder']],
            ['label' => "Назначение пациентов", 'url' => '/schedule/appointment', 'roles' => ['recorder','admin','senior_recorder','therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Назначение пациентов', 'url' => '/old_app/naznach_pat.php', 'roles' => ['recorder','senior_recorder',]],
//            ['label' => 'Пациенты на сегодня', 'url' => '/old_app/pat_tooday_reg.php', 'roles' => ['recorder',]],
            ['label' => 'Пациенты на сегодня', 'url' => '/schedule/recorder', 'roles' => ['senior_recorder', 'radiologist']],
//            ['label' => 'Пациенты на сегодня', 'url' => '/old_app/pat_tooday_orto.php', 'roles' => ['orthodontist','orthopedist',]],
//            ['label' => 'Пациенты на сегодня', 'url' => '/old_app/pat_tooday.php', 'roles' => ['therapist','surgeon',]],
            ['label' => 'Пациенты на сегодня', 'url' => '/schedule/recorder/doctor-index', 'roles' => ['therapist','surgeon','orthodontist','orthopedist']],
            ['label' => 'Лист обзвона', 'url' => '/schedule/call-list', 'roles' => ['recorder','admin','senior_recorder','therapist','surgeon','orthodontist','orthopedist']],
//            ['label' => 'График работы персонала', 'url' => '/old_app/sotr_time.php', 'roles' => ['recorder',]],
//            ['label' => 'Табель', 'url' => '/old_app/tabel.php', 'roles' => ['admin', 'senior_nurse',]],
            ['label' => 'Пакеты расписаний', 'url' => '/schedule/manage-basic-schedule', 'roles' => ['admin',]],
            //['label' => 'Табель', 'url' => '/old_app/sotr_time.php', 'roles' => ['accountant', 'director','admin', 'senior_nurse',]],
            ['label' => 'Табель', 'url' => '/schedule/time-sheet', 'roles' => ['accountant', 'director','admin', 'radiologist','recorder','senior_recorder',]],
//            ['label' => 'Учёт снимков', 'url' => '/old_app/rentgen.php?type=today', 'roles' => ['radiologist', 'therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
           // ['label' => 'Табель', 'url' => '/old_app/sotr_time.php', 'roles' => ['radiologist',]],

        ],
        // 'moduleMenu' => '@common/modules/clinic/components/moduleMenu.php',
    ],
];
