<?php

/**
 * archive
 */

use common\modules\archive\models\ArchivePatientSearch;

return [
    'params' => [

        'menuItems' => [
            ['label' => 'Выручка', 'url' => '/statistics/revenue','roles'=>['admin', 'accountant', 'director', ]],
            ['label' => 'Расходы', 'url' => '/statistics/expenses','roles'=>['admin', 'accountant', 'director', ]],
            ['label' => 'Врачи', 'url' => '/statistics/doctors','roles'=>['admin', 'accountant', 'director', ]],
            ['label' => 'Врачи ежедневно', 'url' => '/statistics/doctors/daily','roles'=>['admin', 'accountant', 'director', ]],
            ['label' => 'План выручки', 'url' => '/statistics/revenue-planing','roles'=>['admin', 'accountant', 'director', ]],
            ['label' => 'Записи', 'url' => '/statistics/appointment','roles'=>['admin', 'accountant', 'director','senior_recorder','recorder' ]],
            ['label' => 'Записи в месяц', 'url' => '/statistics/appointment/months','roles'=>['admin', 'accountant', 'director','senior_recorder','recorder' ]],
            ['label' => 'Назначения в месяц', 'url' => '/statistics/appointment/appointments','roles'=>['admin', 'accountant', 'director','senior_recorder','recorder' ]],
            ['label' => 'Пациенты с эндо прошедшие ортопедию', 'url' => '/statistics/patient/redirect','roles'=>['admin', 'director', ]],
            ['label' => 'Tерапевты на ортодонтию', 'url' => '/statistics/patient/therapy-to-orthodontics','roles'=>['admin', 'director', ]],
            ['label' => 'Анализ по кальдину', 'url' => '/statistics/kaldin/report','roles'=>['admin', 'director', ]],

        ],
        //'moduleMenu' => []
    ],
];