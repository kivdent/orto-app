<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

            ['label' => 'Установить финансовый период', 'url' => '/old_app/fin_per.php', 'roles' => ['accountant',]],
//            ['label' => 'Заработная плата', 'url' => '/old_app/buhg_zp.php', 'roles' => ['accountant',]],
            ['label' => 'Заработная плата', 'url' => '/salary/manage/index', 'roles' => ['accountant',]],
//            ['label' => 'Заработная плата по Ип', 'url' => '/salary/manage/ip', 'roles' => ['accountant',]],
//            ['label' => 'Заработная плата', 'url' => '/old_app/buhg_zp.php', 'roles' => ['accountant',]],
//            ['label' => 'Зарплатная карта', 'url' => '/old_app/buhg_zc.php', 'roles' => ['accountant',]],


        ],
        //'moduleMenu' => []
    ],
];
