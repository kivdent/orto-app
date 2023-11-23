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
            ['label' => 'Назначения', 'url' => '/catalogs/prescriptions', 'roles' => ['admin',]],
            ['label' => 'Направления', 'url' => '/catalogs/referral', 'roles' => ['admin',]],
            ['label' => 'Операции плана лечения', 'url' => '/catalogs/operation', 'roles' => ['admin',]],
            ['label' => 'Содержания назначения', 'url' => '/catalogs/appointment-content', 'roles' => ['admin','senior_recorder']],
            ['label' => 'Шаблоны документов', 'url' => '/catalogs/document-template-word', 'roles' => ['admin','senior_recorder','recorder']],
            ['label' => 'Реквизиты фирм', 'url' => '/old_app/spr_firm.php', 'roles' => ['admin',]],
            ['label' => 'Договора', 'url' => '/old_app/spr_dogovora.php', 'roles' => ['admin',]],
            ['label' => 'Клише', 'url' => '/old_app/klishe.php', 'roles' => ['admin',]],
            ['label' => 'Диагноз', 'url' => '/old_app/spr_ds.php', 'roles' => ['admin',]],
            ['label' => 'Манипуляции', 'url' => '/old_app/spr_manip.php', 'roles' => ['admin',]],
            ['label' => 'Должности', 'url' => '/old_app/spr_dolzh.php', 'roles' => ['admin',]],
            ['label' => 'Причины отказа от приёма', 'url' => '/catalogs/rejection-reasons', 'roles' => ['admin','senior_recorder']],
            ['label' => 'Цели звонка', 'url' => '/catalogs/call-target', 'roles' => ['admin','senior_recorder']],

        ],
       // 'moduleMenu' => '@common/modules/clinic/components/moduleMenu.php',
    ],
];
