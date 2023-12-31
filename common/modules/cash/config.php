<?php

/**
 * clinic
 */
return [
    'params' => [
        //'entities' => [],
        'menuItems' => [
            ['label' => 'Приём оплаты', 'url' => '/cash/payment/today', 'roles' => ['recorder','senior_recorder',]],
            //  ['label' => 'Приём оплаты old', 'url' => '/old_app/pr_opl.php', 'roles' => ['recorder',]],
            //   ['label' => 'Долги old', 'url' => '/old_app/pr_dolg.php', 'roles' => ['recorder',]],
            ['label' => 'Долги', 'url' => '/cash/payment/get-debt', 'roles' => ['recorder','senior_recorder',]],
            //  ['label' => 'Приём аванса old', 'url' => '/old_app/pr_avans.php', 'roles' => ['recorder',]],
            ['label' => 'Приём аванса', 'url' => '/cash/payment/get-prepayment', 'roles' => ['recorder','senior_recorder',]],
//            ['label' => 'Выдача денег old', 'url' => '/old_app/vid_deneg.php?step=1', 'roles' => ['recorder',]],
            ['label' => 'Выдача денег', 'url' => '/cash/manage/money-issue', 'roles' => ['recorder','senior_recorder',]],
            ['label' => 'Начало смены', 'url' => '/cash/manage/start', 'roles' => ['recorder','senior_recorder',]],
            ['label' => 'Закрытие смены', 'url' => '/cash/manage/end', 'roles' => ['recorder','senior_recorder',]],
//            ['label' => 'Окончание смены', 'url' => '/old_app/kassa.php?action=okonch&step=1', 'roles' => ['recorder',]],
            // ['label' => 'Приём оплаты ортодонтия', 'url' => '/old_app/pr_opl_orto.php', 'roles' => ['recorder',]],
            ['label' => 'Приём оплаты ортодонтия', 'url' => '/cash/payment/orthodontics', 'roles' => ['recorder','senior_recorder',]],
            //     ['label' => 'Должники ортодонтия', 'url' => '/old_app/pr_dolg_orto.php', 'roles' => ['recorder',]],


        ],
        //'moduleMenu' => []
    ],
];
