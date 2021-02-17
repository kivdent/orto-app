<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

          //  ['label' => 'Установить финансовый период', 'url' => '/old_app/fin_per.php', 'roles' => ['accountant',]],
            ['label' => 'Финансовые периоды', 'url' => '/salary/financial-periods/', 'roles' => ['accountant','admin',]],
//            ['label' => 'Заработная плата', 'url' => '/old_app/buhg_zp.php', 'roles' => ['accountant',]],
            ['label' => 'Заработная плата', 'url' => '/salary/manage/index', 'roles' => ['accountant','director','admin',]],
            ['label' => 'Зарплатные карты', 'url' => '/salary/salary-card/index', 'roles' => ['accountant','director','admin',]],
//            ['label' => 'Заработная плата по Ип', 'url' => '/salary/manage/ip', 'roles' => ['accountant',]],
//            ['label' => 'Заработная плата', 'url' => '/old_app/buhg_zp.php', 'roles' => ['accountant',]],
//            ['label' => 'Зарплатная карта', 'url' => '/old_app/buhg_zc.php', 'roles' => ['accountant',]],


        ],
        //'moduleMenu' => []
    ],
];
