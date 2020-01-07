<?php

/**
 * catalogs
 */
return [
    'params' => [

        'menuItems' => [
            ['label' => 'Жалобы', 'url' => '/catalogs/complains', 'roles' => ['admin',]],
            ['label' => 'Анамнез', 'url' => '/catalogs/anamnesis', 'roles' => ['admin',]],
            ['label' => 'Рекоммендации', 'url' => '/catalogs/recommendations', 'roles' => ['admin',]],
            ['label' => 'Объёктивно', 'url' => '/catalogs/objectively', 'roles' => ['admin',]],
            ['label' => 'Лечение', 'url' => '/catalogs/therapy', 'roles' => ['admin',]],
            ['label' => 'Назначения', 'url' => '/catalogs/prescriptions', 'roles' => ['admin',]],
            ['label' => 'Реквизиты фирм', 'url' => '/old_app/spr_firm.php', 'roles' => ['admin',]],
            ['label' => 'Договора', 'url' => '/old_app/spr_dogovora.php', 'roles' => ['admin',]],
            ['label' => 'Клише', 'url' => '/old_app/klishe.php', 'roles' => ['admin',]],
            ['label' => 'Диагноз', 'url' => '/old_app/spr_ds.php', 'roles' => ['admin',]],
            ['label' => 'Манипуляции', 'url' => '/old_app/spr_manip.php', 'roles' => ['admin',]],
            ['label' => 'Должности', 'url' => '/old_app/spr_dolzh.php', 'roles' => ['admin',]],

        ],
       // 'moduleMenu' => '@common/modules/clinic/components/moduleMenu.php',
    ],
];
