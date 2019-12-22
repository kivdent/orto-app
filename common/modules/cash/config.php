<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [
            ['label' => 'Приём оплаты', 'url' => '/old_app/pr_opl.php', 'roles' => ['recorder',]],
            ['label' => 'Долги', 'url' => '/old_app/pr_dolg.php', 'roles' => ['recorder',]],
            ['label' => 'Приём аванса', 'url' => '/old_app/pr_avans.php', 'roles' => ['recorder',]],
            ['label' => 'Выдача денег', 'url' => '/old_app/vid_deneg.php?step=1', 'roles' => ['recorder',]],
            ['label' => 'Начало смены', 'url' => '/old_app/kassa.php?action=nach&step=1', 'roles' => ['recorder',]],
            ['label' => 'Окончание смены', 'url' => '/old_app/kassa.php?action=okonch&step=1', 'roles' => ['recorder',]],
            ['label' => 'Приём оплаты ортодонтия', 'url' => '/old_app/pr_opl_orto.php', 'roles' => ['recorder',]],
            ['label' => 'Должники ортодонтия', 'url' => '/old_app/pr_dolg_orto.php', 'roles' => ['recorder',]],


        ],
        //'moduleMenu' => []
    ],
];
