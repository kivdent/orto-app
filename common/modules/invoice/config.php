<?php

/**
 * clinic
 */
return [
    'params' => [
        'menuItems' => [
////            ['label' => 'Ежедневник', 'url' => '/old_app/raspis_show.php', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist','radiologist',]],
            ['label' => 'Схемы за ортодонтию', 'url' => '/invoice/scheme-orthodontics/', 'roles' => ['admin','orthodontist',]],
            ['label' => 'Счета пациентов', 'url' => '/invoice/manage/index', 'roles' => ['admin',]],
            ['label' => 'Заказ-наряды', 'url' => '/invoice/technical-order/index', 'roles' => ['technician', 'admin',\common\modules\userInterface\models\UserInterface::ROLE_ACCOUNTANT]],
//            ['label' => 'Назначение пациентов', 'url' => '/old_app/naznach_pat.php', 'roles' => ['admin', 'therapist', 'orthopedist', 'surgeon', 'orthodontist', 'recorder',]],
//            ['label' => 'Пациенты на сегодня', 'url' => '/old_app/pat_tooday_reg.php', 'roles' => ['recorder',]],
//            ['label' => 'Пациенты на сегодня', 'url' => '/old_app/pat_tooday_orto.php', 'roles' => ['orthodontist','orthopedist',]],
//            ['label' => 'Пациенты на сегодня', 'url' => '/old_app/pat_tooday.php', 'roles' => ['therapist','surgeon',]],
//            ['label' => 'График работы персонала', 'url' => '/old_app/sotr_time.php', 'roles' => ['recorder',]],
//            ['label' => 'Табель', 'url' => '/old_app/tabel.php', 'roles' => ['admin', 'senior_nurse',]],
//            ['label' => 'Пакеты расписаний', 'url' => '/schedule/manage-basic-schedule', 'roles' => ['admin',]],
//            ['label' => 'Табель', 'url' => '/old_app/sotr_time.php', 'roles' => ['accountant', 'director',]],
//            ['label' => 'Учёт снимков', 'url' => '/old_app/rentgen.php?type=today', 'roles' => ['radiologist', 'therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Табель', 'url' => '/old_app/sotr_time.php', 'roles' => ['radiologist',]],

        ],

        // 'moduleMenu' => '@common/modules/clinic/components/moduleMenu.php',
    ],
];
