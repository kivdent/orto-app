<?php

return [
    'params' => [
        // список параметров
        /**
         * workModuleInterface который, должны реулизовывать рабочие модули
         */
        'workModuleInterface' => 'common\interfaces\WorkModuleInterface',
        /**
         * defaultRoutes маршруты по умолчанию,для разных ролей пользователей
         */
        'defaultRoutes' => [
            'admin' => '/user/',
            'therapist' => '/old_app/pat_tooday.php',
            'orthopedist' => '/old_app/pat_tooday.php',
            'surgeon' => '/old_app/pat_tooday.php',
            'orthodontist' => '/old_app/pat_tooday_orto.php',
            'recorder' => '/old_app/naznach_pat.php',
            'accountant' => '/salary/manage/index',
            'senior_nurse' => '/employee/manage/index',
            'senior_recorder' => '/schedule/recorder',
            'director' => '/reports/financial/daily',
            'radiologist' => '/old_app/rentgen.php?type=today',
            'technician' => '/reports/financial/employee-period?invoice_type=technical_order',
        ],
        'widgets' => [
            'addressFormFields' => 'common\modules\userInterface\widgets\AddressFormWidget'
        ],
    ],
];
