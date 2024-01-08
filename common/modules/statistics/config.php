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
            ['label' => 'Назначения', 'url' => '/statistics/appointment','roles'=>['admin', 'accountant', 'director', ]],

        ],
        //'moduleMenu' => []
    ],
];
