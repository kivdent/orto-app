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
            'therapist' => 'schedule/recorder/doctor-index',
            'orthopedist' => 'schedule/recorder/doctor-index',
            'surgeon' => 'schedule/recorder/doctor-index',
            'orthodontist' => 'schedule/recorder/doctor-index',
            'recorder' => '/schedule/recorder',
            'accountant' => '/salary/manage/index',
            'senior_nurse' => '/employee/manage/index',
            'senior_recorder' => '/schedule/recorder',
            'director' => '/reports/financial/daily',
            'radiologist' => '/schedule/recorder',
            'technician' => '/reports/financial/employee-period?invoice_type=technical_order',
        ],
        'widgets' => [
            'addressFormFields' => 'common\modules\userInterface\widgets\AddressFormWidget'
        ],
    ],
];
