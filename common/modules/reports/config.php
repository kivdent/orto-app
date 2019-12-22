<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

            ['label' => 'Финансовый отчёт за день', 'url' => '/old_app/reg_den_opl.php', 'roles' => ['recorder',]],
            ['label' => 'Отчёт за день (чеки)', 'url' => '/old_app/doc_den_ch.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за период (чеки)', 'url' => '/old_app/doc_den_ch_per.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за день (оплаты)', 'url' => '/old_app/doc_den_opl.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за период (оплаты)', 'url' => '/old_app/doc_den_opl_per.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Должники', 'url' => '/old_app/dolzh.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за месяц', 'url' => '/old_app/month_otch.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Все пациенты', 'url' => '/old_app/doc_den_ch_per2.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Финансовый отчёт за день директор', 'url' => '/old_app/dir_den_opl.php', 'roles' => ['director',]],
            ['label' => 'Финансовый отчёт по врачам за период', 'url' => '/old_app/dir_den_opl_per.php', 'roles' => ['director',]],
            ['label' => 'Финансовый отчёт по клинике за период', 'url' => '/old_app/dir_den_opl_per_clin.php', 'roles' => ['director',]],
            ['label' => 'Отчёт по договорам', 'url' => '/old_app/dir_dog.php', 'roles' => ['director',]],
            ['label' => 'Отчёты', 'url' => '/old_app/doc_den_opl_xray_per.php', 'roles' => ['radiologist',]],


        ],
        //'moduleMenu' => []
    ],
];
