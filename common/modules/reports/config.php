<?php

/**
 * clinic
 */

use common\modules\reports\models\DailyReport;

return [
    'params' => [
        //'entities' => [],
        'menuItems' => [

       //     ['label' => 'Финансовый отчёт за день old', 'url' => '/old_app/reg_den_opl.php', 'roles' => ['recorder',]],
            ['label' => 'Финансовый отчёт за день', 'url' => '/reports/financial/daily', 'roles' => ['recorder','director','accountant','senior_recorder',]],
//            ['label' => 'Отчёт за день (чеки)', 'url' => '/old_app/doc_den_ch.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за день', 'url' => '/reports/financial/employee-daily', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за период', 'url' => '/reports/financial/employee-period', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Заказ-наряды', 'url' => ['/reports/financial/employee-period','invoice_type'=>DailyReport::TYPE_OF_REPORT_TECHNICAL_ORDER], 'roles' => ['technician','therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Лаборатория', 'url' => ['/reports/financial/accountat-technical-order-period','invoice_type'=>DailyReport::TYPE_OF_REPORT_TECHNICAL_COMPLETED_ACCOUNTANT], 'roles' => [\common\modules\userInterface\models\UserInterface::ROLE_ACCOUNTANT]],
            ['label' => 'Заказ-наряды закрытые', 'url' => ['/reports/financial/employee-period','invoice_type'=> DailyReport::TYPE_OF_REPORT_TECHNICAL_COMPLETED], 'roles' => ['technician']],
            ['label' => 'Заказ-наряды в работе', 'url' => ['/reports/financial/employee-period','invoice_type'=> DailyReport::TYPE_OF_REPORT_TECHNICAL_CURRENT], 'roles' => ['technician']],
//            ['label' => 'Отчёт за период оплаты', 'url' => '/reports/default/index', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Отчёт за период (чеки)', 'url' => '/old_app/doc_den_ch_per.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Отчёт за день (оплаты)', 'url' => '/old_app/doc_den_opl.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Отчёт за период (оплаты)', 'url' => '/old_app/doc_den_opl_per.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Должники', 'url' => '/reports/default/employee-debt', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Отчёт за месяц', 'url' => '/old_app/month_otch.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
            ['label' => 'Все пациенты', 'url' => '/old_app/doc_den_ch_per2.php', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Финансовый отчёт за день директор', 'url' => '/old_app/dir_den_opl.php', 'roles' => ['director',]],
            ['label' => 'Финансовый отчёт по врачам за период', 'url' => '/old_app/dir_den_opl_per.php', 'roles' => ['director',]],
            ['label' => 'Финансовый отчёт по клинике за период', 'url' => '/old_app/dir_den_opl_per_clin.php', 'roles' => ['director',]],
            ['label' => 'Отчёт по договорам', 'url' => '/old_app/dir_dog.php', 'roles' => ['director',]],
//            ['label' => 'Заказ-наряды', 'url' => '/reports/financial/employee-technical-order', 'roles' => ['therapist', 'orthopedist', 'surgeon', 'orthodontist',]],
//            ['label' => 'Отчёты', 'url' => '/old_app/doc_den_opl_xray_per.php', 'roles' => ['radiologist',]],
            ['label' => 'Отчёты', 'url' =>[
                '/reports/financial/employee-period',
                'period_id' => 'current',
                'employee_id' => 'current',
                'employee_selectable' => true
            ], 'roles' => ['radiologist',]],

            ['label' => 'Отчёт за манипуляци', 'url' => '/reports/manipulation', 'roles' => ['admin',]],
            ['label' => 'Пациенты без планов лечения', 'url' => '/reports/manipulation/treatment-plans', 'roles' => ['admin',]],
        ],
        //'moduleMenu' => []
    ],
];
