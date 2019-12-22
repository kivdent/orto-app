<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

            ['label' => 'Каталог материалов', 'url' => '/old_app/mater.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Остаток материалов', 'url' => '/old_app/mater_ost.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Приход материала', 'url' => '/old_app/mater_prih.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Выдача материалов', 'url' => '/old_app/mater_vid.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Учёт приборов', 'url' => '/old_app/tech_sp.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Учёт расхода материалов', 'url' => '/old_app/mater_uch.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Еденицы измерения', 'url' => '/old_app/spr_edizm.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Mеста хренния материалов', 'url' => '/old_app/mater_mesta_hr.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Составление заявки', 'url' => '/old_app/mater_order.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Списание материалов', 'url' => '/old_app/mater_spis.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Установка соотвествий для автосписания', 'url' => '/old_app/mater_sootv.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Отчёт по автосписанию', 'url' => '/old_app/mater_sootv_otch.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Отчёты по приходам', 'url' => '/old_app/mater_otch_prih.php', 'roles' => ['senior_nurse',]],
            ['label' => 'Отчёты по выдаче', 'url' => '/old_app/mater_otch_vid.php', 'roles' => ['senior_nurse',]],
            ['label' => 'отчёты по списанию', 'url' => '/old_app/mater_otch_spis.php', 'roles' => ['senior_nurse',]],


        ],
        //'moduleMenu' => []
    ],
];
