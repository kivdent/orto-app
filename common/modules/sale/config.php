<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

            ['label' => 'Продажа гигиены', 'url' => '/old_app/pr_opl_hyg.php', 'roles' => ['recorder',]],
            ['label' => 'Подарочные сертификаты', 'url' => '/old_app/certif_gift.php?action=add&step=1', 'roles' => ['recorder',]],
            ['label' => 'Выданные сертификаты', 'url' => '/old_app/certif_gift.php', 'roles' => ['recorder',]],


        ],
        //'moduleMenu' => []
    ],
];
