<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [
            ['label' => 'Выданные карты', 'url' => '/old_app/discount.php?act=view', 'roles' => ['admin', 'recorder','senior_recorder',]],
            ['label' => 'Новые карты', 'url' => '/old_app/discount.php?act=new', 'roles' => ['admin',]],
            ['label' => 'Выдача карт', 'url' => '/old_app/discount.php?act=make', 'roles' => ['admin', 'recorder','senior_recorder',]],
            ['label' => 'Виды карт', 'url' => '/old_app/discount.php?act=types', 'roles' => ['admin',]],

        ],
        //'moduleMenu' => []
    ],
];
